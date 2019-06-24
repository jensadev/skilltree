@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <skillzone :tree="'{{ $skilltree->id }}'":title="'{{ $skilltree->title }}'" :description="'{{ $skilltree->description }}'" :skills="{{ $skilltree->skills }}"></skillzone>
    <edit-skill-modal></edit-skill-modal>
    <manage-skilltree-modal>
        @include('skilltrees.invite')
    </manage-skilltree-modal>
    @include('skilltrees.activity.feed')
@endsection
