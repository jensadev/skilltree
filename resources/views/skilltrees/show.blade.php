@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <skillzone :tree="'{{ $skilltree->id }}'":title="'{{ $skilltree->title }}'" :description="'{{ $skilltree->description }}'" :skills="{{ $skilltree->skills }}"></skillzone>
@endsection
