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
                <addskill :url="'{{ $skilltree->path() . '/skills' }}'">
                    <template v-slot:trigger>
                        <i class="material-icons">add_box</i>
                    </template>
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
