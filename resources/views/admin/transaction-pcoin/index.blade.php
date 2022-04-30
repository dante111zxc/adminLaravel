@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lịch sử nạp Pcoin </h3>

                        @can('transactionpcoin.create')
                            <div class="pull-right">
                                <a href="{{ route('transaction-pcoin.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            </div>
                        @endcan

                    </div>
                    <div class="box-body">
                        <div class="filter-search">
                            <form method="POST" id="search-form">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2">
                                        <input type="text" name="filter_email" class="form-control" placeholder="Email khách hàng">
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <input type="text" name="filter_transaction_code" class="form-control" placeholder="Transaction Code">
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <input type="text" name="filter_request_id" class="form-control" placeholder="Mã giao dịch">
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        <select name="filter_method_payment" class="form-control">
                                            @if(!empty($method_payments))
                                                <option value="">Phương thức giao dịch</option>
                                                @foreach($method_payments as $id => $text)
                                                    <option value="{{$id}}">{{ $text }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">Lọc giao dịch</button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Request ID</th>
                                <th>Transaction_code</th>
                                <th>Người nạp</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

@push('script')
    <script>
        /*
         * init data table server side render
        * */
        let ajaxLoadDataTable = '{{ route('transaction-pcoin.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'request_id', name: 'request_id', width: '120px', class: 'text-center vertical-middle', orderable: false },
            { data: 'transaction_code', name: 'transaction_code', width: '120px', class: 'text-center vertical-middle', orderable: false },
            { data: 'user', name: 'user', width: '100px', orderable: false },
            { data: 'type', name: 'type', width: '100px', class: 'text-center vertical-middle', orderable: false },
            { data: 'status', name: 'status', width: '100px', class: 'text-center vertical-middle', orderable: false },
            { data: 'action', name: 'action', class: 'vertical-middle', width: '150px', orderable: false},
            { data: 'time', name: 'time', width: '150px', class: 'vertical-middle', orderable: false}
        ];
        let order = [[0, "desc"]];
        let table = $('#dataTable').DataTable({
            dom: "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12 col-md-6'l><'col-xs-12 col-md-6'p>r>",
            processing: true,
            serverSide: true,
            ajax: {
                data: function (d){
                    d.filter_email = $('input[name="filter_email"]').val();
                    d.filter_request_id = $('input[name="filter_request_id"]').val();
                    d.filter_method_payment = $('select[name="filter_method_payment"]').val();
                    d.filter_transaction_code = $('input[name="filter_transaction_code"]').val();

                },

                url: ajaxLoadDataTable
            },
            columns: optionColumn,
            order: order,
        });


        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            table.draw();
            $('.loading').removeClass('in');
        })
    </script>
@endpush
