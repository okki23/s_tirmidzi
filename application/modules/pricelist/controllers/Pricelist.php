<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pricelist extends Parent_Controller {
 
  var $nama_tabel = 'm_pricelist';
  var $daftar_field = array('id','id_pelayanan','id_komp_biaya','id_satuan','id_parent_pricelist','nama_pricelist','tipe');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_pricelist'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'pricelist/pricelist_view';
   
		$this->load->view('template_view',$data);		
   
	}

 
 	
 	public function fetch_nama_komp_biaya(){  
  	   
  	   $id_pelayanan =  $this->input->post('id_pelayanan');
       $sql = "select * from m_komp_biaya where id_jenis_layanan = '".$id_pelayanan."' ";
   
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();

       foreach ($getdata as $key => $value) {
       	 $row_array['nama'] = $value->nama_komp_biaya; 
       	 $row_array['action'] = "<button typpe='button' onclick='GetDataKompBiaya(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
       	 array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);
 
  	}  

  	public function fetch_nama_parent(){  
	   //id dari parsing  	   
  	   $id =  $this->input->post('id');
       $id_pelayanan =  $this->input->post('id_pelayanan');
       $id_komp_biaya =  $this->input->post('id_komp_biaya');
       // if($id == '' || $id == NULL){


       // $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan from m_pricelist a
       //        LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
       //        LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
       //        LEFT JOIN m_satuan d on d.id = a.id_satuan")->result();

       // }else{
       // $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan from m_pricelist a
       //        LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
       //        LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
       //        LEFT JOIN m_satuan d on d.id = a.id_satuan where a.id != '".$id."' ")->result();

       // }

       if($id_pelayanan != '' && $id_komp_biaya != '' && $id != ''){
       
       $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan from m_pricelist a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan where a.id != '".$id."' and a.id_pelayanan = '".$id_pelayanan."' and a.id_komp_biaya = '".$id_komp_biaya."' and id_parent_pricelist = 0 OR id_parent_pricelist IS NULL ")->result();

       }else if($id == ''  && $id_pelayanan != '' && $id_komp_biaya !='' ){
       
       $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan from m_pricelist a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan  where a.id_pelayanan = '".$id_pelayanan."' and a.id_komp_biaya = '".$id_komp_biaya."'  and id_parent_pricelist = 0 OR id_parent_pricelist IS NULL ")->result();

       }


        $return_arr = array();

     
         foreach ($sql as $key => $value) {
           $row_array['jenis_pelayanan'] = $value->nama_pelayanan; 
           $row_array['komp_biaya'] = $value->nama_komp_biaya;
           $row_array['nama_pricelist'] = $value->nama_pricelist; 
           $row_array['nama_satuan'] = $value->nama_satuan; 
           $row_array['action'] = "<button typpe='button' onclick='GetParentsVal(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
           array_push($return_arr,$row_array);
         }
       echo json_encode($return_arr);
 
 
        
 
  	}  

  	public function fetch_nama_komp_biaya_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_komp_biaya')->row();
  		echo json_encode($data);
  	}

  	public function fetch_nama_parents_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_pricelist')->row();
  		echo json_encode($data);
  	}


  	public function fetch_pricelist(){  
       $getdata = $this->m_pricelist->fetch_pricelist();
       echo json_encode($getdata);   
  	}
  	
  	public function fetch_pricelist_parent(){  
       $getdata = $this->m_pricelist->fetch_pricelist_parent();
       echo json_encode($getdata);   
  	}

  	public function fetch_satuan(){  
       $getdata = $this->m_pricelist->fetch_satuan();
       echo json_encode($getdata);   
  	}  

  	public function fetch_pelayanan(){  
       $getdata = $this->m_pricelist->fetch_pelayanan();
       echo json_encode($getdata);   
  	}

  	public function fetch_komp_biaya(){  
       $getdata = $this->m_pricelist->fetch_komp_biaya();
       echo json_encode($getdata);   
  	}
 
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan,e.nama_pricelist as nama_pricelist_parent from m_pricelist a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan 
              left join m_pricelist e on e.id = a.id_parent_pricelist
              where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    	
    	$delete_child = "delete from m_pricelist where id_parent_pricelist = '".$id."' ";
    	$exdelete_child = $this->db->query($delete_child);

    	$delete_data = "delete from m_pricelist where id = '".$id."' ";
    	$exdelete_data = $this->db->query($delete_data);

    	if($delete_child && $delete_data){
    	$result = array("response"=>array('message'=>'success'));	
	    }else{
	    	$result = array("response"=>array('message'=>'failed'));
	    }

  //   $sqlhapus = $this->m_pricelist->hapus_data($id);
		
		// if($sqlhapus){
		// 	$result = array("response"=>array('message'=>'success'));
		// }else{
		// 	$result = array("response"=>array('message'=>'failed'));
		// }
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_pricelist->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_pricelist->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}


	public function dataget(){
    //header('Content-type: text/javascript');
    $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan,e.nama_pricelist as parent from m_pricelist a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan
              LEFT JOIN m_pricelist e on e.id = a.id_parent_pricelist")->result();
    $arr = array();
    foreach ($sql as $key => $value) {
      $sub_arr = array();
      $sub_arr['nama_pelayanan'] = $value->nama_pelayanan; 
      $sub_arr['nama_komp_biaya'] = $value->nama_komp_biaya; 
      $sub_arr['nama_pricelist'] = $value->nama_pricelist; 
      $sub_arr['nama_satuan'] = $value->nama_satuan; 
      $sub_arr['parent'] = $value->parent; 

      $arr[] = $sub_arr;
    }

		//$arr = array('data1'=>1,'data2'=>2,'data3'=>3);
    echo json_encode(array("data"=>$arr));
	}
  
       


}
