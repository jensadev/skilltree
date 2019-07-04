@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <section class="skillzone">
        <skill-card
            :tree="{{ $skilltree->id }}"
            :id="0"
            :skill_title="'{{ str_limit($skilltree->title, 15) }}'"
            :skill_description="'{{ $skilltree->description }}'"
            class="root"
        ></skill-card>
        @foreach ($skilltree->skills as $skill)
            <skill-card
                :tree="{{ $skilltree->id }}"
                :id="{{ $skill->id }}"
                :skill_title="'{{ str_limit($skill->skill_title, 15) }}'"
                :skill_description="'{{ $skill->skill_description }}'"
                @if (count($skill->tasks) > 0)
                    :skill_tasks="{{ $skill->tasks }}"
                @endif
            ></skill-card>           
        @endforeach
    </section>
    <edit-skill-modal></edit-skill-modal>
    <manage-skilltree-modal 
        :id="'{{ $skilltree->id }}'" 
        :title="'{{ $skilltree->title }}'" 
        :description="'{{ $skilltree->description }}'" 
        :members="{{ $skilltree->members }}" 
        :c-id="{{ $skilltree->hasMeta('courseId') ? $skilltree->getMeta('courseId')->value : '0' }}">
    </manage-skilltree-modal>
    @include('skilltrees.activity.feed')
@endsection
