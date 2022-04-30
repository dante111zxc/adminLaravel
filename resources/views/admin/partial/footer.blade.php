<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright © 2014-{{ date('Y', time()) }} <a href="javascript:void (0)">Paimonshop</a>.</strong> All rights
    reserved.
</footer>

<div class="alert alert-dismissible toast fade">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
    <div class="message">Success alert preview. This alert is dismissable.</div>
</div>


<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center ">
                <p class="text-danger"><b>Bạn có chắc chắn muốn xóa bản ghi này không?</b></p>
                <button type="button" class="btn btn-default btnClose" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btnConfirmDelete">Đồng ý</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="loading fade">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
</div>
