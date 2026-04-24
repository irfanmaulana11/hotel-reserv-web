<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('book.login')->with('error', 'Silakan login untuk melihat pesanan');
        }

        $reservations = auth()->user()->reservations()
            ->with(['hotel', 'room'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', [
            'reservations' => $reservations,
        ]);
    }

    public function show(Reservation $reservation): View|RedirectResponse
    {
        if (!auth()->check() || $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->load(['hotel', 'room', 'payment']);

        return view('orders.show', [
            'reservation' => $reservation,
        ]);
    }
}
