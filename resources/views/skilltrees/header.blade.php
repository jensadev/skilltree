<header class="d-flex py-2 justify-content-between">
        <h1 class="h3"><a  href="/skilltrees">Skilltrees</a>
            @if(Request::is('skilltrees/*'))
                / {{ $skilltree->title }}
            @endif
        </h1>
        @if(Request::is('/*'))
            <a href="/skilltrees/create" class="btn btn-less" role="button">
                <i class="material-icons">add_circle_outline</i>
            </a>
        @endif
@if(Request::is('skilltrees/*'))
    <addskill>
        <template v-slot:trigger>
            <i class="material-icons">add_circle_outline</i>
        </template>
        <div class="card shadow-sm bg-white">
            <div class="card-body">
                <form action="{{ $skilltree->path() . '/skills'}}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Add a skill" required>
                        </div>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Skill group">
                        </div>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="submit">Create skill</button>
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
                <a class="close" href="{{ $skilltree->path() . '/edit'}}">
                    <i class="material-icons">edit</i>
                </a>
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
@endif
</header>
