@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <skillzone :title="'{{ $skilltree->title }}'" :description="'{{ $skilltree->description }}'" :skills="{{ $skilltree->skills }}"></skillzone>
@endsection
