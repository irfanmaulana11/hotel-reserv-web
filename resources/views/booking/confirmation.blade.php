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
            <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <a href="{{ route('book.index') }}" class="inline-flex justify-center rounded-2xl bg-brand px-6 py-3 text-sm font-semibold text-white hover:bg-brand-dark">Pesan lagi</a>
                <a href="{{ url('/') }}" class="inline-flex justify-center rounded-2xl border border-stone-200 px-6 py-3 text-sm font-semibold text-stone-800 hover:border-brand hover:text-brand">Ke beranda</a>
            </div>
        </div>
    </div>
@endsection
