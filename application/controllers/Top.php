<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller
{
    protected $data = array();

    public function index()
    {
        //$this->load->model('topmodel');


        $results = $this->TopModel->getTopUsers( date("Y-m-d H:i:s",  strtotime("-1 week") ) , date("Y-m-d H:i:s", time()) );
        //dp($results);
        

        $this->data['best'] = [];
        foreach ( $results as $result ) {
            $tmp = [];
            $tmp['name'] = $result['Name'];
            $tmp['rank'] = $result['Rank'];
            $tmp['rank_image'] = 'badges/rank_' . $result['IdRank'] . ".png";
            $tmp['image'] = $result['Name'] . '.jpg';
            $tmp['score'] = $result['XpPoints'];
            $tmp['progress'] = $result['points'];
            $tmp['progress_relative'] = ($result['points'] >= 0) ? "up" : "down";

            $this->data['best'][] = $tmp;
        }
//
//
//        $results = $this->TopModel->getTopUsers( date("Y-m-d H:i:s",  strtotime("-1 week") ) , date("Y-m-d H:i:s", time()), 3, 'ASC');
//
//        $this->data['worst'] = [];
//        foreach ( $results as $result ) {
//            $tmp = [];
//            $tmp['name'] = $result['Name'];
//            $tmp['rank'] = $result['Rank'];
//            $tmp['rank_image'] = 'badges/rank_' . $result['IdRank'] . ".png";
//            $tmp['image'] = $result['Name'] . '.jpg';
//            $tmp['score'] = $result['XpPoints'];
//            $tmp['progress'] = $result['points'];
//            $tmp['progress_relative'] = ($result['points'] >= 0) ? "up" : "down";
//
//            $this->data['worst'][] = $tmp;
//        }

        $this->load->view('top/top', $this->data);
    }

    public function test()
    {
        //$this->load->model('topmodel');
        var_dump($this->TopModel->getTopProjects('2016-05-14 12:30:12', '2016-05-14 12:31:15', 3));
    }

}