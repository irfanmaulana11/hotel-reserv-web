<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $cities = Hotel::where('is_active', true)
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values()
            ->all();

        $destinations = Destination::where('is_active', true)
            ->orderBy('is_popular', 'desc')
            ->orderBy('name')
            ->get()
            ->map(fn ($dest) => [
                'city' => $dest->city,
                'hotels' => Hotel::where('city', $dest->city)->where('is_active', true)->count(),
                'rooms' => Hotel::where('city', $dest->city)->where('is_active', true)->sum('total_rooms'),
                'image' => $dest->image_url,
            ])
            ->all();

        return view('booking.index', [
            'cities' => $cities,
            'destinations' => $destinations,
        ]);
    }

    public function login(): View
    {
        return view('booking.login');
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'city' => ['nullable', 'string', 'max:120'],
            'check_in' => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
            'adults' => ['nullable', 'integer', 'min:1', 'max:8'],
            'children' => ['nullable', 'integer', 'min:0', 'max:6'],
            'rooms' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $checkIn = isset($validated['check_in']) ? Carbon::parse($validated['check_in']) : null;
        $checkOut = isset($validated['check_out']) ? Carbon::parse($validated['check_out']) : null;
        $nights = ($checkIn && $checkOut) ? max(1, $checkIn->diffInDays($checkOut)) : null;
        $adults = (int) ($validated['adults'] ?? 2);
        $children = (int) ($validated['children'] ?? 0);
        $rooms = (int) ($validated['rooms'] ?? 1);

        $hotels = Hotel::where('is_active', true)
            ->with('rooms')
            ->when($validated['city'] ?? null, fn ($q, $city) => $q->where('city', $city))
            ->get()
            ->map(fn ($hotel) => [
                'slug' => $hotel->id,
                'name' => $hotel->name,
                'city' => $hotel->city,
                'brand' => 'Hotel',
                'rating' => $hotel->star_rating,
                'description' => $hotel->description,
                'image' => $hotel->image_url,
                'rooms' => $hotel->rooms->where('is_active', true)->map(fn ($room) => [
                    'type' => $room->type,
                    'price' => $room->price,
                    'max_guests' => $room->max_guests,
                    'available_rooms' => $room->available_rooms,
                    'image' => $room->image_url,
                ])->values()->all(),
            ]);

        return view('booking.search', [
            'hotels' => $hotels,
            'city' => $validated['city'] ?? null,
            'check_in' => $checkIn?->toDateString(),
            'check_out' => $checkOut?->toDateString(),
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
            'nights' => $nights,
        ]);
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $hotel = Hotel::where('is_active', true)->findOrFail($id);

        $checkInRaw = $request->query('check_in', old('check_in'));
        $checkOutRaw = $request->query('check_out', old('check_out'));
        $adultsRaw = $request->query('adults', old('adults'));
        $childrenRaw = $request->query('children', old('children', 0));
        $roomsRaw = $request->query('rooms', old('rooms'));

        $stayFilled = filled($checkInRaw) && filled($checkOutRaw) && filled($adultsRaw) && filled($roomsRaw);

        if (! $stayFilled) {
            $hotelData = [
                'slug' => $hotel->id,
                'name' => $hotel->name,
                'city' => $hotel->city,
                'brand' => 'Hotel',
                'rating' => $hotel->star_rating,
                'description' => $hotel->description,
                'image' => $hotel->image_url,
                'rooms' => $hotel->rooms()->where('is_active', true)->get()->map(fn ($room) => [
                    'type' => $room->type,
                    'price' => $room->price,
                    'max_guests' => $room->max_guests,
                    'available_rooms' => $room->available_rooms,
                    'image' => $room->image_url,
                    'facilities' => $room->facilities ?? [],
                ])->all(),
            ];

            return view('booking.show', [
                'hotel' => $hotelData,
                'staySelected' => false,
                'check_in' => null,
                'check_out' => null,
                'adults' => null,
                'children' => null,
                'rooms' => null,
                'nights' => null,
            ]);
        }

        $validator = Validator::make(
            [
                'check_in' => $checkInRaw,
                'check_out' => $checkOutRaw,
                'adults' => $adultsRaw,
                'children' => $childrenRaw,
                'rooms' => $roomsRaw,
            ],
            [
                'check_in' => ['required', 'date', 'after_or_equal:today'],
                'check_out' => ['required', 'date', 'after:check_in'],
                'adults' => ['required', 'integer', 'min:1', 'max:8'],
                'children' => ['nullable', 'integer', 'min:0', 'max:6'],
                'rooms' => ['required', 'integer', 'min:1', 'max:10'],
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->route('book.hotel', ['slug' => $id])
                ->withInput([
                    'check_in' => $checkInRaw,
                    'check_out' => $checkOutRaw,
                    'adults' => $adultsRaw,
                    'children' => $childrenRaw,
                    'rooms' => $roomsRaw,
                ])
                ->withErrors($validator);
        }

        $data = $validator->validated();
        $checkIn = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));
        $adults = (int) $data['adults'];
        $children = (int) ($data['children'] ?? 0);
        $rooms = (int) $data['rooms'];

        $hotelData = [
            'slug' => $hotel->id,
            'name' => $hotel->name,
            'city' => $hotel->city,
            'brand' => 'Hotel',
            'rating' => $hotel->star_rating,
            'description' => $hotel->description,
            'image' => $hotel->image_url,
            'rooms' => $hotel->rooms()->where('is_active', true)->get()->map(fn ($room) => [
                'type' => $room->type,
                'price' => $room->price,
                'max_guests' => $room->max_guests,
                'available_rooms' => $room->available_rooms,
                'image' => $room->image_url,
                'facilities' => $room->facilities ?? [],
            ])->all(),
        ];

        return view('booking.show', [
            'hotel' => $hotelData,
            'staySelected' => true,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
            'nights' => $nights,
        ]);
    }

    public function checkout(Request $request): View
    {
        $data = $request->validate([
            'hotel' => ['required', 'integer'],
            'room_type' => ['required', 'string', 'max:120'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:8'],
            'children' => ['nullable', 'integer', 'min:0', 'max:6'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $hotel = Hotel::where('is_active', true)->findOrFail($data['hotel']);
        $room = $hotel->rooms()->where('type', $data['room_type'])->where('is_active', true)->firstOrFail();

        $checkIn = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));
        $rooms = (int) $data['rooms'];
        $subtotal = $room->price * $nights * $rooms;
        $tax = (int) round($subtotal * 0.11);
        $total = $subtotal + $tax;

        $hotelData = [
            'slug' => $hotel->id,
            'name' => $hotel->name,
            'city' => $hotel->city,
        ];

        $roomData = [
            'type' => $room->type,
            'price' => $room->price,
        ];

        return view('booking.checkout', [
            'hotel' => $hotelData,
            'room' => $roomData,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => (int) $data['adults'],
            'children' => (int) ($data['children'] ?? 0),
            'rooms' => $rooms,
            'nights' => $nights,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hotel' => ['required', 'integer'],
            'room_type' => ['required', 'string', 'max:120'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:8'],
            'children' => ['nullable', 'integer', 'min:0', 'max:6'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
            'guest_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'requests' => ['nullable', 'string', 'max:2000'],
        ]);

        $hotel = Hotel::where('is_active', true)->findOrFail($validated['hotel']);
        $room = $hotel->rooms()->where('type', $validated['room_type'])->where('is_active', true)->firstOrFail();

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));
        $rooms = (int) $validated['rooms'];
        $subtotal = $room->price * $nights * $rooms;
        $tax = (int) round($subtotal * 0.11);
        $total = $subtotal + $tax;

        $reference = 'HRW-'.strtoupper(bin2hex(random_bytes(4)));

        $reservation = Reservation::create([
            'reference' => $reference,
            'hotel_id' => $hotel->id,
            'room_id' => $room->id,
            //'user_id' => auth()->id() ?? null,
            'guest_name' => $validated['guest_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => (int) $validated['adults'],
            'children' => (int) ($validated['children'] ?? 0),
            'rooms' => $rooms,
            'nights' => $nights,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'requests' => $validated['requests'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('book.confirmation')
            ->with('booking', [
                'reservation_id' => $reservation->id,
                'reference' => $reference,
                'hotel_name' => $hotel->name,
                'room_type' => $room->type,
                'check_in' => $checkIn->toDateString(),
                'check_out' => $checkOut->toDateString(),
                'adults' => (int) $validated['adults'],
                'children' => (int) ($validated['children'] ?? 0),
                'rooms' => $rooms,
                'guest_name' => $validated['guest_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'requests' => $validated['requests'] ?? null,
                'total' => $total,
            ]);
    }

    public function confirmation(): View|RedirectResponse
    {
        if (! session()->has('booking')) {
            return redirect()->route('book.index');
        }

        return view('booking.confirmation', [
            'booking' => session('booking'),
        ]);
    }
}
