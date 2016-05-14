<?php

class User
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
}