@extends('public.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-login">
                <div class="card-header"><h4 class="verify-title">Vui lòng xác thực email của bạn</h4></div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Đã gửi đường dẫn xác thực. Vui lòng kiểm tra hòm mail') }}
                        </div>
                    @endif
                    Khi bạn đăng ký thành viên ở Paimonshop, chúng tôi sẽ gửi cho bạn một đường đẫn liên kết để xác nhận địa chỉ email của bạn.
                    Vui lòng tiến hành xác minh liên kết trong email của bạn để kích hoạt tài khoản.
                    Nếu không nhận được email kích hoạt, vui lòng click vào đường dẫn dưới đây để chúng tôi gửi lại mã xác thực.
{{--                    {{ __('Before proceeding, please check your email for a verification link.') }}--}}
{{--                    {{ __('If you did not receive the email') }},--}}
                    <form class="mt-3" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('Gửi lại xác thực') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
