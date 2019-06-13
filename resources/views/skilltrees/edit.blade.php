@extends('layouts.app')

@section('content')
    <h1>Edit Skilltree</h1>
    <form action="{{ $skilltree->path() }}" method="post">
        @method('PATCH')
        @include('skilltrees.form', ['buttonText' => 'Update Skilltree'])
    </form>
@endsection
