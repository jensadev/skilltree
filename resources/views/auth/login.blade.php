@extends('layouts.app')

@section('content')
<header class="loginheader w-100 ptop bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 loginheader-border">
                <div class="loginheader-left"></div>
                <h1 class="h1 text-uppercase display-2 text-light loginheader-text">Skilltree</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 text-light pt-5 loginheader-padding" style="padding-bottom: 100px;">
                <h2 class="h3">This tool</h2>
                <p class="lead">Är great! Lorem ipsum dolo.... och behöver linjering...</p>
            </div>
        </div>
    </div>
</header>
<div class="container ptop">
    <div class="row">
        <div class="col-lg-6 loginheader-padding">
        <a href="{{ route('login.provider', 'google') }}"
                    class="btn btn-lg btn-light bg-white shadow-lg">
                    <img src="/img/google_g_logo.svg">
                {{ __('Google Sign in') }}</a>
        </div>
    </div>
</div>
@endsection
