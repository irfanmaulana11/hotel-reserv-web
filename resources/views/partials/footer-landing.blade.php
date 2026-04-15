<footer class="relative mt-0">
    <div class="overflow-hidden leading-none">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="block w-full" style="height:80px">
            <path d="M0,40 C180,80 360,0 540,40 C720,80 900,0 1080,40 C1260,80 1380,20 1440,40 L1440,80 L0,80 Z" fill="#98A869"/>
        </svg>
    </div>
    <div class="bg-[#98A869] text-white">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 pb-14 pt-2 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div>
                <p class="font-serif text-lg font-semibold text-white">Hotel ABC</p>
                <p class="mt-3 max-w-sm text-sm leading-relaxed text-white/80">
                    Pengalaman menginap yang hangat, terinspirasi dari keramahan Indonesia — dari kota metropolitan hingga destinasi alam.
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-white/60">Tautan</p>
                <ul class="mt-4 space-y-2 text-sm text-white/80">
                    <li><a href="#tentang" class="hover:text-white">Tentang grup</a></li>
                    <li><a href="#merek" class="hover:text-white">Merek kami</a></li>
                    <li><a href="{{ route('book.index') }}" class="hover:text-white">Pesan sekarang</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-white/60">Kontak</p>
                <ul class="mt-4 space-y-2 text-sm text-white/80">
                    <li><a href="mailto:info@hotelabc.test" class="hover:text-white">info@hotelabc.test</a></li>
                    <li><span>(0271) 601 1888</span></li>
                    <li class="text-white/60">Jl. Contoh No. 62, Solo — demo alamat</li>
                </ul>
                <div class="mt-4 flex gap-3 text-sm text-white/70">
                    <span>Ikuti kami</span>
                    <span class="text-white/30">|</span>
                    <a href="#" class="hover:text-white">Instagram</a>
                    <a href="#" class="hover:text-white">LinkedIn</a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/20">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-6 text-xs text-white/60 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} Hotel ABC. Hak cipta dilindungi.</p>
                <p>Desain referensi: <a href="https://www.azanahotel.com/" class="underline decoration-white/30 underline-offset-2 hover:text-white">Azana Hospitality</a></p>
            </div>
        </div>
    </div>
</footer>
