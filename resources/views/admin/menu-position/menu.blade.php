@extends('admin.layouts.app')
@section('content')
    <!--Template này để add, update, edit danh sách phần tử trên menu-->
    <!-- Main content -->
    <form action="{{route('menu.update', $menu->id)}}" method="POST">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Thêm liên kết</h3>
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


                <div class="col-xs-12 col-md-5">
                    <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        @if(!empty($list_menu)) @foreach($list_menu as $key => $item)
                            <div class="panel box">
                                <div class="box-header">
                                    <h4 style="margin: 0">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="false" class="collapsed text-black" style="display: block">
                                            {{ $item['title'] }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse{{$key}}" class="panel-collapse overflow-y-auto @if ($key === 'category') {{'collapse in'}} @else {{'collapse'}} @endif" aria-expanded="false" style="max-height: 200px">
                                    <div class="box-body">
                                        @foreach( $item['list'] as $index => $item_menu)
                                            <div class="form-group">
                                                <input type="checkbox" value="{{ $item_menu->id }}" data-slug="{{ $item_menu->slug }}" data-type="{{ $key }}" data-title="{{ $item_menu->title }}">
                                                <span style="margin-left: 1rem">{{ $item_menu->title }}</span>
                                            </div>
                                            @if ($key === 'category' || $key === 'product_category')
                                                @if($item_menu->childCategories)
                                                    @foreach($item_menu->childCategories as $subCategories)
                                                        @include('admin.menu-position.sub-item', ['menu_item' => $subCategories, 'key' => $key, 'style' => 25])
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="box-footer"><a href="javascript:void(0)" class="addMenuItem btn btn-sm btn-success"><i class="fa fa-plus"></i> Thêm</a></div>
                            </div>
                        @endforeach @endif

                    </div>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group has-feedback @if ($errors->has('title')) {{ 'has-error' }} @endif">
                                        <label for="title">Tên menu</label>
                                        <input type="text" class="form-control" readonly name="title" value="{{ old('title', $menu->title ?? '') }}">
                                        @if($errors->has('title'))
                                            <span class="help-block">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group has-feedback @if ($errors->has('position')) {{ 'has-error' }} @endif">
                                        <label for="desc">Vị trí</label>
                                        <input type="text" class="form-control" name="position" readonly value="{{ old('position', $menu->position ?? '') }}">
                                        @if($errors->has('position'))
                                            <span class="help-block">{{ $errors->first('position') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select name="status" id="status" class="form-control">
                                            <option @if ($menu->status == 1) selected @endif value="1">Hiện</option>
                                            <option @if ($menu->status == 0) selected @endif value="0">Ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="dd" id="nestable">
                                        <ol class="dd-list">
                                            @if (!empty($nestable))
                                                @foreach($nestable as $item)
                                                    <li class="dd-item"
                                                        data-guid="{{ $item->guid }}"
                                                        data-slug="{{ $item->slug }}"
                                                        data-title="{{ $item->title }}"
                                                        data-type="{{ $item->type }}">
                                                        <div class="dd-handle">{{ $item->title }}</div>
                                                        <span class="edit"><i class="fa fa-fw fa-edit"></i> Sửa</span>
                                                        <span class="delete"><i class="fa fa-fw fa-trash"></i> Xóa</span>
                                                        <div class="edit-menu" >
                                                            <input class="form-control input-sm edit-title" type="text" placeholder="Tiêu đề" value="{{ $item->title }}">
                                                        </div>
                                                        @if(!empty($item->subMenu))
                                                            <ol class="dd-list">
                                                                @foreach ($item->subMenu as $subMenu)
                                                                    @include('admin.menu-position.nestable-submenu', ['subMenu' => $subMenu])
                                                                @endforeach
                                                            </ol>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ol>
                                    </div>
                                </div>
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
        $('#status').select2({
            disabled : true
        });
        $('#nestable').nestable({
            'expandBtnHTML' : '',
            'collapseBtnHTML' : ''
        });
        //thêm phần tử vào menu
        (function () {
            $('.addMenuItem').on('click', function () {
                let checkbox = $(this).closest('.panel.box').find('input:checked');
                let html = '';
                $.each( checkbox, function (key, item) {
                    html += '<li class="dd-item" data-guid="'+$(item).val()+'" data-slug="'+$(item).attr('data-slug')+'" data-type="'+$(item).attr('data-type')+'" data-title="'+$(item).attr('data-title')+'">';
                    html += '<div class="dd-handle">'+$(item).attr('data-title')+'</div>';
                    html += '<span class="edit"><i class="fa fa-fw fa-edit"></i> Sửa</span>';
                    html += '<span class="delete"><i class="fa fa-fw fa-delete"></i> Xóa</span>';
                    html += '<div class="edit-menu" ><input class="form-control input-sm edit-title" type="text" placeholder="Tiêu đề" value="'+$(item).attr('data-title')+'"></div>';
                    html += '</li>';
                });

                if (html) {
                    $('#nestable > .dd-list').append(html);
                    if ($('.dd-empty')) $('.dd-empty').remove();
                }

                $('input[type="checkbox"]').iCheck('uncheck');
            });
        })();

        //xóa phần tử ở menu
        (function () {
            $(document).on('click', '.dd-item .delete', function (e) {
                e.preventDefault();
                $(this).closest('.dd-item').remove();
            });
        })();

        //edit phần tử trên menu
        (function () {
            $(document).on('click', '.dd-item .edit', function (e) {
                e.preventDefault();
                let editMenu = $(this).closest('.dd-item').find('> .edit-menu');
                $('.edit').removeAttr('style');
                $('.edit-menu').removeAttr('style');
                editMenu.toggleClass('show');
            })
        })();

        //sửa tiêu đề menu
        (function () {
            $(document).on('change', '.edit-title', function (e) {
                e.preventDefault();
                let parentEl = $(this).closest('.dd-item');
                parentEl.attr('data-title', $(this).val());
                parentEl.find('> .dd-handle').text($(this).val());
            });
        })();

        //update menu vào database
        (function () {
            $('form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url : '{{route('menu.update', $menu->id)}}',
                    method : 'POST',
                    dataType: 'JSON',
                    data : {
                        _token: '{{ csrf_token() }}',
                        menu: $('#nestable').nestable('serialize'),
                        menu_position_id: '{{ $menu->id }}'
                    },

                    success: function (res) {
                        $('.loading').removeClass('in');
                        UI.toast(res.type, res.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },

                    error: function (error) {
                        console.log(error);
                    }
                });
            })
        })();


    </script>
@endpush

