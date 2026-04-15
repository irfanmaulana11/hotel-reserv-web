<header class="border-b border-stone-200 bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('book.index') }}" class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand text-sm font-bold text-white">A</span>
            <div>
                <p class="font-serif text-base font-semibold text-stone-900">Booking Engine</p>
                <p class="text-xs text-stone-500">Hotel ABC</p>
            </div>
        </a>
        <nav class="flex items-center gap-4 text-sm">
            <a href="{{ route('book.index') }}" class="font-medium text-stone-600 hover:text-brand">Beranda</a>
            <a href="{{ route('book.login') }}" class="rounded-full border border-stone-200 px-4 py-2 font-semibold text-stone-800 hover:border-brand hover:text-brand">
                Masuk / Daftar
            </a>
        </nav>
    </div>
</header>
