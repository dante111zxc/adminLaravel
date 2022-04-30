<option value="{{ $taxonomies->id }}">{{ $char . $taxonomies->title }}</option>
@if($taxonomies->categories)
    @php $char .= '--' @endphp
    @foreach ($taxonomies->categories as $item)
        @include  ('admin.product.creat_sub_categories', [
                'taxonomies' => $item,
                'char' => $char,
         ])
    @endforeach
@endif
