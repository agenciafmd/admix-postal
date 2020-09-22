@can('view', '\Agenciafmd\Postal\Models\Postal')
    <li class="nav-item">
        <a class="nav-link {{ admix_is_active(route('admix.postal.index')) ? 'active' : '' }}"
           href="{{ route('admix.postal.index') }}">
            <span class="nav-icon">
                <i class="icon fe-minus"></i>
            </span>
            <span class="nav-text">
                Formulários
            </span>
        </a>
    </li>
@endcan
