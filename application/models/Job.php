<?php

class Job extends CI_Model
{
    protected $table = 'ivvll_job';
    
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
    
    public function add($jobContents, $projectId, $buildUrl)
    {
        $this->db->query("
            insert into {$this->table}
            set
              Contents = {$this->db->escape($jobContents)},
              IdProject = {$projectId},
              JobUrl = '{$buildUrl}'
        ");
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
    
    public function process($job)
    {
        $this->db->query("
            update {$this->table}
            set ProcessDate = NOW()
            where IdJob = {$job->IdJob}
        ");
    }
    
    public function getById($idJob)
    {
        return $this->db->query("select * from {$this->table} where IdJob = {$this->db->escape($idJob)}")->row();
    }
}