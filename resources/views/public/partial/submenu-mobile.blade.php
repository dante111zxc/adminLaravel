<li>
    <a href="{{ getMenuItemUrl($subMenu) }}">{{ $subMenu->title }}</a>
    @if (!empty($subMenu->subMenu))
        <ul>
            @foreach ($subMenu->subMenu as $subItem)
                @include('public.partial.submenu-mobile', ['subMenu' => $subItem])
            @endforeach
        </ul>
    @endif
</li>
