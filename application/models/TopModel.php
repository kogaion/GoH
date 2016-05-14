<?php

class TopModel extends CI_Model
{
    public function getTopUsers($startDate, $endDate, $userCount, $order = 'DESC')
    {
        return
            $this->db
                ->select("
                sum(ivvll_user_history.EvalXpPoints) as points,
                ivvll_user.*,
                ivvll_ranking.Name as Rank,
                ivvll_user.IdRank
            ")
                ->from('ivvll_user_history')
                ->join('ivvll_user', 'ivvll_user_history.IdUser = ivvll_user.IdUser')
                ->join('ivvll_ranking', 'ivvll_ranking.IdRank = ivvll_user.IdRank')
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->group_by('ivvll_user.IdUser')
                ->limit($userCount)
                ->order_by('points', $order)
                ->get()
                ->result_array();
    }

    public function getTopProjects($startDate, $endDate, $projectCount, $order = 'DESC')
    {
        return
            $this->db
                ->select("
                sum(ivvll_user_history.EvalXpPoints) as points,
                ivvll_project.*,
            ")
                ->from('ivvll_user_history')
                ->join('ivvll_commit', 'ivvll_user_history.CommitId = ivvll_commit.IdCommit')
                ->join('ivvll_project', 'ivvll_project.IdProject = ivvll_commit.IdProject')
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->group_by('ivvll_project.IdProject')
                ->limit($projectCount)
                ->order_by('points', $order)
                ->get()
                ->result_array();
    }
}