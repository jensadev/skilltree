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
                                    <input type="text" name="skill_title" id="skill_title" class="form-control" placeholder="Skill title" aria-label="Skill title" aria-describedby="button-title">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-title">Add skill</button>
                                    </div>
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
