@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('user.store')}}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới thành viên</h3>
                            @can('user.create')
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('user.view')
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('user.create')
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('name')) {{ 'has-error' }} @endif">
                                <label for="name" class="required">Họ và tên</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('email')) {{ 'has-error' }} @endif">
                                <label for="email" class="required">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('password')) {{ 'has-error' }} @endif">
                                <label for="password" class="required">Password</label>
                                <input type="password" class="form-control" name="password">
                                @if($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if ($errors->has('password_confirm')) {{ 'has-error' }} @endif">
                                <label for="password_confirm" class="required">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="password_confirm">
                                @if($errors->has('password_confirm'))
                                    <span class="help-block">{{ $errors->first('password_confirm') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('phone')) {{ 'has-error' }} @endif">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone">
                                @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('address')) {{ 'has-error' }} @endif">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" name="address">
                                @if($errors->has('address'))
                                    <span class="help-block">{{ $errors->first('address') }}</span>
                                @endif
                            </div>

                            <div class="form-group @if ($errors->has('id_number')) {{ 'has-error' }} @endif">
                                <label for="id_number">Số CMND</label>
                                <input type="text" class="form-control" name="id_number">
                                @if($errors->has('id_number'))
                                    <span class="help-block">{{ $errors->first('id_number') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('pcoin')) {{ 'has-error' }} @endif">
                                <label for="pcoin">Pcoin</label>
                                <input type="number" class="form-control" name="pcoin">
                                @if($errors->has('pcoin'))
                                    <span class="help-block">{{ $errors->first('pcoin') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-body">
                           <div class="form-group">
                               <label for="gender">Giới tính</label>
                               <select style="width: 100%" name="gender" id="gender" class="form-control">
                                   <option value="0">Nam</option>
                                   <option value="1">Nữ</option>
                                   <option value="2">Không xác định</option>
                               </select>
                           </div>


                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ asset('adminLTE') }}/dist/img/no-img.png">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @can('user.create')
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
        $('#gender').select2();
    </script>
@endpush
