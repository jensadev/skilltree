@extends('layouts.app')

@section('content')
<header class="loginheader w-100 ptop bg-dark">
    <div class="container">
        <div class="row justify-content-center"> <!-- justify-content-center -->
            <div class="col-lg-8 loginheader-border">
                <div class="loginheader-left"></div>
                <h1 class="h1 text-uppercase display-2 text-light loginheader-text">Skilltree</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 text-light pt-5 loginheader-padding" style="padding-bottom: 100px;">
                <h2 class="h3">Precis som i Diablo</h2>
                <p class="lead text-justify">GDPR: Skilltree sparar din skol-gmail och tillhörande information. Det används till att identifiera dig när du loggar in och att koppla ett Skilltree till dig.
                    Denna data sparas i en databas och används inte till något annat än att visualisera ditt lärande.</p>
                <p>Tycker du att det är trist att få pedagogiskt stöd kan du be din lärare ta bort ditt konto.</p>
                <div class="text-right">
                    <a href="{{ route('login.provider', 'google') }}" class="btn btn-sm btn-light">
                        <img src="/img/google_g_logo.svg">
                        {{ __('Google Sign in') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container ptop">
    <div class="row justify-content-center">
        <div class="col-lg-8 loginheader-padding">
<!--        <a href="{{ route('login.provider', 'google') }}"
                    class="btn btn-lg btn-light bg-white shadow-lg">
                    <img src="/img/google_g_logo.svg">
                {{ __('Google Sign in') }}</a>
-->
        </div>
    </div>
</div>
@endsection
