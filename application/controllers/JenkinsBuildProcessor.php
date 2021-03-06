<?php


class JenkinsBuildProcessor extends CI_Controller
{
    private $projectModel;
    private $jenkinsConnector;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel     = new ProjectModel();
        $this->jenkinsConnector = new JenkinsConnector();
        $this->jobModel         = new Job();
    }

    public function process()
    {
        error_reporting(E_ALL);
        $projects = $this->projectModel->getAll();

        foreach ($projects as $project) {
            $this->processBuildsForProject($project);
        }
    }

    private function processBuildsForProject($project)
    {
        $localLastProcessBuild = $this->projectModel->getLastBuild($project['IdProject']);
        $jenkinsProjectDetails = $this->getJenkinsProjectDetails($project['JenkinsId']);
        $buildsToBeAdded       = [];
        
        if (empty($jenkinsProjectDetails)) {
            return;
        }
        
        foreach ($jenkinsProjectDetails['builds'] as $projectBuilds) {
            if ($projectBuilds['number'] > $localLastProcessBuild) {
                $buildsToBeAdded[] = $projectBuilds['number'];
            } else {
                break;
            }
        }
        if (count($buildsToBeAdded) === 0) {
            return;
        }
        $this->projectModel->updateLastBuild($project['IdProject'], $buildsToBeAdded[0]);
        $this->parseBuilds($buildsToBeAdded, $project);
    }

    private function getJenkinsProjectDetails($JenkinsId)
    {
        return json_decode($this->jenkinsConnector->getProjectDetails($JenkinsId), true);

    }

    private function parseBuilds($buildsToBeAdded, $project)
    {
        foreach ($buildsToBeAdded as $build) {
            $buildDetails        = $this->jenkinsConnector->getBuildDetails($build, $project['JenkinsId']);
            $buildUrl = $this->jenkinsConnector->buildJobUrl($build, $project['JenkinsId']);
            $buildDetailsDecoded = json_decode($buildDetails, true);
            if (empty($buildDetailsDecoded['changeSet']['items'])) {
                continue;
            }

            $this->jobModel->add($buildDetails, $project['IdProject'], $buildUrl);
        }
    }
}