<header class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/90 backdrop-blur-md">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="group flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand text-sm font-bold text-white shadow-sm">A</span>
            <span class="font-serif text-lg font-semibold tracking-tight text-stone-900">Hotel ABC</span>
        </a>
        <nav class="hidden items-center gap-8 text-sm font-medium text-stone-600 md:flex">
            <a href="#tentang" class="transition hover:text-brand">Tentang</a>
            <a href="#merek" class="transition hover:text-brand">Merek</a>
            <a href="#destinasi" class="transition hover:text-brand">Destinasi</a>
            <a href="#anggota" class="transition hover:text-brand">Keanggotaan</a>
        </nav>
        <div class="flex items-center gap-3">
            <a href="{{ route('book.index') }}" class="rounded-full bg-brand px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                Pesan Kamar
            </a>
        </div>
    </div>
</header>
