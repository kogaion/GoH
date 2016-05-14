<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller
{
    protected $data = array();

    public function index()
    {
        $this->load->model('topmodel');


        $results = $this->topmodel->getTop( date("Y-m-d H:i:s",  strtotime("-1 week") ) , date("Y-m-d H:i:s", time()), 3);

        //var_dump($results);

        $this->data['people'] = [];

        foreach ( $results as $result ) {
            $tmp = [];
            $tmp['name'] = $result['Name'];
            $tmp['rank'] = $result['Rank'];
            $tmp['image'] = $result['Name'] . '.jpg';
            $tmp['score'] = $result['XpPoints'];
            $tmp['progress'] = $result['points'];
            $tmp['progress_relative'] = ($result['points'] >= 0) ? "up" : "down";

            $this->data['people'][] = $tmp;
            $this->data['people'][] = $tmp;
            $this->data['people'][] = $tmp;
        }

        $this->load->view('top/top', $this->data);
    }

    public function test()
    {
        $this->load->model('topmodel');
        var_dump($this->topmodel->getTopProjects('2016-05-14 12:30:12', '2016-05-14 12:31:15', 3));
    }

}