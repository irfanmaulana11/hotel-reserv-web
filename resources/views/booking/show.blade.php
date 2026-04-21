@extends('layouts.booking')

@section('title', $hotel['name'].' — Hotel ABC')

@section('content')
    @php
        $fmt = fn (int $n) => 'Rp '.number_format($n, 0, ',', '.');
        $defaultIn = now()->addDay()->toDateString();
        $defaultOut = now()->addDays(3)->toDateString();
    @endphp
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($staySelected)
            <a href="{{ route('book.search', ['city' => $hotel['city'], 'check_in' => $check_in, 'check_out' => $check_out, 'adults' => $adults ?? 2, 'children' => $children ?? 0, 'rooms' => $rooms ?? 1]) }}" class="text-sm font-semibold text-brand hover:text-brand-dark">← Kembali ke hasil</a>
        @else
            <a href="{{ route('book.index') }}" class="text-sm font-semibold text-brand hover:text-brand-dark">← Kembali ke pencarian</a>
        @endif

        <div class="mt-6 overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-md">
            <div class="aspect-[21/9] w-full overflow-hidden bg-stone-100">
                <img src="{{ $hotel['image'] }}" alt="{{ $hotel['name'] }}" class="h-full w-full object-cover" width="1200" height="514">
            </div>
            <div class="p-6 sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                    {{ $hotel['brand'] }}
                </p>

                <h1 class="mt-2 font-serif text-3xl font-semibold text-stone-900">
                    {{ $hotel['name'] }}
                </h1>

                <p class="mt-1 text-sm text-stone-600">
                    <span style="color: #fbce00;">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($hotel['rating']))
                                ★
                            @endif
                        @endfor
                    </span>
                </p>

                <div class="mt-2 flex items-start gap-1.5 text-sm text-stone-600">
                    <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>

                    <p>
                        {{ $hotel['city'] }}
                        @if ($staySelected)
                            <span class="mx-1 text-stone-300">·</span>
                            {{ $adults }} dewasa{{ $children > 0 ? ', '.$children.' anak' : '' }} · {{ $rooms }} kamar · {{ $nights }} malam
                        @endif
                    </p>
                </div>

                <p class="mt-4 max-w-3xl text-sm leading-relaxed text-stone-600">
                    {{ $hotel['description'] }}
                </p>
            </div>
        </div>

        <section class="mt-8 rounded-3xl border border-stone-200 bg-[#f7f5d5] p-6 shadow-md sm:p-8" aria-labelledby="stay-form-heading">
            <h2 id="stay-form-heading" class="font-serif text-xl font-semibold text-stone-900 sm:text-2xl">
                @if ($staySelected)
                    Periode menginap Anda
                @else
                    Pilih tanggal & tamu
                @endif
            </h2>
            @if (! $staySelected)
                <p class="mt-2 text-sm text-stone-600">
                    Isi check-in, check-out, dan jumlah tamu untuk menampilkan kamar yang tersedia beserta harga.
                </p>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-2xl border border-sage-200 bg-sage-50 px-4 py-3 text-sm text-sage-800">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($staySelected)
                <div class="mt-6 flex flex-col gap-4 rounded-2xl bg-canvas px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <div class="text-sm text-stone-700">
                        <p class="font-semibold text-stone-900">
                            {{ \Illuminate\Support\Carbon::parse($check_in)->translatedFormat('d M Y') }}
                            –
                            {{ \Illuminate\Support\Carbon::parse($check_out)->translatedFormat('d M Y') }}
                        </p>
                        <p class="mt-1 text-stone-600">{{ $adults }} dewasa{{ $children > 0 ? ', '.$children.' anak' : '' }} · {{ $rooms }} kamar · {{ $nights }} malam</p>
                    </div>
                    <a href="{{ route('book.hotel', ['slug' => $hotel['slug']]) }}" class="inline-flex justify-center rounded-2xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-800 transition hover:border-brand hover:text-brand sm:shrink-0">
                        Ubah pencarian
                    </a>
                </div>
            @endif

            @unless ($staySelected)
                <form method="get" action="{{ route('book.hotel', ['slug' => $hotel['slug']]) }}" class="mt-6">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="hotel-check-in">Check-in</label>
                            <input
                                type="date"
                                name="check_in"
                                id="hotel-check-in"
                                required
                                value="{{ old('check_in', $defaultIn) }}"
                                class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="hotel-check-out">Check-out</label>
                            <input
                                type="date"
                                name="check_out"
                                id="hotel-check-out"
                                required
                                value="{{ old('check_out', $defaultOut) }}"
                                class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100"
                            >
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="hotel-adults">Dewasa</label>
                                <input type="number" name="adults" id="hotel-adults" min="1" max="8" required value="{{ old('adults', 2) }}" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="hotel-children">Anak</label>
                                <input type="number" name="children" id="hotel-children" min="0" max="6" value="{{ old('children', 0) }}" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="hotel-rooms">Kamar</label>
                                <input type="number" name="rooms" id="hotel-rooms" min="1" max="10" required value="{{ old('rooms', 1) }}" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-full rounded-2xl bg-brand py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark lg:mt-0">
                                Cek ketersediaan kamar
                            </button>
                        </div>
                    </div>
                </form>
            @endunless
        </section>

        @if ($staySelected)
            <h2 class="mt-12 font-serif text-2xl font-semibold text-stone-900">Pilih kamar</h2>
            <div class="mt-6 space-y-4">
                @foreach ($hotel['rooms'] as $room)
                    @continue($room['max_guests'] < ($adults + $children))
                    @continue($room['available_rooms'] < $rooms)
                    @php $line = $room['price'] * $nights * $rooms; @endphp
                    <div class="overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-md transition hover:shadow-xl sm:flex">
                        <div class="aspect-video w-full shrink-0 overflow-hidden bg-stone-100 sm:aspect-auto sm:w-56">
                            <img
                                src="{{ $room['image'] }}"
                                alt="{{ $room['type'] }}"
                                class="h-full w-full object-cover"
                                width="400" height="300" loading="lazy"
                            >
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-5">
                            <div>
                                <h3 class="font-semibold text-2xl text-stone-900">{{ $room['type'] }}</h3>
                                <p class="mt-1 text-sm text-stone-600">Maks. {{ $room['max_guests'] }} tamu · {{ $fmt($room['price']) }} / malam</p>
                                <p class="mt-1 text-xs font-medium" style="color: #8a1e29;">
                                    {{ $room['available_rooms'] }} kamar tersisa
                                </p>

                                @if (!empty($room['facilities']))
                                    @php
                                        $facilityMap = [
                                            'wifi' => [
                                                'label' => 'WiFi Gratis',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.14 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>',
                                            ],
                                            'ac' => [
                                                'label' => 'AC',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>',
                                            ],
                                            'tv' => [
                                                'label' => 'TV',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>',
                                            ],
                                            'breakfast' => [
                                                'label' => 'Sarapan',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7H18M9 21a1 1 0 100-2 1 1 0 000 2zm10 0a1 1 0 100-2 1 1 0 000 2z"/></svg>',
                                            ],
                                            'extra_bed' => [
                                                'label' => 'Extra Bed',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>',
                                            ],
                                            'private_bathroom' => [
                                                'label' => 'Kamar Mandi',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>',
                                            ],
                                            'hot_water' => [
                                                'label' => 'Air Panas',
                                                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>',
                                            ],
                                        ];
                                    @endphp
                                    <div class="mt-3 grid grid-cols-2 gap-1.5 sm:grid-cols-3">
                                        @foreach ($room['facilities'] as $key)
                                            @if (isset($facilityMap[$key]))
                                                <div class="flex items-center gap-1.5 rounded-xl bg-stone-50 px-2.5 py-1.5 text-xs text-stone-600">
                                                    <span class="text-brand">{!! $facilityMap[$key]['icon'] !!}</span>
                                                    <span>{{ $facilityMap[$key]['label'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xl text-stone-600">
                                    Total <span class="font-semibold text-stone-900" style="color: #474ecf;">{{ $fmt($line) }}</span>
                                    <span class="text-stone-400"> ({{ $rooms }} kamar × {{ $nights }} malam)</span>
                                </p>
                                <p class="text-xl text-stone-600">
                                    </span>
                                </p>
                                <a href="{{ route('book.checkout', ['hotel' => $hotel['slug'], 'room_type' => $room['type'], 'check_in' => $check_in, 'check_out' => $check_out, 'adults' => $adults, 'children' => $children, 'rooms' => $rooms]) }}" class="inline-flex justify-center rounded-2xl bg-brand px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-dark sm:shrink-0">
                                    Lanjut checkout
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
