<?php
class Article extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('base_article_model');
    }

    public function index(){
        $this->display('article/index');
    }
    public function add(){
        $post=$this->in_put(array('id','sta','rank','title','content','type_parent','type_child'));
        if($post){
            $data=array(
                'title'      =>  $post['title'],
                'content'    =>  $post['content'],
                'type'       =>  !empty($post['type_child'])?$post['type_child']:$post['type_parent'],
                'sta'        =>  intval($post['sta']),
                'rank'       =>  intval($post['rank']),
                'create_time'=>  time()
            );
            $this->base_article_model->new_article($data);
            redirect('/article/index');
        }
        else{
            $type=$this->base_article_model->type_list();
            $this->send_data('type_list',$type);
            $this->display('article/add');
        }
    }
    public function edit($id=0){
        if(!$id)show_404();

        $post=$this->in_put(array('sta','rank','title','content','type_parent','type_child'));
        if($post){
            $data=array(
                'title'      =>  $post['title'],
                'content'    =>  $post['content'],
                'type'       =>  !empty($post['type_child'])?$post['type_child']:$post['type_parent'],
                'sta'        =>  intval($post['sta']),
                'rank'       =>  intval($post['rank']),
                'last_modefy'=>  time()
            );
            $this->base_article_model->edit_article($data,array('id'=>$id));
            redirect('/article/index');
        }
        else{

            $type=$this->base_article_model->type_list();
            $data=$this->base_article_model->article_detail(array('id'=>$id));

            $this->load->library('menutree');
            $type=$this->menutree->tag_it($type,array('id'=>$data['type']),array('active'=>true));
            //$type=$this->menutree->get_tree($type);

            $this->send_data('article',$data);
            $this->send_data('type_list',$type);
            $this->display('article/edit');
        }

    }
    public function del($id=null){
        if($id){
            if($this->base_article_model->del_article("`id` in (".$id.")")){
                $this->out_put(0);
            }
        }

    }
    public function article_list(){

        //所需的字段数组
        $column=array('id','title','type','sta','create_time','last_modefy');
        //转换为数据库查询的字符串
        $select= implode(",",$column);
        $input=$this->in_put();
        if($input['draw']){
            $order          = $input['order'];
            $search         = $input['search'];
            $order_by       = $column[$order[0]['column']];
            $order          = $order[0]['dir'];
            $search         = $search['value'];
            $start          = $input['start'];
            $length         = $input['length'];

            $data = $this->base_article_model->article_list(null,$select,array($start,$length),array('title'=>$search,'content'=>$search),$order_by,$order);

            $ret_data['data']=$data;
            $ret_data['recordsTotal']=$ret_data['recordsFiltered']=count($data);
            $ret_data['draw'] = $input['draw'];

            $typelist   = $this->base_article_model->type_list();
            foreach($typelist as $k =>$v){
                $typenameid[$v['id']]=$v;
            }

            $datacount  = count($ret_data['data']);
            for($i=0;$i<$datacount;$i++){
                $ret_data['data'][$i]['type']=$typenameid[$ret_data['data'][$i]['type']]['name'];
            }
            for($i=0;$i<$datacount;$i++){
                $ret_data['data'][$i]['handle']=$ret_data['data'][$i]['id'];
            }
            echo json_encode($ret_data);
        }

    }
}