@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('slides.store')}}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới slides</h3>
                            @can('slides.create')
                                <a href="{{ route('slides.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('slides.view')
                            <a href="{{ route('slides.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('slides.create')
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                            @endcan
                        </div>
                    </div>
                </div>

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
                            <div class="form-group has-feedback @if ($errors->has('url')) {{ 'has-error' }} @endif">
                                <label for="url" class="required">Đường dẫn tới bài viết hoặc sản phẩm</label>
                                <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                                @if($errors->has('url'))
                                    <span class="help-block">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('order')) {{ 'has-error' }} @endif">
                                <label for="order" class="required">Thứ tự hiển thị</label>
                                <input type="text" class="form-control" name="order" value="{{ old('order', 9999) }}">
                                @if($errors->has('order'))
                                    <span class="help-block">{{ $errors->first('order') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
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
                                <label for="type" class="required">Kiểu hiển thị</label>
                                <select style="width: 100%" name="type" id="type" class="form-control">
                                    <option value="slide">Slide</option>
                                    <option value="image">Ảnh</option>
                                </select>
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('url')) {{ 'has-error' }} @endif">
                                <label for="thumbnail" class="required">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ asset('adminLTE') }}/dist/img/no-img.png">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>

                                @if($errors->has('thumbnail'))
                                    <span class="help-block">{{ $errors->first('thumbnail') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        @can('slides.view')
                            <a href="{{ route('slides.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('slides.create')
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
    </script>
@endpush
