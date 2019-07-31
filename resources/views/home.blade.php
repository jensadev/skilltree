@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="padding-top: 7rem;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                    {{ auth()->user()->teacher }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
