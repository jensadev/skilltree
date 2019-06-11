<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ul class="list-group">
        @forelse ($skilltrees as $skilltree)
            <li class="list-group-item">
                <a href="{{ $skilltree->path() }}">{{ $skilltree->title }}</a>
            </li>
        @empty
            <li>No skilltrees yet.</li>
        @endforelse
    </ul>
</body>
</html>
