@can('view', \Agenciafmd\Postal\Models\Postal::class)
    <li class="nav-item">
        <a class="nav-link {{ (Str::startsWith(request()->route()->getName(), 'admix.postal')) ? 'active' : '' }}"
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
