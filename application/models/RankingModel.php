<?php

class RankingModel extends CI_Model
{
    public function insert($rankName, $minPoints, $maxPoints)
    {
        return
            $this->db->insert('ivvll_ranking',
                ['Name' => $rankName, 'MinPoints' => $minPoints, 'MaxPoints' => $maxPoints]);
    }

    public function getRank($points)
    {
        return
            $this->db
                ->from('ivvll_ranking')
                ->where('MinPoints <=', $points)
                ->where('MaxPoints >', $points)
                //->get_where('ivvll_ranking', array('MinPoints >=' => $points, 'MaxPoints <' => $points)
                ->get()
                ->row_array();
    }
}