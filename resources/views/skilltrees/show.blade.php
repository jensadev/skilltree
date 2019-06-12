@extends('layouts.app')

@section('content')
    <div class="row py-2">
        <section class="col-lg-8 py-2">

        </section>
        <section class="col-lg-4 py-2">
            <div class="card shadow-sm bg-white rounded float-lg-right w-100" >
                <div class="card-body">
                    <h5 class="card-title border-bottom"><a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a></h5>
                    <p class="card-text text-muted">{{ str_limit($skilltree->description, 150) }}</p>
                </div>
            </div>
            @can('manage', $skilltree)

            @endcan
        </section>

    </div>
@endsection
