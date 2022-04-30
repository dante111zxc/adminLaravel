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
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $text)
                            <p class="mb-0">{{ $text }}</p>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('pay_coin_by_banking_submit') }}" method="POST">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label class="col-md-3 col-form-label">Số Pcoin cần nạp</label>
                        <div class="col-md-9">
                            <input class="form-control bg-transparent rounded-pill" type="number" name="pcoin" value="">
                        </div>
                    </div>

                    <div class="form-group text-center">
                       <button type="submit" class="btn btn-primary">Nạp Pcoin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
