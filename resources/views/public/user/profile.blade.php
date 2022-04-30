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
                        <a href="{{ route('profile') }}" class="bread-crumbs-hr__link">{{ $user->name }}</a>
                    </div>
                </div>

                <h1 class="buy_title">Cập nhật thông tin tài khoản</h1>
            </div>

        </div>

        <div class="row">

            <div class="col-12 col-md-4 col-xl-3">
                <div class="widget-profile">
                    <div class="profile-avatar">
                        <span class="rounded-circle bg-white d-inline-block p-3"><img class="rounded-circle" src="{{ asset('assets/img/og_img.png') }}" alt="avatar"></span>
                    </div>
                    <div class="profile-name">
                        {!! showRankImg($totalAmount) !!}
                        {{ $user->name }}
                    </div>
                    <div class="profile-coin">
                        <img src="{{ asset('assets/img/pcoin.png') }}">
                        <span class="coin">{{ $user->pcoin }} Pcoin</span>
                    </div>
                    <div class="profile-time-join">Ngày tạo: {{ date('d/m/Y', strtotime($user->created_at)) }}</div>
                    <div class="profile-action">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="bi bi-info-circle"></i> Thông tin tài khoản
                            </a>

                            <a class="nav-link" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="true">
                                <i class="bi bi-key"></i> Đổi mật khẩu
                            </a>
                            <a class="nav-link" id="v-pills-order-history-tab" data-toggle="pill" href="#v-pills-order-history" role="tab" aria-controls="v-pills-order-history" aria-selected="false">
                                <i class="bi bi-bag-check-fill"></i> Danh sách đơn hàng
                            </a>
                            <a class="nav-link" id="v-pills-history-transaction-tab" data-toggle="pill" href="#v-pills-history-transaction" role="tab" aria-controls="v-pills-history-transaction-messages" aria-selected="false">
                                <i class="bi bi-cash-stack"></i> Lịch sử giao dịch
                            </a>

                            <a class="nav-link" id="v-pills-charge-money-tab" data-toggle="pill" href="#v-pills-charge-money" role="tab" aria-controls="v-pills-charge-money" aria-selected="false">
                                <i class="bi bi-currency-exchange"></i> Nạp Pcoin
                            </a>

                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                <i class="bi bi-chat-dots"></i> Bình luận của tôi
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-8 col-xl-9">
                @if ( $errors->any() )
                    <div class="alert alert-danger">
                        {!! implode('', $errors->all('<div>:message</div>'))  !!}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="tab-pane-content tab-pane-profile">
                            <form action="{{ route('update_profile') }}" method="POST" class="needs-validation">
                                <input type="hidden" type="text" name="id" value="{{ $user->id }}">
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Email</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="email" readonly name="email" value="{{ $user->email }}" class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Họ và tên</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control bg-transparent rounded-pill">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Số điện thoại</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control bg-transparent rounded-pill">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Số CMND/CCCD</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="text" name="id_number" value="{{ $user->id_number }}" class="form-control bg-transparent rounded-pill">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Địa chỉ</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="text" name="address" value="{{ $user->address }}" class="form-control bg-transparent rounded-pill">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Giới tính</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <select onchange="selected(this)" name="gender" class="form-control  bg-transparent rounded-pill">
                                            <option class="bg-dark" value="0" {{ ($user->gender == 0) ? 'selected=selected' : ''  }}>Nam</option>
                                            <option class="bg-dark" value="1" {{ ($user->gender == 1) ? 'selected=selected' : '' }}>Nữ</option>
                                            <option class="bg-dark" value="2" {{ ($user->gender == 2) ? 'selected=selected' : '' }}>Chưa xác định</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="updateProfile">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                        <div class="tab-pane-content tab-pane-password">
                            <form action="{{ route('update_password') }}" method="POST" class="needs-validation">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Mật khẩu cũ</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="password" name="password" value="" class="form-control  bg-transparent rounded-pill">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Mật khẩu mới</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="password" name="new_password" value="" class="form-control bg-transparent  rounded-pill">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-md-3 col-xl-2 col-form-label">Xác nhận MK</label>
                                    <div class="col-12 col-md-6 col-xl-6">
                                        <input type="password" name="confirm" value="" class="form-control bg-transparent  rounded-pill">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="updatePassword">Đổi mật khẩu</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-order-history" role="tabpanel" aria-labelledby="v-pills-order-history-tab">
                        @include('public.template.history-order')
                    </div>
                    <div class="tab-pane fade" id="v-pills-history-transaction" role="tabpanel" aria-labelledby="v-pills-history-transaction-tab">
                        @include('public.template.history-transaction')
                    </div>

                    <div class="tab-pane fade" id="v-pills-charge-money" role="tabpanel" aria-labelledby="v-pills-charge-money-tab">
                        <div class="tab-pane-content mb-3">
                            <h3 class="tab-pane-title">Chọn phương thức nạp Pcoin</h3>
                            <div class="tab-pane-subtitle">Phương thức nạp tiền: 1 PCoin = 1 VNĐ</div>
                        </div>
                        <div class="charge-money-method">
                            <div class="charge-money-method-item" data-toggle="modal" data-target="#charge-by-telephone-card">
                                <span class="logo">
                                    <img src="{{ asset('assets/img/tel-card.png') }}">
                                </span>
                                <a href="javascript:void(0)">Nạp Pcoin bằng thẻ điện thoại</a>
                            </div>


                            <div class="charge-money-method-item" data-toggle="modal" data-target="#charge-by-momo">
                                <span class="logo">
                                    <img src="{{ asset('assets/img/momo.png') }}">
                                </span>
                                <a href="javascript:void(0)">Nạp Pcoin bằng MOMO, Viettel Pay</a>
                            </div>

                            <div class="charge-money-method-item">
                                <span class="logo">
                                    <img src="{{ asset('assets/img/banking.png') }}">
                                </span>
                                <a href="{{ route('pay_coin_by_banking') }}">Chuyển khoản ngân hàng, Shopee Pay</a>
                            </div>


                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                </div>
            </div>
        </div>
    </div>

    @include('public.template.charge-money.telephone-card')
    @include('public.template.charge-money.momo')
    @include('public.template.charge-money.vnpay')
    @include('public.template.charge-money.banking', ['method_payment' => $method_payment])

@endsection
