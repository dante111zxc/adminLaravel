


<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="by-card-tab" data-toggle="pill" href="#by-card" role="tab" aria-controls="by-card" aria-selected="true">Nạp bằng thẻ điện thoại</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="by-banking-tab" data-toggle="pill" href="#by-banking" role="tab" aria-controls="by-banking" aria-selected="false">Nạp bằng tài khoản ngân hàng</a>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="by-card" role="tabpanel" aria-labelledby="by-card">
        <table id="dataTableByCard" class="table table-dark data-table" data-href="{{ route('transaction_history_by_card') }}" style="width: 100%;">
            <thead>
                <tr>
                    <th class="th-1">ID</th>
                    <th class="th-2">Request ID</th>
                    <th class="th-4">Phương thức</th>
                    <th class="th-5">Trạng thái</th>
                    <th class="th-6">Hành động</th>
                    <th class="th-7">Thời gian</th>
                </tr>
            </thead>
        </table>

    </div>
    <div class="tab-pane fade " id="by-banking" role="tabpanel" aria-labelledby="by-banking">
        <table id="dataTableByBank" class="table table-dark data-table" data-href="{{ route('transaction_history_by_bank') }}" style="width: 100%;">
            <thead>
            <tr>
                <th class="th-1">ID</th>
                <th class="th-2">Request ID</th>
                <th class="th-4">Phương thức</th>
                <th class="th-5">Trạng thái</th>
                <th class="th-6">Hành động</th>
                <th class="th-7">Thời gian</th>
            </tr>
            </thead>
        </table>

    </div>
</div>