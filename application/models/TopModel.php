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
        $limit = '';
        if (!is_null($projectCount)) {
            
            $limit = "
                limit {$projectCount}
            ";
        }
        
        return $this->db->query("
            select 
                ifnull(sum(ivvll_user_history.EvalXpPoints), 0) as points,
                ivvll_project.*
            from ivvll_project
            left join ivvll_commit on ivvll_project.IdProject = ivvll_commit.IdProject
            left join ivvll_user_history on ivvll_user_history.CommitId = ivvll_commit.IdCommit 
                and EvalTime >= {$this->db->escape($startDate)}
                and EvalTime < {$this->db->escape($endDate)}
            
            group by ivvll_project.IdProject
            
            order by points {$order}
            
            {$limit}
        ")->result_array();
        
        
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
                ->from('ivvll_project')
                ->join('ivvll_commit', 'ivvll_project.IdProject = ivvll_commit.IdProject')
                ->join('ivvll_user_history',  'ivvll_user_history.CommitId = ivvll_commit.IdCommit')
                
                ->where('EvalTime >=', $startDate)
                ->where('EvalTime <', $endDate)
                ->where('ivvll_project.IdProject', $idProject)
                ->group_by([
                    'ivvll_project.IdProject',
                    "concat(DATE(ivvll_user_history.EvalTime), ' ', HOUR(ivvll_user_history.EvalTime)) "
                ])
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


    public function getProjectsWithPoints()
    {
//        return
//            $this->db
//                ->select("
//                sum(ivvll_user_history.EvalXpPoints) as points,
//                ivvll_project.*,
//            ")
//                ->from('ivvll_user_history')
//                ->join('ivvll_commit', 'ivvll_user_history.CommitId = ivvll_commit.IdCommit')
//                ->join('ivvll_project', 'ivvll_project.IdProject = ivvll_commit.IdProject')
//                ->group_by('ivvll_project.IdProject')
//                ->order_by('points', 'DESC')
//                ->get()
//                ->result_array();
//
        return
            $this->db
                ->select("
                sum(coalesce(ivvll_user_history.EvalXpPoints, 0)) as points,
                ivvll_project.*,
                count(distinct(ivvll_user_history.IdUser)) as contrib
            ")
                ->from('ivvll_project')
                ->join('ivvll_commit', 'ivvll_project.IdProject = ivvll_commit.IdProject', 'left')
                ->join('ivvll_user_history', 'ivvll_user_history.CommitId = ivvll_commit.IdCommit', 'left')
                ->group_by('ivvll_project.IdProject')
                ->order_by('points', 'DESC')
                ->get()
                ->result_array();
    }
}