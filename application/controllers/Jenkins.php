<?php

class Jenkins extends CI_Controller
{
    protected $url = 'http://ionutcod.avangate.local:8080';
    
    protected $projects = [
        'hackdemo'  => '/job/hackdemo',
    ];
    
    public function notifyJob()
    {
        error_log(dp($_REQUEST));
    }
    
    
    public function xml()
    {
        $url = "/job/hackdemo/6/api/json";
        $token = 'a8784a5d2cd6ac31c8c18de155b3b12c';
        
        $params = [
            'token' => $token,
        ];
        
        $json = $this->call($url, $params);
        
        dp(json_decode($json));
    }
    
    protected function call($url, $params = [], $method = 'POST')
    {
        $options = [
            CURLOPT_URL             => $this->url . $url,
            //CURLOPT_POSTFIELDS    => $params,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_FOLLOWLOCATION  => false,
        ];
        
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