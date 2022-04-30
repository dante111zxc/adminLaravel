@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách đơn hàng</h3>

{{--                        @can('order.create')--}}
{{--                            <div class="pull-right">--}}
{{--                                <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>--}}
{{--                            </div>--}}
{{--                        @endcan--}}
                    </div>
                    <div class="box-body">
                        <div class="filter-search">
                            <form method="POST" id="search-form">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2">
                                        <input type="text" name="filter_email" class="form-control" placeholder="Email khách hàng">
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        <input type="text" name="filter_phone" class="form-control" placeholder="Số điện thoại đặt hàng">
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        <input type="text" name="filter_id" class="form-control" placeholder="Mã đơn hàng">
                                    </div>

                                    <div class="col-xs-12 col-md-2">
                                        <select name="filter_is_vip_member" class="form-control">
                                            <option value="" selected="selected">Tất cả đơn hàng</option>
                                            <option value="0">Đơn hàng thường</option>
                                            <option value="1">Đơn hàng vip</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success">Lọc đơn hàng</button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thông tin</th>
                                <th>Đơn hàng vip</th>
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
        let ajaxLoadDataTable = '{{ route('order.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'info', name: 'title', width: '120px', class: 'vertical-middle', orderable: false },
            { data: 'is_vip_member', name: 'is_vip_member', width: '50px', class: 'text-center vertical-middle', orderable: false },
            { data: 'status', name: 'status', width: '50px', class: 'text-center vertical-middle', orderable: false },
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
                    d.filter_id = $('input[name="filter_id"]').val();
                    d.filter_is_vip_member = $('select[name="filter_is_vip_member"]').val();
                    d.filter_phone = $('input[name="filter_phone"]').val();

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
