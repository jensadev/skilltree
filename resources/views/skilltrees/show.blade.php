@extends('layouts.app')

@section('content')
    <dashbar>
        <template v-slot:trigger>
            <i class="material-icons">dashboard</i>
        </template>
        <template v-slot:add>
                <i class="material-icons">add</i>
        </template>
        <div class="card shadow-sm bg-white">
            <div class="card-header d-flex justify-content-between align-items-baseline">
                <h5 class="text-uppercase"><a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a></h5>
                <button type="button" class="close" aria-label="Close" id="dashbarclose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="card-body">
                <p class="card-text">{{ str_limit($skilltree->description, 150) }}</p>
            </div>
            <ul class="list-group list-group-flush">
                @can('manage', $skilltree)
                    @include("skilltrees.invite")
                @endcan
                @include("skilltrees.activity.card")
            </ul>
        </div>
    </dashbar>
    <section id="dropzone">
        @foreach ($skilltree->skills as $skill)
            <skillcard v-key="index" title="{{ $skill->title }}" description="{{ $skill->description }}">

            </skillcard>

        @endforeach

    <skillcard description="fnas">
    </skillcard>
    <skillcard title="bus" description="fnas">
    </skillcard>
    </div>
@endsection
