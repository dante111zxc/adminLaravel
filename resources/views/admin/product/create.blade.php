@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('product.store')}}" method="POST">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm mới sản phẩm</h3>

                            @can('product.create')
                            <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            @endcan
                        </div>
                        <div class="pull-right">

                            @can('product.view')
                            <a href="{{ route('product.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                            @endcan

                            @can('product.create')
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Đăng</button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">

{{--                Nội dung giới thiệu sản phẩm--}}
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
                                <label for="desc" class="required">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('short_desc')) {{ 'has-error' }} @endif">
                                <label for="short_desc">Mô tả ngắn của sản phẩm (lưu ý khi mua hàng nếu có)</label>
                                <textarea rows="5" class="form-control" name="short_desc">{{ old('short_desc') }}</textarea>
                                @if($errors->has('short_desc'))
                                    <span class="help-block">{{ $errors->first('short_desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('content')) {{ 'has-error' }} @endif">
                                <label for="content">Nội dung</label>
                                <textarea id="content" rows="5" class="form-control" name="content">{{ old('content') }}</textarea>
                                @if($errors->has('content'))
                                    <span class="help-block">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

{{--                Thông tin sản phẩm--}}
                    <div class="box">
                        <div class="box-header">
                            <h4>Thông tin sản phẩm</h4>
                        </div>
                        <div class="box-body">
                            <div class="form-row">
                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('sku')) {{ 'has-error' }} @endif">
                                    <label for="sku">Mã sku (mã sản phẩm)</label>
                                    <input type="text" class="form-control" name="sku" value="{{ old('sku') }}">
                                    @if($errors->has('sku'))
                                        <span class="help-block">{{ $errors->first('sku') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('price')) {{ 'has-error' }} @endif">
                                    <label for="price" class="required">Giá gốc <sup>(vnđ)</sup></label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                    @if($errors->has('price'))
                                        <span class="help-block">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('price_sale')) {{ 'has-error' }} @endif">
                                    <label for="price_sale">Giá khuyến mãi <sup>(vnđ)</sup> <span class="label label-danger sale-off"></span></label>
                                    <input type="text" class="form-control" name="price_sale" value="{{ old('price_sale') }}">
                                    @if($errors->has('price_sale'))
                                        <span class="help-block">{{ $errors->first('price_sale') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row">

                                @if($attribute)
                                    @foreach($attribute as $itemAttribute)
                                        <div class="col-xs-12 col-md-4 form-group">
                                            <select style="width: 100%" name="attribute_id[]" class="form-control attribute"
                                                    data-placeholder="Chọn {{$itemAttribute->title}}" multiple="multiple" data-tags="true">
                                                <option value=""></option>
                                                @if($itemAttribute->childAttributes)
                                                    @foreach($itemAttribute->childAttributes as $childAttributes)
                                                        <option value="{{ $childAttributes->id }}">{{ $childAttributes->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="form-row">
                                <div class="col-xs-12 col-md-8 form-group has-feedback @if ($errors->has('product_related')) {{ 'has-error' }} @endif">
                                    <label for="product_related">Sản phẩm cùng loại</label>
                                    <select style="width: 100%" name="product_related[]" id="product_related"
                                            class="form-control" data-placeholder="Chọn sản phẩm bán kèm" multiple="multiple" data-tags="true">
                                        <option value=""></option>
                                        @foreach($product_related as $item)
                                            <option value="{{ $item->id }}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('product_related'))
                                        <span class="help-block">{{ $errors->first('product_related') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('stock')) {{ 'has-error' }} @endif">
                                    <label for="stock">Trạng thái kho hàng</label>
                                    <select style="width: 100%" name="stock" id="stock" class="form-control">
                                        <option value="1">Còn hàng</option>
                                        <option value="0">Hết hàng</option>
                                    </select>
                                    @if($errors->has('stock'))
                                        <span class="help-block">{{ $errors->first('stock') }}</span>
                                    @endif
                                </div>



                            </div>

                        </div>
                    </div>





                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group @if ($errors->has('category_id')) {{ 'has-error' }} @endif">
                                <label for="category_id" class="required">Danh mục</label>
                                <select style="width: 100%" name="category_id[]" id="category_id" class="form-control"
                                        data-placeholder="Chọn danh mục" multiple="multiple" data-tags="true">
                                    <option value=""></option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}"> {{ $item->title }}</option>
                                        @if($item->childCategories)
                                            @foreach($item->childCategories as $subCategories)
                                                @include('admin.product.creat_sub_categories', ['taxonomies' => $subCategories,  'char' => '--'])
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
                                        <option value="{{ $item->id }}"> {{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tag_id'))
                                    <span class="help-block">{{ $errors->first('tag_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('meta_title')) {{ 'has-error' }} @endif">
                                <label for="meta_title">Tiêu đề SEO</label>
                                <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ old('meta_title') }}">
                                @if($errors->has('meta_title'))
                                    <span class="help-block">{{ $errors->first('meta_title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_desc')) {{ 'has-error' }} @endif">
                                <label for="meta_desc">Mô tả SEO</label>
                                <textarea rows="5" class="form-control" name="meta_desc">{{ old('meta_desc') }}</textarea>
                                @if($errors->has('meta_desc'))
                                    <span class="help-block">{{ $errors->first('meta_desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('meta_keyword')) {{ 'has-error' }} @endif">
                                <label for="meta_keyword">Từ khóa SEO</label>
                                <input type="text" name="meta_keyword" class="form-control" id="meta_keyword" value="{{ old('meta_keyword') }}">
                                @if($errors->has('meta_keyword'))
                                    <span class="help-block">{{ $errors->first('meta_keyword') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('sort')) {{ 'has-error' }} @endif">
                                <label for="sort">Thứ tự</label>
                                <input type="text" name="sort" class="form-control" id="sort" value="{{ old('sort', 9999) }}">
                                @if($errors->has('sort'))
                                    <span class="help-block">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('feature')) {{ 'has-error' }} @endif">
                                <label for="feature">Nổi bật</label>
                                <select style="width: 100%" name="feature" id="feature" class="form-control">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>

                                </select>
                                @if($errors->has('feature'))
                                    <span class="help-block">{{ $errors->first('feature') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="robots" class="required">Robots</label>
                                <select style="width: 100%" name="robots" id="robots" class="form-control">
                                    <option value="1">Index, follow</option>
                                    <option value="0">Noindex, Nofollow</option>
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

                            <div class="form-row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Thư viện ảnh</label>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-success addGallery">Add gallery</a>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control input-gallery" name="gallery[]">
                                        <div class="thumbnail">
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger mb-2 deleteGallery">Delete</a>
                                            <div class="box-preview">
                                                <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                                <img class="img-preview" src="{{ asset('adminLTE') }}/dist/img/no-img.png">
                                            </div>
                                            <button class="btn btn-primary btn-block uploadGallery">Upload Gallery</button>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        @can('product.view')
                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
                        @endcan

                        @can('product.create')
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
        $('#robots').select2();
        $('#category_id').select2();
        $('#tag_id').select2();
        $('#stock').select2();
        $('#feature').select2();
        $('#product_related').select2();
        $('.attribute').select2();
        $('[name="title"]').on('keyup', function () {
            let slug = UI.toSlug($(this).val());
            $('[name="slug"]').val(slug);
        });
    </script>
@endpush
