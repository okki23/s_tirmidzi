<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

 
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_master');
 	}
	public function index()
	{
		$this->load->view('master/master_view');
	}
}
