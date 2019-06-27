<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Asumsi_list extends Parent_Controller {
 
  var $nama_tabel = 'm_asumsi_list';
  var $daftar_field = array('id','id_penawaran','tahap','id_asumsi','vol','safety_factor','keterangan');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_asumsi_list'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'asumsi_list/asumsi_list_view';
		$data['list_penawaran'] = $this->list_penawaran();
		$data['list_kelharsat'] = $this->get_list_kel_harsat();
		$this->load->view('template_view',$data);	 
	}

	public function get_list_kel_harsat(){
		return $this->db->get('m_harga')->result();
	}

	public function call_jumlah_gerbang(){
		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');

		$sql = $this->db->query("select * from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->num_rows();

		echo json_encode($sql);
	}

	public function call_jumlah_lajur_trans(){
		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');

		$sql = $this->db->query("select sum(jml_tot) as result from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."'  ")->row();
		$parse = intval($sql->result);
		echo json_encode($parse);

	}

	public function call_kr_derek_shift(){

		$lhr = $this->input->post('lhr');
		$panjang_jalan = $this->input->post('panjang_jalan');

		if($lhr > 100000){
			if((($panjang_jalan * 0.8)/5) <= 1){
				echo 1;
			}else{
				echo ceil((($panjang_jalan * 0.8)/5));
			}
		}else{
		if((($panjang_jalan * 0.8)/10) <= 1){
				echo 1;
			}else{
				echo ceil((($panjang_jalan * 0.8)/10));
			}
		}
	}

	public function call_pjr_derek_shift(){

		$lhr = $this->input->post('lhr');
		$panjang_jalan = $this->input->post('panjang_jalan');

		if($lhr > 100000){
			if((($panjang_jalan * 0.8)/15) <= 1){
				echo 1;
			}else{
				echo ceil((($panjang_jalan * 0.8)/15));
			}
		}else{
			if((($panjang_jalan * 0.8)/20) <= 1){
				echo 1;
			}else{
				echo ceil((($panjang_jalan * 0.8)/20));
			}
		}
	}

	public function get_additional(){
		$penawaran = $this->input->post('penawaran');
		$tahap  = $this->input->post('tahap');
		//echo $penawaran."".$tahap;
		$query = $this->db->query("select * from m_gardu where id_penawaran = '".$penawaran."' and tahap = '".$tahap."' ")->row();
		//var_dump($query);
		echo "tes";
		 
	}
	public function get_tahap_val(){
		$id_pe = $this->input->post('id_pe');
		$sql = "select * from m_penawaran where id = '".$id_pe."' ";
		$xsql = $this->db->query($sql)->row();
	
		 
		$html = "<select name='id_tahapx' id='id_tahapx' class='form-control'>";
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

  	public function fetch_asumsi_list(){  
       $getdata = $this->m_asumsi_list->fetch_asumsi_list();
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
    
		$sqlhapus = $this->db->query("delete from m_asumsi_list where id_penawaran = '".$id."' and tahap = '".$idx."' "); 
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}

	public function list_detail_asumsi_list(){
	  $id = $this->input->post('id');

      $sql = "select a.*,b.nama_penawaran,b.tahap from m_asumsi_list a
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

	
	public function list_store_asumsi_list(){
		$sql = "select a.*,b.nama_penawaran from m_asumsi_list a
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
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">all_out</i> Detail Asumsi </a>  &nbsp; <a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">create</i> Ubah Data </a>  &nbsp;  <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   $output = array("data"=>$data);
		   echo json_encode($output);
	}


    public function list_detail_asumsi(){
    $id = $this->input->post('id');
    $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a 
left join m_asumsi b on b.id = a.id_asumsi 
left join m_satuan c on c.id = b.id_satuan  where a.id_penawaran = '".$id."' and a.tahap = '".$idx."'  ";
     //echo $sql;
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

         $row_array['no'] = $no;
         $row_array['nama_asumsi'] = $value->nama_asumsi; 
         $row_array['vol'] = $value->vol; 
         $row_array['nama_satuan'] = $value->nama_satuan; 
         $row_array['safety_factor'] = $value->safety_factor;
         $row_array['keterangan'] = $value->keterangan;
          
         array_push($return_arr,$row_array);
         $no++;
       }
       echo json_encode($return_arr);
   
  }

   public function list_detail_asumsi_update(){
    $id = $this->input->post('id');
    $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_asumsi,b.tipe,c.nama_satuan from m_asumsi_list a 
left join m_asumsi b on b.id = a.id_asumsi 
left join m_satuan c on c.id = b.id_satuan  where a.id_penawaran = '".$id."' and a.tahap = '".$idx."'  ";
     //echo $sql;
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;

       foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array['no'] = $no;
                $sub_array['nama_asumsi'] = $row->nama_asumsi.' <input type="hidden" name="id_asumsi[]" value="'.$row->id_asumsi.'" id="id_asumsi_update" class="form-control" value="'.$row->id.'"><input type="hidden" name="id[]" value="'.$row->id.'" id="id" class="form-control" value="'.$row->id.'">';  
                 
                if($row->tipe == 'calculated'){
                  $sub_array['vol'] = '<input type="text" readonly="readonly" style=" background-color:#D8D8D8;" name="vol[]"  value="'.$row->vol.'" id="'.strtolower(str_replace(array(' ','/'),"_",$row->nama_asumsi)).'_update" class="form-control">';  
                }else{
                  $sub_array['vol'] = '<input type="text" name="vol[]"  value="'.$row->vol.'" id="'.strtolower(str_replace(array(' ','/'),"_",$row->nama_asumsi)).'_update" class="form-control">';  
                }
              

                $sub_array['nama_satuan'] = $row->nama_satuan;   
                $sub_array['safety_factor'] = '<input type="text" name="safety_factor[]" id="safety_factor_update"  value="'.$row->safety_factor.'" class="form-control">'; 
                $sub_array['keterangan'] = '<input type="text" name="keterangan[]" id="keterangan_update"  value="'.$row->keterangan.'" class="form-control">'; 
                array_push($return_arr,$sub_array);
         		$no++;
           }  

 
       echo json_encode($return_arr);
   
  }

	 
	public function simpan_data(){
 

 	$cid_asumsi = count($_POST['id_asumsi']); 
 	$id_pe = $_POST['id_pe'];
 	$id_tahapx = $_POST['id_tahapx'];
 	
 	$sqldata = $this->db->query("select * from m_asumsi_list where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->num_rows();
 	// $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_asumsi_list')->num_rows();
 	if($sqldata > 0){
 		//data sudah ada
 		$res = 2;
  
 	}else{
 		//masukkan data jika belum ada

 		if($cid_asumsi > 0)  {

 			for($i=0; $i<$cid_asumsi; $i++){

 	 			$data = $this->db->query("insert into m_asumsi_list (id_penawaran,tahap,id_asumsi,vol,safety_factor,keterangan) 
 	 			values ('".$id_pe."','".$id_tahapx."','".$_POST['id_asumsi'][$i]."','".$_POST['vol'][$i]."','".$_POST['safety_factor'][$i]."','".$_POST['keterangan'][$i]."')");
 				
 			}
 			  

 		}
 			$res = 1;
 	} 
	 	echo $res;
  
 	 
 	}

 	public function simpan_data_update(){
 

 	$cid_asumsi = count($_POST['id_asumsi']); 
 	$id_pe = $_POST['id_pe_ubah'];
 	$id_tahapx = $_POST['id_tahapx_ubah'];
 	
   
 		//masukkan data jika belum ada

 		if($cid_asumsi > 0)  {

 			for($i=0; $i<$cid_asumsi; $i++){
 				$this->db->query("update m_asumsi_list SET vol = '".$_POST['vol'][$i]."',safety_factor = '".$_POST['safety_factor'][$i]."', keterangan = '".$_POST['keterangan'][$i]."' where id = '".$_POST['id'][$i]."' "); 

 				echo $this->db->last_query()."<br>";
 			}
 			  

 		}
 			 
 		
	 	echo 1;
  
 	 
 	}
  


}
