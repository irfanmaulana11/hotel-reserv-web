@extends('layouts.booking')

@section('title', 'Booking — Hotel ABC')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <h1 class="font-serif text-3xl font-semibold text-stone-900 sm:text-4xl">Mulai perjalanan Anda</h1>
            <p class="mt-3 text-sm leading-relaxed text-stone-600 sm:text-base">
                Pilih tanggal, jumlah tamu, dan kota — kami menampilkan properti yang cocok.
            </p>
        </div>

        <div class="mt-10 rounded-3xl border border-stone-200 bg-white p-6 shadow-md sm:p-8">
            <form action="{{ route('book.search') }}" method="get" class="grid gap-5 md:grid-cols-2 lg:grid-cols-5 lg:items-end">
                <div class="md:col-span-2 lg:col-span-1">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="city">Destinasi</label>
                    <select name="city" id="city" class="mt-2 w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                        <option value="">Semua kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="check_in">Check-in</label>
                    <input type="date" name="check_in" id="check_in" value="{{ now()->addDay()->toDateString() }}" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="check_out">Check-out</label>
                    <input type="date" name="check_out" id="check_out" value="{{ now()->addDays(3)->toDateString() }}" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="adults">Dewasa</label>
                        <input type="number" name="adults" id="adults" min="1" max="8" value="2" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="children">Anak</label>
                        <input type="number" name="children" id="children" min="0" max="6" value="0" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="rooms">Kamar</label>
                        <input type="number" name="rooms" id="rooms" min="1" max="10" value="1" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                    </div>
                </div>
                <div class="md:col-span-2 lg:col-span-5">
                    <button type="submit" class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark md:w-auto md:px-10">
                        Cari hotel
                    </button>
                </div>
            </form>
        </div>

        <section class="mt-16">
            <h2 class="font-serif text-2xl font-semibold text-stone-900">Destinasi populer</h2>
            <div class="mt-6 grid grid-cols-3 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($destinations as $d)
                    <a
                        href="{{ route('book.search', ['city' => $d['city']]) }}"
                        class="group flex flex-col overflow-hidden rounded-3xl border border-stone-200/90 bg-white shadow-md transition hover:border-brand/40 hover:shadow-xl"
                    >
                        <div class="relative aspect-[3/4] w-full shrink-0 overflow-hidden bg-stone-200">
                            <img
                                src="{{ $d['image'] ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80' }}"
                                alt="Destinasi {{ $d['city'] }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                width="400" height="500" loading="lazy"
                            >
                        </div>
                        <div class="flex flex-1 flex-col bg-white px-3 py-3 text-left sm:px-4 sm:py-4">
                            <p class="text-sm font-bold leading-tight text-stone-900 group-hover:text-brand sm:text-base">{{ $d['city'] }}</p>
                            <p class="mt-1 text-xs font-normal text-stone-500">{{ $d['hotels'] }} hotel</p>
                            <p class="mt-0.5 hidden text-xs font-normal text-stone-500 sm:block">{{ $d['rooms'] }} kamar</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
