@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Thành viên</h3>

                        @can('user.create')
                            <div class="pull-right">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            </div>
                        @endcan

                    </div>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình đại diện</th>
                                <th>Thông tin thành viên</th>
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
        let ajaxLoadDataTable = '{{ route('user.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'thumbnail', name: 'thumbnail', width: '120px', class: 'text-center vertical-middle', orderable: false },
            { data: 'info', name: 'info', width: '300px', orderable: false },
            { data: 'email_verified_at', name: 'email_verified_at', width: '50px', class: 'text-center vertical-middle', orderable: false },
            { data: 'action', name: 'action', class: 'vertical-middle', width: '150px', orderable: false},
            { data: 'time', name: 'time', width: '150px', class: 'vertical-middle', orderable: false}
        ];
        let order = [[0, "desc"]];
        let table = DATA_TABLE.init(ajaxLoadDataTable, optionColumn, order);
        $('#search').on('change', function () {
            table.draw();
        })
    </script>
@endpush
