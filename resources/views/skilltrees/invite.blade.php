<form action="{{ $skilltree->path() . '/invitations' }}" method="post">
    @csrf
    <div class="input-group">
        <input
            id="email"
            name="email"
            type="text"
            class="form-control"
            placeholder="Email address"
            aria-label="Email address"
        >
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Invite</button>
        </div>
    </div>
</form>
@include('skilltrees.errors', ['bag' => 'invitations'])