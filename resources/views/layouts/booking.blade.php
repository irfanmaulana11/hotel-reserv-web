@extends('layouts.base')

@section('body')
    @include('partials.nav-booking')
    <main class="pb-16">
        @yield('content')
    </main>
    @include('partials.footer-booking')
@endsection
