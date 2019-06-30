@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <div class="container">
        <section class="card-deck ptop">
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
    </div>
    <new-skilltree-modal></new-skilltree-modal>
@endsection