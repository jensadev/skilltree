@extends('layouts.app')
@section('content')
    @include('skilltrees.header')
    <section class="card-deck">
        @forelse ($skilltrees as $skilltree)
            @include('skilltrees.card')
        @empty
            <div class="card shadow-sm bg-white rounded my-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">No Skilltrees yet.</h5>
                </div>
            </div>
        @endforelse
    </section>
@endsection
