@if (count($activity->changes['after']) == 1)
    {{ explode(" ",$activity->user->name)[0] }} updated the {{ key($activity->changes['after']) }}
@else
    {{ explode(" ",$activity->user->name)[0] }} updated the Skilltree
@endif
