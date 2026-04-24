<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login')->with('error', 'Silakan login untuk melihat keranjang');
        }

        $cartItems = auth()->user()->cartItems()
            ->with(['hotel', 'room'])
            ->orderBy('created_at', 'desc')
            ->get();

        $validItems = collect();
        $invalidItems = collect();

        foreach ($cartItems as $item) {
            if ($item->isValid()) {
                $validItems->push($item);
            } else {
                $item->error = $item->getValidationError();
                $invalidItems->push($item);
            }
        }

        $totalValid = $validItems->sum('total');

        return view('cart.index', [
            'cartItems' => $cartItems,
            'validItems' => $validItems,
            'invalidItems' => $invalidItems,
            'totalValid' => $totalValid,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login')->with('error', 'Silakan login untuk menambahkan ke keranjang');
        }

        $validated = $request->validate([
            'hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:8'],
            'children' => ['nullable', 'integer', 'min:0', 'max:6'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $hotel = Hotel::where('is_active', true)->findOrFail($validated['hotel_id']);
        $room = $hotel->rooms()->where('is_active', true)->findOrFail($validated['room_id']);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = max(1, $checkIn->diffInDays($checkOut));
        $rooms = (int) $validated['rooms'];

        // Check room availability
        if ($room->available_rooms < $rooms) {
            return back()->with('error', 'Jumlah kamar melebihi ketersediaan');
        }

        $subtotal = $room->price * $nights * $rooms;
        $tax = (int) round($subtotal * 0.11);
        $total = $subtotal + $tax;

        // Check if same item already exists in cart
        $existingItem = auth()->user()->cartItems()
            ->where('hotel_id', $hotel->id)
            ->where('room_id', $room->id)
            ->where('check_in', $checkIn)
            ->where('check_out', $checkOut)
            ->first();

        if ($existingItem) {
            return back()->with('error', 'Item ini sudah ada di keranjang');
        }

        CartItem::create([
            'user_id' => auth()->id(),
            'hotel_id' => $hotel->id,
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'adults' => (int) $validated['adults'],
            'children' => (int) ($validated['children'] ?? 0),
            'rooms' => $rooms,
            'nights' => $nights,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        return back()->with('success', 'Berhasil menambahkan ke keranjang');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        if (!auth()->check() || $cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang');
    }

    public function clear(): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login');
        }

        auth()->user()->cartItems()->delete();

        return back()->with('success', 'Keranjang dikosongkan');
    }

    public function checkout(): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login')->with('error', 'Silakan login untuk checkout');
        }

        $cartItems = auth()->user()->cartItems()
            ->with(['hotel', 'room'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $validItems = [];
        $invalidItems = [];

        foreach ($cartItems as $item) {
            if ($item->isValid()) {
                $validItems[] = $item;
            } else {
                $item->error = $item->getValidationError();
                $invalidItems[] = $item;
            }
        }

        if (empty($validItems)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item valid untuk checkout');
        }

        $total = array_sum(array_column($validItems, 'total'));

        return view('cart.checkout', [
            'cartItems' => $validItems,
            'total' => $total,
            'invalidItems' => $invalidItems,
        ]);
    }

    public function validateCart(): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login');
        }

        $cartItems = auth()->user()->cartItems()
            ->with(['hotel', 'room'])
            ->get();

        $removed = 0;
        foreach ($cartItems as $item) {
            if (!$item->isValid()) {
                $item->delete();
                $removed++;
            }
        }

        if ($removed > 0) {
            return back()->with('warning', "{$removed} item dihapus karena tidak valid (tanggal lewat atau stok habis)");
        }

        return back()->with('success', 'Keranjang valid');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login')->with('error', 'Silakan login untuk checkout');
        }

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'items.*.room_id' => ['required', 'integer', 'exists:rooms,id'],
            'items.*.check_in' => ['required', 'date'],
            'items.*.check_out' => ['required', 'date', 'after:check_in'],
            'items.*.adults' => ['required', 'integer', 'min:1', 'max:8'],
            'items.*.children' => ['nullable', 'integer', 'min:0', 'max:6'],
            'items.*.rooms' => ['required', 'integer', 'min:1', 'max:10'],
            'guest_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'requests' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::beginTransaction();

        try {
            $createdReservations = [];

            foreach ($validated['items'] as $item) {
                $hotel = Hotel::where('is_active', true)->findOrFail($item['hotel_id']);
                $room = $hotel->rooms()->where('is_active', true)->findOrFail($item['room_id']);

                // Re-validate availability
                if ($room->available_rooms < $item['rooms']) {
                    DB::rollBack();
                    return back()->with('error', "Kamar {$room->type} di {$hotel->name} tidak lagi tersedia");
                }

                $checkIn = Carbon::parse($item['check_in']);
                $checkOut = Carbon::parse($item['check_out']);
                $nights = max(1, $checkIn->diffInDays($checkOut));
                $rooms = (int) $item['rooms'];

                $subtotal = $room->price * $nights * $rooms;
                $tax = (int) round($subtotal * 0.11);
                $total = $subtotal + $tax;

                $reference = 'HRW-' . strtoupper(bin2hex(random_bytes(4)));

                $reservation = Reservation::create([
                    'reference' => $reference,
                    'hotel_id' => $hotel->id,
                    'room_id' => $room->id,
                    'user_id' => auth()->id(),
                    'guest_name' => $validated['guest_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'adults' => (int) $item['adults'],
                    'children' => (int) ($item['children'] ?? 0),
                    'rooms' => $rooms,
                    'nights' => $nights,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'requests' => $validated['requests'] ?? null,
                    'status' => 'pending',
                ]);

                $createdReservations[] = $reservation;
            }

            // Clear cart after successful order
            auth()->user()->cartItems()->delete();

            DB::commit();

            // Redirect to first reservation confirmation
            $firstReservation = $createdReservations[0];

            return redirect()->route('book.confirmation')->with('booking', [
                'reservation_id' => $firstReservation->id,
                'reference' => $firstReservation->reference,
                'hotel_name' => $firstReservation->hotel->name,
                'room_type' => $firstReservation->room->type,
                'check_in' => $firstReservation->check_in->toDateString(),
                'check_out' => $firstReservation->check_out->toDateString(),
                'adults' => $firstReservation->adults,
                'children' => $firstReservation->children,
                'rooms' => $firstReservation->rooms,
                'guest_name' => $firstReservation->guest_name,
                'email' => $firstReservation->email,
                'phone' => $firstReservation->phone,
                'requests' => $firstReservation->requests,
                'total' => $firstReservation->total,
                'multiple_reservations' => count($createdReservations) > 1,
                'reservations_count' => count($createdReservations),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
