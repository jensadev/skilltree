<div class="card shadow-sm bg-white my-2" style="width: 18rem;">
    <h5 class="card-header"><a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a></h5>
    <div class="card-body">
        <p class="card-text text-muted">{{ str_limit($skilltree->description, 150) }}</p>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div>
            @foreach ($skilltree->members as $member)
                <img
                    src="{{ $member->avatar }}"
                    alt="{{ $member->name }}'s avatar"
                    class="rounded-circle mr-1"
                    style="width: 24px;">
            @endforeach
        </div>
        @can('manage', $skilltree)
            <form action="{{ $skilltree->path() }}" method="post">
                @csrf
                @method('DELETE')
                <button class="close" type="submit"><i class="material-icons float-right">delete</i></button>
            </form>
        @endcan
    </div>
</div>
