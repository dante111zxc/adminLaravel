@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('user.update', $user->id)}}" method="POST">
        @csrf
        @method('PUT')
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

                <div class="col-xs-12 col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('name')) {{ 'has-error' }} @endif">
                                <label for="name" class="required">Họ và tên</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', ( $user->name ) ?  $user->name : '') }}">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('email')) {{ 'has-error' }} @endif">
                                <label for="email" class="required">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', ( $user->email ) ?  $user->email : '') }}">
                                @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('phone')) {{ 'has-error' }} @endif">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone', ( $user->phone ) ?  $user->phone : '') }}">
                                @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('address')) {{ 'has-error' }} @endif">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address', ( $user->address ) ?  $user->address : '') }}">
                                @if($errors->has('address'))
                                    <span class="help-block">{{ $errors->first('address') }}</span>
                                @endif
                            </div>

                            <div class="form-group @if ($errors->has('id_number')) {{ 'has-error' }} @endif">
                                <label for="id_number">Số CMND</label>
                                <input type="text" class="form-control" name="id_number" value="{{ old('id_number', ($user->id_number) ? $user->id_number : '') }}">
                                @if($errors->has('id_number'))
                                    <span class="help-block">{{ $errors->first('id_number') }}</span>
                                @endif
                            </div>


                            <div class="form-group @if ($errors->has('pcoin')) {{ 'has-error' }} @endif">
                                <label for="pcoin">Pcoin</label>
                                <input type="number" class="form-control" name="pcoin" value="{{ old('pcoin', ($user->pcoin) ? $user->pcoin : '') }}">
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
                                <label for="email_verified_at">Trạng thái</label>
                                <select style="width: 100%" name="email_verified_at" id="email_verified_at" class="form-control">
                                    <option value="" @if ($user->gender == null) {{ 'selected=selected' }} @endif>Tài khoản bị khóa</option>
                                    <option value="{{ $user->created_at }}" @if ($user->email_verified_at != null) {{ 'selected=selected' }} @endif>Kích hoạt</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <select style="width: 100%" name="gender" id="gender" class="form-control">
                                    <option value="0" @if ($user->gender == 0) {{ 'selected=selected' }} @endif>Nam</option>
                                    <option value="1" @if ($user->gender == 1) {{ 'selected=selected' }} @endif>Nữ</option>
                                    <option value="2" @if ($user->gender == 2) {{ 'selected=selected' }} @endif>Không xác định</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail" value="{{ $user->thumbnail }}">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img {{ !empty($user->thumbnail) ? 'show' : '' }}"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ getThumbnail($user->thumbnail) }}">
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
        $('#email_verified_at').select2();
    </script>
@endpush
