@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{ route('coupon.store') }}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Tạo mã giảm giá</h3>
                            @can('coupon.create')
                                <a href="{{ route('coupon.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('coupon.view')
                                <a href="{{ route('coupon.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('coupon.create')
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                            @endcan
                        </div>
                    </div>
                </div>

                @if ( $errors->has('message') )
                    <div class="col-xs-12">
                        <div class="alert alert-danger">
                            {{ $errors->first('message') }}
                        </div>
                    </div>

                @endif

                @if($success = \Illuminate\Support\Facades\Session::get('success'))
                    <div class="col-xs-12">
                        <div class="alert alert-success">
                            {{ $success }}
                        </div>
                    </div>
                @endif

                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('title')) {{ 'has-error' }} @endif">
                                <label for="title" class="required">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('code')) {{ 'has-error' }} @endif">
                                <label for="code" class="required">Mã giảm giá</label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                @if($errors->has('code'))
                                    <span class="help-block">{{ $errors->first('code') }}</span>
                                @endif
                            </div>


                            <div class="form-group has-feedback @if ($errors->has('number_of_uses')) {{ 'has-error' }} @endif">
                                <label for="number_of_uses" class="required">Số lần sử dụng</label>
                                <input type="text" class="form-control" name="number_of_uses" value="{{ old('number_of_uses')}}">
                                @if($errors->has('number_of_uses'))
                                    <span class="help-block">{{ $errors->first('number_of_uses') }}</span>
                                @endif
                            </div>

                            @if(!empty($couponTemplate))
                            <div class="form-group">
                                <label for="coupon_template_id" class="required">Giảm giá</label>
                                <select style="width: 100%" name="coupon_template_id" id="coupon_template_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($couponTemplate as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        @can('coupon.view')
                            <a href="{{ route('coupon.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('coupon.create')
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                        @endcan
                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection
@push('script')
    <script type="text/javascript">
        $('#coupon_template_id').select2();
        $('#status').select2();
    </script>
@endpush
