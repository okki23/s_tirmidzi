<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Setup_penawaran extends Parent_Controller {
 
  var $nama_tabel = 't_harga_penawaran';
  var $daftar_field = array('id','id_penawaran','tahap','value_harsat','id_pricelist','kebutuhan','volume');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_setup_penawaran'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'setup_penawaran/setup_penawaran_view';
    $data['list_penawaran'] = $this->list_penawaran();
		$this->load->view('template_view',$data);		
   
	}

    public function fetch_harga(){  
       $getdata = $this->m_setup_penawaran->fetch_harga();
       echo json_encode($getdata);   
    } 

    public function fetch_setup_penawaran_modal(){
      $id_harga = $this->input->post('id_harga');
      //echo json_encode($id_harga);
      $sql = "select
              a.*,b.harga,c.tipe,c.nama_pricelist,c.id as id_pricelist,d.nama_satuan,e.nama_pelayanan,f.nama_komp_biaya from m_harga a
              LEFT JOIN m_harsat_val b on b.id_kel_harsat = a.id
              LEFT JOIN m_pricelist c on c.id = b.id_pricelist
              LEFT JOIN m_satuan d on d.id = c.id_satuan
              LEFT JOIN m_jenis_pelayanan e on e.id = c.id_pelayanan
              LEFT JOIN m_komp_biaya f on f.id = c.id_komp_biaya
              WHERE a.id = '".$id_harga."'";
     $data = $this->db->query($sql)->result();

       $return_arr = array();

       foreach ($data as $key => $value) {
         $row_array['nama_pricelist'] = $value->nama_pricelist."<input type='hidden' name='id_pricelist[]' value='".$value->id_pricelist."'>"; 

         $row_array['harga'] = "Rp. ".number_format(intval($value->harga))."<input type='hidden' name='harga[]' value='".$value->harga."'  id='harga_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."' >";

         $row_array['nama_satuan'] = $value->nama_satuan; 

         if($value->tipe == 'calculated'){
           $row_array['kebutuhan'] = '<input type="text" name="kebutuhan[]" id="kebutuhan_'.strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist)).'" class="form-control" readonly="readonly" style=" background-color:#D8D8D8;" value="0">'; 
         }else{
            $row_array['kebutuhan'] = '<input type="text" name="kebutuhan[]" id="kebutuhan_'.strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist)).'" class="form-control" value="1">'; 
         }
        

         $row_array['volume'] = '<input type="text" name="volume[]" id="volume_'.strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist)).'"
           class="form-control" value="1">'; 

         $row_array['jumlah_uraian'] = "<input type='text' name='jumlah_uraian[]'
          class='form-control' id='jumlah_uraian_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."' value='0'  >";

         $row_array['jumlah_tahunan'] = "<input type='text' name='jumlah_tahunan[]' class='form-control' id='jumlah_tahunan_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."' value='0'   >"; 

     
         array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);

    }

    public function listing_hp(){
      $id_penawaran = $this->input->post('id');
      $tahap = $this->input->post('idx');
      //echo json_encode($id_harga);
      $sql = "select a.*,b.nama_pricelist,c.nama_penawaran,d.nama_satuan,
(a.kebutuhan * a.value_harsat) as jumlah_uraian,
((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan,e.nama_pelayanan,f.nama_komp_biaya from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_penawaran c on c.id = a.id_penawaran
LEFT JOIN m_satuan d on d.id = b.id_satuan 
LEFT JOIN m_jenis_pelayanan e on e.id = b.id_pelayanan
LEFT JOIN m_komp_biaya f on f.id = b.id_komp_biaya
              WHERE a.id_penawaran = '".$id_penawaran."' AND a.tahap = '".$tahap."' ";
     $data = $this->db->query($sql)->result();

       $return_arr = array();

       foreach ($data as $key => $value) {
         $row_array['nama_pricelist'] = $value->nama_pricelist;
         $row_array['kebutuhan'] =  $value->kebutuhan; 
         $row_array['nama_satuan'] = $value->nama_satuan;
         $row_array['value_harsat'] =  $value->value_harsat; 
         $row_array['jumlah_uraian'] = $value->jumlah_uraian;
         $row_array['volume'] =  $value->volume; 
         $row_array['jumlah_tahunan'] =  $value->jumlah_tahunan; 
         $row_array['nama_pelayanan'] =  $value->nama_pelayanan; 
         $row_array['nama_komp_biaya'] =  $value->nama_komp_biaya; 

         array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);

    }

    public function listing_hp_ubah(){
      $id_penawaran = $this->input->post('id');
      $tahap = $this->input->post('idx');
      //echo json_encode($id_harga);
      $sql = "select a.*,b.nama_pricelist,b.tipe,c.nama_penawaran,d.nama_satuan,
(a.kebutuhan * a.value_harsat) as jumlah_uraian,
((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan,e.nama_pelayanan,f.nama_komp_biaya from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_penawaran c on c.id = a.id_penawaran
LEFT JOIN m_satuan d on d.id = b.id_satuan 
LEFT JOIN m_jenis_pelayanan e on e.id = b.id_pelayanan
LEFT JOIN m_komp_biaya f on f.id = b.id_komp_biaya
              WHERE a.id_penawaran = '".$id_penawaran."' AND a.tahap = '".$tahap."' ";
     $data = $this->db->query($sql)->result();

       $return_arr = array();

       foreach ($data as $key => $value) {
         $row_array['nama_pricelist'] = $value->nama_pricelist."<input type='hidden' name='id[]' value='".$value->id."'>";
        if($value->tipe == 'calculated'){
          $row_array['kebutuhan'] =  "<input type='text' name='kebutuhan[]' value='".$value->kebutuhan."' class='form-control' readonly='readonly' style='background-color:#D8D8D8;'  id='kebutuhan_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."_update' >"; 
        }else{
          $row_array['kebutuhan'] =  "<input type='text' name='kebutuhan[]' value='".$value->kebutuhan."' class='form-control' id='kebutuhan_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."_update'>"; 
        }
       
         $row_array['nama_satuan'] = $value->nama_satuan;
         $row_array['value_harsat'] =  $value->value_harsat; 
         $row_array['jumlah_uraian'] = $value->jumlah_uraian;
         $row_array['volume'] =  "<input type='text' name='volume[]' value='".$value->volume."' class='form-control'  id='volume_".strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist))."_update' >"; 
         $row_array['jumlah_tahunan'] =  $value->jumlah_tahunan; 
         $row_array['nama_pelayanan'] =  $value->nama_pelayanan; 
         $row_array['nama_komp_biaya'] =  $value->nama_komp_biaya; 

         array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);

    }

    public function call_kebutuhan_biaya_materai(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select *,(sum(total))*3 as total_result from m_jlo_sdm_val WHERE id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total_result;
    }
  
    public function list_harga(){
    $id = $this->input->post('id');
    $idx = $this->input->post('idx');

      $sql = "select a.*,b.nama_country from m_harga a
      left join m_country b on b.id = a.id_country";
    
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

         $row_array['no'] = $no.'<input type="hidden" class="form-control" name="id[]" id="id" value="'.$value->id.'">';

         $row_array['nama_harga'] = $value->nama_harga;

         $row_array['tahun'] = $value->year;

         $row_array['country'] = $value->nama_country;

         $row_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$value->id.');" > <i class="material-icons">create</i> Detail </a>  &nbsp; <a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="val_harga_update" onclick="Pilih('.$value->id.');" > <i class="material-icons">create</i> Pilih </a>  ';  
  
         array_push($return_arr,$row_array);
         $no++;
       }
       echo json_encode($return_arr);
   
  }

  public function list_penawaran(){
    $db = $this->db->get('m_penawaran')->result();
    return $db;
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


    //$callback = array('data_tahap'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota
    echo $html;
    //echo json_encode($callback); // konversi varibael $callback menjadi JSON



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
    
    public function list_detail_setup_penawaran(){
    $id = $this->input->post('id');

      $sql = "select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan,e.setup_penawaran,e.id_kel_harsat,f.nama_setup_penawaran from m_pricelist a
      LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
      LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
      LEFT JOIN m_satuan d on d.id = a.id_satuan
      LEFT JOIN m_harsat_val e on e.id_pricelist = a.id  
      LEFT JOIN m_setup_penawaran f on f.id = e.id_kel_harsat where e.id_kel_harsat = '".$id."'  ";
     //echo $sql;
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();
       $no = 1;
       foreach ($getdata as $key => $value) {

         $row_array['no'] = $no;
         $row_array['nama_pricelist'] = $value->nama_pricelist; 
         $row_array['setup_penawaran'] = "Rp. ".number_format($value->setup_penawaran,0);
         $row_array['nama_pelayanan'] = $value->nama_pelayanan;
         $row_array['nama_komp_biaya'] = $value->nama_komp_biaya;
          
         array_push($return_arr,$row_array);
         $no++;
       }
       echo json_encode($return_arr);
   
  }

    public function generate_setup_penawaran(){

    $nama_setup_penawaran = $_POST['nama_setup_penawaran'];
    $id_country = $_POST['id_country_second'];
    $year = $_POST['year'];
    $id_asal_setup_penawaran = $_POST['id_asal_setup_penawaran'];
    $persentase_kenaikan = $_POST['persentase_kenaikan'];

    //store to setup_penawaran

    $sql_setup_penawaran = "insert into m_setup_penawaran (nama_setup_penawaran,year,id_country) values ('".$nama_setup_penawaran."','".$year."','".$id_country."')";

    $this->db->query($sql_setup_penawaran);
    
    //last_id for generate setup_penawaran
    $last_id = $this->db->insert_id();

    //ambil setup_penawaran 
    $sql_ah = $this->db->query("select * from m_harsat_val where id_kel_harsat = '".$id_asal_setup_penawaran."' ");

    foreach ($sql_ah->result() as $key => $value) {
      //echo ($value->setup_penawaran + ($value->setup_penawaran * 5 / 100))."<br>";

     $sql = "insert into m_harsat_val (id_kel_harsat,id_pricelist,setup_penawaran) values ('".$last_id."','".$value->id_pricelist."','".($value->setup_penawaran + ($value->setup_penawaran * $persentase_kenaikan / 100))."') ";
    $this->db->query($sql);
    }
    }
 

  	public function fetch_nama_komp_biaya_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_komp_biaya')->row();
  		echo json_encode($data);
  	}

  	public function fetch_nama_parents_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_setup_penawaran')->row();
  		echo json_encode($data);
  	}


  	public function fetch_setup_penawaran(){  
       $getdata = $this->m_setup_penawaran->fetch_setup_penawaran();
       echo json_encode($getdata);   
  	}
  	
  	public function fetch_country(){  
       $getdata = $this->m_setup_penawaran->fetch_country();
       echo json_encode($getdata);   
  	}

  	public function fetch_satuan(){  
       $getdata = $this->m_setup_penawaran->fetch_satuan();
       echo json_encode($getdata);   
  	}  

  	public function fetch_pelayanan(){  
       $getdata = $this->m_setup_penawaran->fetch_pelayanan();
       echo json_encode($getdata);   
  	}

  	public function fetch_komp_biaya(){  
       $getdata = $this->m_setup_penawaran->fetch_komp_biaya();
       echo json_encode($getdata);   
  	}
 
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "select a.*,b.nama_country as country from m_setup_penawaran a
              LEFT JOIN m_country b on b.id = a.id_country
              where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    	$delete = $this->db->where('id',$id)->delete('m_setup_penawaran');
    	$deletex =  $this->db->where('id_kel_harsat',$id)->delete('m_harsat_val');
    	if($delete && $deletex){
    		$result = array("response"=>array('message'=>'success'));	
	    }else{
	    	$result = array("response"=>array('message'=>'failed'));
	    }
 
		
		echo json_encode($result,TRUE);
	}

  public function hapus_list_data(){
    $id = $this->uri->segment(3); 
    $idx = $this->uri->segment(4); 
    $sql = "delete from t_harga_penawaran where id_penawaran = '".$id."' and tahap = '".$idx."' ";

      $delete = $this->db->query($sql);
       
      if($delete){
        $result = array("response"=>array('message'=>'success')); 
      }else{
        $result = array("response"=>array('message'=>'failed'));
      }
 
    
    echo json_encode($result,TRUE);
  }
	 
	public function simpan_data(){
 

  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaran'];
  $tahap = $_POST['tahap'];
  
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }


  public function list_store_setup_penawaran(){
    $sql = "select a.*,b.nama_pricelist,c.nama_penawaran,d.nama_satuan,
            (a.kebutuhan * a.value_harsat) as jumlah_uraian,
            ((a.kebutuhan * a.value_harsat) * a.volume) as total_tahun from t_harga_penawaran a
            LEFT JOIN m_pricelist b on b.id = a.id_pricelist
            LEFT JOIN m_penawaran c on c.id = a.id_penawaran
            LEFT JOIN m_satuan d on d.id = b.id_satuan GROUP BY a.id_penawaran,a.tahap";
    $getdata = $this->db->query($sql)->result();
       $data = array();  
       $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_penawaran;  
                $sub_array[] = $row->tahap;
      

                 
                $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_HP('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">create</i> Ubah </a>     &nbsp;<a href="javascript:void(0)" class="btn btn-primary btn-xs waves-effect" id="detail" onclick="Detail_HP('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">all_out</i> Detail </a>     &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">delete</i> Hapus </a>  ';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
       $output = array("data"=>$data);
       echo json_encode($output);
  }


	public function dataget(){
    //header('Content-type: text/javascript');
    $sql = $this->db->query("select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan,e.nama_setup_penawaran as parent from m_setup_penawaran a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan
              LEFT JOIN m_setup_penawaran e on e.id = a.id_parent_setup_penawaran")->result();
    $arr = array();
    foreach ($sql as $key => $value) {
      $sub_arr = array();
      $sub_arr['nama_pelayanan'] = $value->nama_pelayanan; 
      $sub_arr['nama_komp_biaya'] = $value->nama_komp_biaya; 
      $sub_arr['nama_setup_penawaran'] = $value->nama_setup_penawaran; 
      $sub_arr['nama_satuan'] = $value->nama_satuan; 
      $sub_arr['parent'] = $value->parent; 

      $arr[] = $sub_arr;
    }

		//$arr = array('data1'=>1,'data2'=>2,'data3'=>3);
    echo json_encode(array("data"=>$arr));
	}
  
       


}
