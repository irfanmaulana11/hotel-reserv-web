@extends('layouts.landing')

@section('title', 'Hotel ABC — Keramahan Indonesia dalam Setiap Menginap')

@section('content')
    <section class="relative overflow-hidden bg-stone-900">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&q=80"
                alt="Lobi hotel"
                class="h-full w-full object-cover opacity-40"
                width="1920"
                height="1080"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-stone-950/95 via-stone-900/70 to-stone-900/30"></div>
        </div>
        <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-4 py-20 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8 lg:py-28">
            <div class="max-w-xl text-white">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-200/90">Destinasi</p>
                <h1 class="mt-4 font-serif text-4xl font-semibold leading-tight sm:text-5xl">
                    Halo, Temukan hotel yang tepat untuk setiap perjalanan Anda
                </h1>
                <p class="mt-5 text-base leading-relaxed text-stone-200">
                    Dari kota dinamis hingga sudut alam yang tenang — koleksi properti kami menghadirkan kenyamanan, perhatian pada detail, dan suasana seperti rumah.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('book.index') }}" class="rounded-full bg-white px-6 py-3 text-sm font-semibold text-stone-900 shadow-sm transition hover:bg-stone-100">
                        Cari & pesan kamar
                    </a>
                    <a href="#destinasi" class="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10">
                        Jelajahi kota
                    </a>
                </div>
            </div>
            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/10 p-6 shadow-2xl backdrop-blur-md">
                <p class="text-sm font-medium text-white">Cepat cari ketersediaan</p>
                <form action="{{ route('book.search') }}" method="get" class="mt-4 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-stone-200" for="hero-city">Kota</label>
                        <select name="city" id="hero-city" class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                            <option value="">Semua kota</option>
                            @foreach (\App\Models\Hotel::where('is_active', true)->distinct()->pluck('city')->sort() as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-stone-200" for="hero-in">Check-in</label>
                            <input type="date" name="check_in" id="hero-in" required value="{{ now()->addDay()->toDateString() }}" class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-stone-200" for="hero-out">Check-out</label>
                            <input type="date" name="check_out" id="hero-out" required value="{{ now()->addDays(3)->toDateString() }}" class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-stone-200" for="hero-adults">Dewasa</label>
                            <input type="number" name="adults" id="hero-adults" min="1" max="8" value="2" required class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-stone-200" for="hero-children">Anak</label>
                            <input type="number" name="children" id="hero-children" min="0" max="6" value="0" class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-stone-200" for="hero-rooms">Kamar</label>
                            <input type="number" name="rooms" id="hero-rooms" min="1" max="10" value="1" required class="mt-1 w-full rounded-2xl border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-stone-900 outline-none focus:ring-2 focus:ring-sage-300">
                        </div>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                        Temukan hotel
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section id="tentang" class="mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-brand">Perjalanan kami</p>
                <h2 class="mt-3 font-serif text-3xl font-semibold text-stone-900 sm:text-4xl">
                    Keunggulan keramahan Indonesia
                </h2>
                <p class="mt-5 text-sm leading-relaxed text-stone-600 sm:text-base">
                    Sejak 2007, kami membangun jaringan properti yang merawat tamu dengan standar operasional ketat namun tetap humanis. Tim muda yang dinamis menggabungkan strategi manajemen hotel, pemasaran, dan pengalaman tamu agar setiap aset berkembang optimal — termasuk melewati masa tantangan global.
                </p>
                <p class="mt-4 text-sm leading-relaxed text-stone-600 sm:text-base">
                    Kami melayani segmen pasar yang beragam: pelancong hemat, tamu bisnis, keluarga, hingga pencari pengalaman premium. Dengan merek yang saling melengkapi, kami menyusun pengalaman yang tepat untuk tiap perjalanan.
                </p>
                <a href="{{ route('book.index') }}" class="mt-8 inline-flex items-center gap-2 text-sm font-semibold text-brand hover:text-brand-dark">
                    Lanjut ke pemesanan
                    <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-white p-6 shadow-md ring-1 ring-stone-200/80">
                    <p class="text-3xl font-semibold text-stone-900">40+</p>
                    <p class="mt-1 text-sm text-stone-600">Properti demo di berbagai kota</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-md ring-1 ring-stone-200/80">
                    <p class="text-3xl font-semibold text-stone-900">24/7</p>
                    <p class="mt-1 text-sm text-stone-600">Dukungan reservasi terpusat</p>
                </div>
                <div class="rounded-3xl bg-stone-900 p-6 text-white sm:col-span-2">
                    <p class="font-serif text-lg font-medium">“Kenyamanan, kepedulian, dan rasa pulang di setiap malam menginap.”</p>
                    <p class="mt-3 text-sm text-stone-300">— Naratif merek (contoh)</p>
                </div>
            </div>
        </div>
    </section>

    <section id="merek" class="border-y border-stone-200 bg-white py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-brand">Merek kami</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold text-stone-900">Pilihan untuk tiap gaya menginap</h2>
                </div>
                <a href="{{ route('book.index') }}" class="text-sm font-semibold text-brand hover:text-brand-dark">Lihat ketersediaan</a>
            </div>
            <div id="stay-showcase" class="relative mt-10">
                <button
                    type="button"
                    data-showcase-prev
                    class="absolute left-0 top-[38%] z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/45 text-white shadow-md backdrop-blur-sm transition hover:bg-black/60 sm:left-1 lg:left-0"
                    aria-label="Slide sebelumnya"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button
                    type="button"
                    data-showcase-next
                    class="absolute right-0 top-[38%] z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/45 text-white shadow-md backdrop-blur-sm transition hover:bg-black/60 sm:right-1 lg:right-0"
                    aria-label="Slide berikutnya"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

                <div data-showcase-viewport class="overflow-hidden px-11 sm:px-12 lg:px-14">
                    <div
                        data-showcase-track
                        class="flex gap-4 transition-transform duration-500 ease-out will-change-transform"
                    >
                        @foreach ($stayShowcase as $slide)
                            <a
                                data-showcase-slide
                                href="{{ route('book.hotel', ['slug' => $slide['slug']]) }}"
                                class="group relative block h-[min(26rem,72vw)] shrink-0 overflow-hidden rounded-3xl shadow-md ring-1 ring-black/5 transition-shadow hover:shadow-xl"
                            >
                                <img
                                    src="{{ $slide['image'] }}"
                                    alt=""
                                    class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    width="640"
                                    height="800"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-black/10"></div>
                                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] sm:text-xs" style="color: #fbce00;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($slide['rating']))
                                                    ★
                                                @endif
                                            @endfor
                                        </span>

                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-3 w-3 text-white/90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/95 sm:text-xs">
                                                {{ $slide['label'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-2 flex items-end justify-between gap-3">
                                        <h3 class="min-w-0 truncate font-sans text-lg font-bold leading-snug text-white sm:text-xl">
                                            {{ $slide['title'] }}
                                        </h3>

                                        <span class="shrink-0 text-white opacity-90 transition group-hover:translate-x-0.5" aria-hidden="true">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div data-showcase-dots class="mt-8 flex flex-wrap justify-center gap-2" role="tablist" aria-label="Indikator slide"></div>
            </div>
        </div>
    </section>

    <section id="destinasi" class="mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-brand">Jelajahi Indonesia</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold text-stone-900 sm:text-4xl">
                Kota-kota tempat kami hadir
            </h2>
            <p class="mt-4 text-sm leading-relaxed text-stone-600 sm:text-base">
                Temukan budaya, kuliner, dan cerita lokal — dengan sandaran kenyamanan yang konsisten. Data berikut mengikuti ilustrasi pada situs referensi grup perhotelan nasional.
            </p>
        </div>
        <div class="mt-12 grid grid-cols-3 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($destinations as $d)
                <a
                    href="{{ route('book.search', ['city' => $d['city']]) }}"
                    class="group flex flex-col overflow-hidden rounded-3xl border border-stone-200/90 bg-white shadow-md transition hover:border-stone-300 hover:shadow-xl"
                >
                    <div class="relative aspect-[3/4] w-full shrink-0 overflow-hidden bg-stone-200">
                        <img
                            src="{{ $d['image'] ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80' }}"
                            alt="Destinasi {{ $d['city'] }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                            width="400"
                            height="500"
                            loading="lazy"
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

    <section id="anggota" class="bg-stone-900 py-20 text-white">
        <div class="mx-auto flex max-w-6xl flex-col items-start gap-8 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div class="max-w-xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sage-200/90">Keanggotaan</p>
                <h2 class="mt-3 font-serif text-3xl font-semibold sm:text-4xl">Jadilah anggota prioritas</h2>
                <p class="mt-4 text-sm leading-relaxed text-stone-300 sm:text-base">
                    Nikmati tarif eksklusif, kumpulkan poin untuk malam gratis, dan akses penawaran musiman — mirip program tamu setia pada situs referensi.
                </p>
            </div>
            <div class="flex w-full max-w-sm flex-col gap-3 rounded-3xl border border-white/15 bg-white/5 p-6 backdrop-blur">
                <p class="text-sm font-medium">Unduh aplikasi (demo)</p>
                <p class="text-xs text-stone-400">Pindai atau ketuk untuk memulai — alur ini meniru ajakan unduhan aplikasi pada booking engine referensi.</p>
                <button type="button" class="rounded-2xl bg-white py-3 text-sm font-semibold text-stone-900 transition hover:bg-stone-100">
                    Dapatkan tautan unduhan
                </button>
            </div>
        </div>
    </section>
@endsection
