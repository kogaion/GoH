<?php

class UserHistoryModel extends CI_Model
{
    public function insert(
        $idUser,
        $currentXpPoints,
        $newXpPoints,
        $evalXpPoints,
        $currentRankId,
        $newRankId,
        $commitId
    ) {
        return
            $this->db->insert('ivvll_user_history',
                [
                    'IdUser' => $idUser,
                    'CurrentXpPoints' => $currentXpPoints,
                    'NewXpPoints' => $newXpPoints,
                    'EvalXpPoints' => $evalXpPoints,
                    'CurrentRankId' => $currentRankId,
                    'NewRankId' => $newRankId,
                    'CommitId' => $commitId
                ]);
    }


    public function getUserHistory($userId, $startDate = null, $endDate = null, $order = 'ASC')
    {
        if (!is_null($startDate)) {
            $this->db->where('EvalTime >=', $startDate);
        }
        if (!is_null($startDate)) {
            $this->db->where('EvalTime <', $endDate);
        }

        if (!is_null($order)) {
            $this->db->order_by('EvalTime', 'ASC');
        }

        return $this->db
            ->from('ivvll_user_history')
            ->where('IdUser', $userId)
            ->get()
            ->result_array();
    }
}