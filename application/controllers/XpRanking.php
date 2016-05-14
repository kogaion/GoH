<?php

class XpRanking extends CI_Controller
{
    public function evaluate()
    {
        $this->load->model('user');
        $this->load->model('rankingmodel');

        $users = $this->user->getAll();
        foreach ($users as $user) {
            $rank = $this->rankingmodel->getRank($user['XpPoints']);
            $this->user->setRank($user['IdUser'], $rank['IdRank']);
        }
    }

}