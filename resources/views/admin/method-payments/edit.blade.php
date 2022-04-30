@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('methodpayments.update', $method->id)}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa phương thức thanh toán</h3>
                            @can('methodpayments.create')
                                <a href="{{ route('methodpayments.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('methodpayments.view')
                                <a href="{{ route('methodpayments.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('methodpayments.create')
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
                                <input type="text" class="form-control" name="title" value="{{ old('title', ($method->title) ? $method->title : '') }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('account_number')) {{ 'has-error' }} @endif">
                                <label for="account_number" class="required">Số tài khoản</label>
                                <input type="text" class="form-control" name="account_number" value="{{ old('account_number', ($method->account_number) ? $method->account_number : '' )}}">
                                @if($errors->has('account_number'))
                                    <span class="help-block">{{ $errors->first('account_number') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('account_name')) {{ 'has-error' }} @endif">
                                <label for="account_name" class="required">Tên chủ tài khoản</label>
                                <input type="text" class="form-control" name="account_name" value="{{ old('account_name', $method->account_name ? $method->account_name : '') }}">
                                @if($errors->has('account_name'))
                                    <span class="help-block">{{ $errors->first('account_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('bank_name')) {{ 'has-error' }} @endif">
                                <label for="bank_name" class="required">Tên ngân hàng</label>
                                <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name', ($method->bank_name) ? $method->bank_name : '') }}">
                                @if($errors->has('bank_name'))
                                    <span class="help-block">{{ $errors->first('bank_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('bank_code')) {{ 'has-error' }} @endif">
                                <label for="bank_code">Mã ngân hàng</label>
                                @if($listBanks)
                                    <select style="width: 100%" name="bank_code" id="bank_code" class="form-control"  data-placeholder="Chọn mã ngân hàng" data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach($listBanks as $bank)
                                            <option value="{{ $bank['bankCode'] }}" {{ ($method->bank_code == $bank['bankCode']) ? 'selected="selected"' : '' }}>{{ $bank['bankCode'] }} - {{ $bank['bankFullName'] }} - {{$bank['methodCode']}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="text-danger">Không tải được dữ liệu ngân hàng</div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1" {{ ($method->status == 1) ? 'selected=selected' : '' }}>Hiện</option>
                                    <option value="0" {{ ($method->status == 0) ? 'selected=selected' : '' }}>Ẩn</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="type" class="required">Loại hình thanh toán</label>
                                <select style="width: 100%" name="type" id="type" class="form-control">
                                    <option value="1" {{ ($method->type == 1) ? 'selected=selected' : '' }}>Chuyển khoản qua tài khoản ngân hàng</option>
                                    <option value="5" {{ ($method->type == 5) ? 'selected=selected' : '' }}>Thanh toán bằng QR VIETTEL PAY</option>
                                    <option value="3" {{ ($method->type == 3) ? 'selected=selected' : '' }}>Thanh toán bằng QR MOMO</option>
                                    <option value="4" {{ ($method->type == 4) ? 'selected=selected' : '' }}>Thanh toán bằng QR VNPAY</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail" value="{{ $method->thumbnail }}">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img {{ !empty($method->thumbnail) ? 'show' : '' }}"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ getThumbnail($method->thumbnail) }}">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        @can('methodpayments.view')
                            <a href="{{ route('methodpayments.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('methodpayments.create')
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
        $('#status').select2();
        $('#type').select2();
        $('#bank_code').select2();
    </script>
@endpush
