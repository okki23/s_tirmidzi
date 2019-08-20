<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Produk extends Parent_Controller {
  
	var $nama_tabel = 'm_produk';
	var $daftar_field = array('id','nama_produk','id_satuan','harga_satuan','ukuran','id_jenis');
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
	  
	  
	public function item_list(){  
       
		$no_sox =  $this->input->post('no_sox');
		
		$getdata = $this->db->query("select a.*,b.nama_jenis,c.nama_satuan from m_produk a
		left join m_jenis b on b.id = a.id_jenis
		left join m_satuan c on c.id = a.id_satuan")->result();
	   
		  
		  $dataparse = array();  
			 foreach ($getdata as $key => $value) {  
				  $sub_array['nama_produk'] = $value->nama_produk;
				  $sub_array['nama_jenis'] = $value->nama_jenis;  
				  $sub_array['ukuran'] = $value->ukuran;
				  $sub_array['nama_satuan'] = $value->nama_satuan;
				 
				  $sub_array['action'] =  "<button typpe='button' onclick='GetItemList(".$value->id.");' class = 'btn btn-primary'> <i class='material-icons'>shopping_cart</i> Pilih </button>";  
	 
				 array_push($dataparse,$sub_array); 
			  }  
		 
		  echo json_encode($dataparse);
   
	  }


  	 
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$data = $this->db->query("select a.*,b.nama_jenis,c.nama_satuan from m_produk a
		left join m_jenis b on b.id = a.id_jenis
		left join m_satuan c on c.id = a.id_satuan where a.id = '".$id."' ")->row(); 
 
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
