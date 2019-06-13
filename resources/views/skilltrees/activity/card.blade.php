@foreach ($skilltree->activity as $activity)
    <li class="list-group-item">
        @include("skilltrees.activity.{$activity->description}")
        <span class="text-muted">{{ $activity->created_at->diffForHumans(null ,false) }}</span>
    </li>
@endforeach
