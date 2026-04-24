@extends('layouts.booking')

@section('title', 'Pemesanan berhasil — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
        $b = $booking;
    @endphp
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 text-center shadow-md sm:p-10">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700" aria-hidden="true">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="mt-6 font-serif text-2xl font-semibold text-stone-900">Pemesanan tercatat</h1>
            <p class="mt-2 text-sm text-stone-600">Referensi: <span class="font-mono font-semibold text-stone-900">{{ $b['reference'] }}</span></p>
            <p class="mt-6 text-left text-sm leading-relaxed text-stone-600">
                Terima kasih, <span class="font-medium text-stone-900">{{ $b['guest_name'] }}</span>. Kami telah mengirim ringkasan ke <span class="font-medium text-stone-900">{{ $b['email'] }}</span> (simulasi — tidak ada email nyata).
            </p>
            <dl class="mt-8 space-y-3 rounded-2xl bg-canvas px-5 py-4 text-left text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-500">Hotel</dt>
                    <dd class="font-medium text-stone-900">{{ $b['hotel_name'] }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-500">Kamar</dt>
                    <dd class="font-medium text-stone-900">{{ $b['room_type'] }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-500">Menginap</dt>
                    <dd class="font-medium text-stone-900">{{ $b['check_in'] }} – {{ $b['check_out'] }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-500">Tamu</dt>
                    <dd class="font-medium text-stone-900">
                        {{ $b['adults'] }} dewasa{{ ($b['children'] ?? 0) > 0 ? ', '.$b['children'].' anak' : '' }}
                    </dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-500">Jumlah kamar</dt>
                    <dd class="font-medium text-stone-900">{{ $b['rooms'] }}</dd>
                </div>
                <div class="flex justify-between gap-4 border-t border-stone-200 pt-3">
                    <dt class="text-stone-500">Total</dt>
                    <dd class="font-semibold text-stone-900">{{ $fmt($b['total']) }}</dd>
                </div>
            </dl>
            @if (! empty($b['requests']))
                <p class="mt-6 text-left text-sm text-stone-600"><span class="font-medium text-stone-800">Permintaan:</span> {{ $b['requests'] }}</p>
            @endif

            {{-- Stripe Payment --}}
            <div class="mt-8 rounded-2xl border border-stone-200 bg-stone-50 p-6">
                <h2 class="font-semibold text-stone-900">Pembayaran dengan Stripe</h2>
                <p class="mt-1 text-sm text-stone-600">Bayar dengan kartu kredit/debit melalui Stripe.</p>

                @if (session('error'))
                    <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('book.stripe.checkout') }}" method="post" class="mt-4">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{ $b['reservation_id'] }}">
                    <button type="submit" class="w-full rounded-2xl bg-[#635bff] py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5851e6]">
                        <svg class="mx-auto h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M13.976 9.15c2.172-.806 3.356-1.427 3.356-2.982 0-1.754-1.587-2.94-4.228-2.94-2.668 0-4.389 1.246-4.965 3.154l4.523 1.683.286-1.082c.333-1.143 1.054-1.515 2.024-1.515.915 0 1.354.372 1.354 1.026 0 .806-.548 1.354-2.854 2.172-2.305.806-3.87 1.488-3.87 3.322 0 1.967 1.649 3.125 4.415 3.125 2.641 0 4.228-1.104 4.848-3.042l-4.613-1.912-.274 1.082c-.25 1.054-.888 1.488-2.024 1.488-1.026 0-1.488-.434-1.488-1.082 0-.75.488-1.323 2.71-2.097h.001ZM12 24C5.373 24 0 18.627 0 12S5.373 0 12 0s12 5.373 12 12-5.373 12-12 12Z"/></svg>
                        Bayar dengan Stripe
                    </button>
                </form>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <a href="{{ route('book.index') }}" class="inline-flex justify-center rounded-2xl bg-brand px-6 py-3 text-sm font-semibold text-white hover:bg-brand-dark">Pesan lagi</a>
                <a href="{{ url('/') }}" class="inline-flex justify-center rounded-2xl border border-stone-200 px-6 py-3 text-sm font-semibold text-stone-800 hover:border-brand hover:text-brand">Ke beranda</a>
            </div>
        </div>
    </div>
@endsection
