@extends('layouts.booking')

@section('title', 'Detail Pesanan — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
    @endphp
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('orders.index') }}" class="text-sm font-medium text-stone-600 hover:text-brand">&larr; Kembali ke Pesanan Saya</a>

        <div class="mt-6 rounded-3xl border border-stone-200 bg-white p-6 shadow-md sm:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-serif text-2xl font-semibold text-stone-900">Detail Pesanan</h1>
                    <p class="mt-1 font-mono text-sm text-stone-500">{{ $reservation->reference }}</p>
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'confirmed' => 'bg-green-100 text-green-800',
                        'checked_in' => 'bg-blue-100 text-blue-800',
                        'checked_out' => 'bg-stone-100 text-stone-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'checked_in' => 'Check-in',
                        'checked_out' => 'Check-out',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                <span class="rounded-full px-3 py-1 text-sm font-medium {{ $statusColors[$reservation->status] ?? 'bg-stone-100 text-stone-800' }}">
                    {{ $statusLabels[$reservation->status] ?? $reservation->status }}
                </span>
            </div>

            <div class="mt-8 grid gap-8 sm:grid-cols-2">
                <div>
                    <h2 class="font-semibold text-stone-900">Hotel</h2>
                    <p class="mt-2 text-stone-700">{{ $reservation->hotel->name }}</p>
                    <p class="text-sm text-stone-600">{{ $reservation->hotel->city }}, {{ $reservation->hotel->country }}</p>
                </div>
                <div>
                    <h2 class="font-semibold text-stone-900">Kamar</h2>
                    <p class="mt-2 text-stone-700">{{ $reservation->room->type }}</p>
                    <p class="text-sm text-stone-600">{{ $reservation->rooms }} kamar</p>
                </div>
            </div>

            <div class="mt-8 rounded-2xl border border-stone-200 bg-stone-50 p-6">
                <h2 class="font-semibold text-stone-900">Detail Penginapan</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Check-in</dt>
                        <dd class="mt-1 text-stone-900">{{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Check-out</dt>
                        <dd class="mt-1 text-stone-900">{{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Tamu</dt>
                        <dd class="mt-1 text-stone-900">{{ $reservation->adults }} dewasa{{ $reservation->children > 0 ? ', '.$reservation->children.' anak' : '' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Durasi</dt>
                        <dd class="mt-1 text-stone-900">{{ $reservation->nights }} malam</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-8 rounded-2xl border border-stone-200 bg-stone-50 p-6">
                <h2 class="font-semibold text-stone-900">Data Tamu</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Nama</dt>
                        <dd class="mt-1 text-stone-900">{{ $reservation->guest_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Email</dt>
                        <dd class="mt-1 text-stone-900">{{ $reservation->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Telepon</dt>
                        <dd class="mt-1 text-stone-900">{{ $reservation->phone }}</dd>
                    </div>
                    @if ($reservation->requests)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Permintaan Khusus</dt>
                            <dd class="mt-1 text-stone-900">{{ $reservation->requests }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="mt-8 rounded-2xl border border-[#e8dcc0] bg-[#f7f5d5] p-6">
                <h2 class="font-semibold text-stone-900">Ringkasan Pembayaran</h2>
                <dl class="mt-4 space-y-2">
                    <div class="flex justify-between text-stone-600">
                        <dt>Subtotal</dt>
                        <dd>{{ $fmt($reservation->subtotal) }}</dd>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <dt>Pajak & layanan (11%)</dt>
                        <dd>{{ $fmt($reservation->tax) }}</dd>
                    </div>
                    <div class="flex justify-between border-t border-stone-300 pt-3 text-base font-semibold text-stone-900">
                        <dt>Total</dt>
                        <dd style="color: #8a1e29;">{{ $fmt($reservation->total) }}</dd>
                    </div>
                </dl>
            </div>

            @if ($reservation->payment)
                <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-6">
                    <h2 class="font-semibold text-stone-900">Informasi Pembayaran</h2>
                    <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Status</dt>
                            <dd class="mt-1 text-stone-900">{{ ucfirst($reservation->payment->status) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Jumlah</dt>
                            <dd class="mt-1 text-stone-900">{{ $fmt($reservation->payment->amount) }}</dd>
                        </div>
                        @if ($reservation->payment->paid_at)
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">Dibayar pada</dt>
                                <dd class="mt-1 text-stone-900">{{ \Carbon\Carbon::parse($reservation->payment->paid_at)->format('d M Y H:i') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            <div class="mt-8 text-xs text-stone-500">
                Dipesan pada {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y H:i') }}
            </div>
        </div>
    </div>
@endsection
