<?php

class Commit extends CI_Model
{
    protected $table = 'ivvll_commit';
    
    public function add($commit)
    {
        return $this->db->insert(
            $this->table,
            $commit
        );
    }
    
    public function insert($idUser, $idProject, $createDate)
    {
        return
            $this->db->insert('ivvll_commit',
                ['IdUser' => $idUser, 'IdProject' => $idProject, 'CreateDate' => $createDate]);
    }

    public function getCommit($idCommit)
    {
        return $this->db->where('IdCommit', $idCommit)->from('ivvll_commit')->get()->row_array();
    }

    public function getUserCommits($idUser, $dateTime = null)
    {
        if (!is_null($dateTime)) {
            $this->db->where('CreateDate > ', $dateTime);
        }

        return $this->db->where('IdUser', $idUser)->from('ivvll_commit')->get()->result_array();
    }

    public function getAll($dateTime = null)
    {
        if (!is_null($dateTime)) {
            $this->db->where('CreateDate > ', $dateTime);
        }

        return
            $this->db->from('ivvll_commit')->get()->result_array();
    }

    public function getCommitsForProcessing()
    {
        $this->db->where('Processed', 0);

        return
            $this->db->from('ivvll_commit')->get()->result_array();
    }

    public function markAsProcessed(array $processedCommitsId)
    {
        return
            $this->db
                ->where_in('IdCommit', $processedCommitsId)
                ->set('Processed', 1)
                ->update('ivvll_commit');
    }
}