@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{ route('product-attributes.store') }}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        @can('product-attributes.create')
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới thuộc tính sản phẩm</h3>
                            <a href="{{ route('product-attributes.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        @endcan
                        <div class="pull-right">
                            @can('product-attributes.view')
                            <a href="{{ route('product-attributes.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('product-attributes.create')
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
                            <div class="form-group has-feedback @if ($errors->has('slug')) {{ 'has-error' }} @endif">
                                <label for="slug" class="required">Đường dẫn</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
                                @if($errors->has('slug'))
                                    <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('type')) {{ 'has-error' }} @endif">
                                <label for="type" class="require">Loại</label>
                                <input type="text" name="type" class="form-control" id="type" value="{{ old('type') }}">
                                @if($errors->has('type'))
                                <span class="help-block">{{ $errors->first('type') }}</span>
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
                    <div class="form-group">
                        @can('product-attributes.view')
                            <a href="{{ route('product-attributes.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('product-attributes.create')
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
        $('[name="title"]').on('keyup', function () {
            let slug = UI.toSlug($(this).val());
            $('[name="slug"]').val(slug);
            $('[name="type"]').val(slug);
        });
    </script>
@endpush
