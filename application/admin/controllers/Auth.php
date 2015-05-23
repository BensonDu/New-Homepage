<?php
class Auth extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('base_act_model');
    }

    public function index(){
        $this->login();
    }

    public function login(){

        $tip='';

        $post=$this->input->post();

        if(!empty($post['username']) && !empty($post['password'])){

            $check=$this->base_act_model->verify($post['username'],$post['password']);

            if($check){

                $this->session->set_userdata('uid',$check['id']);

                redirect(site_url('/'));

            }
            else{

                $tip='Username or password error';

            }

        }
        //错误报告
        $this->send_data('tip',$tip);

        $this->display_ori('public/header');
        $this->display_ori('login/index');
    }

    public function logout(){
        $this->session->unset_userdata('uid');
        redirect(site_url('auth/index'));
    }

    public function login_api(){

    }

    public function logout_api(){

    }

    public function one(){

    }

    public function test(){
        $this->load->view('test/index');
    }

}