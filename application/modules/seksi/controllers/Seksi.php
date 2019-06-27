<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Seksi extends Parent_Controller {
 
  
  var $nama_tabel = 'm_seksi';
  var $daftar_field = array('id','id_departemen','nama_seksi');
  var $primary_key = 'id';
  
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_seksi'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'seksi/seksi_view';
		$this->load->view('template_view',$data);		
   
	}
 
  	public function fetch_seksi(){  
       $getdata = $this->m_seksi->fetch_seksi();
       echo json_encode($getdata);   
  	} 

  	public function fetch_departemen(){  
       $getdata = $this->m_seksi->fetch_departemen();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$sql = "select a.*,b.nama_departemen from m_seksi a
				left join m_departemen b on b.id = a.id_departemen where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_seksi->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_seksi->array_from_post($this->daftar_field);


    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_seksi->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 	 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
