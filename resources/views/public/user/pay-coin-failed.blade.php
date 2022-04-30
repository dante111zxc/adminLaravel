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
                <div class="alert alert-danger">
                    <div class="transaction-time-out">
                        <p class="mb-0">Giao dịch thất bại. Bạn sẽ được chuyển hướng về trang chủ trong <span>10</span>s</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
