<header class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/90 backdrop-blur-sm">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="group flex items-center gap-2">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand text-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 0 0 0 1.5v13.5c0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75V2.25a.75.75 0 0 0-1.5 0v12.75H6V3.75a.75.75 0 0 0-1.5 0v1.5H4.5ZM13.5 6a.75.75 0 0 1 .75.75v13.5a.75.75 0 0 1-1.5 0V6.75a.75.75 0 0 1 .75-.75Zm3 3a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-1.5 0V9.75a.75.75 0 0 1 .75-.75Zm3 3a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-1.5 0v-7.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </span>
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
                Reservasi Sekarang
            </a>
            @auth
            <div class="relative inline-block text-left" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 rounded-full border border-stone-200 p-1 pr-3 text-sm font-medium text-stone-700 hover:border-brand hover:text-brand transition">

                    {{-- Logika Avatar / Inisial --}}
                    @if (auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}"
                            alt="Avatar"
                            class="h-8 w-8 rounded-full object-cover"
                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white text-xs\'>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>';">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand text-xs text-white">
                            {{-- Mengambil inisial (contoh: Irfan Maulana -> IM) --}}
                            @php
                                $words = explode(' ', auth()->user()->name);
                                $initials = count($words) >= 2
                                    ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                    : strtoupper(substr($words[0], 0, 1));
                            @endphp
                            {{ $initials }}
                        </div>
                    @endif

                    <span class="ml-1">{{ auth()->user()->name }}</span>

                    <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open"
                    x-transition
                    @click.outside="open = false"
                    class="absolute left-0 mt-2 w-56 z-50 rounded-2xl border border-stone-200 bg-white py-2 shadow-lg">

                    <div class="px-4 py-2">
                        <p class="truncate text-sm font-medium text-stone-900">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-stone-500">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="my-2 border-t border-stone-100"></div>

                    @php
                        $cartCount = auth()->check() ? auth()->user()->cartItems()->count() : 0;
                    @endphp

                    <a href="{{ route('cart.index') }}" class="group flex items-center justify-between px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">
                        <span>Keranjang</span>
                        @if ($cartCount > 0)
                            <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-brand px-1.5 text-xs font-semibold text-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">
                        Pesanan Saya
                    </a>

                    @php
                        $isProfileIncomplete =
                            empty(trim(auth()->user()->name)) ||
                            empty(trim(auth()->user()->email)) ||
                            empty(trim(auth()->user()->phone));
                    @endphp

                    <a href="{{ route('book.profile') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">
                        Profil
                        @if($isProfileIncomplete)
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-red-600 border border-red-100 animate-pulse">
                                <span class="h-1 w-1 rounded-full bg-red-600"></span>
                                Lengkapi profil
                            </span>
                        @endif
                    </a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-stone-50">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            @else
                <a href="{{ route('book.login') }}" class="rounded-full border border-stone-200 px-4 py-2 text-sm font-semibold text-stone-800 hover:border-brand hover:text-brand">
                    Masuk / Daftar
                </a>
            @endauth
        </div>
    </div>
</header>
