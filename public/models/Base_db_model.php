<?php
class Base_db_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db=$this->load->database('home', true);
    }
    public function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->affected_rows();
    }
    public function update($table,$data,$where=''){
        $this->db->where($where);
        $this->db->update($table,$data);
        return $this->db->affected_rows();
    }
    public function delete($table,$where){
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }
    public function select($from,$where=null,$select='*',$limit=null,$search=null,$order_by=null,$order='desc'){
        $this->db->select($select)->from($from);
        if($where){
            $this->db->where($where);
        }
        if($limit){
            if(isset($limit[1])){
                $this->db->limit($limit[0],$limit[1]);
            }
            else{
                $this->db->limit($limit[0]);
            }
        }
        if($search){
            if(count($search)>0){
                $s=true;
                foreach($search as $k => $v){
                    if($s){
                        $this->db->like(array($k=>$v));
                        $s=false;
                    }
                    else{
                        $this->db->or_like(array($k=>$v));
                    }

                }
            }
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        return $this->db->get()->result_array();
    }
    public function is_exist($table,$where){
        $ret=$this->db->from($table)->where($where)->affected_rows();
        return $ret>0?true:false;
    }

}