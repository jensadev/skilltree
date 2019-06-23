<nav class="navbar fixed-top bg-transparent justify-content-between dashbar">
    <div class="container">
        <div class="crumb">
            <h1 class="h4 text-capitalize"><a  href="/skilltrees">Skilltrees</a>
                @if(isset($skilltree))
                    / {{ $skilltree->title }}
                @endif
            </h1>
        </div>
        <div class="dashbar d-flex justify-content-between">
            @if(isset($skilltrees))
                <a href="/skilltrees/create" class="btn dashbaricon" role="button" title="Add a new Skilltree">
                    <i class="material-icons">add_circle</i>
                </a>
            @endif
            @if(isset($skilltree))
                <addskill>
                    <template v-slot:trigger>
                        <i class="material-icons">add_circle_outline</i>
                    </template>
                    <div class="card shadow-sm bg-white">
                        <div class="card-body">
                            <form action="{{ $skilltree->path() . '/skills'}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Add a skill" required>
                                    </div>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="submit">Create skill</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </addskill>
                <a href="" class="btn dashbaricon" role="button" title="Save Skilltree">
                    <i class="material-icons">save</i>
                </a>
                <a href="" class="btn dashbaricon" role="button" @click.prevent="$modal.show('manage-skilltree')" title="Skilltree Settings">
                    <i class="material-icons">settings</i>
                </a>
            @endif
        </div>
    </div>
</nav>
<manage-skilltree-modal></manage-skilltree-modal>
