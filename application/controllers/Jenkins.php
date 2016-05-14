<?php

class Jenkins extends CI_Controller
{
    protected $url = 'http://ionutcod.avangate.local:8080';
    protected $apiToken = 'a8784a5d2cd6ac31c8c18de155b3b12c';
    
    protected $project = 'hacktiny';
    protected $jobNr = 2;
    
    protected $projects = [
        'hackaton'  => [
            'url'       => '/job/hackdemo',
            'master'    => 'origin/master',
        ],
        'hacktiny'  => [
            'url'       => '/job/hacktiny',
            'master'    => 'origing/master',
        ]
    ];
    
    public function parseUnprocessedJobs()
    {   
        $lastProcessedJobs = $this->Job->getUnprocessed();
        
        foreach ($lastProcessedJobs as $job) {
            
            $contents = json_decode($job->Contents, true);
            if (empty($contents)) {
                continue;
            }
            
            // project
            $idProject = $job->IdProject;
            
            // user
            $userName = $contents['changeSet']['items'][0]['author']['absoluteUrl'];
            if (false !== ($pos = strripos($userName, '/'))) {
                $userName = substr($userName, $pos + 1);
            }
            $user = $this->User->load($userName);
            if (empty($user->IdUser)) {
                continue;
            }
            
            $artifacts = json_encode($contents['artifacts']);
            
            // commit
            $commitId = $contents['changeSet']['items'][0]['commitId'];
            $commitTS = $contents['changeSet']['items'][0]['timestamp'];
            $commitDate = date('Y-m-d H:i:s', $commitTS / 1000);
            
            // add the commit job
            $jobCommit = new stdClass();
            $jobCommit->IdUser = $user->IdUser;
            $jobCommit->IdProject = $idProject;
            $jobCommit->CreateDate = $commitDate;
            $jobCommit->Artifacts = $artifacts;
            $jobCommit->CommitId = $commitId;
            $this->JobCommit->add($jobCommit);
        }
        
         
    }
    
    public function job()
    {
        $this->project = 'hackaton';
        $this->jobNr = 6;
        
        $url = "/{$this->jobNr}/api/json";
        $response = $this->call($url);
        
        $this->Job->add($response);
        
        echo $response;
        exit;
    }
    
    public function artifacts()
    {
        $job = $this->job(2);
        $jobContents = json_decode($job, true);
        
        dp($jobContents);
        exit;
        
        $userName = $jobContents['actions'][0]['causes'][0]['userId'];
        $commitId = $jobContents['actions'];
        
        
        $changeSet = $jobContents['changeSet'][0];
        $artifacts = $jobContents['artifacts'];
        
        $user = $jobContents[''];
        
        dp($jobContents);
        
        
        //$this->getJobArtifacts('hackaton', );
    }
    
    protected function getJobArtifacts($projectName, $jobContents)
    {
        $url = $this->projects[$projectName] . '/' . $jobNumber . '/api/json';
        $obj = $this->call($url);
        
        dp($obj);
    }
    
    protected function call($url, $params = [], $method = 'POST')
    {
        $options = [
            CURLOPT_URL             => $this->url . $this->projects[$this->project]['url'] . $url,
            //CURLOPT_POSTFIELDS    => $params,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_FOLLOWLOCATION  => false,
        ];
        
        $params['token'] = $this->apiToken;
        
        if ($method == 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $params;
        } else {
            $options[CURLOPT_HTTPGET] = true;
        }
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);
        
        return $output;
    }
}