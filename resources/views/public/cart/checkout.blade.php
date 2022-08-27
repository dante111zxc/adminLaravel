@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">
                    <h1>Thanh toán</h1>
                    <div class="desc">Vui lòng điền đầy đủ thông tin vào form dưới đây để xác nhận đơn hàng của bạn.
                    </div>
                </div>
            </div>

            @if ( $errors->any() )
                <div class="col-12">
                    <div class="alert alert-danger">
                        {!! implode('', $errors->all('<div>:message</div>'))  !!}
                    </div>
                </div>
            @endif

        </div>

        <div class="row no-gutters">

            <div class="col-12 col-lg-8">
                <form class="form-checkout" id="form-checkout" action="{{ route('submit_checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cart_total" value="{{ getCartTotal($cartTotal) }}">
                    <input type="hidden" name="method_payment" value="2">
                    <input type="hidden" name="is_coupon" value="0">
                    <input type="hidden" name="coupon_code_id">
                    <div class="checkout-info">
                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <label for="full-name" class="required">Họ và tên</label>
                                <input type="text" class="form-control bg-transparent rounded-pill" id="full-name"
                                       name="name" value="{{ (!empty(Auth::user()->name)) ? Auth::user()->name : '' }}">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="phone" class="required">Số điện thoại</label>
                                <input type="tel" class="form-control bg-transparent rounded-pill" id="phone"
                                       name="phone"
                                       value="{{ (!empty(Auth::user()->phone)) ? Auth::user()->phone : '' }}">
                            </div>
                            <div class="form-group col-12">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control bg-transparent rounded-pill" id="address"
                                       name="address"
                                       value="{{ !empty(Auth::user()->address) ? Auth::user()->address : '' }}">
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="email" class="required">Email</label>
                                <input type="hidden" class="form-control bg-transparent rounded-pill" id="email"
                                       name="email"
                                       value="{{ !empty(Auth::user()->email) ? Auth::user()->email : '' }}">

                                <input type="email" class="form-control bg-transparent rounded-pill" readonly
                                       value="{{ !empty(Auth::user()->email) ? Auth::user()->email : '' }}">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="link_facebook">Link facebook</label>
                                <input type="text" class="form-control bg-transparent rounded-pill" id="link_facebook"
                                       name="link_facebook" value="">
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col-12">
                            <h3 class="form-checkout-label">Thông tin đăng nhập tài khoản game</h3>
                        </div>
                    </div>

                    <div class="acc-info">
                        <div class="acc-info-item" data-key="0">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Tên đăng nhập</label>
                                    <input type="text" name="acc_info[0][username]"
                                           class="form-control bg-transparent rounded-pill">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="acc_info[0][password]"
                                           class="form-control bg-transparent rounded-pill">
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label>Cổng đăng nhập</label>
                                    <input type="text" name="acc_info[0][platform]"
                                           class="form-control bg-transparent rounded-pill"
                                           placeholder="Mihoyo, facebook, google...">
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label>Server</label>
                                    <input type="text" name="acc_info[0][server]"
                                           class="form-control bg-transparent rounded-pill"
                                           placeholder="Asia, EU, America...">
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label>Tên nhân vật - cấp độ</label>
                                    <input type="text" name="acc_info[0][charactername]"
                                           class="form-control bg-transparent rounded-pill"
                                            placeholder="Paimon - AR 58">
                                </div>
                            </div>
                        </div>

                    </div>

{{--                    <div class="form-row">--}}
{{--                        <div class="col-12">--}}
{{--                            <a href="javascript:void (0)" class="btn btn-primary rounded-0 addAcc">Thêm tài khoản</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </form>
            </div>
            <div class="col-12 col-lg-4 px-2">
                @if (Cart::content()->count()) @php($i = 1)
                <div class="widget widget-cart">
                    <h2 class="widget-title">Thông tin đơn hàng</h2>
                    <div class="widget-content">
                        @foreach(Cart::content() as $key => $item)
                            <div class="cart-item" data-row-id="{{ $item->rowId }}">
                                <div class="cart-item-thumbnail">
                                    <a href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}"
                                       title="{{ $item->model->title }}">
                                        <img src="{{ getThumbnail($item->model->thumbnail) }}"
                                             alt="{{ $item->model->title }}">
                                        {!! saleOff($item->model) !!}
                                    </a>
                                </div>
                                <div class="cart-item-meta">
                                    <a class="title"
                                       href="{{ route('product', ['id' => $item->model->id, 'slug' => $item->model->slug]) }}"
                                       title="{{ $item->model->title }}">
                                        {{ $item->model->title }}
                                    </a>
                                    <div class="price">
                                        @if ( !empty($item->model->price) && !empty($item->model->price_sale) && ( $item->model->price >  $item->model->price_sale) )
                                            <span class="price-sale"><del>{!! showMoney($item->model->price) !!}</del></span>
                                        @endif

                                        <span class="price-regular">
                                        @if ( !empty( $item->model->price_sale)  && $item->model->price_sale < $item->model->price )
                                                {!! showMoney($item->model->price_sale) !!}
                                            @else
                                                {!! showMoney($item->model->price) !!}
                                            @endif
                                    </span>


                                    </div>

                                    <div class="quantity">
                                        <span class="minus" onclick="minusQty(this, '.quantity', true)"
                                              data-href="{{ route('update_qty') }}"
                                              data-id="{{ $item->model->id }}">-</span>
                                        <input class="quantity-input rounded-0" type="text" readonly value="{{ $item->qty }}">
                                        <span class="plus" onclick="plusQty( this, '.quantity', true)"
                                              data-href="{{ route('update_qty') }}"
                                              data-id="{{ $item->model->id }}">+</span>
                                        <span class="delete" data-href="{{ route('ajax_delete_item_from_cart') }}"
                                              data-id="{{ $item->id }}">
                                              <i class="bi bi-trash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="widget widget-cart-summary">
                    <h2 class="widget-title">Thanh toán</h2>
                    <div class="widget-content">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Số sản phẩm</div>
                            <div class="cart-qty">{{ Cart::count() }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3 font-weight-bold">Mã giảm giá</div>
                            <div class="apply-coupon"><input type="text" name="coupon" class="form-control">
                                <button class="btn-apply-coupon">Áp dụng</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Tổng phụ</div>
                            <div class="font-weight-bold">
                                <span class="cart-subtotal-text">{!! showMoney(Cart::subtotal()) !!}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Giảm giá Vip Member</div>
                            <div class="font-weight-bold">
                                <span class="member-sale-percent">{{ getSalePercentByUserId(\Illuminate\Support\Facades\Auth::user()->id) }}</span>
                            </div>
                        </div>
                        <hr class="border-white mb-5">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="font-weight-bold">Tổng</div>
                            <div class="font-weight-bold">
                                <span class="cart-total-text">{!! showMoney($cartTotal) !!}</span></div>
                        </div>
                        @if (Auth::user()->pcoin >= getCartTotal($cartTotal))
                            <a class="btn-block btn-checkout font-weight-bold" id="btnCheckOut" href="javascript:void(0)">Thanh toán</a>
                            @else
                            <a class="btn-block btn-checkout font-weight-bold" href="javascript:void(0)">Thanh toán</a>
                        @endif

                    </div>
                </div>

                <div class="widget widget-method-payment">
                    <h2 class="widget-title">Phương thức thanh toán</h2>
                    <div class="widget-content">

                        <div class="accordion" id="accordionMethodPayments">

{{--                            thanh toán bằng pcoin--}}
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <div class="method-payments">
                                    <div class="header">
                                        <div class="form-check bg-primary" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
{{--                                            <input onclick="changeMethodPayment(this.value)" id="method_payment_2" class="form-check-input" type="radio" name="method_payment" value="2" @if (Auth::user()->pcoin >= getCartTotal($cartTotal)) {{ 'checked' }} @else {{ 'disabled' }} @endif >--}}
                                            <input class="form-check-input" type="radio" @if (Auth::user()->pcoin >= getCartTotal($cartTotal)) {{ 'checked' }} @else {{ 'disabled' }} @endif >
                                            <label class="form-check-label">
                                                Thanh toán bằng Pcoin
                                                @if(Auth::user()->pcoin >= getCartTotal($cartTotal))
                                                    <span class="ml-2">{{ showCoin(Auth::user()->pcoin)  }}</span>
                                                    @else
                                                    <span class="ml-2">Số dư Pcoin không đủ</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif

{{--                        ck trực tiếp--}}
{{--                            @if (!empty($methodPayments))--}}
{{--                            <div class="method-payments">--}}
{{--                               <div class="header">--}}

{{--                                   <div class="form-check bg-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
{{--                                       <input onclick="changeMethodPayment(this.value)" id="method_payment_1" class="form-check-input" type="radio" name="method_payment" value="1" @if (Auth::check() == false || Auth::user()->pcoin < getCartTotal(Cart::subtotal())) {{ 'checked' }} @endif>--}}
{{--                                       <label class="form-check-label">Chuyển khoản qua tài khoản ngân hàng</label>--}}
{{--                                   </div>--}}

{{--                               </div>--}}
{{--                                <div class="content">--}}
{{--                                    <div id="collapseOne" class="collapse @if ( Auth::check() == false || Auth::user()->pcoin < getCartTotal(Cart::subtotal()) ) {{ 'show' }} @endif" data-parent="#accordionMethodPayments">--}}
{{--                                        <div class="method-payment">--}}
{{--                                            @foreach($methodPayments as $item)--}}
{{--                                                <div class="method-payment-item">--}}
{{--                                                    <div class="thumbnail">--}}
{{--                                                        <img src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->bank_name}}">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="meta-info">--}}
{{--                                                        <p class="mb-0">{{ $item->bank_name }}</p>--}}
{{--                                                        <p class="mb-0"><b>Chủ tài khoản: </b>{{ $item->account_name }}</p>--}}
{{--                                                        <p class="mb-0"><b>Số tài khoản: </b>{{ $item->account_number }}</p>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endif--}}

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
