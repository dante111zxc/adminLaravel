@extends('public.layouts.app')

@section('content')
    <div class="container">
        @if (Cart::content()->count())
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">

                    <h1>Xác nhận đơn hàng</h1>
                    <div class="desc">Vui lòng kiểm tra lại đơn hàng của quý khách trước khi thanh toán</div>
                </div>
            </div>
        </div>
        <div class="row no-gutters">

            <div class="col-12 col-md-8">
                @if (Cart::content()->count()) @php($i = 1)
                <div class="table-responsive">
                    <table class="table table-striped table-borderless table-cart">
                        <thead>
                            <tr>
                                <th scope="col" class="text-white text-center">STT</th>
                                <th scope="col" class="text-white">Ảnh sản phẩm</th>
                                <th scope="col" class="text-white">Tên sản phẩm</th>
                                <th scope="col" class="text-white">Đơn giá</th>
                                <th scope="col" class="text-white text-center">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(Cart::content() as $key => $item)
                            <tr data-row-id="{{ $item->rowId }}">
                                <th scope="row" class="text-white text-center">{{$i}}</th>
                                <td class="text-white">
                                    <a class="thumbnail" href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}">
                                        <img src="{{ getThumbnail($item->model->thumbnail) }}" alt="{{ $item->model->title }}">
                                    </a>
                                </td>
                                <td class="text-white">
                                    <a href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}">
                                        {{ $item->model->title }}
                                    </a>
                                </td>
                                <td class="text-white">
                                    <div class="price">{!! showMoney($item->price) !!}</div>
                                </td>
                                <td class="text-white text-center">
                                    <div class="quantity">
                                        <span class="minus" onclick="minusQty(this, '.quantity', true)" data-href="{{ route('update_qty') }}" data-id="{{ $item->model->id }}">-</span>
                                        <input class="quantity-input" type="text" readonly value="{{ $item->qty }}">
                                        <span class="plus" onclick="plusQty(this, '.quantity', true)" data-href="{{ route('update_qty') }}" data-id="{{ $item->model->id }}">+</span>
                                        <span class="delete" data-href="{{ route('ajax_delete_item_from_cart') }}" data-id="{{ $item->id }}">
                                           <i class="bi bi-trash"></i>
                                       </span>
                                    </div>
                                </td>
                            </tr>
                            @php (++$i)
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="col-12 col-md-4 px-2">
                <div class="widget widget-cart-summary">
                    <h2 class="widget-title">Thông tin đơn hàng</h2>
                    <div class="widget-content">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Số sản phẩm</div>
                            <div class="cart-qty">{{ Cart::count() }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3 font-weight-bold">Mã giảm giá</div>
                            <div class="apply-coupon"><input type="text" name="coupon" class="form-control"><button class="btn-apply-coupon">Áp dụng</button></div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Tổng phụ</div>
                            <div class="font-weight-bold"><span class="cart-subtotal">{!! showMoney(Cart::subtotal()) !!}</span></div>
                        </div>
                        <hr class="border-white mb-5">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Tổng</div>
                            <div class="font-weight-bold"><span class="cart-subtotal">{!! showMoney(Cart::subtotal()) !!}</span></div>
                        </div>

                        <a class="btn-block btn-checkout font-weight-bold" href="{{ route('check_out') }}">Thanh toán</a>

                    </div>
                </div>
            </div>
        </div>

            @else

            <div class="row">
                <div class="col-12">
                    <div class="product-category-content">

                        <h1>Giỏ hàng trống</h1>
                        <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>

                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection
