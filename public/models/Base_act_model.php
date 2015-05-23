<?php
class Base_act_model extends Base_db_model
{
    private $table='act_admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function act_exist($username){

        return $this->is_exist($this->table,array('name'=>$username));

    }

    public function verify($username,$password){

        $info=array();

        $data=$this->select($this->table,array('name' => $username));

        count($info>0) && $info=$data[0];

        if(isset($info['password']) && $info['password']==md5($password)){

            $now=time();

            $this->update($this->table,array('lastlogin'=>$now),array('id'=>$info['id']));

            return $info;

        }
        else{
            return false;
        }


    }


}