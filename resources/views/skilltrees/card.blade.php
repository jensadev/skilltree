<div class="card shadow-sm bg-white my-2" style="width: 18rem;">
    <div class="card-header">
        <h3 class="h4 card-title mb-0"><a href="{{ $skilltree->path() }}">{{ str_limit($skilltree->title, 25) }}</a></h5>
    </div>
    <div class="card-body">
        <p class="card-text text-muted">{{ str_limit($skilltree->description, 125) }}</p>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center" style="padding: 0.25rem 0.75rem;">
        <div>
            @foreach ($skilltree->members->take(5) as $member)
                @if ($member->teacher)
                    <img
                        src="{{ $member->avatar }}"
                        alt="{{ $member->name }}'s avatar"
                        title="User {{ $member->name }} is allowed to edit Skilltree"
                        class="rounded-circle mr-1"
                        style="width: 24px;">
                @endif
            @endforeach
        </div>
        @can('manage', $skilltree)
            <form action="{{ $skilltree->path() }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-less" type="submit"><i class="material-icons" style="margin:0;">delete</i></button>
            </form>
        @endcan
    </div>
</div>
