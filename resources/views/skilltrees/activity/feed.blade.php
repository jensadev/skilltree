<footer class="position-absolute feed w-100">
    <div class="container text-right text-muted">
        <ul class="list-unstyled">
        @foreach ($skilltree->activity as $activity)
            <li>
                <small>
                    @include("skilltrees.activity.{$activity->description}")
                    {{ $activity->created_at->diffForHumans(null ,false) }}
                </small>
            </li>
        @endforeach
        </ul>
    </div>
</footer>
