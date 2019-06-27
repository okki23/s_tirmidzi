<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class komp_biaya extends Parent_Controller {
 
  var $nama_tabel = 'm_komp_biaya';
  var $daftar_field = array('id','id_jenis_layanan','nama_komp_biaya');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_komp_biaya'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'komp_biaya/komp_biaya_view';
		$this->load->view('template_view',$data);		
   
	}
 
  public function fetch_komp_biaya(){  
       $getdata = $this->m_komp_biaya->fetch_komp_biaya();
       echo json_encode($getdata);   
  }  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$sql = "select a.*,b.nama_pelayanan from m_komp_biaya a left join m_jenis_pelayanan b on b.id = a.id_jenis_layanan where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		//$get = $this->db->where($this->primary_key,$id)->get($this->nama_tabel)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_komp_biaya->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_komp_biaya->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_komp_biaya->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
