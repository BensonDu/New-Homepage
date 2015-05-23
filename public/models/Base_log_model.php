<?php
class Base_log_model extends Base_db_model
{
    private $table='request_log';
    public function __construct()
    {
        parent::__construct();
    }
    //日志记录，随后加入redis队列，批量写入DB;
    public function record(){
        $ip     =    $this->input->ip_address();
        $agent  =    $this->input->user_agent();
        $url    =    $this->input->server('REQUEST_URI');
        $time   =    time();
       return $this->insert($this->table,array(
            'ip'    => $ip,
            'agent' => $agent,
            'url'   => $url,
            'time'  => $time
        ));
    }
}