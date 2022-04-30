<option value="{{ $category->id }}"  @if (in_array($category->id, $id_category) == true) {{ 'selected' }} @endif>
    {{ $char . $category->title }}</option>
@if($category->categories)
    @php $char .= '--' @endphp
    @foreach ($category->categories as $item)
        @include  ('admin.product.edit_sub_categories', [
                    'category' => $item,
                    'char' => $char,
                    'id_category' => $id_category
                 ])

    @endforeach
@endif
