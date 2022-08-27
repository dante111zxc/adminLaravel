@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Loại mã giảm giá</h3>

                        @can('coupontemplate.create')
                            <div class="pull-right">
                                <a href="{{ route('coupon-template.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</a>
                            </div>
                        @endcan
                    </div>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Giảm giá</th>
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
        let ajaxLoadDataTable = '{{ route('coupon-template.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'title', name: 'title', width: '200px', class: 'text-center vertical-middle', orderable: true },
            { data: 'description', name: 'description', class: 'vertical-middle', width: '100px', orderable: false},
            { data: 'discount', name: 'discount', width: '100px', class: 'text-center vertical-middle', orderable: false},
            { data: 'action', name: 'action', width: '100px', class: 'vertical-middle', orderable: false },
            { data: 'time', name: 'time', width: '150px', class: 'vertical-middle', orderable: false }
        ];

        let order = [[0, "desc"]];

        DATA_TABLE.init(ajaxLoadDataTable, optionColumn, order);
    </script>
@endpush
