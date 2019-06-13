@extends('layouts.app')

@section('content')
    @include('skilltrees.header')
    <skillzone :skilltree="{{ $skilltree->skills }}"></skillzone>
@endsection
