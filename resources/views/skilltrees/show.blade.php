@extends('layouts.app')

@section('content')
    <div class="dashbar position-absolute d-flex w-100 justify-content-end">
        <addskill>
            <template v-slot:trigger>
                <i class="material-icons">add</i>
            </template>
            <div class="card shadow-sm bg-white">
                <div class="card-header d-flex justify-content-between">
                    <h5>Add a skill</h5>
                    <button type="button" class="close" aria-label="Close" id="addskillclose">
                        <i class="material-icons">close</i>
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ $skilltree->path() . '/skills'}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Add a skill" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </addskill>
        <sidebar>
            <template v-slot:trigger>
                <i class="material-icons">menu</i>
            </template>
            <div class="card shadow-sm bg-white">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-uppercase"><a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a></h5>
                    <button type="button" class="close" aria-label="Close" id="sidebarclose">
                        <i class="material-icons">close</i>
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
        </sidebar>
    </div>
    <skillzone :skilltree="{{ $skilltree->skills }}"></skillzone>
@endsection
