@extends('layouts.booking')

@section('title', 'Checkout Keranjang — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
    @endphp
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-semibold text-stone-900 sm:text-3xl">Checkout</h1>
        <p class="mt-2 text-sm text-stone-600">Selesaikan pemesanan untuk {{ count($cartItems) }} item</p>

        @if (!empty($invalidItems ?? []))
            <div class="mt-8 border border-red-200 bg-red-50 p-4 rounded-lg shadow-sm">
                <p class="text-red-800 text-lg font-semibold mb-4">Item Tidak Valid di Keranjang:</p>
                @foreach ($invalidItems as $item)
                    <div class="mt-3 bg-white p-4 rounded-lg border border-red-200">
                        <p class="text-sm font-semibold text-red-800">{{ $item->hotel->name }} - {{ $item->room->type }}</p>
                        <span class="block mt-1 text-base text-red-700 font-medium">{{ $item->error }}</span>
                    </div>
                @endforeach
                <p class="mt-4 text-sm text-red-700">
                    <strong>Pesan:</strong> Item di atas tidak dapat diproses. Silakan periksa kembali atau hapus dari keranjang.
                </p>
            </div>
        @endif

        <div class="mt-10 grid gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-md sm:p-8">
                    <h2 class="font-semibold text-stone-900">Data tamu utama</h2>
                    <form action="{{ route('cart.store') }}" method="post" class="mt-6 space-y-4">
                        @csrf
                        @foreach ($cartItems as $item)
                            <input type="hidden" name="items[{{ $loop->index }}][hotel_id]" value="{{ $item->hotel_id }}">
                            <input type="hidden" name="items[{{ $loop->index }}][room_id]" value="{{ $item->room_id }}">
                            <input type="hidden" name="items[{{ $loop->index }}][check_in]" value="{{ $item->check_in }}">
                            <input type="hidden" name="items[{{ $loop->index }}][check_out]" value="{{ $item->check_out }}">
                            <input type="hidden" name="items[{{ $loop->index }}][adults]" value="{{ $item->adults }}">
                            <input type="hidden" name="items[{{ $loop->index }}][children]" value="{{ $item->children }}">
                            <input type="hidden" name="items[{{ $loop->index }}][rooms]" value="{{ $item->rooms }}">
                        @endforeach

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="guest_name">Nama lengkap</label>
                            <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name', auth()->user()->name) }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="phone">Nomor telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="requests">Permintaan khusus (opsional)</label>
                            <textarea name="requests" id="requests" rows="3" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">{{ old('requests') }}</textarea>
                        </div>

                        @if ($errors->any())
                            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                                <ul class="list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" {{ @if (!empty($invalidItems)) 'disabled' }} class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                            Lanjut Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            <aside class="lg:col-span-2">
                <div class="sticky top-24 rounded-3xl border border-stone-200 bg-[#f7f5d5] p-6 shadow-md">
                    <h2 class="font-semibold text-stone-900">Ringkasan Pesanan</h2>
                    <div class="mt-4 space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="border-t border-stone-200 pt-4 first:mt-0 first:border-t-0 first:pt-0">
                                <p class="text-sm font-medium text-stone-800">{{ $item->hotel->name }}</p>
                                <p class="text-sm text-stone-600">{{ $item->room->type }}</p>
                                <p class="text-xs text-stone-500">
                                    {{ \Carbon\Carbon::parse($item->check_in)->format('d M') }} → {{ \Carbon\Carbon::parse($item->check_out)->format('d M') }}
                                    ({{ $item->nights }} malam) · {{ $item->rooms }} kamar
                                </p>
                                <p class="mt-1 text-sm font-semibold text-stone-900">{{ $fmt($item->total) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <dl class="mt-6 space-y-2 border-t  pt-6 text-sm" style="color: #8a1e29;">
                        <div class="flex justify-between text-stone-600">
                            <dt>Subtotal</dt>
                            <dd>{{ $fmt($cartItems->sum('subtotal')) }}</dd>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <dt>Pajak & layanan (11%)</dt>
                            <dd>{{ $fmt($cartItems->sum('tax')) }}</dd>
                        </div>
                        <div class="flex justify-between text-base font-semibold text-stone-900" style="color: #8a1e29;">
                            <dt>Total</dt>
                            <dd>{{ $fmt($total) }}</dd>
                        </div>
                    </dl>
                </div>
            </aside>
        </div>
    </div>
@endsection
