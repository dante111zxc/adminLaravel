@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('menuposition.update', $menu->id)}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa vị trí menu</h3>

                            @can('menuposition.create')
                                <a href="{{ route('menuposition.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>


                            <div class="pull-right">
                                @can('menuposition.view')
                                <a href="{{ route('menuposition.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
                                <label for="title" class="required">Tên menu</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $menu->title ?? '') }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if ($errors->has('position')) {{ 'has-error' }} @endif">
                                <label for="desc" class="required">Vị trí</label>
                                <input type="text" class="form-control" name="position" readonly value="{{ old('position', $menu->position ?? '') }}">
                                @if($errors->has('position'))
                                    <span class="help-block">{{ $errors->first('position') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option @if ($menu->status == 1) selected @endif value="1">Hiện</option>
                                    <option @if ($menu->status == 0) selected @endif value="0">Ẩn</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('menuposition.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
