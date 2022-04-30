@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Vị trí menu</h3>

                        @can('menuposition.create')
                            <div class="pull-right">
                                <a href="{{ route('menuposition.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            </div>
                        @endcan
                    </div>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Vị trí</th>
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
        let ajaxLoadDataTable = '{{ route('menuposition.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'title', name: 'title', width: '100px', class: 'text-center vertical-middle', orderable: true },
            { data: 'position', name: 'position', width: '100px', class: 'text-center vertical-middle', orderable: true },
            { data: 'status', name: 'status', width: '100px', class: 'text-center vertical-middle', orderable: false },
            { data: 'action', name: 'action', class: 'vertical-middle', width: '300px', orderable: false},
            { data: 'time', name: 'time', width: '220px', class: 'vertical-middle', orderable: false}
        ];

        let order = [[0, "desc"]];

        DATA_TABLE.init(ajaxLoadDataTable, optionColumn, order);
    </script>
@endpush
