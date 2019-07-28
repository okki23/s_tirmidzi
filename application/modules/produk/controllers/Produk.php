<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Produk extends Parent_Controller {
  
  var $nama_tabel = 'm_produk';
  var $daftar_field = array('id','nama_produk','ukuran','satuan','harga');
  var $primary_key = 'id'; 
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_produk'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
  	public function index(){
  		$data['judul'] = $this->data['judul']; 
  		$data['konten'] = 'produk/produk_view';
  		$this->load->view('template_view',$data);		
     
  	}
 
 
  	public function fetch_produk(){  
       $getdata = $this->m_produk->fetch_produk();
       echo json_encode($getdata);   
  	}

  	 
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$data = $this->db->where('id',$id)->get($this->nama_tabel)->row();
 
		echo json_encode($data,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_produk->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_produk->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_produk->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
