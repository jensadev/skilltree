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
        :course_id="'{{ $skilltree->course_id ? $skilltree->course_id : 0 }}'">
    </manage-skilltree-modal>
    @include('skilltrees.activity.feed')
@endsection
