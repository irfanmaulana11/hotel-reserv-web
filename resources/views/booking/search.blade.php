@extends('layouts.booking')

@section('title', 'Hasil pencarian — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
        $hasDate = $check_in && $check_out;
        $from = $hasDate ? \Illuminate\Support\Carbon::parse($check_in)->translatedFormat('d M Y') : null;
        $to   = $hasDate ? \Illuminate\Support\Carbon::parse($check_out)->translatedFormat('d M Y') : null;
    @endphp
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Search form --}}
        <div class="rounded-3xl border border-stone-200 bg-[#f7f5d5] p-6 shadow-md sm:p-8">
    {{-- Grid diubah ke lg:grid-cols-6 untuk menampung semua elemen dalam satu baris --}}
    <form action="{{ route('book.search') }}" method="get" class="grid gap-4 md:grid-cols-2 lg:grid-cols-6 lg:items-end">

        {{-- 1. Destinasi (Dropdown Fixed) --}}
        <div class="md:col-span-2 lg:col-span-1">
            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-city">Destinasi</label>
            <select name="city" id="s-city" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm text-stone-900 outline-none focus:border-brand focus:ring-2 focus:ring-sage-100 appearance-none cursor-pointer">
                <option value="" class="bg-white">Semua kota</option>
                @foreach (\App\Models\Hotel::where('is_active', true)->distinct()->pluck('city')->sort() as $c)
                    <option value="{{ $c }}" @selected($city === $c) class="bg-white">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        {{-- 2. Check-in --}}
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-in">Check-in</label>
            <input type="date" name="check_in" id="s-in" value="{{ $check_in ?? now()->addDay()->toDateString() }}" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
        </div>

        {{-- 3. Check-out --}}
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-out">Check-out</label>
            <input type="date" name="check_out" id="s-out" value="{{ $check_out ?? now()->addDays(3)->toDateString() }}" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
        </div>

        {{-- 4. Dewasa, Anak, Kamar (Grouped) --}}
        <div class="md:col-span-2 lg:col-span-2 grid grid-cols-3 gap-2">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-adults">Dewasa</label>
                <input type="number" name="adults" id="s-adults" min="1" max="8" value="{{ $adults }}" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-children">Anak</label>
                <input type="number" name="children" id="s-children" min="0" max="6" value="{{ $children }}" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="s-rooms">Kamar</label>
                <input type="number" name="rooms" id="s-rooms" min="1" max="10" value="{{ $rooms }}" class="mt-2 w-full rounded-2xl border border-stone-200 bg-transparent px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
            </div>
        </div>

        {{-- 5. Tombol Cari (Sekarang Inline) --}}
        <div class="md:col-span-2 lg:col-span-1">
            <button type="submit" class="w-full rounded-2xl bg-brand py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                Cari hotel
            </button>
        </div>
    </form>
</div>

        {{-- Header hasil --}}
        <div class="mt-8 flex flex-col gap-2 border-b border-stone-200 pb-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-brand">Hasil pencarian</p>
                <h1 class="mt-1 font-serif text-2xl font-semibold text-stone-900 sm:text-3xl">
                    {{ $city ?: 'Semua kota' }}
                </h1>
                <p class="mt-1 text-sm text-stone-500">
                    @if ($hasDate)
                        {{ $from }} – {{ $to }} · {{ $adults }} dewasa{{ $children > 0 ? ', '.$children.' anak' : '' }} · {{ $rooms }} kamar · {{ $nights }} malam
                    @else
                        Isi tanggal & tamu di form atas untuk melihat harga dan ketersediaan.
                    @endif
                </p>
            </div>
            <span class="text-sm text-stone-500">{{ $hotels->count() }} hotel ditemukan</span>
        </div>

        {{-- List hotel --}}
        <div class="mt-8 space-y-6">
            @forelse ($hotels as $hotel)
                @php
                    $minPrice = collect($hotel['rooms'])->min('price');
                    $totalAvail = collect($hotel['rooms'])->sum('available_rooms');
                    $fullyBooked = $totalAvail === 0;
                @endphp
                <article class="overflow-hidden rounded-3xl border bg-white shadow-md transition md:flex {{ $fullyBooked ? 'border-stone-200 opacity-75' : 'border-stone-200 hover:border-brand/30 hover:shadow-xl' }}">
                    <div class="relative md:w-72 md:shrink-0">
                        <img src="{{ $hotel['image'] }}" alt="{{ $hotel['name'] }}" class="h-48 w-full object-cover md:h-full" width="600" height="400" loading="lazy">
                        @if ($fullyBooked)
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-stone-700">Penuh</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col justify-between p-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                {{ $hotel['brand'] }}
                            </p>

                            <h2 class="mt-1 font-serif text-2xl font-semibold text-stone-900">
                                {{ $hotel['name'] }}
                            </h2>

                            <div class="mt-1 flex items-center gap-1.5 text-sm text-stone-600">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>

                                <span>
                                    {{ $hotel['city'] }}
                                    <span class="mx-1 text-stone-400">·</span>
                                    <span style="color: #fbce00;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($hotel['rating']))
                                                ★
                                            @endif
                                        @endfor
                                    </span>
                                </span>
                            </div>

                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-stone-600">
                                {{ $hotel['description'] }}
                            </p>
                        </div>
                        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-xl text-stone-600">
                                    Mulai dari <span class="font-semibold text-stone-900">{{ $fmt($minPrice) }}</span>
                                    <span class="text-stone-400">/ malam</span>
                                </p>
                                @if ($fullyBooked)
                                    <p class="mt-0.5 text-xs font-medium text-stone-400" style="color: #8a1e29;">Tidak ada kamar tersisa</p>
                                @else
                                    <p class="mt-0.5 text-xs text-stone-500" style="color: #8a1e29;">{{ $totalAvail }} kamar tersisa</p>
                                @endif
                            </div>
                            @if ($fullyBooked)
                                <span class="inline-flex justify-center rounded-2xl border border-stone-200 px-5 py-2.5 text-sm font-semibold text-stone-400 sm:shrink-0">
                                    Tidak tersedia
                                </span>
                            @else
                                <a href="{{ route('book.hotel', array_filter(['slug' => $hotel['slug'], 'check_in' => $check_in, 'check_out' => $check_out, 'adults' => $adults, 'children' => $children, 'rooms' => $rooms])) }}" class="inline-flex justify-center rounded-2xl bg-brand px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark sm:shrink-0">
                                    Lihat kamar
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-stone-300 bg-stone-50 px-6 py-12 text-center">
                    <p class="font-medium text-stone-800">Tidak ada hotel ditemukan</p>
                    <p class="mt-2 text-sm text-stone-600">Coba ubah kota atau hapus filter.</p>
                    <a href="{{ route('book.index') }}" class="mt-6 inline-flex rounded-2xl bg-brand px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-dark">Kembali ke beranda booking</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
