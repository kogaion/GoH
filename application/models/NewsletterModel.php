<?php

class NewsletterModel extends CI_Model
{
    public function getAllTimeBoard()
    {
        return
            $this->db
                ->select('ivvll_user.*,ivvll_ranking.Name as Rank')
                ->from('ivvll_user')
                ->join('ivvll_ranking', 'ivvll_ranking.IdRank = ivvll_user.IdRank')
                ->order_by('ivvll_user.XpPoints', 'DESC')
                ->get()
                ->result_array();
    }
}