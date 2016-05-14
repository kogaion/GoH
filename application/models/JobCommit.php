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
    
    protected function getLastProcessDate()
    {
        $q = $this->db->query("
            select MAX(ProcessDate) as LastProcessDate 
            from {$this->table}
        ");
        $row = $q->row();
        
        if (!empty($row)) {
            return $row->LastProcessDate;
        }
        
        return '0000-00-00 00:00:00';
    }
    
    public function getUnprocessed()
    {
        $lastProcessDate = $this->getLastProcessDate();
        
        $q = $this->db->query("
            select *
            from {$this->table}
            where ProcessDate = 0
                #and CreateDate >= {$this->db->escape($lastProcessDate)}
            order by CreateDate
            limit 10
        ");
        
        $result = [];
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $result[] = $row;        
            }
        }
        
        return $result;
    }
    
    public function process($jobCommit)
    {
        return [];
        return $this->db->query("
            update {$this->table}
            set IdCommit = {$this->db->escape($jobCommit->IdCommit)},
                ProcessDate = NOW()
            where CommitId = {$this->db->escape($jobCommit->CommitId)}
        ");
    }
}