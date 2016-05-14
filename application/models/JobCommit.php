<?php

class JobCommit extends CI_Model
{
    protected $table = 'ivvll_job_commit';
    
    public function add($newJob)
    {
        return $this->db->query("
            insert into {$this->table}
            set IdUser = {$this->db->escape($newJob->IdUser)},
                IdProject = {$this->db->escape($newJob->IdProject)},
                CreateDate = {$this->db->escape($newJob->CreateDate)},
                Artifacts = {$this->db->escape($newJob->Artifacts)},
                CommitId = {$this->db->escape($newJob->CommitId)}
            on duplicate key update
                CreateDate = {$this->db->escape($newJob->CreateDate)}
        ");
    }
    
}