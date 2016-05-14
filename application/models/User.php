<?php

class User extends CI_Model
{
    public function insert($email, $name, $firstName, $lastName)
    {
        return
            $this->db->insert('ivvll_user',
                ['Email' => $email, 'Name' => $name, 'FirstName' => $firstName, 'LastName' => $lastName]);
    }

    public function getUser($idUser)
    {
        return $this->db->where('IdUser', $idUser)->from('ivvll_user')->get()->row_array();
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