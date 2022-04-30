@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-crumbs-hr ">
                    <div class="bread-crumbs-hr__item">
                        <a href="{{ url('/') }}" class="bread-crumbs-hr__link">Trang chủ</a>
                        <span class="bread-crumbs-hr__spliter">&gt;</span>
                    </div>
                    <div class="bread-crumbs-hr__item">
                        <a href="#" class="bread-crumbs-hr__link">Nạp Pcoin qua tài khoản ngân hàng</a>
                    </div>
                </div>
                <h1 class="buy_title">Nạp Pcoin qua tài khoản ngân hàng</h1>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="alert alert-success">
                    <div class="transaction-time-out">
                        <p class="mb-0">Giao dịch thành công. Bạn sẽ được chuyển hướng về trang chủ trong <span>10</span>s</p>
                    </div>
                </div>

                <div class="transaction-detail">
                    <ul>
                        <li><b>Mã giao dịch:</b> <span class="ml-2">{{ $transactionData['request_id'] }}</span></li>
                        <li><b>Tên ngân hàng:</b> <span class="ml-2">{{ $transactionData['bank_name'] }}</span></li>
                        <li><b>Phương thức thanh toán:</b> <span class="ml-2">{{ $transactionData['method'] }}</span></li>
                        <li><b>Email:</b> <span class="ml-2">{{ $transactionData['email'] }}</span></li>
                        <li><b>Số điện thoại :</b> <span class="ml-2">{{ $transactionData['phone'] }}</span></li>
                        <li><b>Trạng thái :</b> <span class="ml-2">{{ $transactionData['desc'] }}</span></li>
                        <li><b>Thời gian giao dịch :</b> <span class="ml-2">{{ date('H:i:s d/m/Y', $transactionData['transaction_time']) }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
