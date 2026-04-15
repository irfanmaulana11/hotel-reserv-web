@extends('layouts.booking')

@section('title', 'Checkout — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
    @endphp
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-semibold text-stone-900 sm:text-3xl">Selesaikan pemesanan</h1>
        <p class="mt-2 text-sm text-stone-600">Ini alur demo — tidak ada pembayaran nyata.</p>

        <div class="mt-10 grid gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-md sm:p-8">
                    <h2 class="font-semibold text-stone-900">Data tamu utama</h2>
                    <form action="{{ route('book.store') }}" method="post" class="mt-6 space-y-4">
                        @csrf
                        <input type="hidden" name="hotel" value="{{ $hotel['slug'] }}">
                        <input type="hidden" name="room_type" value="{{ $room['type'] }}">
                        <input type="hidden" name="check_in" value="{{ $check_in }}">
                        <input type="hidden" name="check_out" value="{{ $check_out }}">
                        <input type="hidden" name="adults" value="{{ $adults }}">
                        <input type="hidden" name="children" value="{{ $children }}">
                        <input type="hidden" name="rooms" value="{{ $rooms }}">

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="guest_name">Nama lengkap</label>
                            <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="phone">Nomor telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="requests">Permintaan khusus (opsional)</label>
                            <textarea name="requests" id="requests" rows="3" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">{{ old('requests') }}</textarea>
                        </div>

                        @if ($errors->any())
                            <div class="rounded-2xl border border-sage-200 bg-sage-50 px-4 py-3 text-sm text-sage-800">
                                <ul class="list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                            Konfirmasi pemesanan demo
                        </button>
                    </form>
                </div>
            </div>
            <aside class="lg:col-span-2">
                <div class="sticky top-24 rounded-3xl border border-stone-200 bg-white p-6 shadow-md">
                    <h2 class="font-semibold text-stone-900">Ringkasan</h2>
                    <p class="mt-2 text-sm font-medium text-stone-800">{{ $hotel['name'] }}</p>
                    <p class="mt-1 text-sm text-stone-600">{{ $room['type'] }} · {{ $adults }} dewasa{{ $children > 0 ? ', '.$children.' anak' : '' }} · {{ $rooms }} kamar</p>
                    <p class="mt-4 text-sm text-stone-600">{{ $check_in }} → {{ $check_out }} ({{ $nights }} malam)</p>
                    <dl class="mt-6 space-y-2 border-t border-stone-100 pt-6 text-sm">
                        <div class="flex justify-between text-stone-600">
                            <dt>Subtotal</dt>
                            <dd>{{ $fmt($subtotal) }}</dd>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <dt>Pajak & layanan (11%)</dt>
                            <dd>{{ $fmt($tax) }}</dd>
                        </div>
                        <div class="flex justify-between text-base font-semibold text-stone-900">
                            <dt>Total</dt>
                            <dd>{{ $fmt($total) }}</dd>
                        </div>
                    </dl>
                </div>
            </aside>
        </div>
    </div>
@endsection
