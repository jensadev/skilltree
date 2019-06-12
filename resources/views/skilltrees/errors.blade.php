@if($errors->{ $bag ?? 'default' }->any())
    <div role="alert">
        <ul class="list-group">
            @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
