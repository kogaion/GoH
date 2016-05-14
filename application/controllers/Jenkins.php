<?php

class Jenkins extends CI_Controller
{
    protected $url = 'http://ionutcod.avangate.local:8080';
    protected $apiToken = 'a8784a5d2cd6ac31c8c18de155b3b12c';
    
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
        $lastJobs = $this->Job->getUnprocessed();
        
        foreach ($lastJobs as $job) {
            
            $contents = json_decode($job->Contents, true);
            if (empty($contents)) {
                continue;
            }
            
            if (empty($contents['changeSet']['items'])) {
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
            $jobCommit->IdJob = $job->IdJob;
            
            //dp($jobCommit);
            
            $this->JobCommit->add($jobCommit);
            $this->Job->process($job);
            
            dp("processed {$job->IdJob}");
        }
    }
    
    public function parseUnprocessedCommits()
    {
        $lastCommits = $this->JobCommit->getUnprocessed();
        
        foreach ($lastCommits as $jobCommit) {
            
            $artifacts = json_decode($jobCommit->Artifacts);
            
            $buildScore = BUILD_FAILED; // build failed
            $crapScore = 0;
            $unitScore = 0;
            
            if (!empty($artifacts)) {
                $buildScore = BUILD_SUCCESFUL; // build failed
                
                $score = $this->parseArtifacts($jobCommit);
                $crapScore = $score['crap'];
                $unitScore = $score['unit'];
            }
            
            $commit = new stdClass();
            $commit->IdUser = $jobCommit->IdUser;
            $commit->IdProject = $jobCommit->IdProject;
            $commit->Build = $buildScore;
            $commit->Crap = $crapScore;
            $commit->Unit = $unitScore;
            
            $idCommit = $this->Commit->add($commit);
            
            $jobCommit->IdCommit = 0;$idCommit;
            $this->JobCommit->process($jobCommit);
            
            dp("processed {$jobCommit->CommitId}");
        }
    }
    
    protected function parseArtifacts($jobCommit)
    {
        $result = [
            'crap' => 0,
            'unit'  => 0,
        ];
        
        $artifacts = $jobCommit->Artifacts;
        
        if (empty($artifacts)) {
            return $result;
        }
        
        $idJob = $jobCommit->IdJob;
        $job = $this->Job->getById($idJob);
        
        if (empty($job->JobUrl)) {
            return $result;
        }
        
        $artifacts = json_decode($artifacts);
        foreach ($artifacts as $artifactDetails) {
            
            if (!in_array($artifactDetails->fileName, ['build-coverege.xml', 'crap.xml'])) {
                return $result;
            }
            
            $relativePath = $artifactDetails->relativePath;
            $url = $this->getArtifactUrl($relativePath, $job);
            
            $contents = $this->call($url, [], 'GET');
            if (empty($contents)) {
                continue;
            }
            
            if ($artifactDetails->fileName == 'build-coverege.xml') {
                $result['unit'] = $this->parseCodeCoverage($contents);
            }
            
            if ($artifactDetails->fileName == 'crap.xml') {
                $result['crap'] = $this->parseCrap($contents);
            }
        }
        
        return $result;
    }
    
    protected function parseCodeCoverage($contents)
    {
        $xml = simplexml_load_string($contents);
        $attrs = $xml->project->metrics->attributes();
        
        $keys = [
            'methods', 'coveredmethods', 
            'conditionals', 'coveredconditionals', 
            'statements', 'coveredstatements', 
            'elements', 'coveredelements'
        ];
        $coverage = array_fill_keys($keys, 0);
        
        foreach ($attrs as $name => $val) {
            if (in_array($name, $keys)) {
                $coverage[$name] = (string) $val; 
            }
        }
        
        return round(100 * (0
            + 0.25 * ($coverage['coveredmethods'] / (empty($coverage['methods']) ? 1 : $coverage['methods']))
            + 0.25 * ($coverage['coveredconditionals'] / (empty($coverage['conditionals']) ? 1 : $coverage['conditionals']))
            + 0.25 * ($coverage['coveredstatements'] / (empty($coverage['statements']) ? 1 : $coverage['statements']))
            + 0.25 * ($coverage['coveredelements'] / (empty($coverage['elements']) ? 1 : $coverage['elements']))
        ));
    }
    
    protected function parseCrap($contents)
    {
        $xml = simplexml_load_string($contents);
        return (float) $xml->stats->crapMethodPercent * 100;
    }
    
    protected function getArtifactUrl($relativePath, $job)
    {
        return "{$job->JobUrl}/artifact/{$relativePath}";
    }
    
    protected function call($url, $params = [], $method = 'POST')
    {
        $options = [
            CURLOPT_URL             => $url,
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