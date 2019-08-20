<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Karyawan extends Parent_Controller {
  
  var $nama_tabel = 'm_karyawan';
  var $daftar_field = array('id','nip','nama','alamat','telp','email','id_jabatan');
  var $primary_key = 'id'; 
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_karyawan'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
  	public function index(){
  		$data['judul'] = $this->data['judul']; 
  		$data['konten'] = 'karyawan/karyawan_view';
  		$this->load->view('template_view',$data);		
     
  	}
 
 
  	public function fetch_karyawan(){  
       $getdata = $this->m_karyawan->fetch_karyawan();
       echo json_encode($getdata);   
  	}

  	public function fetch_jabatan(){  
       $getdata = $this->m_karyawan->fetch_jabatan();
       echo json_encode($getdata);   
  	}  

    public function fetch_status(){  
       $getdata = $this->m_karyawan->fetch_status();
       echo json_encode($getdata);   
    }  
  

	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = " select a.*,b.nama_jabatan  from m_karyawan a 
    left join m_jabatan b on b.id = a.id_jabatan where a.id = '".$id."' ";

		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_karyawan->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_karyawan->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_karyawan->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
