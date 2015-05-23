<?php

class MY_Loader extends CI_Loader{
    public function __construct(){
        parent::__construct();
        $this->_ci_model_paths[] = APPPATH.'../../public/';
        $this->_ci_helper_paths[] = APPPATH.'../../public/';
        $this->_ci_library_paths[] = APPPATH.'../../public/';
        $this->_ci_service_paths[] = APPPATH.'../../public/';
        $this->_ci_view_paths[] = APPPATH.'../../public/';
    }
}