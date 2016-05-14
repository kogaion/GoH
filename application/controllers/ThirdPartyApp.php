<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ThirdPartyApp extends CI_Controller
{
    public function index()
    {
        $projectGraphData = $this->TopModel->getProjectsWithPoints();
        $this->load->view('third_party_app/app_tpl', ['projects' => $projectGraphData]);
    }
    
    public function projectQuality()
    {
        $imagesPath = IMAGES_PATH;
        
        $endT = strtotime('tomorrow');
        $startT = strtotime('-6 days', $endT);
        
        $startDT = date('Y-m-d', $startT);
        $endDT = date('Y-m-d', $endT);
        
        
        $projects = $this->TopModel->getTopProjects($startDT, $endDT);
        
        foreach ($projects as $proj) {
          
            $name = $proj['Name'];
            
            $data = [
                'gauge' => $proj['points'],
                'title' => $name,
            ];  
            $html = $this->load->view('third_party_app/fusioncharts', $data, true);
            
            $title = "graph_{$proj['IdProject']}";
            $fileName = IMAGES_PATH . '/' . $title;
            
            $htmlFile = "{$fileName}.html";
            $imageFile = "{$fileName}.jpg";
            
            delete_files($imageFile);
            write_file($htmlFile, $html);
            
            $cmd = WKHTMLTOIMAGE_FILENAME 
                . ' --width 400 ' 
                . escapeshellarg($htmlFile) 
                . "  " 
                . escapeshellarg($imageFile)
                . ' 2>&1';
            exec($cmd, $out, $return);
            
            
            
            delete_files($htmlFile);
        }
        
    }
}