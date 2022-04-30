@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Thẻ tag sản phẩm</h3>
                        @can('product-tag.create')
                        <div class="pull-right">
                            <a href="{{ route('product-tag.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        @endcan
                    </div>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình đại diện</th>
                                <th>Tiêu đề</th>
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
        let ajaxLoadDataTable = '{{ route('product-tag.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'thumbnail', width: '150px', class: 'text-center vertical-middle', orderable: false },
            { data: 'title', name: 'title', width: '200px', class: 'text-center vertical-middle', orderable: true },
            { data: 'status', name: 'status', width: '100px', class: 'text-center vertical-middle', orderable: false},
            { data: 'action', name: 'action', width: '100px', class: 'vertical-middle', orderable: false },
            { data: 'time', name: 'time', width: '150px', class: 'vertical-middle', orderable: false }
        ];

        DATA_TABLE.init(ajaxLoadDataTable, optionColumn);
    </script>
@endpush
