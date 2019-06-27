<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Generate_harga extends Parent_Controller {
 
  var $nama_tabel = 'm_harga';
  var $daftar_field = array('id','nama_harga','year','id_country');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_generate_harga'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'generate_harga/generate_harga_view';
		$data['list_penawaran'] = $this->list_penawaran();
		$data['list_kelharsat'] = $this->get_list_kel_harsat();
		$this->load->view('template_view',$data);	 
	}

	public function get_list_kel_harsat(){
		return $this->db->get('m_harga')->result();
	}

	public function get_tahap_val(){
		$id_pe = $this->input->post('id_pe');
		$sql = "select * from m_penawaran where id = '".$id_pe."' ";
		$xsql = $this->db->query($sql)->row();
	
		 
		$html = "<select name='id_tahapx' id='id_tahapx' onchange='GantiTahap();' class='form-control'>";
		$html .= "<option value=''>Pilih</option>"; 
			for ($i=1; $i<=$xsql->tahap; $i++) { 
				$html .= "<option value='".$i."'> ".$i." </option>";
			}
		$html .= "</select>";	
 
		echo $html;
	 
	}

 
 	public function list_penawaran(){
    	$db = $this->db->get('m_penawaran')->result();
    	return $db;
  	} 

  	public function fetch_generate_harga(){  
       $getdata = $this->m_generate_harga->fetch_generate_harga();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$get = $this->db->where($this->primary_key,$id)->get($this->nama_tabel)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    	$sqlhapus = $this->db->where('id_penawaran',$id)->delete('m_generate_harga');
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}

	public function list_detail_generate_harga(){
	  $id = $this->input->post('id');

      $sql = "select a.*,b.nama_penawaran,b.tahap from m_generate_harga a
				left join m_penawaran b on b.id = a.id_penawaran  where a.id_penawaran = '".$id."'  ";
   	  
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

       	 $row_array['no'] = $no;
       	 $row_array['nama_gt'] = $value->nama_gt; 
       	 $row_array['jml_ent'] = $value->jml_ent;
       	 $row_array['jml_ext'] = $value->jml_ext;
       	 $row_array['jml_rev'] = $value->jml_rev;
       	 $row_array['jml_tot'] = $value->jml_tot;
       	 $row_array['ent_gto_single'] = $value->ent_gto_single;
       	 $row_array['ent_gto_multi'] = $value->ent_gto_multi;
       	 $row_array['ent_reg'] = $value->ent_reg;
       	 $row_array['ext_gto_multi'] = $value->ext_gto_multi;
       	 $row_array['ext_gto_single'] = $value->ext_gto_single;
       	 $row_array['ext_rev'] = $value->ext_rev;
       	 $row_array['kpt'] = $value->kpt;
       	 $row_array['kspt'] = $value->kspt;
       	 $row_array['ktugt'] = $value->ktugt;
       	 $row_array['jops'] = $value->jops; 

       	 $row_array['action'] = "<button typpe='button' onclick='GetDataSeksi(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
       	 array_push($return_arr,$row_array);
       	 $no++;
       }
       echo json_encode($return_arr);
   
	}

	
	public function list_store_generate_harga(){
		$sql = "select a.*,b.nama_penawaran,b.tahap from m_generate_harga a
				left join m_penawaran b on b.id = a.id_penawaran group by a.id_penawaran";
		$getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_penawaran;  
                $sub_array[] = $row->tahap;
                $sub_array[] = $row->user_insert;
                $sub_array[] = $row->date_insert;

                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_penawaran.');" > <i class="material-icons">create</i> Detail generate_harga </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   $output = array("data"=>$data);
		   echo json_encode($output);
	}
	 
	public function simpan_data(){
 
   
    $nama_harga = $_POST['nama_harga'];
    $id_country = $_POST['id_country'];
    $year = $_POST['year'];
    $id_asal_harga = $_POST['id_asal_harga'];
    $persentase_kenaikan = $_POST['persentase_kenaikan'];

    //store to harga

    $sql_harga = "insert into m_harga (nama_harga,year,id_country) values ('".$nama_harga."','".$year."','".$id_country."')";

    $this->db->query($sql_harga);
    
    //last_id for generate harga
    $last_id = $this->db->insert_id();

    //ambil harga 
    $sql_ah = $this->db->query("select * from m_harsat_val where id_kel_harsat = '".$id_asal_harga."' ");

    foreach ($sql_ah->result() as $key => $value) {
    	//echo ($value->harga + ($value->harga * 5 / 100))."<br>";

     $sql = "insert into m_harsat_val (id_kel_harsat,id_pricelist,harga) values ('".$last_id."','".$value->id_pricelist."','".($value->harga + ($value->harga * 5 / 100))."') ";
    $this->db->query($sql);
    }

  
 	 
 	}
  


}
