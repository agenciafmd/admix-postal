@can('view', '\Agenciafmd\Postal\Postal')
    <li class="{{ admix_is_active(route('admix.postal.index')) ? 'active' : '' }}">
        <a href="{{ route('admix.postal.index') }}"
           class="{{ admix_is_active(route('admix.postal.index')) ? 'active' : '' }}">
            <i class="fe fe-minus"></i>
            Formulários
        </a>
    </li>
@endcan