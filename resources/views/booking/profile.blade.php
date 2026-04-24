@extends('layouts.booking')

@section('title', 'Profil Saya — Hotel ABC')

@section('content')
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6 lg:px-8">
        <h1 class="text-center font-serif text-2xl font-semibold text-stone-900">Profil Saya</h1>
        <p class="mt-2 text-center text-sm text-stone-600">Kelola informasi profil Anda.</p>

        @if (session('success'))
            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-10 space-y-6 rounded-3xl border border-stone-200 bg-white p-6 shadow-md">
            @if (auth()->user()->avatar)
                <div class="text-center">
                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="mx-auto h-20 w-20 rounded-full">
                </div>
            @endif

            <form action="{{ route('book.profile.update') }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="name">Nama lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" disabled class="mt-2 w-full rounded-2xl border border-stone-200 bg-stone-100 px-3 py-2.5 text-sm text-stone-500">
                    <p class="mt-1 text-xs text-stone-500">Email tidak dapat diubah.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-stone-500" for="phone">Nomor telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Masukkan nomor telepon Anda" class="mt-2 w-full rounded-2xl border border-stone-200 px-3 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-sage-100">
                </div>

                <button type="submit" class="w-full rounded-2xl bg-brand py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark">
                    Simpan Perubahan
                </button>
            </form>

            <div class="border-t border-stone-200 pt-4">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="w-full rounded-2xl bg-red-700 py-3 text-sm font-semibold text-white transition hover:bg-red-700">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-stone-600">
            <a href="{{ route('book.index') }}" class="font-semibold text-brand hover:text-brand-dark">Kembali ke beranda booking</a>
        </p>
    </div>
@endsection
