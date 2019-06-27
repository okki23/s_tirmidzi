<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Gardu extends Parent_Controller {
 
  var $nama_tabel = 'm_gardu';
  var $daftar_field = array('id','id_penawaran','tahap','nama_gt','jml_ent','jml_ext','jml_rev','jml_tot','ent_gto_single','ent_gto_multi','ent_reg','ext_gto_multi','ext_gto_single','ext_rev','kpt','kspt','ktugt','jops');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_gardu'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'gardu/gardu_view';
		 $data['list_penawaran'] = $this->list_penawaran();
		$this->load->view('template_view',$data);		
   
	}

	public function get_tahap_val(){
		$id_pe = $this->input->post('id_pe');
		$sql = "select * from m_penawaran where id = '".$id_pe."' ";
		$xsql = $this->db->query($sql)->row();
	
		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		
		$html = "<select name='id_tahapx' id='id_tahapx' onchange='GantiTahap();' class='form-control'>";
		$html .= "<option value=''>Pilih</option>"; 
		for ($i=1; $i<=$xsql->tahap; $i++) { 
			$html .= "<option value='".$i."'> ".$i." </option>";
		}
		$html .= "</select>";	


		//$callback = array('data_tahap'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota
		echo $html;
		//echo json_encode($callback); // konversi varibael $callback menjadi JSON



	}

 public function list_penawaran(){
    $db = $this->db->get('m_penawaran')->result();
    return $db;
  } 
  public function fetch_gardu(){  
       $getdata = $this->m_gardu->fetch_gardu();
       echo json_encode($getdata);   
  }  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$get = $this->db->where($this->primary_key,$id)->get($this->nama_tabel)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3); 
		$idx = $this->uri->segment(4);  
    
		$sqlhapus = $this->db->query("delete from m_gardu where id_penawaran = '".$id."' and tahap = '".$idx."' ");
     
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}

	public function list_detail_gardu(){
	  $id = $this->input->post('id');
	  $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_penawaran,b.tahap from m_gardu a
				left join m_penawaran b on b.id = a.id_penawaran  where a.id_penawaran = '".$id."' and a.tahap = '".$idx."' ";
   	 //echo $sql;
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

	public function list_detail_gardu_ubah(){
	  $id = $this->input->post('id');
	  $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_penawaran,b.tahap from m_gardu a
				left join m_penawaran b on b.id = a.id_penawaran  where a.id_penawaran = '".$id."' and a.tahap = '".$idx."' ";
    
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

       	 $row_array['no'] = $no.'<input type="hidden" class="form-control" name="id[]" id="id" value="'.$value->id.'">';

       	 $row_array['nama_gt'] = '<input type="text" class="form-control" name="nama_gt_update[]" id="nama_gt_update" value="'.$value->nama_gt.'" >';

       	 $row_array['jml_ent'] = '<input type="text" class="form-control" name="jml_ent_update[]" id="jml_ent_update" readonly="readonly" value="'.$value->jml_ent.'" >';

       	 $row_array['jml_ext'] = '<input type="text" class="form-control" name="jml_ext_update[]" id="jml_ext_update" readonly="readonly" value="'.$value->jml_ext.'" >';

       	 $row_array['jml_rev'] ='<input type="text" class="form-control" name="jml_rev_update[]" id="jml_rev_update" readonly="readonly" value="'.$value->jml_rev.'" >';

       	 $row_array['jml_tot'] = '<input type="text" class="form-control" name="jml_tot_update[]" id="jml_tot_update" readonly="readonly" value="'.$value->jml_tot.'" >';

       	 $row_array['ent_gto_single'] = '<input type="text" class="form-control" name="ent_gto_single_update[]" id="ent_gto_single_update"  value="'.$value->ent_gto_single.'" > ';

       	 $row_array['ent_gto_multi'] = '<input type="text" class="form-control"  name="ent_gto_multi_update[]" id="ent_gto_multi_update"  value="'.$value->ent_gto_multi.'" >';

       	 $row_array['ent_reg'] = '<input type="text" class="form-control" name="ent_reg_update[]" id="ent_reg_update"  value="'.$value->ent_reg.'" >';

       	 $row_array['ext_gto_multi'] = '<input type="text" class="form-control" name="ext_gto_multi_update[]" id="ext_gto_multi_update"  value="'.$value->ext_gto_multi.'" >';

       	 $row_array['ext_gto_single'] = '<input type="text" class="form-control" name="ext_gto_single_update[]" id="ext_gto_single_update"  value="'.$value->ext_gto_single.'" >';

       	 $row_array['ext_rev'] = '<input type="text" class="form-control" name="ext_rev_update[]" id="ext_rev_update"   value="'.$value->ext_rev.'" >';

       	 $row_array['kpt'] = '<input type="text" class="form-control" name="kpt_update[]" id="kpt_update" readonly="readonly" value="'.$value->kpt.'" >';

       	 $row_array['kspt'] = '<input type="text" class="form-control" name="kspt_update[]" id="kspt_update"  value="'.$value->kspt.'" >';

       	 $row_array['ktugt'] = '<input type="text" class="form-control" name="ktugt_update[]" id="ktugt_update" value="'.$value->ktugt.'" >';

       	 $row_array['jops'] ='<input type="text" class="form-control" name="jops_update[]" id="jops_update"  value="'.$value->jops.'" >';
  
       	 array_push($return_arr,$row_array);
       	 $no++;
       }
       echo json_encode($return_arr);
   
	}

	
	public function list_store_gardu(){
		$sql = "select a.id_penawaran,b.nama_penawaran,a.tahap,a.user_insert,a.date_insert from m_gardu a
				left join m_penawaran b on b.id = a.id_penawaran GROUP BY a.id_penawaran,a.tahap";
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

                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">all_out</i> Detail Gardu </a>   &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-warning btn-xs waves-effect" onclick="Ubah_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">create</i> Ubah </a> &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">delete</i> Hapus </a>  ';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   $output = array("data"=>$data);
		   echo json_encode($output);
	}
	 
	public function simpan_data(){
 
   
 	$cnama_gt = count($_POST['nama_gt']); 
 	$id_pe = $_POST['id_pe'];
 	$id_tahapx = $_POST['id_tahapx'];

 	$sqldata = $this->db->query("select * from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->num_rows();
 	if($sqldata > 0){
 		//data sudah ada
 		$res = 2;
 
 
 	}else{
 		//masukkan data jika belum ada

 		if($cnama_gt > 0)  {

 			for($i=0; $i<$cnama_gt; $i++){

 	 			$data = $this->db->query("insert into m_gardu (id_penawaran,tahap,nama_gt,jml_ent,jml_ext,jml_rev,jml_tot,ent_gto_single,ent_gto_multi,ent_reg,ext_gto_multi,ext_gto_single,ext_rev,kpt,kspt,ktugt,jops,date_insert,user_insert) values ('".$id_pe."','".$id_tahapx."','".$_POST['nama_gt'][$i]."','".$_POST['jml_ent'][$i]."','".$_POST['jml_ext'][$i]."','".$_POST['jml_rev'][$i]."','".$_POST['jml_tot'][$i]."','".$_POST['ent_gto_single'][$i]."','".$_POST['ent_gto_multi'][$i]."','".$_POST['ent_reg'][$i]."','".$_POST['ext_gto_multi'][$i]."','".$_POST['ext_gto_single'][$i]."','".$_POST['ext_rev'][$i]."','".$_POST['kpt'][$i]."','".$_POST['kspt'][$i]."','".$_POST['ktugt'][$i]."','".$_POST['jops'][$i]."',now(),'".$this->session->userdata('username')."')");
 				
 			}
 			 
 		 

		 

 		}
 			$res = 1;
 	}


	 echo $res;
 
 
 	 
 	}

  	public function simpan_data_update(){
 

 	$cid = count($_POST['id']); 
  
 		//masukkan data jika belum ada

 		if($cid > 0)  {

 			for($i=0; $i<$cid; $i++){
 				$this->db->query("update m_gardu SET nama_gt = '".$_POST['nama_gt_update'][$i]."',jml_ent = '".$_POST['jml_ent_update'][$i]."', jml_ext = '".$_POST['jml_ext_update'][$i]."', jml_rev = '".$_POST['jml_rev_update'][$i]."', jml_tot = '".$_POST['jml_tot_update'][$i]."', ent_gto_single = '".$_POST['ent_gto_single_update'][$i]."', ent_gto_multi = '".$_POST['ent_gto_multi_update'][$i]."', ent_reg = '".$_POST['ent_reg_update'][$i]."', ext_gto_single = '".$_POST['ext_gto_single_update'][$i]."', ext_gto_multi = '".$_POST['ext_gto_multi_update'][$i]."', ext_rev = '".$_POST['ext_rev_update'][$i]."', kpt = '".$_POST['kpt_update'][$i]."' , kspt = '".$_POST['kspt_update'][$i]."', ktugt = '".$_POST['ktugt_update'][$i]."', jops = '".$_POST['jops_update'][$i]."' where id = '".$_POST['id'][$i]."' "); 

 				echo $this->db->last_query()."<br>";
 			}
 			  

 		} 
 		
	 	echo 1; 
 	 
 	}


}
