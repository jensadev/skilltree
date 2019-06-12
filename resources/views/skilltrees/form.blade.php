@csrf
<div class="form-group">
    <label for="title">Title</label>
    <input id="title" name="title" class="form-control" type="text" value="{{ $skilltree->title }}" required>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" class="form-control" rows="6" required>{{ $skilltree->description }}</textarea>
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ $buttonText }}</button>
    <a href="{{ $skilltree->path() }}">Cancel</a>
</div>
@include('skilltrees.errors')
