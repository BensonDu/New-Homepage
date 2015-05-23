<?php
class Base_article_model extends Base_db_model
{
    private $table = 'article';
    private $type  = 'article_type';

    public function __construct(){
        parent::__construct();
    }
    public function type_list(){
        $list=$this->select($this->type,null,'*',null,null,'rank','asc');
        foreach($list as $k => $v){
            $ret[$v['id']]=$v;
        }
        return isset($ret)?$ret:array();
    }
    public function new_article($data){
        return $this->insert($this->table,$data);
    }
    public function edit_article($data,$where){
        return $this->update($this->table,$data,$where);
    }
    public function article_list($where,$select,$limit,$search,$order_by,$order){
        return $this->select($this->table,$where,$select,$limit,$search,$order_by,$order);
    }
    public function article_detail($where){
        $ret= $this->select($this->table,$where);
        return isset($ret[0])?$ret[0]:array();
    }



}