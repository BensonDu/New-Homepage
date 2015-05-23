<?php

class MY_Config extends CI_Config{
    public function __construct(){
        parent::__construct();
        $this->_config_paths[] = APPPATH.'../../public/';
    }
}