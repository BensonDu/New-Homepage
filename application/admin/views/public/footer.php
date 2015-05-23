</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->


<!-- Modal -->
<div class="modal fade" id="del_basic" tabindex="-1" role="basic" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">刪除信息確認</h4>
            </div>
            <div class="modal-body" id="preview-sdk-config-con">
                確認刪除操作么？此操作將不可恢復！請謹慎使用！
            </div>
            <div class="modal-footer">
                <a id="del_button" href="#" class="btn btn-danger">確認刪除</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
    function del_confirm(url){
        $("#del_button").attr('href', url);
    }
</script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo ADMIN_STATIC_PATH;?>js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo ADMIN_STATIC_PATH;?>js/sb-admin-2.js"></script>

</body>

</html>
