<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Teser extends Parent_Controller {
 
   
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_teser','me'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
   	
   
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['dataparse'] = $this->me->getMenu(0,"");
		$data['konten'] = 'teser/teser_view';
		$this->load->view('template_view',$data);		
   
	}
 
   

}
