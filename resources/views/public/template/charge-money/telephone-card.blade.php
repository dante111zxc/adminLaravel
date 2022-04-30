<div class="modal fade modal-charge" id="charge-by-telephone-card" tabindex="-1" aria-labelledby="telephone-card" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nạp Pcoin bằng thẻ điện thoại (phí giao dịch 25%)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="note">
                    <ul>
                        <li>Lưu ý điền đúng thông tin và mệnh giá</li>
                        <li>Nếu sai mệnh giá thì sẽ bị phạt tùy theo quy định của bên thứ 3</li>
                    </ul>
                </div>
                <form class="needs-validation">
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="card-type">Loại thẻ</label>
                                <select onchange="selected(this)" class="form-control" name="card_type" id="card-type">
                                    <option value="VIETTEL" selected="selected">Viettel</option>
                                    <option value="MOBIFONE">Mobifone</option>
                                    <option value="VINAPHONE">Vinaphone</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="card-price">Mệnh giá</label>
                                    <select onchange="selected(this)" class="form-control" name="card_price" id="card-price">
                                        <option value="1000000" selected="selected">1.000.000 VND</option>
                                        <option value="500000">500.000 VND</option>
                                        <option value="300000">300.000 VND</option>
                                        <option value="200000">200.000 VND</option>
                                        <option value="100000">100.000 VND</option>
                                        <option value="50000">50.000 VND</option>
                                        <option value="30000">30.000 VND</option>
                                        <option value="20000">20.000 VND</option>
                                        <option value="10000">10.000 VND</option>
                                    </select>
                                </div>

                        </div>


                        {{--seri--}}
                        <div class="col-12">
                            <div class="form-group">
                                <label for="card-serial">Seri thẻ</label>
                                <input type="number" class="form-control" name="card_serial">
                            </div>
                        </div>

                        {{--mã thẻ--}}
                        <div class="col-12">
                            <div class="form-group">
                                <label for="card-code">Mã thẻ</label>
                                <input type="number" class="form-control" name="card_code">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="payCoinByCardPhone" data-href="{{ route('pay_coin_by_card_phone') }}">Nạp Pcoin</button>
            </div>
        </div>
    </div>
</div>
