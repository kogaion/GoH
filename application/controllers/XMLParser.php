<?php

class XMLParser extends CI_Controller
{
    public function index()
    {
        $this->load->view('top/top');
    }
    
    public function load()
    {
        $values = $index = [];
        
        $parser = xml_parser_create();
        xml_parse_into_struct($parser, read_file(XML_PATH . '/test.xml'), $values, $index);
        
        dp($values);
        dp($index);
        
        
    }
}