<?php

class UserHistoryModel extends CI_Model
{
    public function insert($idUser, $currentXpPoints, $newXpPoints, $evalXpPoints, $currentRankId, $newRankId, $commitId)
    {
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
}