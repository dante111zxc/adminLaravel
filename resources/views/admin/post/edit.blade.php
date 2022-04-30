@extends('admin.layouts.app')
@section('content')
    <!-- Main content -->
    <form action="{{route('post.update', $post->id)}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới bài viết</h3>
                            <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('post.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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


                <div class="col-xs-12 col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('title')) {{ 'has-error' }} @endif">
                                <label for="title" class="required">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('slug')) {{ 'has-error' }} @endif">
                                <label for="slug" class="required">Đường dẫn</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug', $post->slug) }}">
                                @if($errors->has('slug'))
                                    <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc" class="required">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc', $post->desc) }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('content')) {{ 'has-error' }} @endif">
                                <label for="content">Nội dung</label>
                                <textarea id="content" rows="5" class="form-control" name="content">{{ old('content', $post->content) }}</textarea>
                                @if($errors->has('content'))
                                    <span class="help-block">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-body">

                            <div class="form-group @if ($errors->has('category_id')) {{ 'has-error' }} @endif">
                                <label for="category_id">Danh mục</label>
                                <select style="width: 100%" name="category_id[]" id="category_id" class="form-control"
                                        data-placeholder="Chọn danh mục" multiple="multiple" data-tags="true">
                                    <option value=""></option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}" @if (in_array($item->id, $id_category) == true) {{ 'selected' }} @endif> {{ $item->title }}</option>
                                        @if($item->childCategories)
                                            @foreach($item->childCategories as $subCategories)
                                                @include('admin.post.edit_sub_categories', [
                                                    'category' => $subCategories,
                                                    'char' => '--',
                                                    'id_category' => $id_category
                                                ])
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('category_id'))
                                    <span class="help-block">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if ($errors->has('tag_id')) {{ 'has-error' }} @endif">
                                <label for="tag_id">Thẻ tag</label>
                                <select style="width: 100%" name="tag_id[]" id="tag_id" class="form-control"
                                        data-placeholder="Chọn thẻ tag" multiple="multiple" data-tags="true">
                                    <option value=""></option>

                                    @foreach($tag as $item)
                                        <option value="{{ $item->id }}" @if (in_array($item->id, $id_tag) == true) {{ 'selected' }} @endif> {{ $item->title }}</option>
                                    @endforeach

                                </select>
                                @if($errors->has('tag_id'))
                                    <span class="help-block">{{ $errors->first('tag_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('meta_title')) {{ 'has-error' }} @endif">
                                <label for="meta_title">Tiêu đề SEO</label>
                                <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
                                @if($errors->has('meta_title'))
                                    <span class="help-block">{{ $errors->first('meta_title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_desc')) {{ 'has-error' }} @endif">
                                <label for="meta_desc">Mô tả SEO</label>
                                <textarea rows="5" class="form-control" name="meta_desc">{{ old('meta_desc', $post->meta_desc) }}</textarea>
                                @if($errors->has('meta_desc'))
                                    <span class="help-block">{{ $errors->first('meta_desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_keyword')) {{ 'has-error' }} @endif">
                                <label for="meta_keyword">Từ khóa SEO</label>
                                <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" value="{{ old('meta_keyword', $post->meta_keyword) }}">
                                @if($errors->has('meta_keyword'))
                                    <span class="help-block">{{ $errors->first('meta_keyword') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option @if ($post->status == 1) selected @endif value="1">Hiện</option>
                                    <option @if ($post->status == 0) selected @endif value="0">Ẩn</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="robots" class="required">Robots</label>
                                <select style="width: 100%" name="robots" id="robots" class="form-control">
                                    <option @if ($post->robots == 1) @endif value="1">Index, follow</option>
                                    <option @if ($post->robots == 0) @endif value="0">Noindex, Nofollow</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail" value="{{ $post->thumbnail }}">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img {{ !empty($post->thumbnail) ? 'show' : '' }}"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ getThumbnail($post->thumbnail) }}">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('post.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
        $('#robots').select2();
        $('#category_id').select2();
        $('#tag_id').select2();
    </script>
@endpush
