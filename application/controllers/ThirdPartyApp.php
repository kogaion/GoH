<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ThirdPartyApp extends CI_Controller
{
    public function index()
    {
        $this->load->view('third_party_app/app_tpl');
    }
}