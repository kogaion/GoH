<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller
{
    protected $data = array();

    public function index()
    {
        $mock = [
            [
                'name' => "Liviu Gelea",
                'image' => "liviu.jpg",
                'score' => "liviu.jpg",
                'progress' => "liviu.jpg",
            ],
        ];

        $this->data['people'] = $mock;

        $this->load->view('top/top', $this->data);
    }

    public function test()
    {
        $this->load->model('topmodel');
        var_dump($this->topmodel->getTopProjects('2016-05-14 12:30:12', '2016-05-14 12:31:15', 3));
    }

}