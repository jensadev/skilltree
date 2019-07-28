<nav class="navbar fixed-top bg-transparent dashbar" style="z-index: 100;">
    <div class="container">
        <div class="crumb">
            <h1 class="h3 text-capitalize mb-1"><a  href="/skilltrees">Skilltrees</a>
                @if(isset($skilltree))
                    / {{ str_limit($skilltree->title, 30) }}
                @endif
            </h1>
        </div>
        <div class="dashbar d-flex justify-content-between">
            @if(isset($skilltrees) && auth()->user()->teacher)
                <a href="" class="btn dashbaricon" role="button" @click.prevent="$modal.show('new-skilltree')" title="Create a new Skilltree">
                    <i class="material-icons">add_box</i>
                </a>
            @endif
            @if(isset($skilltree))
                @can('update', $skilltree)
                    <add-skill :url="'{{ $skilltree->path() . '/skills' }}'">
                    </add-skill>
                    <invite-skilltree-member :url="'{{ $skilltree->path() . '/invitation' }}'">
                    </invite-skilltree-member>
                    <save-load-skilltree-pos-con :tree="'{{ $skilltree->id }}'" :save="'{{ auth()->user()->id == $skilltree->owner_id ? true : false }}'">
                    </save-load-skilltree-pos-con>
                    <a href="" class="btn dashbaricon" role="button" @click.prevent="$modal.show('manage-skilltree')" title="Manage Skilltree">
                        <i class="material-icons">settings</i>
                    </a>
                @endcan
            @endif
            <bug-report></bug-report>
        </div>
    </div>
</nav>
