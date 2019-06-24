@extends('layouts.app')

@section('content')
<header class="loginheader w-100 ptop bg-dark">
    <div class="container">
        <h1 class="h1 text-uppercase display-2 text-light">Skilltree</h1>
    </div>
</header>
<div class="container ptop">
    <div class="row justify-content-center">
        <div class="col-8">
            <a href="{{ route('login.provider', 'google') }}"
                        class="btn btn-lg btn-light bg-white shadow-lg">
                        <img src="/img/google_g_logo.svg">
                    {{ __('Google Sign in') }}</a>
        </div>
    </div>
</div>
@endsection
