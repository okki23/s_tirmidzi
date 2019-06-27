<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class waktu_transaksi extends Parent_Controller {
 
  var $nama_tabel = 'm_waktu_transaksi';
  var $daftar_field = array('id','id_jenis_gardu','waktu_transaksi','periode_start','periode_end');
  var $primary_key = 'id';
  

  //pada module ini data terakhir di add, adalah data periode baru,sedangkan data terakhir nya akan di update pula ditambahkan periode end dengan kondisi di note ke db tanggal sehari mundur dari hari dimana data ditambahkan
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_waktu_transaksi'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'waktu_transaksi/waktu_transaksi_view';
		$this->load->view('template_view',$data);		
   
	}

   
  	public function fetch_waktu_transaksi(){  
       $getdata = $this->m_waktu_transaksi->fetch_waktu_transaksi();
       echo json_encode($getdata);   
  	}  

  	public function fetch_jenis_gardu(){  
       $getdata = $this->m_waktu_transaksi->fetch_jenis_gardu();
       echo json_encode($getdata);   
  	}  
	
   
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$sql = "select a.*,b.jenis_gardu from m_waktu_transaksi a 
                left join m_jenis_gardu b on b.id = a.id_jenis_gardu where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	
   
	public function hapus_data(){
		$id = $this->uri->segment(3);  
      
    	$sqlhapus = $this->m_waktu_transaksi->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	
 
	public function simpan_data(){
    
    
    $data_form = $this->m_waktu_transaksi->array_from_post($this->daftar_field);
 
    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_waktu_transaksi->simpan_waktu_transaksi($data_form,$this->nama_tabel,$this->primary_key,$id);
   
	
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
	 


}
