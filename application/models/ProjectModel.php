<?php

class ProjectModel extends CI_Model
{
    public function insert($name, $description)
    {
        return
            $this->db->insert('ivvll_project', ['Name' => $name, 'Description' => $description]);
    }

    public function getProject($idProject)
    {
        return $this->db->where('IdProject', $idProject)->from('ivvll_project')->get()->row_array();
    }

    public function getAll()
    {
        return
            $this->db->from('ivvll_project')->get()->result_array();
    }

    public function getLastBuild($IdProiect)
    {
        $project = $this->getProject($IdProiect);
        return $project['LastParsedBuild'];
    }

    public function updateLastBuild($IdProject, $lastBuild)
    {
        return
            $this->db
                ->where_in('IdProject', $IdProject)
                ->set('LastParsedBuild', $lastBuild)
                ->update('ivvll_project');
    }
}
