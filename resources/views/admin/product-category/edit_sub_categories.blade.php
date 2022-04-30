<option value="{{ $taxonomies->id }}"{{ ($parent_id == $taxonomies->id) ? 'selected' : '' }}>
    {{ $char . $taxonomies->title }}</option>
@if($taxonomies->categories)
    @php $char .= '--' @endphp
    @foreach ($taxonomies->categories as $item)
        @include  ('admin.product-category.edit_sub_categories', [
                    'taxonomies' => $item,
                    'char' => $char,
                    'parent_id' => $parent_id
                 ])

    @endforeach
@endif
