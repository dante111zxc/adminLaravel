
<li class="dd-item" data-guid="{{ $subMenu->guid }}"
    data-slug="{{ $subMenu->slug }}"
    data-title="{{ $subMenu->title }}"
    data-type="{{ $subMenu->type }}">
    <div class="dd-handle">{{ $subMenu->title }}</div>
    <span class="edit"><i class="fa fa-fw fa-edit"></i> Sửa</span>
    <span class="delete"><i class="fa fa-fw fa-trash"></i> Xóa</span>
    <div class="edit-menu" >
        <input class="form-control input-sm edit-title" type="text" placeholder="Tiêu đề" value="{{ $subMenu->title }}">
    </div>

    @if (!empty($subMenu->subMenu))
        <ol class="dd-list">
            @foreach ($subMenu->subMenu as $subItem)
                @include('admin.menu-position.nestable-submenu', ['subMenu' => $subItem])
            @endforeach
        </ol>
    @endif
</li>
