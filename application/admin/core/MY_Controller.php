<?php
class MY_Controller extends CI_Controller
{
    private $_view_data = array();

    public $_uid=0;

    public function __construct()
    {
        parent::__construct();
        $this->_uid   =   $this->base_auth_model->auth_check();
        $this->send_data($this->base_auth_model->menu_init());
        IS_LOG && $this->base_log_model->record();

    }
    //cookie 处理
    public function get_cookie($name,$prefix=true){
        if($prefix)
            $name = COOKIE_PRE.$name;
        return $this->input->cookie($name);
    }
    function set_cookie($name,$value,$expire=COOKIE_TIME,$prefix=1){
        if($prefix)
            $name = COOKIE_PRE.$name;
        $expire = $expire > 0 ? $expire : ($expire < 0 ? -86500 : 0);
        $this->input->set_cookie($name,$value,$expire,COOKIE_DOMAIN,COOKIE_PATH);
    }
    function del_cookie($name,$prefix=true){
        if($prefix){
            $this->set_cookie($name,'',-1,$prefix);
        }
    }
    //数据输入
    public function in_put($key=null){
        $get_post = array_merge($this->input->get(), $this->input->post());
        if($key){
            if (is_array($key)) {
                $init = array();
                if ($get_post) {
                    foreach ($key as $v) {
                        $init[$v] = '';
                    }
                    $ret = array_merge($init, $get_post);
                } else {
                    $ret = array();
                }

            } else {
                $ret = $this->input->get_post($key);
            }
        }
        else{
            $ret=$get_post;
        }
        return $ret;
    }
    //接口输出
    public function out_put($ret = 0, $msg = '', $data = null){
        $result=array(
            'ret'   =>  $ret,
            'msg'    =>  $msg,
            'data'  =>  $data
        );
        $callback = $this->input->get('callback');
        echo !$callback?json_encode($result):'('.json_encode($result).');';
        exit;
    }
    //输出view
    public function display_ori($view){
        $this->load->view($view, $this->_view_data);
    }
    public function display($view){
        $this->load->view('public/header', $this->_view_data);
        $this->load->view('public/nav');
        $this->load->view('public/left');
        $this->load->view($view);
        $this->load->view('public/footer');
    }
    //输出数据到页面
    public function send_data($name,$value=''){
        if(is_array($name)) {
            foreach ($name as $k => $v) {
                $this->_view_data[$k] = $v;
            }
        }
        else{
            $this->_view_data[$name] = $value;
        }
    }

}