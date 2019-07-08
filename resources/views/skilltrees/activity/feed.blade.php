<footer class="position-absolute feed w-100">
    <div class="container d-flex justify-content-between">
        <ul class="list-unstyled text-info">
            @foreach ($skilltree->activity->take(5) as $activity)
                <li>
                    <small>
                        @include("skilltrees.activity.{$activity->description}")
                        {{ $activity->created_at->diffForHumans(null ,false) }}
                    </small>
                </li>
            @endforeach
        </ul>
        <p class="align-self-end text-muted">Hold ALT to zoom/drag Skilltree</p>
    </div>
</footer>