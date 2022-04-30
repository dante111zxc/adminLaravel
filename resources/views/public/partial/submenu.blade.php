<li class="menu-item">
    <a class="menu-link" href="{{ getMenuItemUrl($subMenu) }}">{{ $subMenu->title }}</a>
    @if (!empty($subMenu->subMenu))
        <ul class="sub-menu">
            @foreach ($subMenu->subMenu as $subItem)
                @include('public.partial.submenu', ['subMenu' => $subItem])
            @endforeach
        </ul>
    @endif
</li>
