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

    (function () {
        var $ = jQuery;
        var DbxSelectInit=(function(){
            function Core(type,data,level,option,callback){
                this.type=type;
                this.data=data;
                this.level=[
                    {defaultText: '', defaultVal: 0}
                ];
                this.option={
                    def_id:'id',
                    def_parent:'parent',
                    def_child:'child',
                    def_active:'active',
                    def_name:'name'
                };
                this.first=true;
                this.callback=callback;
                this.$all=$('select[data-select-class='+this.type+']');
                this.init(data,level,option,callback);
            }
            Core.prototype.init=function(data,lev,opt,call){
                var $this=this,$every=this.$every=[];
                if(typeof lev != 'undefined'){
                    $.extend(true,this.level,lev);
                }
                if(typeof opt == 'object'){
                    $.extend(true,this.option,opt);
                }
                if(typeof opt == 'function'){
                    this.callback=opt;
                }
                if(typeof data == 'string'){
                    try{
                        this.data=JSON.parse(data);
                    }
                    catch (e){

                    }
                }
                this.$all.change(function(){
                   $this.eventBind($(this).val(),$(this).data('select-level'));
                });

                this.$all.each(function () {
                    var offset=$(this).data('select-level');
                    $every[offset-1]=$(this);
                });
                this.firstFill();
                //this.debug();
            };
            Core.prototype.debug=function(){

            };
            /*首次执行（需对active 处理）*/
            Core.prototype.firstFill=function(){
                var len=this.$all.length;
                if(len!=this.level.length){
                    return false;
                }
                for(var i=0;i<len;i++){
                    if(i==0){
                        this.level[i].data=this.dataGetChild(i);
                    }
                    else{
                        var act=this.getActive(this.level[i-1].data);
                        if(!!act){
                            this.level[i].data=this.dataGetChild(act);
                        }
                    }
                }
                this.first=false;
                this.append();
                this.callback(this.$every);
            };
            /*获得子列表菜单*/
            Core.prototype.dataGetChild=function(id){
                var cache=[];
                for(var i in this.data){
                    if(this.data[i][this.option.def_parent]==id){
                        cache[i]= this.data[i];
                        if(!this.first){
                            cache[i][this.option.def_active]=false;
                        }
                    }
                }
                return cache;
            };
            /*获取active选项id*/
            Core.prototype.getActive=function(data){
                for(var i in data){
                    if(true==data[i][this.option.def_active]){
                        return data[i][this.option.def_id];
                    }
                }
                return false;
            };
            /*生成dom*/
            Core.prototype.getHtml=function(val,name,select){
                var sel=true==!!select?'selected':'';
                return "<option value='"+val+"' "+sel+">"+name+"</option>"
            };
            /*根据level 中 data 插入dom*/
            Core.prototype.append=function(){
                var len=this.$every.length,cache=[];
                if(len!=this.level.length){
                    return false;
                }
                for(var i=0;i<len;i++){
                    cache[i]='';
                    if(!!this.level[i].defaultText){
                        cache[i]=this.getHtml(this.level[i].defaultVal,this.level[i].defaultText,false);
                    }
                    var data=this.level[i].data;
                    for(var n in data){
                        cache[i]+=this.getHtml(data[n][this.option.def_id],data[n][this.option.def_name],!!data[n][this.option.def_active]);
                    }
                }
                for(var m in cache){
                    this.$every[m].empty().append(cache[m]);
                }
            };

            Core.prototype.eventBind=function(val,level){
                console.log(val,level);

            };
            Core.prototype.callBack=function(){
                  var
                  for(var i in this.level){
                      if(!!this.level[i].data){

                      }
                  }
            };

            return Core;
        })();

        this.DbxSelect=function(type,data,level,option,callback){
            return new DbxSelectInit(type,data,level,option,callback);
        }
    }).call(this);

   DbxSelect(
       'type',
       '<?php echo json_encode($type_list) ?>',
       [
        {defaultText:'选择分类', defaultVal:0},
        {defaultText:'', defaultVal:0}
       ],
       function(every){
           if(every.length==2){
               $('#type_select_child_display').removeClass('hide');
           }
           else{
               $('#type_select_child_display').addClass('hide');
           }
       }
   );
</script>