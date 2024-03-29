<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Barang extends Parent_Controller {
  
  var $nama_tabel = 'm_barang';
  var $daftar_field = array('id','nama_barang','qty','id_jenis');
  var $primary_key = 'id'; 
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_barang'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
  	public function index(){
  		$data['judul'] = $this->data['judul']; 
  		$data['konten'] = 'barang/barang_view';
  		$this->load->view('template_view',$data);		
     
  	}
 
 
  	public function fetch_barang(){  
       $getdata = $this->m_barang->fetch_barang();
       echo json_encode($getdata);   
  	}

  	public function fetch_jenis(){  
       $getdata = $this->m_barang->fetch_jabatan();
       echo json_encode($getdata);   
  	}  

   

	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "select a.*,b.nama_jenis from m_barang a
		left join m_jenis b on b.id = a.id_jenis where a.id = '".$id."' ";

		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_barang->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 

 

	public function item_list(){  
       
		$no_sox =  $this->input->post('no_sox');
		 
		  $sql = "select a.*,b.nama_jenis from m_barang a
		  left join m_jenis b on b.id = a.id_jenis";
		  $exsql = $this->db->query($sql)->result();
					
		  $dataparse = array();  
			 foreach ($exsql as $key => $value) {  
				  $sub_array['nama_kategori'] = $value->nama_kategori;
				  $sub_array['nama_sub_kategori'] = $value->nama_sub_kategori;  
				  $sub_array['nama_barang'] = $value->nama_barang;
				 
				  $sub_array['action'] =  "<button typpe='button' onclick='GetItemList(".$value->id.");' class = 'btn btn-primary'> <i class='material-icons'>shopping_cart</i> Pilih </button>";  
	 
				 array_push($dataparse,$sub_array); 
			  }  
		 
		  echo json_encode($dataparse);
   
	  }

	public function simpan_data(){
    
    
    $data_form = $this->m_barang->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_barang->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
