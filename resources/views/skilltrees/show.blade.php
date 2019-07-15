@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    {{-- <skill-cards
        :skilltree="{{ $skilltree }}"
        :skills="{{ $skilltree->skills }}"></skill-cards> --}}
    <section class="skillzone">
        <skill-card
            :skilltree="{{ $skilltree }}"
            class="root"
        ></skill-card>
        @foreach ($skilltree->skills as $skill)
            <skill-card
                :skill="{{ $skill }}"
            ></skill-card>           
        @endforeach
    </section>
    <edit-skill-modal></edit-skill-modal>
    {{-- <manage-skilltree-modal 
        :id="'{{ $skilltree->id }}'"
        :title="'{{ $skilltree->title }}'" 
        :description="'{{ $skilltree->description }}'" 
        :members="{{ $skilltree->members }}" 
        :course_id="'{{ $skilltree->course_id ? $skilltree->course_id : 0 }}'">
    </manage-skilltree-modal> --}}
    @include('skilltrees.activity.feed')
@endsection
