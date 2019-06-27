<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Divisi extends Parent_Controller {
 
  
  var $nama_tabel = 'm_divisi';
  var $daftar_field = array('id','id_direktorat','nama_divisi');
  var $primary_key = 'id';
  
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_divisi'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'divisi/divisi_view';
		$this->load->view('template_view',$data);		
   
	}
 
  	public function fetch_divisi(){  
       $getdata = $this->m_divisi->fetch_divisi();
       echo json_encode($getdata);   
  	} 

  	public function fetch_direktorat(){  
       $getdata = $this->m_divisi->fetch_direktorat();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$sql = "select a.*,b.nama_direktorat  from m_divisi a
				left join m_direktorat b on b.id = a.id_direktorat where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_divisi->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_divisi->array_from_post($this->daftar_field);


    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_divisi->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 	
 	echo $this->db->last_query();
 	exit();
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
