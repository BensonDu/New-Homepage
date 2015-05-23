<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interfaces extends MY_Controller {

    public function ueditor(){
        $this->load->library('Ueditor');
        echo $this->ueditor->output_data();
    }

}
