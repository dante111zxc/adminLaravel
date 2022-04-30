@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('role.update', [$group->id])}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới nhóm quyền</h3>
                            @can('role.create')
                            <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('role.view')
                            <a href="{{ route('role.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
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
                                <label for="title" class="required">Nhóm quyền</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $group->title) }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc">Mô tả</label>
                                <textarea name="desc" class="form-control" rows="5">{{ old('desc',  $group->desc) }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option @if ($group->status == 1) selected @endif value="1">Hiện</option>
                                    <option @if ($group->status == 0) selected @endif value="0">Ẩn</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header with-border" id="accordion">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="box-title" style="color: #000">
                                Phân quyền
                            </a>

                        </div>
                        <div class="box-body">
                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Module</th>
                                            <th class="text-center">Xem</th>
                                            <th class="text-center">Thêm</th>
                                            <th class="text-center">Sửa</th>
                                            <th class="text-center">Xóa</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($roles as $module => $item)
                                            <tr>
                                                <td>@lang("role.$module")</td>
                                                @foreach($item as $action)
                                                    <td class="text-center">
                                                        <input name="permission[]" type="checkbox" value="{{ $action }}" @if (in_array($action, $permission, true) == true) {{'checked'}} @endif>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
    </script>
@endpush
