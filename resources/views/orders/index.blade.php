@extends('layouts.booking')

@section('title', 'Pesanan Saya — Hotel ABC')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-semibold text-stone-900 sm:text-3xl">Pesanan Saya</h1>
        <p class="mt-2 text-sm text-stone-600">Pantau dan lihat riwayat pemesanan Anda</p>

        @if (session('success'))
            <div class="mt-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @if ($reservations->isEmpty())
            <div class="mt-10 rounded-3xl border border-stone-200 bg-white p-10 text-center shadow-sm">
                <svg class="mx-auto h-16 w-16 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-stone-900">Belum ada pesanan</h3>
                <p class="mt-2 text-sm text-stone-600">Mulai pesan kamar hotel untuk melihat riwayat pesanan</p>
                <a href="{{ route('book.index') }}" class="mt-6 inline-block rounded-2xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                    Pesan Kamar
                </a>
            </div>
        @else
            <div class="mt-8 space-y-4">
                @foreach ($reservations as $reservation)
                    <a href="{{ route('orders.show', $reservation) }}" class="block">
                        <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-brand hover:shadow-md">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs font-medium text-stone-500">{{ $reservation->reference }}</span>
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
                                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$reservation->status] ?? 'bg-stone-100 text-stone-800' }}">
                                            {{ $statusLabels[$reservation->status] ?? $reservation->status }}
                                        </span>
                                    </div>
                                    <h3 class="mt-2 font-semibold text-stone-900">{{ $reservation->hotel->name }}</h3>
                                    <p class="text-sm text-stone-600">{{ $reservation->room->type }} · {{ $reservation->adults }} dewasa{{ $reservation->children > 0 ? ', '.$reservation->children.' anak' : '' }} · {{ $reservation->rooms }} kamar</p>
                                    <p class="mt-1 text-xs text-stone-500">
                                        {{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }} →
                                        {{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}
                                        ({{ $reservation->nights }} malam)
                                    </p>
                                    <p class="mt-1 text-xs text-stone-500">Tamu: {{ $reservation->guest_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-stone-900">Rp {{ number_format($reservation->total, 0, ',', '.') }}</p>
                                    <p class="text-xs text-stone-500">{{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y') }}</p>
                                    <span class="mt-2 inline-block text-sm font-medium text-brand">Lihat detail &rarr;</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
@endsection
