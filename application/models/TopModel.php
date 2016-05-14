<?php

class TopModel extends CI_Model
{
    public function getTop($startDate, $endDate, $userCount, $order = 'DESC')
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
}