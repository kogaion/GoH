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
    
    public function notifyJob()
    {
        error_log(dp($_REQUEST));
    }
    
    public function parseUnprocessedJobs()
    {   
        $lastProcessedJobs = $this->Job->getUnprocessed();
        //dp($lastProcessedJobs);
        
        foreach ($lastProcessedJobs as $job) {
            $contents = json_decode($job->Contents, true);
            if (empty($contents)) {
                continue;
            }
            
            $user = $contents['changeSet']['items'][0]['author']['fullName'];
            if (false !== ($pos = stripos($user, '/'))) {
                $user = substr($user, $pos + 1);
            }
            
            dp($user);
            
            dp($contents);
        }
        
         
    }
    
    public function job()
    {
        $this->project = 'hacktiny';
        $this->jobNr = 2;
        
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