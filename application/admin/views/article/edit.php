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
                                <input type="hidden" name="sta" value="1" id="article_sta">
                                <input type="text" name="title" class="form-control" value="<?php echo $article['title'] ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>排序</label>
                                <input type="number" name="rank" class="form-control" value="<?php echo $article['rank'] ?>">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>类型</label>
                                <select class="form-control" name="type_parent" data-select-class="type" data-select-level="1" id="type_select_parent" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 hide" id="type_select_child_display">
                            <div class="form-group">
                                <label>子类</label>
                                <select class="form-control" name="type_child" data-select-class="type" data-select-level="2" id="type_select_child" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>内容</label>
                                <script name="content" id="editor" type="text/plain"><?php echo $article['content'] ?></script>
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
    /*hover 保存到草稿按钮 文章状态改变*/
    $('#btn_draft').hover(function(){
        $('#article_sta').val('2');
    },function(){
        $('#article_sta').val('1');
    });

    $.extend({
        DbxSelect:function (c,data,opt) {
            var $all = $('select[data-select-class='+c+']'),
                $s={},
                l=(function(){
                    var i;
                    for(i in opt.level){}
                    return i;
                })(),
                getHtml=function(num) {
                    var c='';
                    for(var i in data){
                        if(data[i].parent==num){
                            var act=typeof data[i].active!='undefined'?' selected':'';
                            if(!!$s[i] && !!opt.level[i].defaultText){
                                c+="<option value='"+opt.level[i].defaultVal+"'>"+opt.level[i].defaultText+"</option>";
                            }
                            c+="<option value='"+data[i].id+"'"+act+">"+data[i].name+"</option>";
                        }
                    }
                    return c;
                },
                parFilter=function(num){
                    var a=[],s=0;
                    for(var i in data){
                       if(data[i].parent==num){
                           a.push(i);
                       }
                    }
                    return a;
                },
                appendto=function(num,level){
                    $s[num+1].append(gethtml(num));
                    for(var i in data)
                },
                init=function(){
                    var num= 0,
                        level= 1,
                        con=getHtml(num);

                }
                ;
            $all.each(function(){
               var level=$(this).data('select-level');
                if(level && level<=l){
                    $s[level]=$(this);
                }
            });
            appendto(0);

        }
    });

    $.DbxSelect('type',JSON.parse('<?php echo json_encode($type_list) ?>'),{
        level:{
            1:{
                defaultText:'选择分类',
                defaultVal:0
            },
            2:{
                defaultText:'',
                defaultVal:0
            }
        }
    });
    /*二级selsect*//*
    var type_list='<?php echo json_encode($type_list)?>';
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

    });*/

</script>