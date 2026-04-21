<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request): RedirectResponse
    {
        $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Reservasi sudah diproses.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'idr',
                            'product_data' => [
                                'name' => "Reservasi Hotel - {$reservation->reference}",
                                'description' => "{$reservation->hotel->name} - {$reservation->room->type}",
                            ],
                            'unit_amount' => (int) ($reservation->total * 100), // Stripe uses cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('book.payment.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
                'cancel_url' => route('book.payment.cancel'),
                'metadata' => [
                    'reservation_id' => $reservation->id,
                    'reference' => $reservation->reference,
                ],
            ]);

            Payment::create([
                'reservation_id' => $reservation->id,
                'stripe_session_id' => $session->id,
                'amount' => $reservation->total,
                'currency' => 'idr',
                'status' => 'pending',
                'metadata' => [
                    'stripe_session_id' => $session->id,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat pembayaran: '.$e->getMessage());
        }
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('book.index')->with('error', 'Sesi pembayaran tidak ditemukan.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $payment = Payment::where('stripe_session_id', $sessionId)->first();

                if ($payment && $payment->isPending()) {
                    $payment->markAsSuccess([
                        'stripe_session_id' => $session->id,
                        'payment_intent_id' => $session->payment_intent ?? null,
                    ]);
                }

                $reservation = $payment->reservation;

                return view('booking.payment-success', [
                    'reservation' => $reservation,
                    'payment' => $payment,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('book.index')->with('error', 'Gagal memuat status pembayaran.');
        }

        return redirect()->route('book.index')->with('error', 'Pembayaran belum selesai.');
    }

    public function cancel(): RedirectResponse
    {
        return redirect()->route('book.index')->with('info', 'Pembayaran dibatalkan.');
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $endpointSecret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Event::constructFrom(
                Event::parseWebhook($payload, $sigHeader, $endpointSecret)
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $dataObject = $event->data->object;

        switch ($event->type) {
            case 'checkout.session.completed':
                /** @var Session $session */
                $session = $dataObject;
                $payment = Payment::where('stripe_session_id', $session->id)->first();

                if ($payment && $payment->isPending()) {
                    $payment->markAsSuccess([
                        'stripe_session_id' => $session->id,
                        'payment_intent_id' => $session->payment_intent ?? null,
                        'customer_email' => $session->customer_details->email ?? null,
                    ]);
                }
                break;

            case 'payment_intent.succeeded':
                /** @var PaymentIntent $paymentIntent */
                $paymentIntent = $dataObject;
                $payment = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

                if ($payment && $payment->isPending()) {
                    $payment->markAsSuccess([
                        'payment_intent_id' => $paymentIntent->id,
                        'payment_method' => $paymentIntent->payment_method ?? null,
                    ]);
                }
                break;

            case 'payment_intent.payment_failed':
                /** @var PaymentIntent $paymentIntent */
                $paymentIntent = $dataObject;
                $payment = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

                if ($payment) {
                    $payment->markAsFailed($paymentIntent->last_payment_error->message ?? 'Payment failed');
                }
                break;

            case 'checkout.session.expired':
                $session = $dataObject;
                $payment = Payment::where('stripe_session_id', $session->id)->first();

                if ($payment && $payment->isPending()) {
                    $payment->markAsFailed('Session expired');
                }
                break;
        }

        return response()->json(['received' => true]);
    }
}
