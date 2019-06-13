@extends('layouts.app')
@section('content')
    <header class="d-flex py-2 justify-content-between">
        <h2 class="h3 text-muted">Skilltrees</h2>
        <a href="/skilltrees/create" class="btn btn-primary" role="button">Add Skilltree</a>
    </header>
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
