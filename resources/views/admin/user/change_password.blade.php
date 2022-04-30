@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('user.change_password_store', $user->id)}}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa thành viên</h3>
                            @can('user.create')
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('user.view')
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('user.update')
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

                            <div class="form-group has-feedback @if ($errors->has('password')) {{ 'has-error' }} @endif">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password">
                                @if($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if ($errors->has('password_confirm')) {{ 'has-error' }} @endif">
                                <label for="password_confirm">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="password_confirm">
                                @if($errors->has('password_confirm'))
                                    <span class="help-block">{{ $errors->first('password_confirm') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                                @can('user.edit')
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection
