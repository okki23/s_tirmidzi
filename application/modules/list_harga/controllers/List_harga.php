<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class list_harga extends Parent_Controller {
 
  var $nama_tabel = 'm_list_harga';
  var $daftar_field = array('id','id_penawaran','nama_gt','jml_ent','jml_ext','jml_rev','jml_tot','ent_gto_single','ent_gto_multi','ent_reg','ext_gto_multi','ext_gto_single','ext_rev','kpt','kspt','ktugt','jops');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_list_harga'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'list_harga/list_harga_view';
		$data['list_penawaran'] = $this->list_penawaran();
		$data['list_kelharsat'] = $this->get_list_kel_harsat();
		$this->load->view('template_view',$data);	 
	}

	public function get_list_kel_harsat(){
		return $this->db->get('m_harga')->result();
	}


	public function list_detail_harga(){
	  $id = $this->input->post('id');

      $sql = "select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan,e.harga,e.id_kel_harsat,f.nama_harga from m_pricelist a
      LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
      LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
      LEFT JOIN m_satuan d on d.id = a.id_satuan
      LEFT JOIN m_harsat_val e on e.id_pricelist = a.id  
      LEFT JOIN m_harga f on f.id = e.id_kel_harsat where e.id_kel_harsat = '".$id."'  ";
   	 //echo $sql;
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

       	 $row_array['no'] = $no;
       	 $row_array['nama_pricelist'] = $value->nama_pricelist; 
       	 $row_array['harga'] = "Rp. ".number_format($value->harga,0);
       	 $row_array['nama_pelayanan'] = $value->nama_pelayanan;
       	 $row_array['nama_komp_biaya'] = $value->nama_komp_biaya;
       	  
       	 array_push($return_arr,$row_array);
       	 $no++;
       }
       echo json_encode($return_arr);
   
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

  	public function fetch_list_harga(){  
       $getdata = $this->m_list_harga->fetch_list_harga();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$get = $this->db->where($this->primary_key,$id)->get($this->nama_tabel)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    	$sqlhapus = $this->db->where('id_kel_harsat',$id)->delete('m_harsat_val');
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}

	public function list_detail_list_harga(){
	  $id = $this->input->post('id');

      $sql = "select a.*,b.nama_penawaran,b.tahap from m_list_harga a
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

	
	public function list_store_list_harga(){
		$sql = "select a.*,b.nama_penawaran,b.tahap from m_list_harga a
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

                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_penawaran.');" > <i class="material-icons">create</i> Detail list_harga </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   $output = array("data"=>$data);
		   echo json_encode($output);
	}
	 
	public function simpan_data(){
 
   
 	$cnama_gt = count($_POST['nama_gt']); 
 	$id_pe = $_POST['id_pe'];
 	 
 	$sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_list_harga')->num_rows();
 	if($sqldata > 0){
 		//data sudah ada
 		$res = 2;
  
 	}else{
 		//masukkan data jika belum ada

 		if($cnama_gt > 0)  {

 			for($i=0; $i<$cnama_gt; $i++){

 	 			$data = $this->db->query("insert into m_list_harga (id_penawaran,nama_gt,jml_ent,jml_ext,jml_rev,jml_tot,ent_gto_single,ent_gto_multi,ent_reg,ext_gto_multi,ext_gto_single,ext_rev,kpt,kspt,ktugt,jops,date_insert,user_insert) values ('".$id_pe."','".$_POST['nama_gt'][$i]."','".$_POST['jml_ent'][$i]."','".$_POST['jml_ext'][$i]."','".$_POST['jml_rev'][$i]."','".$_POST['jml_tot'][$i]."','".$_POST['ent_gto_single'][$i]."','".$_POST['ent_gto_multi'][$i]."','".$_POST['ent_reg'][$i]."','".$_POST['ext_gto_multi'][$i]."','".$_POST['ext_gto_single'][$i]."','".$_POST['ext_rev'][$i]."','".$_POST['kpt'][$i]."','".$_POST['kspt'][$i]."','".$_POST['ktugt'][$i]."','".$_POST['jops'][$i]."',now(),'".$this->session->userdata('username')."')");
 				
 			}
 			 
 		 

		 

 		}
 			$res = 1;
 	} 
	 	echo $res;
  
 	 
 	}
  


}
