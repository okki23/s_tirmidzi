<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Jlo_sdm_val extends Parent_Controller {
 
  var $nama_tabel = 'm_jlo_sdm_val';
  var $daftar_field = array('id','id_penawaran','tahap','id_jlo_sdm_list','kantor','gt','ht','base','k_ops','k_shuttle');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_jlo_sdm_val'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'jlo_sdm_val/jlo_sdm_val_view';
		 $data['list_penawaran'] = $this->list_penawaran();
		$this->load->view('template_view',$data);		
   
	}

	public function list_penawaran(){
    $db = $this->db->get('m_penawaran')->result();
    return $db;
    } 



  	public function list_store_sdm_val(){
		$sql = "select a.*,b.nama_penawaran from m_jlo_sdm_val a
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
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">all_out</i> Detail SDM Val </a>  &nbsp;  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-warning btn-xs waves-effect" onclick="Ubah_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">create</i> Ubah </a> &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   $output = array("data"=>$data);
		   echo json_encode($output);
	}

	public function list_detail_sdm_val(){
	  $id = $this->input->post('id');
	  $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_penawaran,b.tahap,c.sdm_list,c.tipe_field_kantor,
      	c.tipe_field_gt,c.tipe_field_ht,c.tipe_field_base,c.tipe_field_kops,
     	c.tipe_field_kshuttle from m_jlo_sdm_val a 
		left join m_penawaran b on b.id = a.id_penawaran 
		left join m_jlo_sdm_list c on c.id = a.id_jlo_sdm_list 
		where a.id_penawaran = '".$id."' and a.tahap = '".$idx."' ";
   	  
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
    
       foreach ($getdata as $key => $value) {

  
       	 $row_array['sdm_list'] = $value->sdm_list; 
       	 $row_array['kantor'] = $value->kantor;
       	 $row_array['gt'] = $value->gt;
       	 $row_array['total'] = intval($value->kantor) + intval($value->gt);
       	 $row_array['ht'] = $value->ht;
       	 $row_array['base'] = $value->base;
       	 $row_array['k_ops'] = $value->k_ops;
       	 $row_array['k_shuttle'] = $value->k_shuttle;
       	   
       	 array_push($return_arr,$row_array);
       	 
       }
       echo json_encode($return_arr);
   
	}

	public function call_kepala_shift_pengumpulan_tol_gt(){
		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select sum(kspt) as vol from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->vol;
	}


	public function list_detail_sdm_val_ubah(){
	  $id = $this->input->post('id');
	  $idx = $this->input->post('idx');

       $sql = "select a.*,b.nama_penawaran,b.tahap,c.sdm_list,c.tipe_field_kantor,
       	c.tipe_field_gt,c.tipe_field_ht,c.tipe_field_base,c.tipe_field_kops,
       	c.tipe_field_kshuttle from m_jlo_sdm_val a 
		left join m_penawaran b on b.id = a.id_penawaran 
		left join m_jlo_sdm_list c on c.id = a.id_jlo_sdm_list 
		where a.id_penawaran = '".$id."' and a.tahap = '".$idx."' ";
   	  
   	  
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
    
        foreach($getdata as $row)  
           {  
                $sub_array = array();  
              
                $sub_array['sdm_list'] = $row->sdm_list.'<input type="hidden" name="id[]" value="'.$row->id.'" >';  
                
                if($row->tipe_field_kantor == 'calculated'){
                    $sub_array['kantor'] = '<input type="text" readonly="readonly" name="kantor[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_kantor_update" class="form-control" style="width:80%;  background-color:#D8D8D8;" value = "'.$row->kantor.'">  ';  
                }else{
                  $sub_array['kantor'] = '<input type="text" name="kantor[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_kantor_update" class="form-control" style="width:80%;"  value = "'.$row->kantor.'"> ';
                }
                
                if($row->tipe_field_gt == 'calculated'){
                  $sub_array['gt'] = '<input type="text" readonly="readonly"  name="gt[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_gt_update" class="form-control" style="width:100%; background-color:#D8D8D8;" value = "'.$row->gt.'">';    
                }else{
                  $sub_array['gt'] = '<input type="text" name="gt[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_gt_update" class="form-control" style="width:100%;"  value = "'.$row->gt.'">';    
                }

                $sub_array['total'] = '<input type="text" readonly="readonly" name="total[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_total_update" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "'.$row->total.'">';   

                if($row->tipe_field_ht == 'calculated'){ 
                  $sub_array['ht'] = '<input type="text" readonly="readonly" name="ht[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_ht_update" class="form-control" style="width:100%; background-color:#D8D8D8;"  value = "'.$row->ht.'">';  
                }else{
                  $sub_array['ht'] = '<input type="text" name="ht[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_ht_update" class="form-control" style="width:100%;"  value = "'.$row->ht.'">';  
                }

                if($row->tipe_field_base == 'calculated'){
                  $sub_array['base'] = '<input type="text" readonly="readonly" name="base[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_base_update" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "'.$row->base.'">';    
                }else{
                  $sub_array['base'] = '<input type="text" name="base[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_base_update" class="form-control" style="width:80%;"  value = "'.$row->base.'">';   
                }

                if($row->tipe_field_kops == 'calculated'){
                  $sub_array['k_ops'] = '<input type="text" readonly="readonly" name="k_ops[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_ops_update" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "'.$row->k_ops.'">';   
                }else{
                  $sub_array['k_ops'] = '<input type="text" name="k_ops[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_ops_update" class="form-control" style="width:80%;" value = "'.$row->k_ops.'">';   
                }              

                if($row->tipe_field_kshuttle == 'calculated'){
                  $sub_array['k_shuttle'] = '<input type="text" readonly="readonly" name="k_shuttle[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_shuttle_update" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "'.$row->k_ops.'">';  
                }else{
                  $sub_array['k_shuttle'] = '<input type="text" name="k_shuttle[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_shuttle_update" class="form-control" style="width:80%;" value = "'.$row->k_shuttle.'">'; 
                }               
                 
               
                array_push($return_arr,$sub_array);
      			
                //$data[] = $sub_array;  
            
           }  
          echo json_encode($return_arr);
		  
   
	}

	public function call_asisten_manager_transaksi_gt(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');

		$sql = $this->db->query("select * from m_asumsi_list where id_asumsi = 11 and id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->vol;
		
	}

	public function call_kepala_shift_patroli_kantor(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');

		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol,(b.vol) * 5 as val from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 2 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->val;
		
	}

	public function call_petugas_patroli_kantor(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');

		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol,(b.vol) * 10 as val from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 3 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->val;
		
	}

	public function call_pengumpul_tol_gt(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select *,sum(kpt) as val from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->val;
		
	}

	public function call_tu_administrasi_gerbang_tol_gt(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select *,sum(ktugt) as val from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->val;
		
	}

	public function call_asisten_manager_transaksi_ht(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select *,sum(ktugt) as val from m_gardu where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->row();
  		
	  	echo $sql->val;
		
	}

	public function call_kepala_shift_pengumpulan_tol_ht(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 12 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol;
		
	}

	public function call_kamtib_ht(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 9 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol;
		
	}

	public function call_derek_base(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 6 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol+1;
		
	}

	public function call_derek_k_ops(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 6 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol;
		
	} 
 	public function call_rescue(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 4 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol;
		
	}

	public function call_ambulance(){

		$id_pe = $this->input->post('id_pe');
		$id_tahapx = $this->input->post('id_tahapx');
 
		$sql = $this->db->query("select a.id,a.nama_asumsi,a.id_satuan,b.id_penawaran,b.tahap,c.nama_satuan,b.vol from m_asumsi a
			LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id
			LEFT JOIN m_satuan c on c.id = a.id_satuan  where a.id = 5 and b.id_penawaran = '".$id_pe."' and 
			b.tahap = '".$id_tahapx."'  ")->row();
  		
	  	echo $sql->vol;
		
	}
 
 
 
 
   public function get_tahap_val(){
		$id_pe = $this->input->post('id_pe');
		$sql = "select * from m_penawaran where id = '".$id_pe."' ";
		$xsql = $this->db->query($sql)->row();
	
		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		
		$html = "<select name='id_tahapx' id='id_tahapx' class='form-control'>";
		$html .= "<option value=''>Pilih</option>"; 
		for ($i=1; $i<=$xsql->tahap; $i++) { 
			$html .= "<option value='".$i."'> ".$i." </option>";
		}
		$html .= "</select>";	

 
		echo $html;
 


	}
 
  	public function fetch_jlo_sdm_val(){  
       $getdata = $this->m_jlo_sdm_val->fetch_jlo_sdm_val();
       echo json_encode($getdata);   
  	}

  	public function fetch_kategori(){  
       $getdata = $this->m_jlo_sdm_val->fetch_kategori();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "select a.*,b.cat_jlo_sdm from m_jlo_sdm_val a
               LEFT JOIN m_jlo_sdm_cat b on b.id = a.id_cat_jlo_sdm where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3); 
		$idx = $this->uri->segment(4); 
    //cek apakah foto/gambar tersedia
		 
	$sqlhapus = $this->db->query("delete from m_jlo_sdm_val where id_penawaran = '".$id."' and tahap = '".$idx."' ");
  
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
 

 	$cid_jlo_sdm_list = count($_POST['id_jlo_sdm_list']); 
 	$id_pe = $_POST['id_pe'];
 	$id_tahapx = $_POST['id_tahapx'];
 	
 	$sqldata = $this->db->query("select * from m_jlo_sdm_val where id_penawaran = '".$id_pe."' and tahap = '".$id_tahapx."' ")->num_rows();
 	// $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
 	if($sqldata > 0){
 		//data sudah ada
 		$res = 2;
  
 	}else{
 		//masukkan data jika belum ada

 		if($cid_jlo_sdm_list > 0)  {

 			for($i=0; $i<$cid_jlo_sdm_list; $i++){

 	 			$data = $this->db->query("insert into m_jlo_sdm_val (id_penawaran,tahap,id_jlo_sdm_list,kantor,gt,total,ht,base,k_ops,k_shuttle) 
 	 			values ('".$id_pe."','".$id_tahapx."','".$_POST['id_jlo_sdm_list'][$i]."','".$_POST['kantor'][$i]."','".$_POST['gt'][$i]."','".($_POST['kantor'][$i] + $_POST['gt'][$i])."','".$_POST['ht'][$i]."','".$_POST['base'][$i]."','".$_POST['k_ops'][$i]."','".$_POST['k_shuttle'][$i]."')");
 				
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
 				$this->db->query("update m_jlo_sdm_val SET kantor = '".$_POST['kantor'][$i]."',gt = '".$_POST['gt'][$i]."', total = '".$_POST['total'][$i]."', ht = '".$_POST['ht'][$i]."', base = '".$_POST['base'][$i]."', k_ops = '".$_POST['k_shuttle'][$i]."' where id = '".$_POST['id'][$i]."' "); 

 				echo $this->db->last_query()."<br>";
 			}
 			  

 		} 
 		
	 	echo 1; 
 	 
 	} 
       


}
