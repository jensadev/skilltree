<nav class="navbar fixed-top bg-transparent dashbar">
    <div class="container">
        <h1 class="navbar-brand h3 text-capitalize mb-0" style="font-size: 1.75rem;"><a  href="/skilltrees">Skilltrees</a>
            @if(isset($skilltree))
                / {{ str_limit($skilltree->title, 30) }}
            @endif
        </h1>
        <ul class="navbar mr-auto">
            {{-- <li class="nav-item">

            </li> --}}
        </ul>
        <ul class="navbar-nav ml-auto align-items-center flex-row">
                @if(isset($skilltrees) && auth()->user()->teacher)
                    <li class="nav-item">
                        <button href="" class="nav-link btn dashbaricon" role="button" @click.prevent="$modal.show('new-skilltree')" title="Create a new Skilltree">
                            <i class="material-icons">create_new_folder</i>
                        </button>
                    </li>
                @endif
                @if(isset($skilltree))
                    @can('update', $skilltree)
                        <add-skill :url="'{{ $skilltree->path() . '/skills' }}'">
                        </add-skill>
                        <invite-skilltree-member :url="'{{ $skilltree->path() . '/invitation' }}'">
                        </invite-skilltree-member>
                        <save-load-skilltree-pos-con :tree="'{{ $skilltree->id }}'" :save="'{{ auth()->user()->id == $skilltree->owner_id ? true : false }}'">
                        </save-load-skilltree-pos-con>
                        <li class="nav-item">
                            <button class="nav-link btn dashbaricon" role="button" @click.prevent="$modal.show('manage-skilltree')" title="Manage Skilltree">
                                <i class="material-icons">settings</i>
                            </button>
                        </li>
                    @endcan
                @endif
                {{-- <bug-report></bug-report> --}}
            </li>
        </ul>
    </div>
</nav>
