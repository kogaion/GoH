<?php

class User extends CI_Model
{
    public function load($name)
    {
        $user = $this->getByName($name);
        if (empty($user)) {
            $id = $this->insert("{$name}@avangate.com", $name);
            $user = $this->getUser($id);
        }
        
        return $user;
    }
    
    
    public function insert($email, $name)
    {
        return
            $this->db->insert('ivvll_user',
                ['Email' => $email, 'Name' => $name]
            );
    }

    public function getUser($idUser)
    {
        return $this->db->where('IdUser', $idUser)->from('ivvll_user')->get()->row_array();
    }
    
    protected function getByName($name)
    {
        return $this->db->query("select * from ivvll_user where name = {$this->db->escape($name)}")->row();
    }

    public function getAll()
    {
        return
            $this->db->from('ivvll_user')->get()->result_array();
    }

    public function addPoints($idUser, $points = 0)
    {
        $this->db
            ->where('IdUser', $idUser)
            ->set('XpPoints', 'XpPoints + ' . $points, false);

        return
            $this->db->update('ivvll_user');
    }

    public function setRank($idUser, $idRank)
    {
        $this->db
            ->where('IdUser', $idUser)
            ->set('IdRank', $idRank);

        return
            $this->db->update('ivvll_user');
    }
    
    
}