<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class jlo_sdm_list extends Parent_Controller {
 
  var $nama_tabel = 'm_jlo_sdm_list';
  var $daftar_field = array('id','id_cat_jlo_sdm','sdm_list','tipe_field_kantor','tipe_field_gt','tipe_field_ht','tipe_field_base','tipe_field_kops','tipe_field_kshuttle');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_jlo_sdm_list'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'jlo_sdm_list/jlo_sdm_list_view';
		$this->load->view('template_view',$data);		
   
	}
 
  	public function fetch_jlo_sdm_list(){  
       $getdata = $this->m_jlo_sdm_list->fetch_jlo_sdm_list();
       echo json_encode($getdata);   
  	}

  	public function fetch_kategori(){  
       $getdata = $this->m_jlo_sdm_list->fetch_kategori();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "select a.*,b.cat_jlo_sdm from m_jlo_sdm_list a
               LEFT JOIN m_jlo_sdm_cat b on b.id = a.id_cat_jlo_sdm where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_jlo_sdm_list->hapus_data($id);
    
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_jlo_sdm_list->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_jlo_sdm_list->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);

   
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}

 
 
  
       


}
