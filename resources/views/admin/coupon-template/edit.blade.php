@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{ route('coupon-template.update', $couponTemplate->id) }}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa loại giảm giá</h3>
                            @can('coupontemplate.create')
                                <a href="{{ route('coupon-template.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('coupontemplate.view')
                                <a href="{{ route('coupon-template.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('coupontemplate.edit')
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
                                <input type="text" class="form-control" name="title" value="{{ old('title', ($couponTemplate->title) ? $couponTemplate->title : '') }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('description')) {{ 'has-error' }} @endif">
                                <label for="description">Mô tả</label>
                                <textarea rows="5" class="form-control" name="description">{{ old('description', ($couponTemplate->description) ? $couponTemplate->description : '') }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('discount')) {{ 'has-error' }} @endif">
                                <label for="discount" class="required">Giảm giá</label>
                                <input type="text" class="form-control" name="discount" value="{{ old('discount', ($couponTemplate->discount) ? $couponTemplate->discount : '')}}">
                                @if($errors->has('discount'))
                                    <span class="help-block">{{ $errors->first('discount') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="type" class="required">Giảm giá theo</label>
                                <select style="width: 100%" name="type" id="type" class="form-control">
                                    <option value="1" @if ($couponTemplate->type == 1) {{ 'selected="selected"'}} @endif>Tỷ lệ (%)</option>
                                    <option value="2" @if ($couponTemplate->type == 2) {{ 'selected="selected"'}} @endif>Tiền mặt (VND)</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        @can('coupontemplate.view')
                            <a href="{{ route('coupon-template.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('coupontemplate.edit')
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
        $('#type').select2();
    </script>
@endpush
