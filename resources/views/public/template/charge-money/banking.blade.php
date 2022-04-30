<div class="modal fade modal-charge" id="charge-by-banking" tabindex="-1" aria-labelledby="banking" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nạp Pcoin qua tài khoản ngân hàng (Không mất phí)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Bạn thanh toán số tiền cần nạp vào 1 trong các tài khoản dưới đây:</p>
                <p class="mb-1">Nội dung chuyển khoản: "<b>số pcoin cần nạp + email</b>".</p>
                <p class="mb-1">VD: "<b>Nạp 500k Pcoin + abcxyz@gmail.com</b>". </p>
                <p class="mb-1">Sử dụng chức năng nạp ngay để thanh toán bằng Internet Banking</p>
                <p class="mb-1"><a class="btn btn-primary" target="_blank" href="{{ route('pay_coin_by_banking') }}">Nạp ngay</a></p>
                <p class="mb-1"> Lưu ý: </p>
                <ul>
                    <li><b>Chuyển khoản nhanh 24/7</b>.</li>
                    <li>Chụp hình ảnh chuyển khoản thành công và gửi cho page kèm email cần nạp qua nút “Inbox qua fanpage” bên dưới</li>
                    <li>Sau khi nhân viên của Shop nhận được biên lai sẽ cộng Pcoin và thông báo.</li>
                    <li>Nếu quá 10 phút Shop không có phản hồi, vui lòng liên hệ hotline: <b>0329.14.16.15</b> hoặc <b>0394.03.55.89</b></li>
                </ul>
                <h4>Thông tin tài khoản ngân hàng</h4>
                @if ($method_payment)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ngân hàng</th>
                                <th scope="col">Thông tin tài khoản</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($method_payment as $key => $item)
                            <tr>
                                <td class="vertical-middle">{{ $key + 1 }}</td>
                                <td class="vertical-middle">
                                    <img class="bank-img" src="{{ getThumbnail($item->thumbnail) }}" alt="{{ $item->title }}">
                                </td>
                                <td class="vertical-middle">
                                    <p class="mb-0"><b>Ngân hàng: </b>{{ $item->bank_name }}</p>
                                    <p class="mb-0"><b>Số tài khoản: </b>{{ $item->account_number }}</p>
                                    <p class="mb-0"><b>Chủ tài khoản: </b>{{ $item->account_name }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>

                @endif


{{--                <button class="btn btn-primary mb-2" data-toggle="collapse" href="#requestOrderPcoin" role="button" aria-expanded="false" aria-controls="requestOrderPcoin">Gửi biên lai</button>--}}
                <a href="https://www.facebook.com/PaimonTopup/" target="_blank" class="btn btn-success mb-2">Inbox qua fanpage</a>
{{--                <div class="collapse" id="requestOrderPcoin">--}}
{{--                    <form method="POST" id="uploadImageBanking" enctype="multipart/form-data" action="{{ route('pay_coin_by_banking') }}">--}}
{{--                        @csrf--}}
{{--                        <div class="form-row">--}}
{{--                            <div class="col-12 col-md-9">--}}
{{--                                <div class="input-group mb-3">--}}
{{--                                    <div class="input-group-prepend">--}}
{{--                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="custom-file">--}}
{{--                                        <input type="file" name="thumbnail" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="">--}}
{{--                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-3">--}}
{{--                                <button type="submit" class="btn btn-block btn-success" id="requestOrderPcoin">Gửi biên lai</button>--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="thumbnail-preview"></div>--}}
{{--                                <div class="result"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </form>--}}


{{--                </div>--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
