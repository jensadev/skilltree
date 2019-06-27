@extends('layouts.app')

@section('content')
<header class="loginheader w-100 ptop bg-dark">
    <div class="container">
        <div class="loginheader-border">
            <div class="loginheader-left"></div>
            <h1 class="h1 text-uppercase text-center display-2 text-light loginheader-text">Skilltree</h1>
        </div>
        <div class="loginheader-content text-light">
            <h2 class="h3">This tool</h2>
            <p class="lead">Är great! Lorem ipsum dolo.... och behöver linjering...</p>
        </div>
    </div>
</header>
<div class="container ptop">
    <div class="" style="width:600px; padding-left: 70px;">
        <a href="{{ route('login.provider', 'google') }}"
                    class="btn btn-lg btn-light bg-white shadow-lg">
                    <img src="/img/google_g_logo.svg">
                {{ __('Google Sign in') }}</a>
    </div>
</div>
@endsection
