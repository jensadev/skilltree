@extends('layouts.app')
@section('content')
    @include('skilltrees.header')
    <section class="card-deck ptop" style="margin: 15px">
        @forelse ($skilltrees as $skilltree)
            @include('skilltrees.card')
        @empty
            <div class="card shadow-sm bg-white my-2" style="width: 18rem;">
                <h5 class="card-header">No Skilltrees yet.</h5>
                <div class="card-body">
                    <p class="card-text text-muted">Try adding some...</p>
                </div>
            </div>
        @endforelse
    </section>
@endsection