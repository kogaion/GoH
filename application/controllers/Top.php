<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller
{
    public function index()
    {
        $this->load->view('top/top');
        
        
    }

    public function test()
    {
        $this->load->model('commit');
        var_dump($this->commit->insert(1,1));
    }
    
}