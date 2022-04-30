@extends('public.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-login">
                    <div class="card-header"><h4 class="verify-title">Kích hoạt thành công</h4></div>

                    <div class="card-body">
                        Tài khoản của bạn đã được kích hoạt. Click vào đường dẫn phía dưới để quay lại trang chủ
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary" href="{{ url('/') }}">Quay lại trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
