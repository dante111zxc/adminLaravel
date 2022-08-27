@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="bill">
                    <div class="bill-info">
                        <h2 class="bill-title">Thông tin đơn hàng #{{$order->id}} - {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</h2>
                        <ul>
                            <li><b>Khách hàng: </b> {{ $order->name }}</li>
                            <li><b>Số điện thoại: </b> {{ $order->phone }}</li>
                            <li><b>Địa chỉ: </b> {{ $order->address }}</li>
                            <li><b>Email: </b> {{ $order->email }}</li>
                            <li><b>Tình trạng đơn hàng: </b> {{ $orderStatus }}</li>
                            <li><b>Hình thức thanh toán: </b>{{ $methodPayment }}</li>
                            <li><b>Tổng tiền thanh toán: </b>{!! showMoney($order->total) !!}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="bill">
                    <h2 class="bill-title">Chi tiết đơn hàng</h2>
                    @if(!empty($order->products))
                        @foreach($order->products as $key => $item)
                            <div class="bill-product-item">
                                <div class="thumbnail">
                                    <a href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                        <img src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                                    </a>
                                </div>
                                <div class="meta-info">
                                    <a class="title" href="{{ route('product', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                        {{ $item->title }}
                                    </a>
                                    <div class="price">
                                        {{ $item->pivot->qty }} x {!! showMoney($item->pivot->price) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
