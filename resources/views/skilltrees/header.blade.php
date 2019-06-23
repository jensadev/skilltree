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
                <a href="" class="btn dashbaricon" role="button" @click.prevent="$modal.show('new-skilltree')" title="Create a new Skilltree">
                    <i class="material-icons">add_box</i>
                </a>
            @endif
            @if(isset($skilltree))
                <addskill>
                    <template v-slot:trigger>
                        <i class="material-icons">add_box</i>
                    </template>
                    <div class="card shadow-sm bg-white">
                        <div class="card-body">
                            <form action="{{ $skilltree->path() . '/skills'}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="skill_title" id="skill_title" placeholder="Add a skill" required>
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
<new-skilltree-modal></new-skilltree-modal>
