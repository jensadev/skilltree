<div class="card shadow-sm bg-white rounded my-2" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title border-bottom"><a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a></h5>
        <p class="card-text text-muted">{{ str_limit($skilltree->description, 150) }}</p>
        @can('manage', $skilltree)
            <form action="{{ $skilltree->path() }}" method="post">
                @csrf
                @method('DELETE')
                <button class="close" type="submit"><i class="material-icons float-right">delete</i></button>
            </form>
        @endcan
    </div>
</div>
