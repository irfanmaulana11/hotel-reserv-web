@extends('layouts.booking')

@section('title', 'Keranjang Belanja — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
    @endphp
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-semibold text-stone-900 sm:text-3xl">Keranjang Belanja</h1>
        <p class="mt-2 text-sm text-stone-600">Kelola pesanan kamar Anda sebelum checkout</p>

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

        @if (session('warning'))
            <div class="mt-4 rounded-2xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                {{ session('warning') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="mt-10 rounded-3xl border border-stone-200 bg-white p-10 text-center shadow-sm">
                <svg class="mx-auto h-16 w-16 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-stone-900">Keranjang kosong</h3>
                <p class="mt-2 text-sm text-stone-600">Mulai tambahkan kamar hotel ke keranjang Anda</p>
                <a href="{{ route('book.index') }}" class="mt-6 inline-block rounded-2xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                    Pesan Kamar
                </a>
            </div>
        @else
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="rounded-3xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-stone-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h2 class="font-semibold text-stone-900">Item di Keranjang ({{ $cartItems->count() }})</h2>
                                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700">Kosongkan semua</button>
                                </form>
                            </div>
                        </div>
                        <div class="divide-y divide-stone-100">
                            @foreach ($cartItems as $item)
                                <div class="p-6 {{ isset($item->error) ? 'bg-red-50' : '' }}">
                                    <div class="flex gap-4">
                                        <img src="{{ $item->room->image_url ?? 'https://placehold.co/120x90/e7e5e4/a8a29e?text=Room' }}"
                                             alt="{{ $item->room->type }}"
                                             class="h-20 w-28 rounded-xl object-cover">
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="font-semibold text-stone-900">{{ $item->hotel->name }}</h3>
                                                    <p class="text-sm text-stone-600">{{ $item->room->type }}</p>
                                                    <p class="mt-2 text-xs text-stone-500">
                                                        {{ \Carbon\Carbon::parse($item->check_in)->format('d M Y') }} →
                                                        {{ \Carbon\Carbon::parse($item->check_out)->format('d M Y') }}
                                                        ({{ $item->nights }} malam)
                                                    </p>
                                                    <p class="text-xs text-stone-500">
                                                        {{ $item->adults }} dewasa{{ $item->children > 0 ? ', '.$item->children.' anak' : '' }} ·
                                                        {{ $item->rooms }} kamar
                                                    </p>
                                                </div>
                                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-stone-400 hover:text-red-600">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            @if (isset($item->error))
                                                <div class="mt-3 flex items-center gap-2 rounded-xl border border-red-200 bg-red-100 px-3 py-2 text-xs text-red-800">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $item->error }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-stone-900">{{ $fmt($item->total) }}</p>
                                            <p class="text-xs text-stone-500">{{ $fmt($item->subtotal) }} + {{ $fmt($item->tax) }} pajak</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 rounded-3xl border border-stone-200 bg-white p-6 shadow-md">
                        <h2 class="font-semibold text-stone-900">Ringkasan</h2>

                        @if ($invalidItems->count() > 0)
                            <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-900">{{ $invalidItems->count() }} item tidak valid</p>
                                        <p class="mt-1 text-xs text-red-700">Item dengan tanggal lewat atau stok habis tidak dapat di-checkout</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <dl class="mt-6 space-y-3 border-t border-stone-100 pt-6 text-sm">
                            <div class="flex justify-between text-stone-600">
                                <dt>Item valid</dt>
                                <dd>{{ $validItems->count() }} dari {{ $cartItems->count() }}</dd>
                            </div>
                            <div class="flex justify-between text-base font-semibold text-stone-900">
                                <dt>Total</dt>
                                <dd>{{ $fmt($totalValid) }}</dd>
                            </div>
                        </dl>

                        @if ($validItems->count() > 0)
                            <form action="{{ route('cart.checkout') }}" method="GET" class="mt-6">
                                <button type="submit" class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                                    Checkout ({{ $validItems->count() }} item)
                                </button>
                            </form>
                        @else
                            <button disabled class="mt-6 w-full cursor-not-allowed rounded-2xl bg-stone-200 py-3 text-sm font-semibold text-stone-500">
                                Checkout tidak tersedia
                            </button>
                        @endif

                        <a href="{{ route('book.index') }}" class="mt-3 block text-center text-sm font-medium text-stone-600 hover:text-brand">
                            Lanjutkan belanja &rarr;
                        </a>
                    </div>
                </aside>
            </div>
        @endif
    </div>
@endsection
