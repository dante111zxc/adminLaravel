@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-category-content">
                    @if ($order->status == 0 || $order->status == 1)
                    <h1>Đặt hàng Thành Công</h1>
                    <div class="desc">Cảm ơn bạn đã mua hàng tại Paimonshop. Sau đây là thông tin thanh toán cho đơn hàng của bạn. Chúng tôi đã gửi thông tin này qua email {{ $order->email }}. Vui lòng kiểm tra email để biết thêm chi tiết</div>
                    @endif

                    @if($order->status == 2)
                    <h1>Thanh toán thành công</h1>
                    <div class="desc">Cảm ơn bạn đã mua hàng tại Paimonshop. Đơn hàng của bạn đã được thanh toán thành công bằng Pcoin. Sau đây là thông tin chi tiết đơn hàng của bạn. Chúng tôi đã gửi thông tin này qua email {{ $order->email }}. Vui lòng kiểm tra email để biết thêm chi tiết</div>
                    @endif

                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="bill">
                    <div class="bill-info">
                        <h2 class="bill-title">Thông tin đơn hàng #{{$order->id}} - {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</h2>
                        <ul>
                            <li><b>Khách hàng: </b> {{ $order->name }}</li>
                            <li><b>Số điện thoại: </b> {{ $order->phone }}</li>
                            <li><b>Địa chỉ: </b> {{ $order->address }}</li>
                            <li><b>Email: </b> {{ $order->email }}</li>
                            <li><b>Tình trạng đơn hàng: </b> {{ $orderStatus }}</li>
                        </ul>
                    </div>

                    <div class="bill-product">
                        <h2 class="bill-title">Chi tiết đơn hàng</h2>
                        @if(!empty($cart))
                            @foreach($cart as $key => $item)
                            <div class="bill-product-item">
                                <div class="thumbnail">
                                    <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->model->slug]) }}">
                                        <img src="{{ getThumbnail($item->model->thumbnail) }}" alt="{{ $item->model->title }}">
                                    </a>
                                </div>
                                <div class="meta-info">
                                    <a class="title" href="{{ route('product', ['id' => $item->id, 'slug' => $item->model->slug]) }}">
                                        {{ $item->model->title }}
                                    </a>
                                    <div class="price">
                                        {{ $item->qty }} x {!! showMoney($item->price) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="payment-methods">
                                <span><b>Hình thức thanh toán:</b></span>
                                <span><b>{{ $methodPayment }}</b></span>
                            </div>
                            <div class="bill-total">
                                <span><b>Tổng phụ:</b></span>
                                <span class="total">
                                    {!! showMoney($order->subtotal) !!}
                                </span>
                            </div>
                            <div class="bill-total">
                                <span><b>Giảm giá Vip Member:</b></span>
                                <span class="total">
                                    {{ getSalePercentByUserId(\Illuminate\Support\Facades\Auth::user()->id) }}
                                </span>
                            </div>

                            <div class="bill-total">
                                <span><b>Tổng tiền:</b></span>
                                <span class="total">
                                {!! showMoney($order->total) !!}
                                </span>

                            </div>

                        @endif
                    </div>
                </div>
                @php(Cart::destroy())
                <div class="text-center">
                    <a href="{{ url('/') }}" class="btn btn-primary">Trang chủ</a>
                </div>
            </div>
        </div>
    </div>
@endsection
