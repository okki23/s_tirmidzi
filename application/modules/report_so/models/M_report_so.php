<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_report_so extends Parent_Model { 
   
   
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
 
   
 
}
