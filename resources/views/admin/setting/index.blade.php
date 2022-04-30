@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Cài đặt</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('setting.update') }}" class="form-horizontal" id="form-setting">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Cài đặt chung</a></li>
                                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Mail server</a></li>
                                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Mạng xã hội</a></li>
                                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Script</a></li>
                                    <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Chính sách bảo hành</a></li>

                                    @can('setting.edit')
                                    <li class="pull-right"><button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Lưu cài đặt</button></li>
                                    @endcan
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <!--site-name-->
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="site-name">Tên website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="site_name" id="site-name" value="{{ !empty($setting['site_name']) ? $setting['site_name'] : old('site_name', '') }}">
                                            </div>
                                        </div><!--site-name-->

                                        <!--slogan-->
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="slogan">Khẩu hiệu</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="slogan" id="slogan" value="{{ !empty($setting['slogan']) ? $setting['slogan'] : old('slogan', '') }}">
                                            </div>
                                        </div>

                                        <!--mô tả-->
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="meta_desc">Mô tả chung</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="meta_desc" id="meta_desc" value="{{ !empty($setting['meta_desc']) ? $setting['meta_desc'] : old('meta_desc', '') }}">
                                            </div>
                                        </div>

                                        <!--từ khóa seo-->
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="keyword_seo">Keywords Seo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="keyword_seo" id="keyword_seo" value="{{ !empty($setting['keyword_seo']) ? $setting['keyword_seo'] : old('keyword_seo', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="address">Địa chỉ</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="address" id="address" value="{{ !empty($setting['address']) ? $setting['address'] : old('address', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="phone">Số điện thoại</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone" value="{{ !empty($setting['phone']) ? $setting['phone'] : old('phone', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="email">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" value="{{ !empty($setting['email']) ? $setting['email'] : old('email', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="logo">Logo</label>
                                            <div class="col-sm-9">
                                                <input id="logo" type="hidden" class="form-control" name="logo" value="{{ !empty($setting['logo']) ? $setting['logo'] : asset('adminLTE/dist/img/no-img.png') }}">
                                                <div class="box-thumbnail">
                                                    <div class="box-preview">
                                                        <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                                        <img id="logoPreview" src="{{ !empty($setting['logo']) ? getThumbnail($setting['logo']) : asset('adminLTE/dist/img/no-img.png') }}">
                                                    </div>
                                                    <div class="text-center">
                                                        <button id="uploadLogo" class="btn btn-primary">Upload image</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="favicon">Favicon</label>
                                            <div class="col-sm-9">
                                                <input id="favicon" type="hidden" class="form-control" name="favicon" value="{{ !empty($setting['favicon']) ? $setting['favicon'] : asset('adminLTE/dist/img/no-img.png') }}">
                                                <div class="box-thumbnail">
                                                    <div class="box-preview">
                                                        <a href="javascript:void(0)" class="clear-img"> <i class="fa fa-close"></i> </a>
                                                        <img id="faviconPreview" src="{{ !empty($setting['favicon']) ? getThumbnail($setting['favicon']) : asset('adminLTE/dist/img/no-img.png') }}">
                                                    </div>
                                                    <div class="text-center">
                                                        <button id="uploadFavicon" class="btn btn-primary">Upload image</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="mail_driver">Phương thức: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mail_driver" id="mail_driver" value="{{ !empty($setting['mail_driver']) ? $setting['mail_driver'] : old('mail_driver', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="mail_port">Cổng: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mail_port" id="mail_port" value="{{ !empty($setting['mail_port']) ? $setting['mail_port'] : old('mail_port', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="mail_username">Email: </label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="mail_username" id="mail_username" value="{{ !empty($setting['mail_username']) ? $setting['mail_username'] : old('mail_username', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="mail_password">Mật khẩu: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mail_password" id="mail_password" value="{{ !empty($setting['mail_password']) ? $setting['mail_password'] : old('mail_password', '') }}">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3">
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="facebook">Facebook: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="facebook" id="facebook" value="{{ !empty($setting['facebook']) ? $setting['facebook'] : old('facebook', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="twitter">Twitter: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="twitter" id="twitter" value="{{ !empty($setting['twitter']) ? $setting['twitter'] : old('twitter', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="youtube">Youtube: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="youtube" id="youtube" value="{{ !empty($setting['youtube']) ? $setting['youtube'] : old('youtube', '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="instagram">Instagram: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="instagram" id="instagram" value="{{ !empty($setting['instagram']) ? $setting['instagram'] : old('instagram', '') }}">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="pinterest">Pinterest: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="pinterest" id="pinterest" value="{{ !empty($setting['pinterest']) ? $setting['pinterest'] : old('pinterest', '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_4">
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="custom_css">Custom Css: </label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="custom_css" id="custom_css" rows="20">{{ !empty($setting['custom_css']) ? $setting['custom_css'] : old('custom_css', '') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="custom_js">Custom Javascript: </label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="custom_js" id="custom_js" rows="20">{{ !empty($setting['custom_js']) ? $setting['custom_js'] : old('custom_js', '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_5">
                                        <div class="form-group">
                                            <label class="col-sm-3 text-left control-label" for="custom_js">Chính sách bảo hành: </label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="service" id="service" rows="20">{{ !empty($setting['service']) ? $setting['service'] : old('service', '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

