<div class="row">
    <form id="add_sdk_xml_form" method="post">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">基础信息</div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>名称</label>
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="sta" value="1" id="article_sta">
                                <input type="text" name="title" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>排序</label>
                                <input type="number" name="rank" class="form-control" value="">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>类型</label>
                                <select class="form-control" name="type_parent" id="type_select_parent" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 hide" id="type_select_child_display">
                            <div class="form-group">
                                <label>子类</label>
                                <select class="form-control" name="type_child" id="type_select_child">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>内容</label>
                                <script name="content" id="editor" type="text/plain"></script>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">提交并发布</button>
                                <button id="btn_draft" type="submit" class="btn btn-default">保存到草稿</button>
                                <a href="/article/index" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" charset="utf-8" src="<?php echo COMMON_STATIC_PATH;?>admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo COMMON_STATIC_PATH;?>admin/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo COMMON_STATIC_PATH;?>admin/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    var editor1 = UE.getEditor('editor',{
        serverUrl:'/interfaces/ueditor',
        initialFrameWidth:"100%",
        initialFrameHeight:"400"
    });
    /*hover 文章状态改变*/
    $('#btn_draft').hover(function(){
        $('#article_sta').val('1');
    },function(){
        $('#article_sta').val('2');
    });
    /*二级selsect*/
    var type_list='<?php echo json_encode($type_list) ?>';
    var parent="<option value='0'>-请选择-</option>",
        data={};
    try{data=JSON.parse(type_list)}catch (e){}

    for(var i in data){
        if(data[i].parent==0){
            parent+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
        }
    }
    $('#type_select_parent').empty().append(parent).change(function(){
        var val=$(this).val(),child='';
        for(var n in data){
            if(data[n].parent==val && data[n].parent!=0){
                child+="<option value='"+data[n].id+"'>"+data[n].name+"</option>";
            }
        }
        if(child!=''){
            $('#type_select_child_display').removeClass('hide');
            $('#type_select_child').empty().append(child)
        }
        else{
            $('#type_select_child_display').addClass('hide');
        }

    });

</script>