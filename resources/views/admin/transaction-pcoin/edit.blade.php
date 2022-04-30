@extends('admin.layouts.app')
@section('content')
    <!-- Main content -->
    <form action="{{route('transaction-pcoin.update', $transaction->id )}}" method="POST">
        @csrf
        @method('PUT')
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header">
                        <div class="pull-left">
                            <h3 class="box-title">Chi tiết giao dịch</h3>
                        </div>
                        <div class="pull-right">
                            @can('transactionpcoin.view')
                            <a href="{{ route('transaction-pcoin.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>

                            @endcan

                            @can('transactionpcoin.edit')
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

                <div class="col-xs-12 col-md-4">
                    <div class="box">
                        <div class="box-header">
                            <h4 style="font-size: 16px; font-weight: 700">Thông tin giao dịch</h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="request_id">Mã giao dịch</label>
                                <input type="text" readonly class="form-control" id="request_id" name="request_id" value="{{ old('request_id', ($transaction->request_id) ? $transaction->request_id : '') }}">
                            </div>
                            @if($transaction->type == 1)
                            <div class="form-group">
                                <label for="tel_code">Nhà mạng</label>
                                <input type="text" readonly class="form-control" id="tel_code" name="tel_code" value="{{ old('tel_code', (!empty($transaction_data->tel_code)) ? $transaction_data->tel_code : '') }}">
                            </div>

                            <div class="form-group">
                                <label for="code">Mã thẻ</label>
                                <input type="text" readonly class="form-control" id="code" name="code" value="{{ old('code', (!empty($transaction_data->code)) ? $transaction_data->code : '') }}">
                            </div>

                            <div class="form-group">
                                <label for="serial">Seri thẻ</label>
                                <input type="text" readonly class="form-control" id="serial" name="serial" value="{{ old('serial', (!empty($transaction_data->serial)) ? $transaction_data->serial : '') }}">
                            </div>

                            <div class="form-group">
                                <label for="amount">Mệnh giá thẻ cào</label>
                                <input type="text" readonly class="form-control" id="amount" name="amount" value="{{ old('amount', (!empty($transaction_data->amount)) ? $transaction_data->amount : '') }}">
                            </div>


                            <div class="form-group">
                                <label for="actually_received">Giá trị thực nhận</label>
                                <input type="text" readonly class="form-control" id="actually_received" name="actually_received" value="{{ old('actually_received', (!empty($transaction_data->actually_received)) ? $transaction_data->actually_received : '') }}">
                            </div>

                            <div class="form-group">
                                <label for="pcoin">Pcoin</label>
                                <input type="text" readonly class="form-control" id="pcoin" name="pcoin" value="0">
                            </div>

                            <div class="form-group">
                                <label for="type">Loại giao dịch</label>
                                <input type="text" hidden value="{{ $transaction->type }}" name="type">
                                <div>Nạp Pcoin bằng thẻ điện thoại</div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" id="checkCardStatus">Kiểm tra trạng thái thẻ cào</button>
                                <input type="hidden" name="card_status" id="card_status" value="{{ !empty($transaction_data->status) ? $transaction_data->status : '' }}">
                                <span class="card_status"></span>
                            </div>
                            @endif

                            @if($transaction->type == 2)
                            <div class="fomr-group">
                                <label for="thumbnail">Ảnh chuyển tiền</label>
                                @if ($transaction_data->thumbnail)
                                    <input type="hidden" value="{{ $transaction_data->thumbnail }}">
                                    <img src="{{ $transaction_data->thumbnail }}" style="display: block; max-width: 100%; height: auto">
                                    @else
                                    <p>Đề nghị khách hàng gửi ảnh chuyển tiền bằng cách tạo Request Order hoặc gửi qua fanpage</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="type">Loại giao dịch</label>
                                <input type="text" hidden value="{{ $transaction->type }}" name="type">
                                <div>Nạp Pcoin bằng CK Ngân hàng</div>
                            </div>

                            <div class="form-group">
                                <label for="pcoin">Pcoin</label>
                                <input type="text" class="form-control" id="pcoin" name="pcoin" value="0">
                            </div>

                            @endif
                            @if($transaction->type == 3)
                                <div class="form-group">
                                    <label for="transaction_code">Transaction Code</label>
                                    <input class="form-control" type="text" readonly value="{{ $transaction_data->transaction_code }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Loại giao dịch</label>
                                    <input type="text" hidden value="{{ $transaction->type }}" name="type">
                                    <div>Nạp Pcoin bằng Internet Banking</div>
                                </div>

                                <div class="form-group">
                                    <label for="pcoin">Pcoin</label>
                                    <input type="text" class="form-control" readonly id="pcoin" name="pcoin" value="{{ $transaction_data->amount }}">
                                </div>

                            @endif

                            <div class="form-group">
                                <label for="status" class="required">Trạng thái giao dịch</label>
                                <select style="width: 100%" name="status" id="status" class="form-control">
                                    <option @if ($transaction->status == 0) selected @endif value="0">Đang xử lý</option>
                                    <option @if ($transaction->status == 1) selected @endif value="1">Đã hoàn thành</option>
                                    <option @if ($transaction->status == 2) selected @endif value="2">Lỗi</option>

                                </select>
                            </div>


                            <div class="form-group has-feedback @if ($errors->has('note')) {{ 'has-error' }} @endif">
                                <label for="note">Ghi chú</label>
                                <textarea name="note" id="note" class="form-control" rows="10">{{ old('note', $transaction->note) }}</textarea>
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
                            <h4 style="font-size: 16px; font-weight: 700">Thông tin thành viên nạp Pcoin</h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <label for="email">Email</label>
                                <input type="text" readonly class="form-control" value="{{ old('email', ($user->email) ? $user->email : '') }}" name="email">
                            </div>

                            <div class="form-group">
                                <label for="name">Tên thành viên</label>
                                <input type="text" readonly class="form-control" value="{{ old('name', ($user->name) ? $user->name : '') }}" name="name">
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" readonly class="form-control" value="{{ old('phone', ($user->phone) ? $user->phone : '') }}" name="phone">
                            </div>

                            <div class="form-group">
                                <label for="id_number">Số CMND</label>
                                <input type="text" readonly class="form-control" value="{{ old('id_number', ($user->id_number) ? $user->id_number : '') }}" name="id_number">
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" readonly class="form-control" value="{{ old('address', ($user->address ) ? $user->address  : '')}}" name="address">
                            </div>

                            <div class="form-group">
                                <label for="pcoin">Pcoin hiện có</label>
                                <input type="hidden" class="form-control" value="{{ $user->pcoin }}" name="user_pcoin" id="user_pcoin">
                                <input type="text" readonly="readonly" class="form-control user_pcoin" value="{{ $user->pcoin }}">
                            </div>

                            <div class="form-group">
                                <label for="created_at">Ngày giao dịch</label>
                                <input type="text" readonly class="form-control" value="{{ !empty($transaction_data->created_at) ? $transaction_data->created_at : '' }}" name="transaction_created">
                            </div>

                        </div>
                    </div>


                </div>
                <div class="col-xs-12">
                    <div class="pull-right">
                        <a href="{{ route('transaction-pcoin.index') }}" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Hủy</a>

                        @can('transactionpcoin.edit')
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

        $('#checkCardStatus').on('click', function (e) {
            e.preventDefault();
            let user_pcoin = '{{ $user->pcoin }}';
            $.ajax({
                url : '{{ route("check_card_status") }}',
                dataType: "JSON",
                method: 'POST',
                data: {
                    _token: _token,
                    telco: '{{ (!empty($transaction_data->tel_code)) ? $transaction_data->tel_code : '' }}',
                    code: '{{ (!empty($transaction_data->code)) ? $transaction_data->code : '' }}',
                    serial: '{{ (!empty($transaction_data->serial)) ? $transaction_data->serial : '' }}',
                    amount: '{{ (!empty($transaction_data->amount)) ? $transaction_data->amount : '' }}',
                    request_id: '{{ (!empty($transaction_data->request_id)) ? $transaction_data->request_id : '' }}'
                },

                beforeSend(){
                    $('.loading').addClass('in');
                },

                success (res){
                    $('.loading').removeClass('in');
                    let textStatus = res.message;
                    if (res.status == 3) {
                        textStatus = 'Thẻ lỗi hoặc đã qua sử dụng';
                    }

                    let cardStatus;
                    switch (res.status) {
                        case 1 :
                            cardStatus = 1;
                            break;
                        case 99 :
                            cardStatus = 0;
                            break;
                        case 2 :
                            cardStatus = 2;
                            break;
                        case 3 :
                            cardStatus = 2;
                            break;
                        case 4:
                            cardStatus = 2;
                            break;

                        default :
                            cardStatus = 2;
                            break;
                    }

                    $('#card_status').val(cardStatus);


                    if (res.status == 1) {
                        $('#actually_received').val(res.amount);
                        let fee = Math.floor((parseInt(25 * res.declared_value)) / 100);
                        let pcoin = Math.floor( parseInt(res.declared_value) - parseInt(fee));
                        $('#pcoin').val(parseInt(pcoin));
                        $('#user_pcoin').val(parseInt(user_pcoin) + parseInt(pcoin));
                        $('.user_pcoin').val(parseInt(user_pcoin) + parseInt(pcoin));
                    }
                    $('.card_status').text(textStatus);
                }
            })
        });

        $('#pcoin').on('change', function () {
            let pcoin = parseInt($(this).val());
            let user_pcoin = parseInt('{{ $user->pcoin }}');
            console.log(user_pcoin);
            if (!isNaN(pcoin)) {
                $('#user_pcoin').val(user_pcoin + pcoin);
            }

        });
    </script>
@endpush
