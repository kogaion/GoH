<?php


class JenkinsConnector
{
    public function __construct()
    {
        $this->jenkinsBaseUrl = JENKINS_BASE_URL;
        $this->jenkinsToken   = JENKINS_TOKEN;
    }

    public function getProjectDetails($JenkinsId)
    {
        $url = $this->getProjectBaseUrlApi($JenkinsId);

        return $this->send($url);
    }

    private function send($url)
    {
        $options                     = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
        ];
        $fields                      = ['token' => $this->jenkinsToken];
        $options[CURLOPT_POST]       = true;
        $options[CURLOPT_POSTFIELDS] = $fields;

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return $output;
    }

    private function getProjectBaseUrlApi($JenkinsId)
    {
        return sprintf('%s/job/%s/api/json', $this->jenkinsBaseUrl, $JenkinsId);
    }

    public function getBuildDetails($buildId, $IdProject)
    {
        $jobUrl = $this->buildJobUrl($buildId, $IdProject);

        return $this->send($jobUrl . '/api/json');
    }

    public function buildJobUrl($buildId, $IdProject)
    {
        return sprintf('%s/job/%s/%d', $this->jenkinsBaseUrl, $IdProject, $buildId);
    }
}