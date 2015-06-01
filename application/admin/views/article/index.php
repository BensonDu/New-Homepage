<!-- DataTables CSS -->
<link href="<?php echo COMMON_STATIC_PATH;?>admin/css/dataTables.bootstrap.css?v=1" rel="stylesheet">
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div id="alert_info" class="panel-heading" style="height: 0; opacity:0;display: none;padding: 0;line-height: 40px;text-align:center;">
                <p style="color:#FFF;font-weight: bold;font-size: 1.2em;"></p></div>
            <div class="panel-heading">
                全部文章<a class="btn btn-info btn-xs arrow" href="/article/add"><i class="fa fa-plus"></i> 添加</a>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>标题</th>
                            <th>类别</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>最后修改</th>
                            <th>操作</th>
                        </tr>
                        </thead>


                    </table>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


<!-- DataTables JavaScript -->
<script src="<?php echo COMMON_STATIC_PATH;?>admin/js/jquery.dataTables.js"></script>
<script src="<?php echo COMMON_STATIC_PATH;?>admin/js/dataTables.bootstrap.js"></script>
<script>
    $.extend({
        'Dateformat':function(stamp){
            var t=new Date(1e3*parseInt(stamp)),y= t.getFullYear(),m= t.getMonth()+1,d= t.getDate(),h= t.getHours(),i= t.getMinutes(),s= t.getSeconds();
            return y+'年'+m+'月'+d+'日 '+h+':'+i+':'+s;
        }
    });
    $('#dataTables-example').dataTable( {
        "bAutoWidth": false,
        "processing": true,
        "serverSide": true,
        "bStateSave": true,
        "order": [[ 0, "desc" ]],
        "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 6 ]
        } ],
        "columns": [
            { "data": "id" },
            { "data": "title" },
            { "data": "type" },
            {
                "data":'sta',
                "render":function(data,type,full,meta){
                    return data==1?'<span style="color: green">已发布</span>':'<span style="color: #428bca">草稿</span>';
                }
            },
            {
                "data": "create_time",
                "render":function(data, type, full, meta){
                    return $.Dateformat(data);
                }
            },
            { "data": "last_modefy" ,
               "render":function(data){
                   return data!=0?$.Dateformat(data):'';
               }
            },
            {
                "data":'handle',
                "render":function(data,type,full,meta){
                    var id=data;
                    var htm = '<a class="btn btn-outline btn-primary btn-xs" href="/article/edit/'+id+'"><i class="fa fa-edit"></i> 编辑</a> ';
                        htm += '<a class="btn btn-outline btn-info btn-xs" target="_blank" href=""><i class="fa fa-times-circle-o"></i> 预览</a> ';
                        htm += '<a class="btn btn-outline btn-danger btn-xs serverdel"  onclick="return deleteServer('+id+')">刪除</a>';
                    return htm;
                }
            }
        ],
        "oLanguage": {
            "sProcessing" : "正在获取数据，请稍等...",
            "sLengthMenu" : "显示 _MENU_ 条",
            "sZeroRecords" : "没有您搜索到的内容",
            "sInfo" : "从 _START_ 到  _END_ 条记录  共 _TOTAL_ 条",
            "sInfoEmpty" : "记录数为0",
            "sInfoFiltered" : "(全部记录数为 _MAX_ 条)",
            "sInfoPostFix" : "",
            "sSearch" : "搜索 ",
            "sUrl" : "",
            "oPaginate": {
                "sFirst" : "第一页",
                "sPrevious" : "上一页",
                "sNext" : "下一页",
                "sLast" : "最后一页"
            }},
        "ajax": "/article/article_list"

    } );
</script>