@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <section class="skillzone">
        <skill-card
            :data="{{ $skilltree }}"
            :tree="{{ $skilltree->id }}"
            :id="0"
            class="root"
        ></skill-card>
        @foreach ($skilltree->skills as $skill)
            <skill-card
                :data="{{ $skill }}"
                :tree="{{ $skilltree->id }}"
                :id="{{ $skill->id }}"
                {{-- :skill_topicid = "'{{ $skill->hasMeta('topicId') ? $skill->getMeta('topicId')->value : 0 }}'"
                :skill_courseid = "'{{ $skill->hasMeta('courseId') ? $skill->getMeta('courseId')->value : 0 }}'" --}}

                @if (count($skill->tasks) > 0)
                    :skill_tasks="{{ $skill->tasks }}"
                @endif
            ></skill-card>           
        @endforeach
    </section>
    <edit-skill-modal></edit-skill-modal>
    <manage-skilltree-modal 
        :data="{{ $skilltree }}"
        :id="'{{ $skilltree->id }}'" 
        :members="{{ $skilltree->members }}" 
        :c-id="{{ $skilltree->hasMeta('courseId') ? $skilltree->getMeta('courseId')->value : 0 }}">
    </manage-skilltree-modal>
    @include('skilltrees.activity.feed')
@endsection
