<!-- Template này để hiển thị các item con của danh mục -->

<div class="form-group" style="margin-left: {{ $style }}px">
    <input type="checkbox" value="{{ $menu_item->id }}" data-slug="{{ $menu_item->slug }}" data-type="{{ $key }}" data-title="{{ $menu_item->title }}">
    <span style="margin-left: 1rem">{{ $menu_item->title }}</span>
</div>

@if($menu_item->categories)
    @php $style += 10 @endphp
    @foreach ($menu_item->categories as $item)
        @include('admin.menu-position.sub-item', [
            'menu_item' => $item,
            'key' => $key,
            'style' => $style
        ])
    @endforeach
@endif
