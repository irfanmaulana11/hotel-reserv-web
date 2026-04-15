@extends('layouts.base')

@section('body')
    @include('partials.nav-landing')
    <main>
        @yield('content')
    </main>
    @include('partials.footer-landing')
@endsection
