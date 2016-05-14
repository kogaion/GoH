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
        $this->load->model('topmodel');
        var_dump($this->topmodel->getTop('2016-05-14 12:30:12', '2016-05-14 12:31:15', 3));
    }

}