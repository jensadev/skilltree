@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <skillzone :skills="{{ $skilltree->skills }}"></skillzone>
@endsection
