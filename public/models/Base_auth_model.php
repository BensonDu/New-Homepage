<?php
class Base_auth_model extends Base_db_model{

    //预留根据用户名设置权限检查接口
    private $table_admin    =   'act_admin';
    private $table_item     =   'nav_item';

    public  $router_class ='';
    public  $router_method='';

    private $menu_list=array();
    private $menu_cur='';

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('menutree');
        $this->router_class=$this->router->class;
        $this->router_method=$this->router->method;
    }

    public function auth_check(){

        $uid=$this->session->userdata('uid');

        //随后 根据权限模块判定
        if(!empty($uid)) return $uid;

        if(!$this->is_ingore()){
            redirect(site_url('/auth'));
        }

    }

    public function menu_init(){

        //获取菜单数据
        $this->menu_list=$this->select($this->table_item,null,'*',null,null,'rank','asc');
        //菜单数据标记active
        $this->is_active($this->router_class,$method=$this->router_method);
        //结构化的菜单数据
        $menu['menu_list']=$this->menutree->get_tree($this->menu_list);
        //当前item名称
        $menu['menu_cur'] =$this->menu_cur;

        return $menu;

    }
    /*
     * 依据请求URL
     * 对该菜单项及父目录打上active标记
     * 并设置当前目录名称
     */
    public function is_active($class,$method,$id=null){
        if(!empty($this->menu_list)){
            foreach($this->menu_list as $k => $v){
                if(!$id){
                    $link=explode('/',$v['link']);
                    if(isset($link[2]) && $link[1]==$class && $link[2]==$method){
                        $this->menu_list[$k]['active']=true;
                        $this->menu_cur=$v['name'];
                        if($v['parent'] != 0){
                            $this->is_active('','',$v['parent']);
                        }
                    }
                }
                else{
                    if($v['id']==$id){
                        $this->menu_list[$k]['active']=true;
                        if($v['parent'] !=0 ){
                            $this->is_active('','',$v['parent']);
                        }
                    }
                }
            }
        }
    }
    /*
     * 依据请求URL，判断属于忽略列表，不进行鉴权
     * 默认包含登陆auth类，否则重定向循环
     * 配置文件appliction/config/auth.php
     */
    public function is_ingore(){

        $this->config->load('auth');
        $auth_ignore    =   $this->config->item('ignore');
        $fit_class      =   array();
        $fit_method     =   array();
        $fit_all        =   array();
        if(!empty($auth_ignore)){
            foreach($auth_ignore as $v){
                $c=count($v);
                if($c===1){
                    $fit_class[]=$v[0];
                }
                if($c===2 && empty($v[0])){
                    $fit_method[]=$v[1];
                }
                if($c===2 && !empty($v[0])){
                    $fit_all[]=$v;
                }
            }
        }
        if(!empty($fit_class) && in_array($this->router_class,$fit_class)){
            return true;
        }
        if(!empty($fit_method) && in_array($this->router_method,$fit_method)){
            return true;
        }
        if(!empty($fit_all)){
            foreach($fit_all as $v){
                if($v[0]==$this->router_class && $v[1]==$this->router_method){
                    return true;
                }
            }
        }
        return false;

    }
}