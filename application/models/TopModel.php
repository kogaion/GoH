<?php

class TopModel extends CI_Model
{
    public function getTopUsers($startDate, $endDate, $userCount = null, $order = 'DESC')
    {
        if (!is_null($userCount)) {
            $this->db->limit($userCount);
        }

        return
            $this->db
                ->select("
                sum(ivvll_user_history.EvalXpPoints) as points,
                ivvll_user.*,
                ivvll_ranking.Name as Rank,
                ivvll_user.IdRank
            ")
                ->from('ivvll_user_history')
                ->join('ivvll_user', 'ivvll_user_history.IdUser = ivvll_user.IdUser')
                ->join('ivvll_ranking', 'ivvll_ranking.IdRank = ivvll_user.IdRank')
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->group_by('ivvll_user.IdUser')
                ->order_by('points', $order)
                ->get()
                ->result_array();
    }

    public function getTopProjects($startDate, $endDate, $projectCount = null, $order = 'DESC')
    {
        if (!is_null($projectCount)) {
            $this->db->limit($projectCount);
        }

        return
            $this->db
                ->select("
                sum(ivvll_user_history.EvalXpPoints) as points,
                ivvll_project.*,
            ")
                ->from('ivvll_user_history')
                ->join('ivvll_commit', 'ivvll_user_history.CommitId = ivvll_commit.IdCommit')
                ->join('ivvll_project', 'ivvll_project.IdProject = ivvll_commit.IdProject')
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->group_by('ivvll_project.IdProject')
                ->limit($projectCount)
                ->order_by('points', $order)
                ->get()
                ->result_array();
    }

    public function getProjectsGraph($idProject, $startDate, $endDate)
    {
        $projectData =
            $this->db
                ->select("
                sum(ivvll_user_history.EvalXpPoints) as points,
                ivvll_project.*,
                concat(DATE(ivvll_user_history.EvalTime), ' ', HOUR(ivvll_user_history.EvalTime)) AS dtime
            ")
                ->from('ivvll_user_history')
                ->join('ivvll_commit', 'ivvll_user_history.CommitId = ivvll_commit.IdCommit')
                ->join('ivvll_project', 'ivvll_project.IdProject = ivvll_commit.IdProject')
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->where('ivvll_project.IdProject', $idProject)
                ->group_by(['ivvll_project.IdProject', "concat(DATE(ivvll_user_history.EvalTime), ' ', HOUR(ivvll_user_history.EvalTime)) "])
                ->order_by('dtime', 'ASC')
                ->get()
                ->result_array();

        $totalPoints = 0;
        foreach ($projectData as &$projectItem) {
            $totalPoints += $projectItem['points'];
            $projectItem['totalPoints'] = $totalPoints;
        }

        return $projectData;
    }
}