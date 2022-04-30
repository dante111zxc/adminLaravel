@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <form action="{{route('product.update', $product->id)}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Sửa sản phẩm</h3>

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

                    {{--Nội dung giới thiệu sản phẩm--}}
                    <div class="box">
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('title')) {{ 'has-error' }} @endif">
                                <label for="title" class="required">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', ($product->title) ? $product->title : '' ) }}">
                                @if($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('slug')) {{ 'has-error' }} @endif">
                                <label for="slug" class="required">Đường dẫn</label>
                                <input type="text" class="form-control" name="slug" value="{{ old('slug', ($product->slug) ? $product->slug : '') }}">
                                @if($errors->has('slug'))
                                    <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('desc')) {{ 'has-error' }} @endif">
                                <label for="desc" class="required">Mô tả</label>
                                <textarea rows="5" class="form-control" name="desc">{{ old('desc', ($product->desc) ? $product->desc : '') }}</textarea>
                                @if($errors->has('desc'))
                                    <span class="help-block">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('short_desc')) {{ 'has-error' }} @endif">
                                <label for="short_desc">Mô tả ngắn của sản phẩm (lưu ý khi mua hàng nếu có)</label>
                                <textarea rows="5" class="form-control" name="short_desc">{{ old('short_desc', ($product->short_desc) ? $product->short_desc : '') }}</textarea>
                                @if($errors->has('short_desc'))
                                    <span class="help-block">{{ $errors->first('short_desc') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('content')) {{ 'has-error' }} @endif">
                                <label for="content">Nội dung</label>
                                <textarea id="content" rows="5" class="form-control" name="content">{{ old('content', ($product->content) ? $product->content : '') }}</textarea>
                                @if($errors->has('content'))
                                    <span class="help-block">{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h4>Thông tin sản phẩm</h4>
                        </div>

                        <div class="box-body">
                            <div class="form-row">
                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('sku')) {{ 'has-error' }} @endif">
                                    <label for="sku">Mã sku (mã sản phẩm)</label>
                                    <input type="text" class="form-control" name="sku" value="{{ old('sku', ($product->sku) ? $product->sku : '') }}">
                                    @if($errors->has('sku'))
                                        <span class="help-block">{{ $errors->first('sku') }}</span>
                                    @endif
                                </div>

                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('price')) {{ 'has-error' }} @endif">
                                    <label for="price" class="required">Gía gốc <sup>(vnđ)</sup></label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price', ($product->price) ? $product->price : '') }}">
                                    @if($errors->has('price'))
                                        <span class="help-block">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>

                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('price_sale')) {{ 'has-error' }} @endif">
                                    <label for="price_sale">Gía khuyến mãi <sup>(vnđ)</sup> <span class="label label-danger sale-off"></span></label>
                                    <input type="text" class="form-control" name="price_sale" value="{{ old('price_sale', ($product->price_sale) ? $product->price_sale : '') }}">
                                    @if($errors->has('price_sale'))
                                        <span class="help-block">{{ $errors->first('price_sale') }}</span>
                                    @endif
                                </div>


                            </div>
                            <div class="form-row">
                                @if($attribute)
                                    @foreach($attribute as $itemAttribute)
                                        <div class="col-xs-12 col-md-4 form-group">
                                            <label>{{ $itemAttribute->title }}</label>
                                            <select style="width: 100%" name="attribute_id[]" class="form-control attribute"
                                                    data-placeholder="Chọn {{$itemAttribute->title}}" multiple="multiple" data-tags="true">
                                                <option value=""></option>
                                                @if($itemAttribute->childAttributes)
                                                    @foreach($itemAttribute->childAttributes as $childAttributes)
                                                        <option value="{{ $childAttributes->id }}" @if (in_array($childAttributes->id, $idAttribute) == true) {{ 'selected' }} @endif>{{ $childAttributes->title }}</option>
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
                                            <option value="{{ $item->id }}"  @if (in_array($item->id, $idProductRelated) == true) {{ 'selected' }} @endif>{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('product_related'))
                                        <span class="help-block">{{ $errors->first('product_related') }}</span>
                                    @endif
                                </div>

                                <div class="col-xs-12 col-md-4 form-group has-feedback @if ($errors->has('stock')) {{ 'has-error' }} @endif">
                                    <label for="stock">Trạng thái kho hàng</label>
                                    <select style="width: 100%" name="stock" id="stock" class="form-control">
                                        <option value="1" {{ ($product->stock == 1) ? 'seleted' : '' }}>Còn hàng</option>
                                        <option value="0" {{ ($product->stock == 0) ? 'seleted' : '' }}>Hết hàng</option>
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
                                        <option value="{{ $item->id }}" @if (in_array($item->id, $idCategory) == true) {{ 'selected' }} @endif> {{ $item->title }}</option>
                                        @if($item->childCategories)
                                            @foreach($item->childCategories as $subCategories)
                                                @include('admin.product.edit_sub_categories', ['category' => $subCategories,  'char' => '--',  'id_category' => $idCategory])
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
                                        <option value="{{ $item->id }}" @if (in_array($item->id, $idTag) == true) {{ 'selected' }} @endif> {{ $item->title }}</option>
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
                                <input type="text" name="sort" class="form-control" id="sort" value="{{ old('sort', ($product->sort) ? $product->sort : 9999) }}">
                                @if($errors->has('sort'))
                                    <span class="help-block">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option value="1" {{ ($product->status == 1) ? 'selected' : '' }}>Hiện</option>
                                    <option value="0" {{ ($product->status == 0) ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('feature')) {{ 'has-error' }} @endif">
                                <label for="feature">Nổi bật</label>
                                <select style="width: 100%" name="feature" id="feature" class="form-control">
                                    <option value="0"{{ ($product->feature == 0) ? 'selected' : '' }}>Ẩn</option>
                                    <option value="1"{{ ($product->feature == 1) ? 'selected' : '' }}>Hiện</option>

                                </select>
                                @if($errors->has('feature'))
                                    <span class="help-block">{{ $errors->first('feature') }}</span>
                                @endif
                            </div>



                            <div class="form-group">
                                <label for="robots" class="required">Robots</label>
                                <select style="width: 100%" name="robots" id="robots" class="form-control">
                                    <option value="1" {{ ($product->robots == 1) ? 'selected' : '' }}>Index, follow</option>
                                    <option value="0" {{ ($product->robots == 1) ? 'selected' : '' }}>Noindex, Nofollow</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="thumbnail">Ảnh đại diện</label>
                                <input id="thumbnail" type="hidden" class="form-control" name="thumbnail" value="{{ $product->thumbnail }}">
                                <div class="box-thumbnail">
                                    <div class="box-preview">
                                        <a href="javascript:void(0)" class="clear-img {{ !empty($product->thumbnail) ? 'show' : '' }}"> <i class="fa fa-close"></i> </a>
                                        <img id="thumbnailPreview" src="{{ getThumbnail($product->thumbnail) }}">
                                    </div>
                                    <button id="uploadThumbnail" class="btn btn-primary btn-block">Upload image</button>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Thư viện ảnh</label>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-success addGallery">Add gallery</a>
                                    </div>
                                </div>

                                @if($gallery) @foreach($gallery as $item)
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control input-gallery" name="gallery[]" value="{{ $item }}">
                                        <div class="thumbnail">
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger mb-2 deleteGallery">Delete</a>
                                            <div class="box-preview">
                                                <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                                <img class="img-preview" src="{{ getThumbnail($item) }}">
                                            </div>
                                            <button class="btn btn-primary btn-block uploadGallery">Upload Gallery</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                    @else
                                    <div class="col-12 col-md-6">
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

                                @endif
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
        $('.attribute').select2();
        $('#product_related').select2();
    </script>
@endpush
