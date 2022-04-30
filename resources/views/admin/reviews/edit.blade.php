@extends('admin.layouts.app')
@section('content')
    <!-- Main content -->
    <form action="{{route('reviews.update', $review->id )}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa bình luận</h3>
                            @can('reviews.create')
                            <a href="{{ route('reviews.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">
                            @can('reviews.view')
                            <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('reviews.edit')
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
                            <input type="hidden" name="type" value="{{ $review->type }}">
                            <input type="hidden" name="post_id" value="{{ $review->post_id }}">
                            <input type="hidden" name="user_id" value="{{ $review->user_id }}">

                            <div class="form-group">
                                <label for="vote">Slug</label>
                                <input type="text" class="form-control" readonly="" name="slug" value="{{ $review->slug }}">
                            </div>

                            <div class="form-group">
                                <label>Link</label>
                                @switch($review->type)
                                    @case('product')
                                        <a href="{{ route('product', ['id' => $review->post_id, 'slug' => $review->slug]) }}">{{ $review->slug }}</a>
                                        @break
                                    @case('post')
                                        <a href="{{ route('post', ['id' => $review->post_id, 'slug' => $review->slug]) }}">{{ $review->slug }}</a>
                                        @break

                                @endswitch
                            </div>

                            <div class="form-group has-feedback  @if ($errors->has('vote')) {{ 'has-error' }} @endif">
                                <label for="vote">Số sao</label>
                                <input type="text" class="form-control" value="{{ $review->vote }}" max="5">
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('content')) {{ 'has-error' }} @endif">
                                <label for="content" class="required">Mô tả</label>
                                <textarea rows="5" class="form-control" name="content">{{ old('content', $review->content) }}</textarea>
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

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option @if ($review->status == 1) selected @endif value="1">Hiện</option>
                                    <option @if ($review->status == 0) selected @endif value="0">Ẩn</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="feature" class="required">Nổi bật</label>
                                <select style="width: 100%" name="feature" id="feature" class="form-control">
                                    <option @if ($review->feature == 1) selected @endif value="1">Hiện</option>
                                    <option @if ($review->feature == 0) selected @endif value="0">Ẩn</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
        $('#feature').select2();
    </script>
@endpush
