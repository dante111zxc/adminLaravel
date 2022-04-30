<div class="modal fade modal-charge" id="charge-by-momo" tabindex="-1" aria-labelledby="banking" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nạp Pcoin bằng MOMO, Viettel Pay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Sử dụng ứng dụng MOMO, Viettel Pay để quét mã QR</p>
                <p class="mb-1">Nội dung chuyển khoản: "<b>số pcoin cần nạp + email</b>".</p>
                <p class="mb-1">VD: "<b>Nạp 500k Pcoin + abcxyz@gmail.com</b>". </p>
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
                            <th scope="col">Cổng thanh toán</th>
                            <th scope="col">Mã QR</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="vertical-middle"><b>MOMO</b></td>
                                <td class="vertical-middle">
                                    <img style="display: block; object-fit: cover; width: 250px; height: auto" src="{{ asset('assets/img/momo.jpg') }}">
                                </td>
                                <td class="vertical-middle">
                                    <p class="mb-0">Số tài khoản: 0329141615</p>
                                    <p class="mb-0"><b>Chủ tài khoản: </b>Đào Quang Huy</p>
                                </td>
                            </tr>

                            <tr>
                                <td class="vertical-middle"><b>Viettel Pay</b></td>
                                <td class="vertical-middle">
                                    <img style="display: block; object-fit: cover; width: 250px; height: auto" src="{{ asset('assets/img/viettel.jpg') }}">
                                </td>
                                <td class="vertical-middle">
                                    <p class="mb-0">Số tài khoản: 9704 2292 0924 3191 947</p>
                                    <p class="mb-0"><b>Chủ tài khoản: </b>Đào Quang Huy</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
                <a href="https://www.facebook.com/PaimonTopup/" target="_blank" class="btn btn-success mb-2">Inbox qua fanpage</a>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
