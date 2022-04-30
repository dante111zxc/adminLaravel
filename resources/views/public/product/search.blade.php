@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">
                    <h1>Tìm kiếm sản phẩm</h1>
                    <div class="desc">

                    </div>
                </div>


            </div>
            <div class="col-12 col-md-3 order-2 order-md-1">
                <form method="GET" class="form-filter-widget" id="formFilter">
                    @csrf
                    <input type="hidden" name="sort_by" value="1">
                    <div class="widget widget-filter">
                        <h3 class="widget-title">Tình trạng</h3>
                        <select onchange="selected(this)" name="product_status" class="form-control">
                            <option value="1" {{ ($dataFilter['product_status'] == 1) ? 'selected=selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ ($dataFilter['product_status'] == 0) ? 'selected=selected' : '' }}>Hết hàng</option>
                        </select>
                    </div>

                    @if(!empty($attributes))
                        @foreach($attributes as $key => $attr)
                            <div class="widget widget-platform">
                                <h3 class="widget-title">{{ $attr->title }}</h3>

                                @if($attr->childAttributes)
                                    @foreach($attr->childAttributes as $keyAttr => $itemAttr)
                                        <div class="custom-control custom-checkbox">
                                            <input name="attribute[]" {{ (!empty($dataFilter['attributes']) && in_array($itemAttr->id, $dataFilter['attributes']) === true ) ? 'checked=checked' : '' }} onclick="checkbox(this)" type="checkbox" class="custom-control-input" id="{{ $itemAttr->slug . $keyAttr }}" value="{{ $itemAttr->id }}">
                                            <label class="custom-control-label" for="{{ $itemAttr->slug . $keyAttr }}">{{ $itemAttr->title }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @endif


                    <div class="widget widget-price-range">
                        <h3 class="widget-title">Khoảng giá</h3>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Giá từ: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="price_from">
                            </div>

                        </div>


                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Đến: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="price_to">
                            </div>
                        </div>

                    </div>


{{--                    <a href="{{ route('product_category', ['id' => $category->id, 'slug' => $category->slug]) }}" class="btn"><i class="bi bi-x-lg"></i> Reset filter</a>--}}
                    <button type="submit" class="btn"><i class="bi bi-funnel"></i> Lọc sản phẩm</button>
                </form>
            </div>
            <div class="col-12 col-md-9 order-1 order-md-2">
                <div class="widget widget-sort-product-by">
                    <form method="GET">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-7 col-form-label">Tìm thấy {{ $product->total() }} sản phẩm</label>
                            <label class="col-sm-2 col-form-label">Sắp xếp theo</label>
                            <div class="col-sm-3">
                                <select onchange="sortProduct(this)" class="form-control" name="sort_by" id="sort-by">
                                    <option value="0" {{ ($dataFilter['sort_by'] == 0) ? 'selected=selected' : '' }}>Thứ tự mặc định</option>
                                    <option value="1" {{ ($dataFilter['sort_by'] == 1) ? 'selected=selected' : '' }}>Giá thấp đến cao</option>
                                    <option value="2" {{ ($dataFilter['sort_by'] == 2) ? 'selected=selected' : '' }}>Giá cao đến thấp</option>
                                    <option value="3" {{ ($dataFilter['sort_by'] == 3) ? 'selected=selected' : '' }}>Tên từ A-Z</option>
                                    <option value="4" {{ ($dataFilter['sort_by'] == 4) ? 'selected=selected' : '' }}>Tên Z-A</option>
                                    <option value="5" {{ ($dataFilter['sort_by'] == 5) ? 'selected=selected' : '' }}>Sản phẩm giảm giá</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                @if(!empty($product))
                    <div class="product-list">
                        @foreach($product as $key => $item)
                            <div data-wow-duration="1.5s" class="card border-0 col-md-1/4 col-1/2 wow fadeIn">
                                <a class="d-block position-relative card-img" href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                    <img src="{{ getThumbnail($item->thumbnail) }}" class="card-img-top" alt="{{ $item->title }}">
                                    {!! saleOff($item) !!}
                                </a>

                                <div class="card-content">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}" title="{{ $item->title }}">
                                                {{ $item->title }}
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="price">
                                        @if ( !empty($item->price) && !empty($item->price_sale) && ( $item->price >  $item->price_sale) )
                                            <span class="regular-price"><del>{!! showMoney($item->price) !!}</del></span>
                                        @endif

                                        @if( !empty($item->price_sale) && ($item->price_sale < $item->price))
                                            <span class="price-sale">{!! showMoney($item->price_sale) !!}</span>
                                        @else
                                            <span class="price-sale">{!! showMoney($item->price) !!}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{ $product->links() }}

                @endif
            </div>
        </div>
    </div>
@endsection
