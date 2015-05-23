<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index()
	{
        $this->display('index/index');
	}
    public function test(){
        $this->load->model('base_db_model');
        $data=array(
            'name'=>'dubaoxing1',
            'password'=>'dubaoxing1',
            'createtime'=>time()
        );
        $ret=$this->base_db_model->insert('act_admin',$data);
        if($ret){
            echo 'IT\'s works';
        }
    }
    public function verify(){
        $u='dubaoxing';
        $b='dubaoxing';
        $this->load->model('base_act_model');
        $ret=$this->base_act_model->verify($u,$b);
        if($ret){
            echo 'it is impossible';
        }
        else{
            echo 'nothing else';
        }
    }

}
