<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Customer extends Parent_Controller {
  
  var $nama_tabel = 'm_customer';
  var $daftar_field = array('id','kode_pelanggan','nama','alamat','telp','email');
  var $primary_key = 'id'; 
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_customer'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
  	public function index(){
  		$data['judul'] = $this->data['judul']; 
  		$data['konten'] = 'customer/customer_view';
  		$this->load->view('template_view',$data);		
     
  	}
 
 
  	public function fetch_customer(){  
       $getdata = $this->m_customer->fetch_customer();
       echo json_encode($getdata);   
  	}

  	 
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$data = $this->db->where('id',$id)->get($this->nama_tabel)->row();
 
		echo json_encode($data,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_customer->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_customer->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_customer->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
