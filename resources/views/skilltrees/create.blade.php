@extends('layouts.app')

@section('content')
    <h1>Create Skilltree</h1>
    <form action="/skilltrees" method="post">
        @include('skilltrees.form', ['skilltree' => new App\Skilltree, 'buttonText' => 'Create Skilltree'])
    </form>
@endsection
