<?php


class Test extends CI_Model 
{
    public function test()
    {
        $query = $this->db->query("
            select *
            from ivvll_project
        ");
        
        foreach ($query->result() as $row)
        {
            echo $row->title;
            echo $row->name;
            echo $row->email;
        }

        echo 'Total Results: ' . $query->num_rows();
        
        dp($query);
    }
}