<nav class="navbar fixed-top bg-transparent dashbar">
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
                <add-skill :url="'{{ $skilltree->path() . '/skills' }}'">
                </add-skill>
                <invite-skilltree-member :url="'{{ $skilltree->path() . '/invitations' }}'">
                </invite-skilltree-member>
                <save-skilltree-positions :tree="'{{ $skilltree->id }}'" :save="'{{ auth()->user()->id == $skilltree->owner_id ? true : false }}'">
                </save-skilltree-positions>
                <a href="" class="btn dashbaricon" role="button" @click.prevent="$modal.show('manage-skilltree')" title="Skilltree Settings">
                    <i class="material-icons">settings</i>
                </a>
            @endif
        </div>
    </div>
</nav>
<new-skilltree-modal></new-skilltree-modal>
