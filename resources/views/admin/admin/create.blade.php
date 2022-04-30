@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('admin.store')}}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới quản trị viên</h3>
                            <a href="{{ route('admin.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('admin.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
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
                            <div class="form-group @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc">Giới thiệu bản thân</label>
                                <textarea name="desc" id="desc" class="form-control" rows="5">{{ old('desc') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-body">

                            <div class="form-group @if ($errors->has('role_id')) {{ 'has-error' }} @endif">
                                <label for="role_id" class="required">Quyền</label>
                                <select style="width: 100%" name="role_id" id="role_id" class="form-control" data-placeholder="Chọn quyền" >
                                    <option value=""></option>
                                    @foreach( $roles  as $item)
                                        <option value="{{ $item->id }}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('role_id'))
                                    <span class="help-block">{{ $errors->first('role_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
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
                       <a href="{{ route('admin.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                       <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                   </div>
                </div>
            </div>
        </section>
    </form>

@endsection
@push('script')
    <script type="text/javascript">
        $('#status').select2();
        $('#role_id').select2();
    </script>
@endpush
