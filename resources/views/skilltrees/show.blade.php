@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <section class="skillzone">
        <skill-card
            :tree="{{ $skilltree->id }}"
            :id="0"
            :skill_title="'{{ $skilltree->title }}'"
            :skill_description="'{{ $skilltree->description }}'"
            class="root"
        ></skill-card>
        @foreach ($skilltree->skills as $skill)
            <skill-card
                :tree="{{ $skilltree->id }}"
                :id="{{ $skill->id }}"
                :skill_title="'{{ $skill->skill_title }}'"
                :skill_description="'{{ $skill->skill_description }}'"
                :skill_topicid = "'{{ $skill->hasMeta('topicId') ? $skill->getMeta('topicId')->value : 0 }}'"
                :skill_courseid = "'{{ $skill->hasMeta('courseId') ? $skill->getMeta('courseId')->value : 0 }}'"

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
        :c-id="{{ $skilltree->hasMeta('courseId') ? $skilltree->getMeta('courseId')->value : 0 }}">
    </manage-skilltree-modal>
    <footer class="position-absolute feed w-100">
        <div style="margin-left: 30px;">
            <p class="text-muted">Hold ALT to zoom/drag Skilltree</p>
        </div>
        @include('skilltrees.activity.feed')
    </footer>
@endsection
