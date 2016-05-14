<?php

class XpPoints extends CI_Controller
{
    function evaluate()
    {
        $this->load->model('commit');
        $commitsToBeProcessed = $this->commit->getCommitsForProcessing();

        if (count($commitsToBeProcessed) > 0) {
            $this->load->model('user');
            $this->load->model('userhistorymodel');
            $this->load->model('rankingmodel');
            $this->config->load('commit_points_algo', true);
            $this->load->library('Points', ['algo' => $this->config->item('algo', 'commit_points_algo')]);

            $markAsProcessed = [];
            foreach ($commitsToBeProcessed as $commit) {
                $commitPoints = $this->points->getPoints($commit);
                //if ($commitPoints != 0) {
                $currentUserData = $this->user->getUser($commit['IdUser']);
                if ($this->user->addPoints($commit['IdUser'], $commitPoints)) {
                    $markAsProcessed[] = $commit['IdCommit'];
                    $newRrank = $this->rankingmodel->getRank($currentUserData['XpPoints'] + $commitPoints);
                    $this->user->setRank($commit['IdUser'], $newRrank['IdRank']);

                    $this->userhistorymodel->insert(
                        $commit['IdUser'],
                        $currentUserData['XpPoints'],
                        $currentUserData['XpPoints'] + $commitPoints,
                        $commitPoints,
                        $currentUserData['IdRank'],
                        $newRrank['IdRank'],
                        $commit['IdCommit']
                    );
                }
                // }

            }

            if (count($markAsProcessed) > 0) {
                $this->commit->markAsProcessed($markAsProcessed);
            }
        }

    }
}