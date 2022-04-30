@extends('admin.layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Bình luận</h3>
                    </div>
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vote</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
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
        let ajaxLoadDataTable = '{{ route('reviews.data_table') }}';
        let optionColumn = [
            { data: 'id', name: 'id', width: '50px', class: 'text-center vertical-middle', orderable: true },
            { data: 'vote', name: 'vote', width: '120px', class: 'text-center vertical-middle', orderable: false },
            { data: 'status', name: 'status', width: '50px', class: 'text-center vertical-middle', orderable: false },
            { data: 'feature', name: 'feature', width: '50px', class: 'text-center vertical-middle', orderable: false },
            { data: 'action', name: 'action', class: 'vertical-middle', width: '150px', orderable: false},
            { data: 'time', name: 'time', width: '150px', class: 'vertical-middle', orderable: false}
        ];

        let order = [[0, "desc"]];
        DATA_TABLE.init(ajaxLoadDataTable, optionColumn, order);
    </script>
@endpush
