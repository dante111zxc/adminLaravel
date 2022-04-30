@extends('admin.layouts.app')
@section('content')
    <!-- Main content -->
    <form action="{{route('order.update', $order->id )}}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="is_vip_member" value="{{ $order->is_vip_member }}">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Chi tiết đơn hàng</h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('order.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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

                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-header">
                            <h4 style="font-size: 16px; font-weight: 700">Thông tin khách hàng</h4>
                            @if($order->is_vip_member)
                                {!! showRankImg(getTotalOrderAmountByUserId($order->user_id)) !!}
                            @endif
                        </div>
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('name')) {{ 'has-error' }} @endif">
                                <label for="name" class="required">Tên khách hàng</label>
                                <input type="text" class="form-control" readonly name="name" value="{{ old('name', $order->name) }}">
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('phone')) {{ 'has-error' }} @endif">
                                <label for="phone" class="required">Số điện thoại</label>
                                <input type="text" class="form-control" readonly name="phone" value="{{ old('phone', $order->phone) }}">
                                @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('address')) {{ 'has-error' }} @endif">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" readonly name="address" value="{{ old('address', $order->address) }}">
                                @if($errors->has('address'))
                                    <span class="help-block">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-feedback @if ($errors->has('email')) {{ 'has-error' }} @endif">
                                <label for="email" class="required">Email</label>
                                <input type="email" class="form-control" readonly name="email" value="{{ old('email', $order->email) }}">
                                @if($errors->has('address'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('link_facebook')) {{ 'has-error' }} @endif">
                                <label for="link_facebook">Link facebook</label>
                                <input type="text" class="form-control" readonly name="link_facebook" value="{{ old('link_facebook', $order->link_facebook) }}">
                                @if($errors->has('link_facebook'))
                                    <span class="help-block">{{ $errors->first('link_facebook') }}</span>
                                @endif
                            </div>


                            <!--
                                 0: Chuyển khoản qua tài khoản ngân hàng
                                 1: thanh toan truc tiep
                             -->

                            <div class="form-group">
                                <label for="method_payment" class="required">Phương thức thanh toán</label>
                                <select style="width: 100%" name="method_payment" id="method_payment" class="form-control">
                                    <option @if ($order->method_payment == 1) selected @endif value="1">CK qua tài khoản ngân hàng</option>
                                    <option @if ($order->method_payment == 2) selected @endif value="2">Thanh toán bằng Pcoin</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="subtotal" style="margin-right: 10px">Tổng phụ:</label><small>{!! showMoney($order->subtotal) !!}</small>
                                <input type="text" readonly name="subtotal" class="form-control" value="{{ $order->subtotal }}">
                            </div>

                            <div class="form-group">
                                <label for="is_vip_member">Giảm giá Vip Member</label>
                                <input class="form-control" type="text" disabled value="{{ $saleVipMember }}">
                            </div>

                            <div class="form-group has-feedback @if ($errors->has('total')) {{ 'has-error' }} @endif">
                                <label for="total" style="margin-right: 10px">Tổng tiền thanh toán:</label><small>{!! showMoney($order->total) !!}</small>
                                <input type="text" class="form-control" readonly name="total" value="{{ old('total', $order->total) }}">
                                @if($errors->has('total'))
                                    <span class="help-block">{{ $errors->first('total') }}</span>
                                @endif
                            </div>

                        <!--0 - Dang xu ly
                            1 - da xu ly
                            2 - hoan thanh
                            3 - huy

                            0 - dang xu ly
                            1 - hoan thanh
                            2 - huy  -->

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option @if ($order->status == 0) selected @endif value="0">Đang xử lý</option>
                                    <option @if ($order->status == 1) selected @endif value="1">Hoàn thành</option>
                                    <option @if ($order->status == 2) selected @endif value="2">Đã hủy</option>
                                </select>
                            </div>

{{--                            ghi chu--}}
                            <div class="form-group has-feedback @if ($errors->has('note')) {{ 'has-error' }} @endif">
                                <label for="note">Ghi chú</label>
                                <textarea name="note" id="note" class="form-control" rows="10">{{ old('note', $order->note) }}</textarea>
                                @if($errors->has('note'))
                                    <span class="help-block">{{ $errors->first('note') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-md-8">
                    <div class="box">
                        <div class="box-header">
                            <h4 style="font-size: 16px; font-weight: 700">Chi tiết đơn hàng</h4>
                        </div>
                        <div class="box-body">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th>Ảnh đại diện</th>
                                            <th>Tên sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-center">Đơn giá</th>
                                        </tr>
                                    </thead>

                                    @foreach($orderDetail as $key => $item)
                                    <tr>
                                        <td class="vertical-middle text-center">{{ $key + 1 }}</td>
                                        <td>
                                            <img style="display: block; max-width: 200px; height: auto" src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                                        </td>
                                        <td class="vertical-middle">
                                            <a href="{{ route('product.edit', $item->id) }}"> {{ $item->title }}</a>
                                        </td>
                                        <td class="text-center vertical-middle">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="text-center vertical-middle">
                                            @if ( !empty($item->price) && !empty($item->price_sale) && ( $item->price >  $item->price_sale) )
                                                <div class="regular-price"><del>{!! showMoney($item->price) !!}</del></div>
                                            @endif

                                            @if( !empty($item->price_sale) && ($item->price_sale < $item->price))
                                                <div class="price-sale text-danger">{!! showMoney($item->price_sale) !!}</div>
                                            @else
                                                <div class="price-sale text-danger">{!! showMoney($item->price) !!}</div>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </table>

                        </div>
                    </div>

                    {{--thông tin tài khoản in game nếu có--}}
                    @if(!empty($accInfo))

                    <div class="box">
                        <div class="box-body">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    @foreach($accInfo as $key => $item)
                                        <li class="{{ ($key == 0) ? 'active' : '' }}"><a href="#tab_acc_info-{{ $key }}" data-toggle="tab" aria-expanded="false">Tài khoản {{ $key + 1 }}</a></li>
                                    @endforeach
                                    <li class="pull-left header"><i class="fa fa-th"></i>
                                        Thông tin tài khoản Ingame
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    @foreach($accInfo as $key => $item)
                                    <div class="tab-pane {{ ($key == 0) ? 'active' : '' }}" id="tab_acc_info-{{ $key }}">
                                        <ul>
                                            <li><b>Tên đăng nhập: </b>{{ (!empty($item->username)) ? $item->username : '' }}</li>
                                            <li><b>Mật khẩu: </b>{{ (!empty($item->password)) ? $item->password : '' }}</li>
                                            <li><b>Nền tảng: </b>{{ (!empty($item->platform)) ? $item->platform : '' }}</li>
                                            <li><b>Server: </b>{{ (!empty($item->server)) ? $item->server : '' }}</li>
                                            <li><b>Tên nhân vật - cấp độ: </b>{{ (!empty($item->charactername)) ? $item->charactername : '' }}</li>
                                        </ul>

                                    </div>
                                    @endforeach
                                </div>
                                <!-- /.tab-content -->
                            </div>

                        </div>
                    </div>
                    @endif


                    <div class="box">
                        <div class="box-header">
                            <h4 style="font-size: 16px; font-weight: 700">Gửi email cho khách hàng</h4>
                            <input type="hidden" name="email_has_send" value="{{ old('email_has_send', $order->email_has_send) }}">

                            @if($order->email_has_send == 1)
                                    <p class="label label-success">Đã gửi mail</p>
                                @else
                                <p class="label label-warning">Chưa gửi mail</p>
                            @endif
                        </div>
                        <div class="box-body">
                            <div class="form-group has-feedback @if ($errors->has('email_to')) {{ 'has-error' }} @endif">
                                <label for="email_to">Email khách hàng</label>
                                <input type="text" class="form-control" name="email_to" value="{{ old('email', (!empty($order->email) ? $order->email : "")) }}">
                                @if($errors->has('email_to'))
                                    <span class="help-block">{{ $errors->first('email_to') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email_content">Nội dung email</label>
                                <textarea name="email_content" class="form-control" id="email_content">{{ old('email_content', !empty($order->email_content) ? $order->email_content : "") }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('order.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>
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
        $('#method_payment').select2({
            disabled: true
        });
    </script>
@endpush
