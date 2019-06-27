<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

      
            $row_array['kebutuhan'] = '<input type="text" name="kebutuhan[]" id="kebutuhan_'.strtolower(str_replace(array(' ','/'),"_",$value->nama_pricelist)).'" class="form-control" value="1">'; 
      

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
              WHERE a.id_penawaran = '".$id_penawaran."' AND a.tahap = '".$tahap."' ORDER by b.id ASC ";
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
              WHERE a.id_penawaran = '".$id_penawaran."' AND a.tahap = '".$tahap."'  ORDER by b.id ASC  ";
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

    public function call_fotocopy_perjanjian(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql = "select *,(sum(total)*25) as result from m_jlo_sdm_val where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ";
      $ex = $this->db->query($sql)->row();
   
      echo $ex->result;
    }

    public function call_pulsa_telepon(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql = "select *,(sum(total)*3) as result from m_jlo_sdm_val where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ";
      $ex = $this->db->query($sql)->row();
   
      echo $ex->result;
    }

 
    public function call_seleksi_manager_area(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '1' ";
      if($this->db->query($sql)->num_rows() > 0){
        $res = 0;
      }else{
        $res = $ex->result;
      }
      
      
      echo $res;
    }

    

    public function call_seleksi_asisten_manager(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '3' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '14' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '25' ";
      $ex_c = $this->db->query($sql_c)->row();

      $calculate = (($ex_a->total + $ex_b->total + $ex_c->total) * 2);
   
      echo $calculate;
    }

    public function call_kspt_ks_patroli(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '5' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '16' ";
      $ex_b = $this->db->query($sql_b)->row();

    
      $calculate = (($ex_a->total + $ex_b->total) * 2);
   
      echo $calculate;
    }

    public function call_seleksi_pik(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '18' ";
      $ex_a = $this->db->query($sql_a)->row();
 
    
      $calculate = (($ex_a->total) * 2);
   
      echo $calculate;
    }

    public function call_seleksi_jtu(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '2' ";
      $ex_a = $this->db->query($sql_a)->row();

       $sql_b = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '26' ";
      $ex_b = $this->db->query($sql_b)->row();
 
    
       $calculate = (($ex_a->total + $ex_b->total) * 2);
   
      echo $calculate;
    }

     public function call_seleksi_tu(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '12' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '13' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '19' ";
      $ex_c = $this->db->query($sql_c)->row();

      $sql_d = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '27' ";
      $ex_d = $this->db->query($sql_d)->row();
       
       $calculate = (($ex_a->total + $ex_b->total + $ex_c->total + $ex_d->total)*2);
   
      echo $calculate;
    }
  

    public function call_seleksi_narkoba(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '11' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '12' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '13' ";
      $ex_c = $this->db->query($sql_c)->row();

      $sql_d = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '17' ";
      $ex_d = $this->db->query($sql_d)->row();
      
      $sql_e = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '18' ";
      $ex_e = $this->db->query($sql_e)->row();

      $sql_f = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '19' ";
      $ex_f = $this->db->query($sql_f)->row();

      $sql_g = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '27' ";
      $ex_g = $this->db->query($sql_g)->row();
    
       $calculate = ($ex_a->total + $ex_b->total + $ex_c->total + $ex_d->total + $ex_e->total + $ex_f->total + $ex_g->total);
   
      echo $calculate;
    }

      public function call_honor_pengajar(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '11' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '17' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '18' ";
      $ex_c = $this->db->query($sql_c)->row();
 
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = ((ceil($ex_a->total/50) + ceil(($ex_b->total + $ex_c->total)/50))*2);
      echo $calculate;
    }

    public function call_akomodasi_pelatihan(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '11' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '17' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '18' ";
      $ex_c = $this->db->query($sql_c)->row();
 
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = ($ex_a->total + $ex_b->total + $ex_c->total);
      echo $calculate;
    }

    public function call_sewa_kendaraan_bus(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '11' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '17' ";
      $ex_b = $this->db->query($sql_b)->row();

      $sql_c = "select a.*,b.sdm_list from m_jlo_sdm_val a
                left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '18' ";
      $ex_c = $this->db->query($sql_c)->row();
 
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = ceil(($ex_a->total + $ex_b->total + $ex_c->total)/3);
      echo $calculate;
    }

    public function call_honor_pengajar_pelatihan_sop_kspt_dan_ks_patroli(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '5' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '16' ";
      $ex_b = $this->db->query($sql_b)->row();
 
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = (ceil($ex_a->total/20) + ceil($ex_b->total/20));
      echo $calculate;
    }

    public function call_akomodasi_pelatihan_pelatihan_sop_kspt_dan_ks_patroli(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '5' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '16' ";
      $ex_b = $this->db->query($sql_b)->row();

   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = ($ex_a->total + $ex_b->total);
      echo $calculate;
    }

    public function call_tunjangan_belajar_pelatihan_sop_kspt_dan_ks_patroli(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '5' ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b =  "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '16' ";
      $ex_b = $this->db->query($sql_b)->row();

   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = (($ex_a->total + $ex_b->total)*2);
      echo $calculate;
    }

    public function call_kebutuhan_honor_manager_area_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '1' ";
      $ex_a = $this->db->query($sql_a)->row();
 
   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = $ex_a->total;
      echo $calculate;
    }
    public function call_kebutuhan_honor_asisten_manager_yantran_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '3' ";
      $ex_a = $this->db->query($sql_a)->row();
 
   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = $ex_a->total;
      echo $calculate;
    }

    public function call_kebutuhan_honor_kepala_shift_pengumpulantol_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.* from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'and id_asumsi = '12'";
      $ex_a = $this->db->query($sql_a)->row();
 
   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = $ex_a->vol;
      echo $calculate;
    }

    public function call_kebutuhan_honor_pengumpultol_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.* from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."'and id_asumsi = '12'";
      $ex_a = $this->db->query($sql_a)->row();
 
   
    
      //$calculate = (ceil($ex_a->total/50) + (ceil(($ex_b->total) + ($ex_c->total)/50))*2 );
      $calculate = (($ex_a->vol)*2);
      echo $calculate;
    }

    public function call_kebutuhan_honor_asisten_manager_pelayanan_lalin_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
        $sql_a = "select a.*,(a.total * 2) as result,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '14' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;
    }

    public function call_kebutuhan_honor_petugas_patroli_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
       $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and id_asumsi = '3'";
      $ex_a = $this->db->query($sql_a)->row();
 
   
  
      $calculate = (($ex_a->vol)*2);
      echo $calculate;
    }
 

    public function call_kebutuhan_honor_petugas_derek_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
       $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and id_asumsi = '6' ";
      $ex_a = $this->db->query($sql_a)->row();
 
   
  
      $calculate = (($ex_a->vol)*2);
      echo $calculate;
    }

    public function call_kebutuhan_honor_petugas_ambulan_pra_kelaikan_operasi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and id_asumsi = '5' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $calculate = (($ex_a->vol)*2);
      echo $calculate;
    }

    public function call_kebutuhan_displayled24touchscreen_peralatan_komputer(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and id_asumsi = '11' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $calculate = $ex_a->vol;
      echo $calculate;
    }

    public function call_kebutuhan_rj_amp_peralatan_komputer(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and id_asumsi = '11' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $calculate = (($ex_a->vol)*0.5);
      echo $calculate;
    }

    public function call_kebutuhan_meja_desain_kirim_peralatan_komputer(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and id_asumsi = '11' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $calculate = (($ex_a->vol)*2);
      echo $calculate;
    }

    public function call_kebutuhan_utpcard_peralatan_komputer(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and id_asumsi = '11' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $calculate = (($ex_a->vol)*50);
      echo $calculate;
    }

    public function call_manager_area_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '1' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_juru_tata_usaha_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '2' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_asisten_manager_transaksi_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '3' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_kepala_shift_pengumpulan_tol_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '5' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_kepala_shift_pengumpul_tol_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '11' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_tuadministrasigt_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."' and a.id_jlo_sdm_list = '12' ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->total;
      echo $calculate;

    }

    public function call_sewa_kendaraan_shuttle_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,SUM(a.total) as res,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'   ";
      $ex_a = $this->db->query($sql_a)->row();
  
      $calculate = $ex_a->res;
      echo $calculate;

    }

     public function call_bbm_shuttle_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'   ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '53'";

      $ex_b = $this->db->query($sql_b)->row();
  
      $calculate = (($ex_a->results) * ($ex_b->vol));
      echo $calculate;

    }


    public function call_kebutuhan_sewa_kendaraan_manager_area(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '1' ";
      $ex_a = $this->db->query($sql_a)->row();

      
  
      $calculate = $ex_a->k_ops;
      echo $calculate;

    }


    public function call_sewa_kendaraan_asisten_manager_transaksi(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '3' ";
      $ex_a = $this->db->query($sql_a)->row();

      
  
      $calculate = $ex_a->k_ops;
      echo $calculate;

    }

    public function call_kebutuhan_bbm_manager_area(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
 
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '1' ";
      $ex_a = $this->db->query($sql_a)->row();

      
      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '49'"; 
      $ex_b = $this->db->query($sql_b)->row();       
  
      $calculate = (($ex_a->k_ops) * ($ex_b->vol));
      echo $calculate;

    }

    public function call_kebutuhan_bbm_asisten_manager(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'  and a.id_jlo_sdm_list = '3' ";
      $ex_a = $this->db->query($sql_a)->row();

      
      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '50'"; 
      $ex_b = $this->db->query($sql_b)->row();       
  
      $calculate = (($ex_a->k_ops) * ($ex_b->vol));
      echo $calculate;

    }


 
 

    public function call_pengemuditahunkontrak_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      $sql_a = "select a.*,sum(a.k_shuttle) as results,b.sdm_list from m_jlo_sdm_val a
      left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list
      where a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = '".$tahap."'   ";
      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '65'";

      $ex_b = $this->db->query($sql_b)->row();
  
      $calculate = (($ex_a->results) * ($ex_b->vol));
      echo $calculate;

    }

    public function call_yantrans_rollpaper(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '14'";

      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '15'";

      $ex_b = $this->db->query($sql_b)->row();
  


      $calculate =ceil(((($ex_a->vol) / ($ex_b->vol) * 105)/100));
      echo $calculate;

    }

    public function call_yantrans_kttm(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '14'";

      $ex_a = $this->db->query($sql_a)->row();

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi
                where a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' and a.id_asumsi = '16'";

      $ex_b = $this->db->query($sql_b)->row();
  

 
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      echo ceil(((((intval($ex_a->vol)) * (intval($ex_b->vol)))*105)/100));

    }

    public function call_yantrans_continious_form(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
       
      
      $sql_a = "select *,sum(jml_rev) as res_a,sum(jml_tot) as res_b from m_gardu WHERE id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();

      

      $calculate = ceil((($ex_a->res_a) + ($ex_a->res_b) * 3 * 30)/(1000*(85/100)));
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo $calculate;
    }

    public function call_laserjet_toner(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $calculate =  (($ex_a->vol)*2);
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo $calculate;
    }

    public function call_kertas_hvs_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $calculate =  (($ex_a->vol)*3);
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo $calculate;
    }

    public function call_vol_kontrak(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo $ex_a->vol;
    }

    public function call_vol_toner_lasjet_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*4);
    }

    public function call_vol_tahunan_yantrans(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi 
                WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*365);
    }


    public function call_lalin_assman_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '14' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total;
    }

    public function call_lalin_kepala_shift_patroli_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '16' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total;
    }

    public function call_lalin_petugas_patroli_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '17' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total;
    }

    public function call_lalin_pik_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '18' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total;
    }

    public function call_lalin_tu_pelayanlalin_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sql = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '19' ";
      $ex = $this->db->query($sql)->row();
      //echo $this->db->last_query();
      echo $ex->total;
    }

    public function call_lalin_sewa_pickup_patroli_doublecab(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sqla = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '17' ";
      $exa = $this->db->query($sqla)->row();
      $sqlb = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '16' ";
      $exb = $this->db->query($sqlb)->row();
      $calculate = (($exa->k_ops) + ($exb->k_ops));
      echo $calculate;
    }

    public function call_lalin_bbm_ljt(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sqla = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '17' ";
      $exa = $this->db->query($sqla)->row();
      $sqlb = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '16' ";
      $exb = $this->db->query($sqlb)->row();
      $sqlc = "select a.id,a.nama_asumsi,b.vol,b.id_penawaran,b.tahap from m_asumsi a
LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '51' ";
      $exc = $this->db->query($sqlc)->row();
      $calculate = (($exa->k_ops) + ($exb->k_ops));
      echo ($exc->vol * $calculate);
    }

    public function call_derek_10ton_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      
      $sqlc = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap from m_asumsi a
LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '73' ";
      $exc = $this->db->query($sqlc)->row();
       
      echo $exc->keterangan;
    }

    public function call_derek_25ton_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      
      $sqlc = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap from m_asumsi a
LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '74' ";
      $exc = $this->db->query($sqlc)->row();
       
      echo $exc->keterangan;
    }

    public function call_bbm_derek_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      
      $sqla = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap 
              from m_asumsi a
              LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '73' ";
      $exa = $this->db->query($sqla)->row();

      $sqlb = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap 
              from m_asumsi a
              LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '74' ";
      $exb = $this->db->query($sqlb)->row();
       
      $sqlc = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap 
              from m_asumsi a
              LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '55' ";
      $exc = $this->db->query($sqlc)->row();
      $calculate = ((intval($exa->keterangan) + intval($exb->keterangan)) * $exc->vol);

      echo $calculate;
    }

    public function call_petugasderektahunan_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      
      $sqla = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap 
              from m_asumsi a
              LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '73' ";
      $exa = $this->db->query($sqla)->row();
 
      $calculate =  ($exa->vol * 4 *2);

      echo $calculate;
    }

    public function call_kebutuhan_lalin_grup_a(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      
      $sqla = "select a.id,a.nama_asumsi,b.vol,b.keterangan,b.id_penawaran,b.tahap 
              from m_asumsi a
              LEFT JOIN m_asumsi_list b on b.id_asumsi = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '73' ";
      $exa = $this->db->query($sqla)->row();
 
      $calculate =  ($exa->vol * 4 *2)+2;

      echo $calculate;
    }


    public function call_kebutuhan_lalin_grup_b(){
      //7
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      
      echo $ex_a->vol;
    }


    public function call_umum_teh_celup(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap,sum(b.total) as res from m_jlo_sdm_list a
LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."'  ";

      $ex_a = $this->db->query($sql_a)->row();
      echo ceil(($ex_a->res * 22 *2 / 40 / 2));
    }
    public function call_umum_sabun_cair_handsoap(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo (($ex_a->vol)+ ($ex_b->vol)) * 5;
    }


     public function call_umum_tissue(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sqla = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '1' ";

      $sqlb = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '3' ";

      $sqlc = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '14' ";

      $sqld = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '25' ";

      $sqle = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sqlf = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sqla)->row(); 
      $ex_b = $this->db->query($sqlb)->row();
      $ex_c = $this->db->query($sqlc)->row(); 
      $ex_d = $this->db->query($sqld)->row(); 
      $ex_e = $this->db->query($sqle)->row(); 
      $ex_f = $this->db->query($sqlf)->row();  

      
      echo ((($ex_a->total)+ ($ex_b->total) + ($ex_c->total)+ ($ex_d->total) + ($ex_e->vol)+ ($ex_f->vol)) + 2) * 2;
    }

    public function call_umum_sabun_cuci_piring(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo ceil(($ex_a->vol) + ($ex_b->vol) * 8);
    }

    public function call_umum_sewagalondispenser(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo (($ex_a->vol *2) + ($ex_b->vol)) + 2;
    }

    public function call_umum_kotakp3kantor(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo (($ex_a->vol) + ($ex_b->vol));
    }

    public function call_umum_airminumkantortamu(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
        b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap,sum(b.total) as res from m_jlo_sdm_list a 
        LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id where b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' ";
 

      $ex_a = $this->db->query($sql_a)->row(); 
    
      
      echo ceil(($ex_a->res) * 2 * 1.1);
    }

     public function call_umum_gas_elpiji(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo (($ex_a->vol) + ($ex_b->vol)) * 2;
    }

    public function call_umum_pembasmi_serangga(){
   
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '11' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '12' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 
      $ex_b = $this->db->query($sql_b)->row(); 

      
      echo (($ex_a->vol) + ($ex_b->vol) + 2) * 2;
    }
 
    public function call_umum_bast_tugas(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '5' ";

      $ex_a = $this->db->query($sql_a)->row();

      //$ex_a->total;
      
      $sql_b = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '16' ";

      $ex_b = $this->db->query($sql_b)->row(); 
      //$ex_b->total;

      $sql_c = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '18' ";

      $ex_c = $this->db->query($sql_c)->row(); 
      //$ex_b->total;
      $cal = ceil(((($ex_a->total/5) + ($ex_b->total/5) + ($ex_c->total/5)*3 *365/50)/5)*5);
      echo $cal;
    }
	
	 public function call_umum_penjilidan(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '1' ";

      $ex_a = $this->db->query($sql_a)->row();

      //$ex_a->total;
      
      $sql_b = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '3' ";

      $ex_b = $this->db->query($sql_b)->row(); 
      //$ex_b->total;

      $sql_c = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '14' ";

      $ex_c = $this->db->query($sql_c)->row(); 
	  
	  $sql_d = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '14' ";

      $ex_d = $this->db->query($sql_d)->row(); 
      //$ex_b->total;
      $cal = ceil(($ex_a->total) + ($ex_b->total) + ($ex_c->total) + ($ex_d->total)*2);
      echo $cal;
    }


 public function call_umum_bast_operasional(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '5' ";

      $ex_a = $this->db->query($sql_a)->row();

      //$ex_a->total;
      
      $sql_b = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '16' ";

      $ex_b = $this->db->query($sql_b)->row(); 
      //$ex_b->total;

      $sql_c = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '18' ";

      $ex_c = $this->db->query($sql_c)->row(); 
      //$ex_b->total;
      $cal = ceil(((($ex_a->total/5) + ($ex_b->total/5) + ($ex_c->total/5)*3 *365/50)/5)*5);
      $res = ceil($cal*0.6);
      echo $res;
    }

    public function call_umum_grup_a(){
      //1
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '72' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 

      
      echo ceil(($ex_a->vol)/12);
    }

    public function call_umum_grup_b(){
      //7
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '72' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      echo $ex_a->vol;
    }

    public function call_umum_grup_c(){
      //3
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '72' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      echo ceil((($ex_a->vol)/12)*4);
    }

    public function call_umum_grup_d(){
      //6
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = 
                '72' and a.id_penawaran = '".$id_penawaran."' 
                and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      echo ceil((($ex_a->vol)/12)*4)*2;
    }

     public function call_kebutuhan_lalin_grup_c(){
      //213
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi 
                WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*365);
    }

    public function call_kebutuhan_lalin_grup_d(){
      //3
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*4);
    }

    public function call_kebutuhan_lalin_grup_e(){
      //6
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*4)*2;
    }


    public function call_umum_grup_e(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol))*2)+2;
    }

    public function call_umum_grup_f(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol))*2);
    }



     public function call_kebutuhan_sewa_kendaraan_prescue_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '4' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo $ex_a->vol;
    }

  public function call_kebutuhan_bbm_rescue_lalin(){
     
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '4' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '57' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol) * ($ex_b->vol));
    }

    public function call_kebutuhan_lalin_grup_f(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '4' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo (($ex_a->vol) * 5);
    }

     public function call_kebutuhan_lalin_grup_g(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '16' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '17' ";


      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->k_ops) + ($ex_b->k_ops));
    }

    public function call_kebutuhan_lalin_grup_h(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '16' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,
      b.base,b.ht,b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id
      WHERE b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' 
      and a.id = '17' ";


      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->total) + ($ex_b->total));
    }
 
  public function call_sewa_ken_ambulance_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '5' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo ($ex_a->vol);
    }

    public function call_sewa_bbm_ken_ambulance_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '5' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '56' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol) * ($ex_b->vol));
    }

    public function call_paramedis_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '5' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
 
      echo (($ex_a->vol) * 4);
    }

    public function call_sewa_ht_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "
      select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,b.k_ops, b.k_shuttle,b.id_penawaran,b.tahap,sum(ht) as result 
      from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id 
      where b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
 
      echo $ex_a->result;
    }

    public function call_sewa_base_station_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "
      select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,b.k_ops, b.k_shuttle,b.id_penawaran,b.tahap,sum(base) as result 
      from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id 
      where b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
 
      echo $ex_a->result;
    }

    public function call_kebutuhan_insentilang_pjr_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '14' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo number_format(($ex_a->vol * (0.5/100)));
    }

   

    public function call_kebutuhan_kamtibsatpam_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo $ex_a->vol;
    }

     public function call_kebutuhan_patroli_kamtib_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo ($ex_a->vol * 8);
    }

    public function call_kebutuhan_satpeng_gerbangtol_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol * 5) + ($ex_b->vol * 5));


    }
 

 public function call_kebutuhan_lalin_grup_i(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_b = $this->db->query($sql_b)->row(); 
      //1
      $seca = (($ex_a->vol * 5) + ($ex_b->vol * 5));
      //echo (($ex_a->vol * 5) + ($ex_b->vol * 5));


      $sql_c = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_c = $this->db->query($sql_c)->row(); 
      //2
      $secb = ($ex_c->vol * 8);
      //echo ($ex_c->vol * 8);

      $sql_d = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      //3
      $ex_d = $this->db->query($sql_d)->row(); 
      $secc = ($ex_d->vol);
      echo ($seca + $secb + $secc);
    }
 

    public function call_sewa_minibus_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo $ex_a->vol;
    }

    public function call_bbm_satpem_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '9' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' "; 

      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '58' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' "; 

      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol) * ($ex_b->vol));
    }

    public function call_sewa_kend_asmenlalin_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
     $sql_a = "
      select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,b.k_ops, b.k_shuttle,b.id_penawaran,b.tahap
      from m_jlo_sdm_list a
      LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id 
      where b.id_penawaran = '".$id_penawaran."' and b.tahap = '".$tahap."' and b.id_jlo_sdm_list = '14' ";

      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo ($ex_a->k_ops);
    }

    public function call_kebutuhan_bbm_asisten_managers_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.id,b.id_jlo_sdm_list,a.sdm_list,b.kantor,
              b.gt,b.total,b.base,b.ht,b.k_ops, b.k_shuttle,b.id_penawaran,b.tahap
              from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id 
              where b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' and b.id_jlo_sdm_list = '14' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '50' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  

      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->k_ops) * ($ex_b->vol));
    }

    public function call_kebutuhan_apab50_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row(); 
 
      echo ($ex_a->vol);
    }

      public function call_kebutuhan_rubbercone_lalin(){
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap');
      $sqla = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '17' ";
      $exa = $this->db->query($sqla)->row();
      $sqlb = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '16' ";
      $exb = $this->db->query($sqlb)->row();
      $calculate = (($exa->k_ops) + ($exb->k_ops)) * 5;
      echo $calculate;
    }

    public function call_kebutuhan_bbmsurveywtmpuh_lalin(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '59' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row(); 
 
 
 
      echo ($ex_a->vol);
    }

     public function call_sewa_kendaraan_pjr_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '7' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row(); 
 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '8' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol) + ($ex_b->vol));
    }

    

    public function call_bbm_pjr_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '7' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row(); 
 

      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '60' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_b = $this->db->query($sql_b)->row(); 
 
      echo (($ex_a->vol) * ($ex_b->vol));
    } 

    public function call_kanit_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '8' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row();  
 
      echo ($ex_a->vol);
    } 

    public function call_panit_ob_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '8' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row();  
 
      echo ($ex_a->vol) * 2;
    } 

    public function call_anggota_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '7' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row();  
 
      echo ($ex_a->vol) * 2 * 3;
    } 

    public function call_staff_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '8' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row();  
 
      echo ($ex_a->vol) * 3;
    } 

     public function call_apar_lalins(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_a = $this->db->query($sql_a)->row(); 
      $resa = (($ex_a->vol) * 2);
      
      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and 
      a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";  
      $ex_b = $this->db->query($sql_b)->row(); 
      $resb = (($ex_b->vol) * 2);

      $sql_c = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '16' ";

      $ex_c = $this->db->query($sql_c)->row(); 
      $sql_d = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '17' ";

      $ex_d = $this->db->query($sql_d)->row();  
      
      $cal = ($resa + $resb + $ex_c->k_ops + $ex_d->k_ops);
      echo $cal;
    } 


   public function call_pml_asmen_pemeliharaaan(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 

      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '25' ";

      $ex_a = $this->db->query($sql_a)->row();  
 
      echo ($ex_a->total);
    } 

    public function call_kebutuhan_pml_grup_a(){
      //7
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

      
      echo $ex_a->vol;
    }

     public function call_kebutuhan_pml_grup_b(){
      //213
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi 
                WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*365);
    }


     public function call_kebutuhan_pml_grup_c(){
      //3
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '72' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo ceil((($ex_a->vol)/12)*4);
    }

    public function call_kebutuhan_pml_grup_d(){
      //9
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '68' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row(); 

     
      //$calculate =ceil(((($ex_a->vol) * ($ex_b->vol) * 105)/100));
      //echo ((intval($ex_a->res_a)) + (intval($ex_a->res_b)) * 90);
      echo (12-($ex_a->vol)+1);
    }


    public function call_pml_jutu_pml(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '26' ";

      $ex_a = $this->db->query($sql_a)->row();  

      echo $ex_a->total;
    }
    public function call_pml_teknisi_inspektor(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '27' ";

      $ex_a = $this->db->query($sql_a)->row();  
      
      echo $ex_a->total;
    }

    public function call_pml_inspeksi_pml(){
 
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
      
      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '26' ";

      $ex_a = $this->db->query($sql_a)->row();  
      
      $sql_b = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '27' ";

      $ex_b = $this->db->query($sql_b)->row();  
      
      echo (($ex_a->k_ops) + ($ex_b->k_ops));
    }

    public function call_pml_bbm_asmens(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 

      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '25' ";

      $ex_a = $this->db->query($sql_a)->row();  
  
      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '50' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_b = $this->db->query($sql_b)->row(); 

     
      echo (($ex_a->total) * ($ex_b->vol));
    } 

    public function call_pml_bbm_inspeksi_pml(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 

      $sql_a = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '26' ";

      $ex_a = $this->db->query($sql_a)->row();  
      
      $sql_b = "select a.sdm_list,b.kantor,b.gt,b.total,b.base,b.ht,
              b.k_ops,b.k_shuttle,b.id_penawaran,b.tahap from m_jlo_sdm_list a
              LEFT JOIN m_jlo_sdm_val b on b.id_jlo_sdm_list = a.id  
              WHERE b.id_penawaran = '".$id_penawaran."' 
              and b.tahap = '".$tahap."' 
              and a.id = '27' ";

      $ex_b = $this->db->query($sql_b)->row();  
      
  
      $sql_c = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '52' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_c = $this->db->query($sql_c)->row();  
     echo ((($ex_a->k_ops) + ($ex_b->k_ops)) * $ex_c->vol);
      //echo (($ex_a->total) * ($ex_b->vol));
    } 

    public function call_pml_ob_kantor(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (($ex_a->vol)*4);
    } 

    public function call_pml_ob_gerbang(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (($ex_a->vol)*4);
    } 

    public function call_pml_kebersihan(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo ($ex_a->vol);
    } 

    public function call_pml_potong_rumput(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '1' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (($ex_a->vol) *2 * 7 * 1000);
    } 
 
    public function call_pml_potong_semak(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '1' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo ((($ex_a->vol) *2 * 7 * 1000)/2);
    } 

    public function call_pml_sum_ac_gardu_toll(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select *,sum(ent_reg) as a,sum(ext_gto_single) as b,sum(ext_rev) as c,sum(ent_gto_multi) as d from m_gardu WHERE id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' ";


      $ex_a = $this->db->query($sql_a)->row();  
      $cal = ($ex_a->a + $ex_a->b + $ex_a->c + (ceil($ex_a->d/2)));
      echo $cal;
    } 
 

   public function call_pml_ac_kantor_gerbang(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (($ex_a->vol)*5);
    } 

     public function call_pml_ac_kantor_operasi(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (($ex_a->vol)*10);
    } 

    public function call_pml_drainase(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '1' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      echo (((($ex_a->vol) *2 * 1000)*30)/100);
    } 

    public function call_pml_plhgenset(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '11' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      
      $sql_b = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '12' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_b = $this->db->query($sql_b)->row();  
 
      echo ($ex_a->vol) + ($ex_b->vol);
    } 

     public function call_pml_sapujalan(){
    
      $id_penawaran = $this->input->post('id_penawaran');
      $tahap = $this->input->post('tahap'); 
 
      $sql_a = "select a.*,b.nama_asumsi from m_asumsi_list a
                LEFT JOIN m_asumsi b on b.id = a.id_asumsi WHERE a.id_asumsi = '1' and a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' ";

      $ex_a = $this->db->query($sql_a)->row();  
      
   echo (($ex_a->vol) *2  * 1000);
  
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

  public function link_setup_penawaran(){
    $penawaran = $this->uri->segment(3);
    $harga = $this->uri->segment(4); 

    $sql = "select * from m_penawaran where id = '".$penawaran."' ";
    
    $data['judul'] = $this->data['judul']; 

    $data['list_praops'] = $this->db->query("SELECT a.*,b.harga,c.nama_harga,d.nama_satuan from m_pricelist a
LEFT JOIN m_harsat_val b on b.id_pricelist = a.id 
LEFT JOIN m_harga c on c.id = b.id_kel_harsat 
LEFT JOIN m_satuan d on d.id = a.id_satuan
WHERE c.id = '".$harga."' and a.id_pelayanan = '1' order by a.id ")->result();

    $data['list_yan_trans'] = $this->db->query("SELECT a.*,b.harga,c.nama_harga,d.nama_satuan from m_pricelist a
LEFT JOIN m_harsat_val b on b.id_pricelist = a.id 
LEFT JOIN m_harga c on c.id = b.id_kel_harsat 
LEFT JOIN m_satuan d on d.id = a.id_satuan
WHERE c.id = '".$harga."' and a.id_pelayanan = '5' order by a.id ")->result();

    $data['list_yan_lalin'] = $this->db->query("SELECT a.*,b.harga,c.nama_harga,d.nama_satuan from m_pricelist a
LEFT JOIN m_harsat_val b on b.id_pricelist = a.id 
LEFT JOIN m_harga c on c.id = b.id_kel_harsat 
LEFT JOIN m_satuan d on d.id = a.id_satuan
WHERE c.id = '".$harga."' and a.id_pelayanan = '6' order by a.id ")->result();

    $data['list_yan_pml'] = $this->db->query("SELECT a.*,b.harga,c.nama_harga,d.nama_satuan from m_pricelist a
LEFT JOIN m_harsat_val b on b.id_pricelist = a.id 
LEFT JOIN m_harga c on c.id = b.id_kel_harsat 
LEFT JOIN m_satuan d on d.id = a.id_satuan
WHERE c.id = '".$harga."' and a.id_pelayanan = '7' order by a.id ")->result();

    $data['list_umum'] = $this->db->query("SELECT a.*,b.harga,c.nama_harga,d.nama_satuan from m_pricelist a
LEFT JOIN m_harsat_val b on b.id_pricelist = a.id 
LEFT JOIN m_harga c on c.id = b.id_kel_harsat 
LEFT JOIN m_satuan d on d.id = a.id_satuan
WHERE c.id = '".$harga."' and a.id_pelayanan = '8' order by a.id ")->result();

    $data['id_penawaran'] = $penawaran;
    $data['tahap'] = $this->db->query($sql)->row();
 
    $this->load->view('setup_penawaran/link_setup_penawaran',$data);
  }


  public function ubah_setup_penawaran(){
    $id_penawaran = $this->uri->segment(3);
    $tahap = $this->uri->segment(4); 
/*select a.*,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan*/
    $sql = "select * from m_penawaran where id = '".$id_penawaran."' ";
    
    $data['judul'] = $this->data['judul']; 

    $data['list_praops'] = $this->db->query("select a.*,b.id_komp_biaya,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan 
where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and c.id = 1 ORDER by b.id ")->result();

    $data['list_yan_trans'] = $this->db->query("select a.*,b.id_komp_biaya,b.id as idku,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan 
where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and c.id = 5 ORDER by b.id ")->result();

    $data['list_yan_lalin'] = $this->db->query("select a.*,b.id_komp_biaya,b.id as idku,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan 
where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and c.id = 6 ORDER by b.id ")->result();

$data['list_yan_pml'] = $this->db->query("select a.*,b.id_komp_biaya,b.id as idku,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan 
where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and c.id = 7 ORDER by b.id ")->result();
 
    $data['list_umum'] = $this->db->query("select a.*,b.nama_pricelist,c.nama_pelayanan,d.nama_komp_biaya,e.nama_satuan from t_harga_penawaran a
LEFT JOIN m_pricelist b on b.id = a.id_pricelist
LEFT JOIN m_jenis_pelayanan c on c.id = b.id_pelayanan
LEFT JOIN m_komp_biaya d on d.id = b.id_komp_biaya
LEFT JOIN m_satuan e on e.id = b.id_satuan 
where a.id_penawaran = '".$id_penawaran."' and a.tahap = '".$tahap."' and c.id = 8 ORDER by b.id ")->result();

    $data['id_penawaran'] = $id_penawaran;
    $data['tahap'] = $id_penawaran;
 
    $this->load->view('setup_penawaran/ubah_setup_penawaran',$data);
  }

  public function get_tahap_val(){
    $id_pe = $this->input->post('id_pe');
    $sql = "select * from m_penawaran where id = '".$id_pe."' ";
    $xsql = $this->db->query($sql)->row();
  
    // Buat variabel untuk menampung tag-tag option nya
    // Set defaultnya dengan tag option Pilih
    if($id_pe == ''){
        $html = "<select name='id_tahapx' id='id_tahapx' class='form-control'>";
        $html .= "<option value=''><p style='background-color:red;'>Kamu tidak dapat memilih penawaran yang kosong!</p></option>"; 
        
        $html .= "</select>"; 
    }else{
      $html = "<select name='id_tahapx' id='id_tahapx' class='form-control'>";
      $html .= "<option value=''>Pilih</option>"; 
      for ($i=1; $i<=$xsql->tahap; $i++) { 
        $html .= "<option value='".$i."'> ".$i." </option>";
      }
      $html .= "</select>"; 
    }
     
    echo $html;
   

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
	 

  public function simpan_data_ubah_praops(){ 

  $cid = count($_POST['id']); 
     

    if($cid > 0)  {

      for($i=0; $i<$cid; $i++){
        $this->db->query("update t_harga_penawaran SET kebutuhan = '".$_POST['kebutuhan'][$i]."', volume = '".$_POST['volume'][$i]."' where id = '".$_POST['id'][$i]."' "); 

        echo $this->db->last_query()."<br>";
      }
        

    } 
    
    echo 1; 
   
  } 

  public function simpan_data_ubah_umum(){ 

  $cid = count($_POST['id']); 
     

    if($cid > 0)  {

      for($i=0; $i<$cid; $i++){
        $this->db->query("update t_harga_penawaran SET kebutuhan = '".$_POST['kebutuhan'][$i]."', volume = '".$_POST['volume'][$i]."' where id = '".$_POST['id'][$i]."' "); 

        echo $this->db->last_query()."<br>";
      }
        

    } 
    
    echo 1; 
   
  } 


public function simpan_data_ubah_pml(){ 
  
  $cid = count($_POST['id']); 
     

    if($cid > 0)  {

      for($i=0; $i<$cid; $i++){
        $this->db->query("update t_harga_penawaran SET kebutuhan = '".$_POST['kebutuhan'][$i]."', volume = '".$_POST['volume'][$i]."' where id = '".$_POST['id'][$i]."' "); 

        echo $this->db->last_query()."<br>";
      }
        

    } 
    
    echo 1; 
   
  } 

   public function simpan_data_ubah_yantrans(){
    
    $cid = count($_POST['id']); 
    
    if($cid > 0)  {

      for($i=0; $i<$cid; $i++){
        $this->db->query("update t_harga_penawaran SET kebutuhan = '".$_POST['kebutuhan'][$i]."', volume = '".$_POST['volume'][$i]."' where id = '".$_POST['id'][$i]."' "); 

        echo $this->db->last_query()."<br>";
      }
        

    } 
    
    echo 1; 
   
  // $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' and id_pelayanan = '".$id_pelayanan."' ")->num_rows();
 
  // if($sqldata > 0){
 
  //   $res = 2;
  
  // }else{
 

  //   if($cid_pricelist > 0)  {

  //     for($i=0; $i<$cid_pricelist; $i++){

  //       $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
  //       values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
  //     }
        

  //   }
  //     $res = 1;
  // } 
  //   echo $res;
  
   
  }

   public function simpan_data_ubah_lalin(){ 

  $cid = count($_POST['id']); 
     

    if($cid > 0)  {

      for($i=0; $i<$cid; $i++){
        $this->db->query("update t_harga_penawaran SET kebutuhan = '".$_POST['kebutuhan'][$i]."', volume = '".$_POST['volume'][$i]."' where id = '".$_POST['id'][$i]."' "); 

        echo $this->db->last_query()."<br>";
      }
        

    } 
    
    echo 1; 
   
  } 

	public function simpan_data_praops(){
 

  $id_pelayanan = $_POST['id_pelayanan'][0];
 
  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaranx'];
  $tahap = $_POST['tahapx'];

 
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."'  and id_pelayanan = '".$id_pelayanan."'  ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }


  public function simpan_data_yantrans(){
 
  $id_pelayanan = $_POST['id_pelayanan'][0];
  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaran_trans'];
  $tahap = $_POST['tahap_trans'];

 
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' and id_pelayanan = '".$id_pelayanan."' ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }

  public function simpan_data_pml(){
 
  $id_pelayanan = $_POST['id_pelayanan'][0];
  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaran_yanpml'];
  $tahap = $_POST['tahap_pml'];

 
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' and id_pelayanan = '".$id_pelayanan."' ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }

  public function simpan_data_umum(){
 
  $id_pelayanan = $_POST['id_pelayanan'][0];
  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaran_umum'];
  $tahap = $_POST['tahap_umum'];

 
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."' and id_pelayanan = '".$id_pelayanan."' ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }

  public function simpan_data_yanlalin(){
 

  $id_pelayanan = $_POST['id_pelayanan'][0];
 
  $cid_pricelist = count($_POST['id_pricelist']); 
  $id_penawaran = $_POST['id_penawaran_lalin'];
  $tahap = $_POST['tahap_lalin'];

 
  $sqldata = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$id_penawaran."' and tahap = '".$tahap."'  and id_pelayanan = '".$id_pelayanan."'  ")->num_rows();
  // $sqldata = $this->db->where('id_penawaran',$id_pe)->get('m_jlo_sdm_list')->num_rows();
  if($sqldata > 0){
    //data sudah ada
    $res = 2;
  
  }else{
    //masukkan data jika belum ada

    if($cid_pricelist > 0)  {

      for($i=0; $i<$cid_pricelist; $i++){

        $data = $this->db->query("insert into t_harga_penawaran (id_penawaran,tahap,value_harsat,id_pricelist,id_pelayanan,kebutuhan,volume) 
        values ('".$id_penawaran."','".$tahap."','".$_POST['harga'][$i]."','".$_POST['id_pricelist'][$i]."','".$id_pelayanan."','".$_POST['kebutuhan'][$i]."','".$_POST['volume'][$i]."')");
        
      }
        

    }
      $res = 1;
  } 
    echo $res;
  
   
  }

  

  // public function print_all_to_excel(){
  //  $this->load->library('excel');
    
   
  // }



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
           foreach($getdata as $row){  
    
                // $sqlb = $this->db->query("select * from t_harga_penawaran where id_penawaran = '".$row->id_penawaran."' group by tahap ")->result();
                // $return = '';
 
                // foreach ($sqlb as $post) {
                //   $title = $post->tahap; 
                //   $return .= '<li><a href="javascript:void(0);">'.$title.'</a></li>';
                // }
//return $return;
               
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_penawaran."<a href='".base_url('setup_penawaran/print_all_to_excel/'.$row->id_penawaran)."' target='_blank'>   Download Excel <i class='material-icons'>open_in_new</i> </a>";  
                $sub_array[] = $row->tahap;
  
                $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="UbahDataPopup('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">create</i> Ubah </a>     &nbsp;<a href="javascript:void(0)" class="btn btn-primary btn-xs waves-effect" id="detail" onclick="Detail_HP('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">all_out</i> Detail </a>     &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id_penawaran.','.$row->tahap.');" > <i class="material-icons">delete</i> Hapus </a>  ';  
               
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




  public function print_all_to_excel(){
  $id_penawaran = $this->uri->segment(3);

  $get_tahap_byquery = $this->db->where('id',$id_penawaran)->get("m_penawaran")->row();
  //var_dump($get_tahap_byquery);
  //exit();

  $tahap = $get_tahap_byquery->tahap;
  
  // aktivasi module spreadsheet
  $spreadsheet = new Spreadsheet(); 

  //setting sheet nya
  $myWorkSheetPraops = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Praops'); //4
  $myWorkSheetYanTrans = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanTrans'); //5
  $myWorkSheetYanLalin = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanLalin'); //6
  $myWorkSheetYanPML = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanPML'); //7

  $myWorkSheetUmum = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Umum'); //8
  $myWorkSheetRekap = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Rekapitulasi Penawaran'); // 0
  $myWorkSheetAsumsi = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Asumsi');  //1
  $myWorkSheetGardu = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Gardu'); //3
  $myWorkSheetJLO = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'JLO'); //2


  //ini buat setting cellborder
  $stylecelldoang = [ 
     
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],

        ], 
    ],
    
  ];

  $styleArray = [ 
    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],

        ], 
    ],
    
  ];

  $contentcenter= [ 
    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],

        ], 
    ],
    
  ];
   $styleArrayheaderJLO = [ 
    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],

        ], 
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'rotation' => 90,
        'color' => [
            'rgb' => 'ffff00'
        ] 
         
    ],
    
  ];

  $styleheadcatjlo = [ 
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
         
        'color' => [
            'rgb' => 'ddebf7'
        ],

         
    ],
     'font' => [
          'color' =>  [
                    'rgb' => '000000'
                      ],
         'bold' => true,
    ],
  ];

  $styleArrayheadrekap = [ 
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'rotation' => 90,
        'color' => [
            'rgb' => 'ffff00'
        ] 
         
    ],
     'font' => [
        'bold' => true,
    ],
  
  ];

  $stylebold = [ 
     'font' => [
        'bold' => true,
    ],
  ];
  $stylebottom = [ 
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
         
        'color' => [
            'rgb' => '333f4f'
        ],

         
    ],
     'font' => [
          'color' =>  [
                    'rgb' => 'ffffff'
                      ],
         'bold' => true,
    ],
  ];
  $stylebold14 = [ 
     'font' => [
        'bold' => true,
        'size'=>14
    ],
 
  ];
    
  //ambil penawaran, ada berapa tahap di penawaran itu

  $sqlpe_thp = $this->db->query("select * from m_penawaran where id = '".$id_penawaran."' ")->row();

  //INI SHEET BUAT REKAP
  
  //INI BUAT AMBIL SHEET  REKAP
  if($tahap == '1'){

    //ambil rekap nya 1 tahap
    $sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yantrans = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

  $spreadsheet->addSheet($myWorkSheetRekap, 0);
  $spreadsheet->setActiveSheetIndex(0);

  $sheet = $spreadsheet->getActiveSheet();
  
  $spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
  $spreadsheet->getActiveSheet()->mergeCells('A2:D2');

  $spreadsheet->getActiveSheet()->mergeCells('A16:B16');
  $spreadsheet->getActiveSheet()->mergeCells('A17:B17');
  $spreadsheet->getActiveSheet()->mergeCells('A18:B18');
  $spreadsheet->getActiveSheet()->mergeCells('A19:B19');
  $spreadsheet->getActiveSheet()->mergeCells('A20:B20');
  $spreadsheet->getActiveSheet()->mergeCells('A21:B21'); 
   

  $spreadsheet->getActiveSheet()->getStyle('A1:D15')->applyFromArray($styleArray);

  $spreadsheet->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleArrayheadrekap);
  $spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A10')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold14);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold14);
  $spreadsheet->getActiveSheet()->getStyle('A15:D15')->applyFromArray($stylebottom);
 
  $spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:B10');
    
    $spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue(number_format($sql_tahap1_praops->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue(number_format($sql_tahap1_yantrans->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue(number_format($sql_tahap1_yanlalin->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue(number_format($sql_tahap1_yanpml->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue(number_format($sql_tahap1_umum->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');


    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
      $sql_tahap1_praops_val = 0;
    }else{
      $sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
      $sql_tahap1_yantrans_val = 0;
    }else{
      $sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
      $sql_tahap1_yanlalin_val = 0;
    }else{
      $sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
      $sql_tahap1_yanpml_val = 0;
    }else{
      $sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
      $sql_tahap1_umum_val = 0;
    }else{
      $sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }
 

    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val);

    $manfee = ($subtotal * 8)/100;
    $submanfeetotal = $subtotal + $manfee;

    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C10')
    ->setValue(number_format($subtotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D10')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('Management Fee (8%) '); 
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue(number_format($manfee));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue(number_format($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue(number_format(ceil($submanfeetotal)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue(number_format(ceil(($submanfeetotal)*10/100)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue(number_format(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue(''); 
 
     
  $spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

     
  }elseif ($tahap == '2') {
    //ambil rekap nya 1 tahap

    //SECTION TAHAP 1
    $sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yantrans = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    //SECTION TAHAP 2
    $sql_tahap2_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yantrans = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

  $spreadsheet->addSheet($myWorkSheetRekap, 0);
  $spreadsheet->setActiveSheetIndex(0);

  $sheet = $spreadsheet->getActiveSheet();

  $spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
  $spreadsheet->getActiveSheet()->mergeCells('A2:D2');

  $spreadsheet->getActiveSheet()->mergeCells('A16:B16');
  $spreadsheet->getActiveSheet()->mergeCells('A17:B17');
  $spreadsheet->getActiveSheet()->mergeCells('A18:B18');
  $spreadsheet->getActiveSheet()->mergeCells('A19:B19');
  $spreadsheet->getActiveSheet()->mergeCells('A20:B20');
  $spreadsheet->getActiveSheet()->mergeCells('A21:B21'); 
   

  $spreadsheet->getActiveSheet()->getStyle('A1:D21')->applyFromArray($styleArray);


   

  $spreadsheet->getActiveSheet()->getStyle('A3:D3')->applyFromArray($styleArrayheadrekap);
  $spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A10')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A16')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('C16')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold14);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold14);
  $spreadsheet->getActiveSheet()->getStyle('A21:D21')->applyFromArray($stylebottom);
 


  $spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:D10');
    
    $spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue(number_format($sql_tahap1_praops->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue(number_format($sql_tahap1_yantrans->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue(number_format($sql_tahap1_yanlalin->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue(number_format($sql_tahap1_yanpml->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue(number_format($sql_tahap1_umum->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');

  
    
    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Tahap 2');

     $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B11')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue(number_format($sql_tahap2_praops->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B12')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue(number_format($sql_tahap2_yantrans->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B13')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue(number_format($sql_tahap2_yanlalin->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B14')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue(number_format($sql_tahap2_yanpml->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B15')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue(number_format($sql_tahap2_umum->semua));
    $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue(''); 

    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
      $sql_tahap1_praops_val = 0;
    }else{
      $sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
      $sql_tahap1_yantrans_val = 0;
    }else{
      $sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
      $sql_tahap1_yanlalin_val = 0;
    }else{
      $sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
      $sql_tahap1_yanpml_val = 0;
    }else{
      $sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
      $sql_tahap1_umum_val = 0;
    }else{
      $sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }

    if($sql_tahap2_praops->semua == NULL || $sql_tahap2_praops->semua == ''){
      $sql_tahap2_praops_val = 0;
    }else{
      $sql_tahap2_praops_val = $sql_tahap2_praops->semua;
    }
    
    if($sql_tahap2_yantrans->semua == NULL || $sql_tahap2_yantrans->semua == ''){
      $sql_tahap2_yantrans_val = 0;
    }else{
      $sql_tahap2_yantrans_val = $sql_tahap2_yantrans->semua;
    }

    if($sql_tahap2_yanlalin->semua == NULL || $sql_tahap2_yanlalin->semua == ''){
      $sql_tahap2_yanlalin_val = 0;
    }else{
      $sql_tahap2_yanlalin_val = $sql_tahap2_yanlalin->semua;
    }

    if($sql_tahap2_yanpml->semua == NULL || $sql_tahap2_yanpml->semua == ''){
      $sql_tahap2_yanpml_val = 0;
    }else{
      $sql_tahap2_yanpml_val = $sql_tahap2_yanpml->semua;
    }

    if($sql_tahap2_umum->semua == NULL || $sql_tahap2_umum->semua == ''){
      $sql_tahap2_umum_val = 0;
    }else{
      $sql_tahap2_umum_val = $sql_tahap2_umum->semua;
    }


    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val) + intval($sql_tahap2_praops_val) + intval($sql_tahap2_yantrans_val) + intval($sql_tahap2_yanlalin_val) + intval($sql_tahap2_yanpml_val) + intval($sql_tahap2_umum_val);
    $manfee = ($subtotal * 8)/100;
    $submanfeetotal = $subtotal + $manfee;
    $spreadsheet->getActiveSheet()
    ->getCell('A16')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C16')
    ->setValue(number_format($subtotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D16')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A17')
    ->setValue('Management Fee (8%) '); 
    $spreadsheet->getActiveSheet()
    ->getCell('C17')
    ->setValue(number_format($manfee));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D17')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A18')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C18')
    ->setValue(number_format($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D18')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A19')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C19')
    ->setValue(number_format(ceil($submanfeetotal)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D19')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A20')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C20')
    ->setValue(number_format(ceil(($submanfeetotal)*10/100)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D20')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A21')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C21')
    ->setValue(number_format(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100)));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D21')
    ->setValue(''); 
 

     
  $spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

  }elseif ($tahap == '3') {
    //ambil rekap nya 3 tahap 

    //SECTION TAHAP 1
    $sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yantrans = $this->db->query("SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    $sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '1'  ")->row();

    //SECTION TAHAP 2
    $sql_tahap2_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yantrans = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    $sql_tahap2_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '2'  ")->row();

    //SECTION TAHAP 3
    $sql_tahap3_praops = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '1'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '3'  ")->row();

    $sql_tahap3_yantrans = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '5'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '3'  ")->row();

    $sql_tahap3_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '6'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '3'  ")->row();

    $sql_tahap3_yanpml = $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '7'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '3'  ")->row();

    $sql_tahap3_umum =  $this->db->query(" SELECT b.nama_pricelist,
         a.kebutuhan,
         e.nama_satuan,
         c.harga,
         ( a.kebutuhan * c.harga ) AS jumlahuraian,
         a.volume,
         ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
         sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
      FROM   t_harga_penawaran a
             LEFT JOIN m_pricelist b
                    ON b.id = a.id_pricelist
             LEFT JOIN m_harsat_val c
                    ON c.id_pricelist = b.id
             LEFT JOIN m_harga d
                    ON d.id = c.id_kel_harsat
             LEFT JOIN m_satuan e
                    ON e.id = b.id_satuan
      WHERE  a.id_pelayanan = '8'
             AND a.id_penawaran = '".$id_penawaran."'
             AND a.tahap = '3'  ")->row();

    $spreadsheet->addSheet($myWorkSheetRekap, 0);
  $spreadsheet->setActiveSheetIndex(0);

  $sheet = $spreadsheet->getActiveSheet();

  $spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
  $spreadsheet->getActiveSheet()->mergeCells('A2:D2');

  $spreadsheet->getActiveSheet()->mergeCells('A22:B22');
  $spreadsheet->getActiveSheet()->mergeCells('A23:B23');
  $spreadsheet->getActiveSheet() ->mergeCells('A24:B24');
  $spreadsheet->getActiveSheet()->mergeCells('A25:B25');
  $spreadsheet->getActiveSheet()->mergeCells('A26:B26');
  $spreadsheet->getActiveSheet()->mergeCells('A27:B27'); 
   

  $spreadsheet->getActiveSheet()->getStyle('A1:D27')->applyFromArray($styleArray);
  $spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:D10');
    $spreadsheet->getActiveSheet()->mergeCells('A16:D16');
    
    $spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue($sql_tahap1_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue($sql_tahap1_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue($sql_tahap1_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue($sql_tahap1_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue($sql_tahap1_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');

  
    
    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Tahap 2');

     $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B11')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue($sql_tahap2_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B12')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue($sql_tahap2_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B13')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue($sql_tahap2_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B14')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue($sql_tahap2_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B15')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue($sql_tahap2_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A16')
    ->setValue('Tahap 3');

    $spreadsheet->getActiveSheet()
    ->getCell('A17')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B17')
   ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C17')
    ->setValue($sql_tahap3_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D17')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A18')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B18')
     ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C18')
    ->setValue($sql_tahap3_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D18')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A19')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B19')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C19')
    ->setValue($sql_tahap3_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D19')
    ->setValue(''); 

     $spreadsheet->getActiveSheet()
    ->getCell('A20')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B20')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C20')
    ->setValue($sql_tahap3_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D20')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A21')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B21')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C21')
    ->setValue($sql_tahap3_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D21')
    ->setValue(''); 

    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
      $sql_tahap1_praops_val = 0;
    }else{
      $sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
      $sql_tahap1_yantrans_val = 0;
    }else{
      $sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
      $sql_tahap1_yanlalin_val = 0;
    }else{
      $sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
      $sql_tahap1_yanpml_val = 0;
    }else{
      $sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
      $sql_tahap1_umum_val = 0;
    }else{
      $sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }

    if($sql_tahap2_praops->semua == NULL || $sql_tahap2_praops->semua == ''){
      $sql_tahap2_praops_val = 0;
    }else{
      $sql_tahap2_praops_val = $sql_tahap2_praops->semua;
    }
    
    if($sql_tahap2_yantrans->semua == NULL || $sql_tahap2_yantrans->semua == ''){
      $sql_tahap2_yantrans_val = 0;
    }else{
      $sql_tahap2_yantrans_val = $sql_tahap2_yantrans->semua;
    }

    if($sql_tahap2_yanlalin->semua == NULL || $sql_tahap2_yanlalin->semua == ''){
      $sql_tahap2_yanlalin_val = 0;
    }else{
      $sql_tahap2_yanlalin_val = $sql_tahap2_yanlalin->semua;
    }

    if($sql_tahap2_yanpml->semua == NULL || $sql_tahap2_yanpml->semua == ''){
      $sql_tahap2_yanpml_val = 0;
    }else{
      $sql_tahap2_yanpml_val = $sql_tahap2_yanpml->semua;
    }

    if($sql_tahap2_umum->semua == NULL || $sql_tahap2_umum->semua == ''){
      $sql_tahap2_umum_val = 0;
    }else{
      $sql_tahap2_umum_val = $sql_tahap2_umum->semua;
    }

    if($sql_tahap3_praops->semua == NULL || $sql_tahap3_praops->semua == ''){
      $sql_tahap3_praops_val = 0;
    }else{
      $sql_tahap3_praops_val = $sql_tahap3_praops->semua;
    }
    
    if($sql_tahap3_yantrans->semua == NULL || $sql_tahap3_yantrans->semua == ''){
      $sql_tahap3_yantrans_val = 0;
    }else{
      $sql_tahap3_yantrans_val = $sql_tahap3_yantrans->semua;
    }

    if($sql_tahap3_yanlalin->semua == NULL || $sql_tahap3_yanlalin->semua == ''){
      $sql_tahap3_yanlalin_val = 0;
    }else{
      $sql_tahap3_yanlalin_val = $sql_tahap3_yanlalin->semua;
    }

    if($sql_tahap3_yanpml->semua == NULL || $sql_tahap3_yanpml->semua == ''){
      $sql_tahap3_yanpml_val = 0;
    }else{
      $sql_tahap3_yanpml_val = $sql_tahap3_yanpml->semua;
    }

    if($sql_tahap3_umum->semua == NULL || $sql_tahap3_umum->semua == ''){
      $sql_tahap3_umum_val = 0;
    }else{
      $sql_tahap3_umum_val = $sql_tahap2_umum->semua;
    }


    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val) + intval($sql_tahap2_praops_val) + intval($sql_tahap2_yantrans_val) + intval($sql_tahap2_yanlalin_val) + intval($sql_tahap2_yanpml_val) + intval($sql_tahap2_umum_val) +  intval($sql_tahap3_praops_val) + intval($sql_tahap3_yantrans_val) + intval($sql_tahap3_yanlalin_val) + intval($sql_tahap3_yanpml_val) + intval($sql_tahap3_umum_val);

    $manfee = ($subtotal * 8)/100;

    $submanfeetotal = $subtotal + $manfee;

    $spreadsheet->getActiveSheet()
    ->getCell('A22')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C22')
    ->setValue($subtotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D22')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A23')
    ->setValue('Management Fee (8%) '); 
    $spreadsheet->getActiveSheet()
    ->getCell('C23')
    ->setValue($manfee);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D23')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A24')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C24')
    ->setValue($submanfeetotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D24')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A25')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C25')
    ->setValue(ceil($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D25')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A26')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C26')
    ->setValue(ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D26')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A27')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C27')
    ->setValue(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D27')
    ->setValue(''); 
  $spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

  }
  
  
  //GANTI SHEET, INI SHEET NYA ASUMSI

  $spreadsheet->addSheet($myWorkSheetAsumsi, 1);
  $spreadsheet->setActiveSheetIndex(1);
  
  $sheet = $spreadsheet->getActiveSheet();
  $spreadsheet->getActiveSheet()->mergeCells('A1:L1');
  $spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('ASUMSI PERHITUNGAN PENAWARAN PT JMTO UNTUK :'); 
 
   
  //kondisi si asumsi ini berapa?
 

  if($tahap == '1'){
    $spreadsheet->getActiveSheet()->getStyle('A2:F46')->applyFromArray($styleArray);
    $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

      $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
      $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

    $sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
      LEFT JOIN m_asumsi b on b.id = a.id_asumsi
      LEFT JOIN m_satuan c on c.id = b.id_satuan 
      WHERE a.id_penawaran = '".$id_penawaran."' 
      and a.tahap = 1 ")->result();

    foreach (range(1,1) as $i) {
     
     $row = 4;
     $nourut = 1;
     foreach ($sqlasumsitahap1 as $keys => $values) {
      $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
      $sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
      $sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
      $sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
      $sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
     $nourut++;
     $row++;
     } 
      
    }  

  }elseif ($tahap == '2') {

    $spreadsheet->getActiveSheet()->getStyle('A2:L46')->applyFromArray($styleArray);
    $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

      $spreadsheet->getActiveSheet()->mergeCells('H2:M2');
      $spreadsheet->getActiveSheet()->getCell('H2')->setValue('Tahap 2');

      $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
      $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

 
      $spreadsheet->getActiveSheet()->getCell('H3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('I3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('L3')->setValue('Keterangan'); 

    $sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 ")->result();


    $sqlasumsitahap2 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 ")->result();

   

    foreach (range(1,2) as $i) {
     
     $row = 4;
     $nourut = 1;
     foreach ($sqlasumsitahap1 as $keys => $values) {
      $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
      $sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
      $sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
      $sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
      $sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
     $nourut++;
     $row++;
     }

     $rowx = 4;
     $nourutx = 1;
     foreach ($sqlasumsitahap2 as $keyx => $valuex) {
 
      $sheet->setCellValueByColumnAndRow(8, $rowx, $valuex->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(9, $rowx, $valuex->vol);
      $sheet->setCellValueByColumnAndRow(10, $rowx, $valuex->nama_satuan);
      $sheet->setCellValueByColumnAndRow(11, $rowx, $valuex->safety_factor);
      $sheet->setCellValueByColumnAndRow(12, $rowx, $valuex->keterangan);
     $nourutx++;
     $rowx++;
     }

     
      
      
    }  


      
  }elseif ($tahap == '3') {
     $spreadsheet->getActiveSheet()->getStyle('A2:R46')->applyFromArray($styleArray);

    $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

      $spreadsheet->getActiveSheet()->mergeCells('H2:M2');
      $spreadsheet->getActiveSheet()->getCell('H2')->setValue('Tahap 2');

      $spreadsheet->getActiveSheet()->mergeCells('N2:R2');
      $spreadsheet->getActiveSheet()->getCell('N2')->setValue('Tahap 3');

      $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
      $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

 
      $spreadsheet->getActiveSheet()->getCell('H3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('I3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('L3')->setValue('Keterangan'); 

      $spreadsheet->getActiveSheet()->getCell('N3')->setValue('Uraian');
      $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Volume');
      $spreadsheet->getActiveSheet()->getCell('P3')->setValue('Satuan');
      $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('Safety Factor');
      $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Keterangan'); 

    $sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 ")->result();


    $sqlasumsitahap2 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 ")->result();

    $sqlasumsitahap3 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 ")->result();

   

    foreach (range(1,3) as $i) {
     
     $row = 4;
     $nourut = 1;
     foreach ($sqlasumsitahap1 as $keys => $values) {
      $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
      $sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
      $sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
      $sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
      $sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
     $nourut++;
     $row++;
     }

     $rowx = 4;
     $nourutx = 1;
     foreach ($sqlasumsitahap2 as $keyx => $valuex) {
 
      $sheet->setCellValueByColumnAndRow(8, $rowx, $valuex->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(9, $rowx, $valuex->vol);
      $sheet->setCellValueByColumnAndRow(10, $rowx, $valuex->nama_satuan);
      $sheet->setCellValueByColumnAndRow(11, $rowx, $valuex->safety_factor);
      $sheet->setCellValueByColumnAndRow(12, $rowx, $valuex->keterangan);
     $nourutx++;
     $rowx++;
     }

     $rowy = 4;
     $nouruty = 1;
     foreach ($sqlasumsitahap3 as $keyy => $valuey) {
 
      $sheet->setCellValueByColumnAndRow(14, $rowy, $valuey->nama_asumsi);
      $sheet->setCellValueByColumnAndRow(15, $rowy, $valuey->vol);
      $sheet->setCellValueByColumnAndRow(16, $rowy, $valuey->nama_satuan);
      $sheet->setCellValueByColumnAndRow(17, $rowy, $valuey->safety_factor);
      $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->keterangan);
     $nouruty++;
     $rowy++;
     }

     
      
      
    }  


  }


  $spreadsheet->getActiveSheet()->setTitle("Asumsi");

  //DISINI JLO SDM 2

  $spreadsheet->addSheet($myWorkSheetJLO, 2);
  $spreadsheet->setActiveSheetIndex(2);
   
  $sheet = $spreadsheet->getActiveSheet(); 
  if($tahap == 1){

  }elseif ($tahap == 2) {
     
  }elseif ($tahap == 3) {
     
  }
 
  $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
  $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A3:I4')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A3:I4')->applyFromArray($styleArrayheaderJLO);
 

  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
  $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
 

  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('RENCANA KARYAWAN PT.JMTO');
  $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
  
  $spreadsheet->getActiveSheet()->mergeCells('A3:A4'); 
  $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
  $spreadsheet->getActiveSheet()->mergeCells('C3:E3');
  $spreadsheet->getActiveSheet()->mergeCells('F3:I3');
  $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
  $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Jabatan');
  $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Jumlah Personel');
  $spreadsheet->getActiveSheet()->getCell('F3')->setValue('Fasilitas');
  $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kantor');
  $spreadsheet->getActiveSheet()->getCell('D4')->setValue('GT');
  $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Total');
  $spreadsheet->getActiveSheet()->getCell('F4')->setValue('HT');
  $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Base');
  $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Kendaraan Operasional');
  $spreadsheet->getActiveSheet()->getCell('I4')->setValue('Kendaraan Shuttle');



      $sqljlosdmtahap1 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1");

   
      $countjlosdm1 = $sqljlosdmtahap1->num_rows();
     
        $rowsdm = 5;
        $nourutsdm = 1;
        $tempHeadsdm = ""; 

        $sgtsdm = 0;
        $skantorsdm = 0;
        $stotalsdm = 0;
        $shtsdm = 0;

        $sbasesdm = 0;
        $sk_opssdm = 0;
        $sk_shuttlesdm = 0;
       
        foreach ($sqljlosdmtahap1->result() as $key => $value) {

          $resultjlo1 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and c.id = '".$value->id_cat."' ")->row();
        
        
          $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm.':I'.$rowsdm)->applyFromArray($stylecelldoang);
         
            if($tempHeadsdm == "" || $tempHeadsdm != $value->cat_jlo_sdm) {  
              
              $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm.':I'.$rowsdm);
              $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm)->applyFromArray($styleheadcatjlo);
              $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm.':I'.$rowsdm)->applyFromArray($contentcenter);

              $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm)->setValue($value->cat_jlo_sdm);
           
              $rowsdm++;
            }
         
           
          $sheet->setCellValueByColumnAndRow(1, $rowsdm, $nourutsdm);
          $sheet->setCellValueByColumnAndRow(2, $rowsdm, $value->sdm_list);
          $sheet->setCellValueByColumnAndRow(3, $rowsdm, $value->gt);
          $sheet->setCellValueByColumnAndRow(4, $rowsdm, $value->kantor);
          $sheet->setCellValueByColumnAndRow(5, $rowsdm, $value->total);
          $sheet->setCellValueByColumnAndRow(6, $rowsdm, $value->ht);
          $sheet->setCellValueByColumnAndRow(7, $rowsdm, $value->base);
          $sheet->setCellValueByColumnAndRow(8, $rowsdm, $value->k_ops);
          $sheet->setCellValueByColumnAndRow(9, $rowsdm, $value->k_shuttle);
          $sgtsdm += $value->gt;
          $skantorsdm += $value->kantor;
          $stotalsdm += $value->total;
          $shtsdm += $value->ht;

          $sbasesdm += $value->base;
          $sk_opssdm += $value->k_ops;
          $sk_shuttlesdm += $value->k_shuttle;
          $tempHeadsdm = $value->cat_jlo_sdm;
          $nourutsdm++;
          $rowsdm++;
         
      }


      //TOTAL JLO 1
      $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm.':B'.$rowsdm);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm.':I'.$rowsdm)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm)->applyFromArray($stylebold);
     
      $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm)->setValue("TOTAL"); 
      $spreadsheet->getActiveSheet()->getCell('C'.$rowsdm)->setValue($sgtsdm); 
  
      $spreadsheet->getActiveSheet()->getCell('D'.$rowsdm)->setValue($skantorsdm); 
      $spreadsheet->getActiveSheet()->getCell('E'.$rowsdm)->setValue($stotalsdm); 
      $spreadsheet->getActiveSheet()->getCell('F'.$rowsdm)->setValue($shtsdm); 
      $spreadsheet->getActiveSheet()->getCell('G'.$rowsdm)->setValue($sbasesdm); 
      $spreadsheet->getActiveSheet()->getCell('H'.$rowsdm)->setValue($sk_opssdm);
      $spreadsheet->getActiveSheet()->getCell('I'.$rowsdm)->setValue($sk_shuttlesdm); 
  
    

      //tahap 2 JLO
      $newlinesdm2 = $rowsdm + 2;

       $spreadsheet->getActiveSheet()->getCell('A'.$newlinesdm2)->setValue('Tahap 2');
      $spreadsheet->getActiveSheet()->mergeCells('A'.$newlinesdm2.':I'.$newlinesdm2);
  
      $spreadsheet->getActiveSheet()->getStyle('A'.$newlinesdm2)->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm2+1))->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm2+1).':I'.($newlinesdm2+2))->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm2+1).':I'.($newlinesdm2+2))->applyFromArray($styleArrayheaderJLO);


  
      $spreadsheet->getActiveSheet()->mergeCells('A'.($newlinesdm2+1).':A'.($newlinesdm2+2)); 
      $spreadsheet->getActiveSheet()->mergeCells('B'.($newlinesdm2+1).':B'.($newlinesdm2+2));
      $spreadsheet->getActiveSheet()->mergeCells('C'.($newlinesdm2+1).':E'.($newlinesdm2+1));
      $spreadsheet->getActiveSheet()->mergeCells('F'.($newlinesdm2+1).':I'.($newlinesdm2+1));
      $spreadsheet->getActiveSheet()->getCell('A'.($newlinesdm2+1))->setValue('No');
      $spreadsheet->getActiveSheet()->getCell('B'.($newlinesdm2+1))->setValue('Jabatan');
      $spreadsheet->getActiveSheet()->getCell('C'.($newlinesdm2+1))->setValue('Jumlah Personel');
      $spreadsheet->getActiveSheet()->getCell('F'.($newlinesdm2+1))->setValue('Fasilitas');
      $spreadsheet->getActiveSheet()->getCell('C'.($newlinesdm2+2))->setValue('Kantor');
      $spreadsheet->getActiveSheet()->getCell('D'.($newlinesdm2+2))->setValue('GT');
      $spreadsheet->getActiveSheet()->getCell('E'.($newlinesdm2+2))->setValue('Total');
      $spreadsheet->getActiveSheet()->getCell('F'.($newlinesdm2+2))->setValue('HT');
      $spreadsheet->getActiveSheet()->getCell('G'.($newlinesdm2+2))->setValue('Base');
      $spreadsheet->getActiveSheet()->getCell('H'.($newlinesdm2+2))->setValue('Kendaraan Operasional');
      $spreadsheet->getActiveSheet()->getCell('I'.($newlinesdm2+2))->setValue('Kendaraan Shuttle');


 $sqljlosdmtahap2 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2");

    $countjlosdm2 = $sqljlosdmtahap2->num_rows();
        $rowsdm2 = $newlinesdm2+3;
        $nourutsdm2 = 1;
        $tempHeadsdm2 = ""; 

        $sgtsdm2 = 0;
        $skantorsdm2 = 0;
        $stotalsdm2 = 0;
        $shtsdm2 = 0;

        $sbasesdm2 = 0;
        $sk_opssdm2 = 0;
        $sk_shuttlesdm2 = 0;
 

    foreach ($sqljlosdmtahap2->result() as $keysdm2 => $valuesdm2) {

          $resultjlosdm2 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and c.id = '".$valuesdm2->id_cat."' ")->row();
        
        
          $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm2.':I'.$rowsdm2)->applyFromArray($stylecelldoang);
         
            if($tempHeadsdm2 == "" || $tempHeadsdm2 != $valuesdm2->cat_jlo_sdm) {  
              
              $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm2.':I'.$rowsdm2);
              $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm2)->applyFromArray($styleheadcatjlo);
              $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm2.':I'.$rowsdm2)->applyFromArray($contentcenter);

              $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm2)->setValue($valuesdm2->cat_jlo_sdm);
           
              $rowsdm2++;
            }
         
           
          $sheet->setCellValueByColumnAndRow(1, $rowsdm2, $nourutsdm2);
          $sheet->setCellValueByColumnAndRow(2, $rowsdm2, $valuesdm2->sdm_list);
          $sheet->setCellValueByColumnAndRow(3, $rowsdm2, $valuesdm2->gt);
          $sheet->setCellValueByColumnAndRow(4, $rowsdm2, $valuesdm2->kantor);
          $sheet->setCellValueByColumnAndRow(5, $rowsdm2, $valuesdm2->total);
          $sheet->setCellValueByColumnAndRow(6, $rowsdm2, $valuesdm2->ht);
          $sheet->setCellValueByColumnAndRow(7, $rowsdm2, $valuesdm2->base);
          $sheet->setCellValueByColumnAndRow(8, $rowsdm2, $valuesdm2->k_ops);
          $sheet->setCellValueByColumnAndRow(9, $rowsdm2, $valuesdm2->k_shuttle);
          $sgtsdm2 += $valuesdm2->gt;
          $skantorsdm2 += $valuesdm2->kantor;
          $stotalsdm2 += $valuesdm2->total;
          $shtsdm2 += $valuesdm2->ht;

          $sbasesdm2 += $valuesdm2->base;
          $sk_opssdm2 += $valuesdm2->k_ops;
          $sk_shuttlesdm2 += $valuesdm2->k_shuttle;
          $tempHeadsdm2 = $valuesdm2->cat_jlo_sdm;
          $nourutsdm2++;
          $rowsdm2++;
         
      }
     

      //TOTAL JLO 2
      $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm2.':B'.$rowsdm2);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm2)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm2.':I'.$rowsdm2)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm2)->applyFromArray($stylebold);
     
      $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm2)->setValue("TOTAL"); 
      $spreadsheet->getActiveSheet()->getCell('C'.$rowsdm2)->setValue($sgtsdm2); 
  
      $spreadsheet->getActiveSheet()->getCell('D'.$rowsdm2)->setValue($skantorsdm2); 
      $spreadsheet->getActiveSheet()->getCell('E'.$rowsdm2)->setValue($stotalsdm2); 
      $spreadsheet->getActiveSheet()->getCell('F'.$rowsdm2)->setValue($shtsdm2); 
      $spreadsheet->getActiveSheet()->getCell('G'.$rowsdm2)->setValue($sbasesdm2); 
      $spreadsheet->getActiveSheet()->getCell('H'.$rowsdm2)->setValue($sk_opssdm2);
      $spreadsheet->getActiveSheet()->getCell('I'.$rowsdm2)->setValue($sk_shuttlesdm2); 
  

      //tahap 3 JLO
      $newlinesdm3 = $rowsdm2 + 2;

       $spreadsheet->getActiveSheet()->getCell('A'.$newlinesdm3)->setValue('Tahap 3');
      $spreadsheet->getActiveSheet()->mergeCells('A'.$newlinesdm3.':I'.$newlinesdm3);
  
      $spreadsheet->getActiveSheet()->getStyle('A'.$newlinesdm3)->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm3+1))->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm3+1).':I'.($newlinesdm3+2))->applyFromArray($stylebold);
      $spreadsheet->getActiveSheet()->getStyle('A'.($newlinesdm3+1).':I'.($newlinesdm3+2))->applyFromArray($styleArrayheaderJLO);


  
      $spreadsheet->getActiveSheet()->mergeCells('A'.($newlinesdm3+1).':A'.($newlinesdm3+2)); 
      $spreadsheet->getActiveSheet()->mergeCells('B'.($newlinesdm3+1).':B'.($newlinesdm3+2));
      $spreadsheet->getActiveSheet()->mergeCells('C'.($newlinesdm3+1).':E'.($newlinesdm3+1));
      $spreadsheet->getActiveSheet()->mergeCells('F'.($newlinesdm3+1).':I'.($newlinesdm3+1));
      $spreadsheet->getActiveSheet()->getCell('A'.($newlinesdm3+1))->setValue('No');
      $spreadsheet->getActiveSheet()->getCell('B'.($newlinesdm3+1))->setValue('Jabatan');
      $spreadsheet->getActiveSheet()->getCell('C'.($newlinesdm3+1))->setValue('Jumlah Personel');
      $spreadsheet->getActiveSheet()->getCell('F'.($newlinesdm3+1))->setValue('Fasilitas');
      $spreadsheet->getActiveSheet()->getCell('C'.($newlinesdm3+2))->setValue('Kantor');
      $spreadsheet->getActiveSheet()->getCell('D'.($newlinesdm3+2))->setValue('GT');
      $spreadsheet->getActiveSheet()->getCell('E'.($newlinesdm3+2))->setValue('Total');
      $spreadsheet->getActiveSheet()->getCell('F'.($newlinesdm3+2))->setValue('HT');
      $spreadsheet->getActiveSheet()->getCell('G'.($newlinesdm3+2))->setValue('Base');
      $spreadsheet->getActiveSheet()->getCell('H'.($newlinesdm3+2))->setValue('Kendaraan Operasional');
      $spreadsheet->getActiveSheet()->getCell('I'.($newlinesdm3+2))->setValue('Kendaraan Shuttle');


 $sqljlosdmtahap3 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3");

        $countjlosdm3 = $sqljlosdmtahap3->num_rows();
        $rowsdm3 = $newlinesdm3+3;
        $nourutsdm3 = 1;
        $tempHeadsdm3 = ""; 

        $sgtsdm3 = 0;
        $skantorsdm3 = 0;
        $stotalsdm3 = 0;
        $shtsdm3 = 0;

        $sbasesdm3 = 0;
        $sk_opssdm3 = 0;
        $sk_shuttlesdm3 = 0;
 

    foreach ($sqljlosdmtahap3->result() as $keysdm3 => $valuesdm3) {

          $resultjlosdm3 = $this->db->query("select b.sdm_list,c.cat_jlo_sdm,a.id_penawaran,a.tahap,a.kantor,a.gt,a.total,a.ht,a.base,a.k_ops,a.k_shuttle,a.id,a.id_jlo_sdm_list,c.id as id_cat from m_jlo_sdm_val a
left join m_jlo_sdm_list b on b.id = a.id_jlo_sdm_list 
left join m_jlo_sdm_cat c on c.id = b.id_cat_jlo_sdm
WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and c.id = '".$valuesdm3->id_cat."' ")->row();
        
        
          $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm3.':I'.$rowsdm3)->applyFromArray($stylecelldoang);
         
            if($tempHeadsdm3 == "" || $tempHeadsdm3 != $valuesdm3->cat_jlo_sdm) {  
              
              $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm3.':I'.$rowsdm3);
              $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm3)->applyFromArray($styleheadcatjlo);
              $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm3.':I'.$rowsdm3)->applyFromArray($contentcenter);

              $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm3)->setValue($valuesdm3->cat_jlo_sdm);
           
              $rowsdm3++;
            }
         
           
          $sheet->setCellValueByColumnAndRow(1, $rowsdm3, $nourutsdm3);
          $sheet->setCellValueByColumnAndRow(2, $rowsdm3, $valuesdm3->sdm_list);
          $sheet->setCellValueByColumnAndRow(3, $rowsdm3, $valuesdm3->gt);
          $sheet->setCellValueByColumnAndRow(4, $rowsdm3, $valuesdm3->kantor);
          $sheet->setCellValueByColumnAndRow(5, $rowsdm3, $valuesdm3->total);
          $sheet->setCellValueByColumnAndRow(6, $rowsdm3, $valuesdm3->ht);
          $sheet->setCellValueByColumnAndRow(7, $rowsdm3, $valuesdm3->base);
          $sheet->setCellValueByColumnAndRow(8, $rowsdm3, $valuesdm3->k_ops);
          $sheet->setCellValueByColumnAndRow(9, $rowsdm3, $valuesdm3->k_shuttle);
          $sgtsdm3 += $valuesdm3->gt;
          $skantorsdm3 += $valuesdm3->kantor;
          $stotalsdm3 += $valuesdm3->total;
          $shtsdm3 += $valuesdm3->ht;

          $sbasesdm3 += $valuesdm3->base;
          $sk_opssdm3 += $valuesdm3->k_ops;
          $sk_shuttlesdm3 += $valuesdm3->k_shuttle;
          $tempHeadsdm3 = $valuesdm3->cat_jlo_sdm;
          $nourutsdm3++;
          $rowsdm3++;
         
      }
     

      //TOTAL JLO 3
      $spreadsheet->getActiveSheet()->mergeCells('A'.$rowsdm3.':B'.$rowsdm3);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm3)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('C'.$rowsdm3.':I'.$rowsdm3)->applyFromArray($contentcenter);
      $spreadsheet->getActiveSheet()->getStyle('A'.$rowsdm3)->applyFromArray($stylebold);
     
      $spreadsheet->getActiveSheet()->getCell('A'.$rowsdm3)->setValue("TOTAL"); 
      $spreadsheet->getActiveSheet()->getCell('C'.$rowsdm3)->setValue($sgtsdm3); 
  
      $spreadsheet->getActiveSheet()->getCell('D'.$rowsdm3)->setValue($skantorsdm3); 
      $spreadsheet->getActiveSheet()->getCell('E'.$rowsdm3)->setValue($stotalsdm3); 
      $spreadsheet->getActiveSheet()->getCell('F'.$rowsdm3)->setValue($shtsdm3); 
      $spreadsheet->getActiveSheet()->getCell('G'.$rowsdm3)->setValue($sbasesdm3); 
      $spreadsheet->getActiveSheet()->getCell('H'.$rowsdm3)->setValue($sk_opssdm3);
      $spreadsheet->getActiveSheet()->getCell('I'.$rowsdm3)->setValue($sk_shuttlesdm3); 
  

  $spreadsheet->getActiveSheet()->setTitle("JLO SDM Wide");

  //DISINI GARDU 3

  $spreadsheet->addSheet($myWorkSheetGardu, 3);
  $spreadsheet->setActiveSheetIndex(3); 
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == 1){


  $spreadsheet->getActiveSheet()->mergeCells('A1:P1');
  $spreadsheet->getActiveSheet()->mergeCells('A2:P2');
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A3:P5')->applyFromArray($styleArrayheaderJLO);
 
  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
  $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);

  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Sistem Operasi : Tertutup');
 

    $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B5');
  
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:L3');
    $spreadsheet->getActiveSheet()->mergeCells('M3:M5');
    $spreadsheet->getActiveSheet()->mergeCells('N3:N5');
    $spreadsheet->getActiveSheet()->mergeCells('O3:O5');
    $spreadsheet->getActiveSheet()->mergeCells('P3:P5');
    $spreadsheet->getActiveSheet()->mergeCells('C4:C5');
    $spreadsheet->getActiveSheet()->mergeCells('D4:D5');
    $spreadsheet->getActiveSheet()->mergeCells('E4:E5');
    $spreadsheet->getActiveSheet()->mergeCells('F4:F5');
    $spreadsheet->getActiveSheet()->mergeCells('G4:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J4:K4');
    $spreadsheet->getActiveSheet()->mergeCells('L4:L5');


    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M3')->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N3')->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P3')->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G5')->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I5')->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K5')->setValue('GTO Single'); 

    $sqljlotahap1 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 1 ");

    $count1 = $sqljlotahap1->num_rows();

     $rowy = 6;
     $nouruty = 1;

     $sjml_ent = 0;
     $sjml_ext = 0;
     $sjml_rev = 0;
     $sjml_tot = 0;

     $sent_gto_single = 0;
     $sent_gto_multi = 0;
     $sent_reg = 0;

     $sext_gto_multi = 0;
     $sext_gto_single = 0; 
     $sext_rev = 0;

     $skpt = 0;
     $skspt = 0;
     $sktugt = 0;
     $sjops = 0;


     foreach ($sqljlotahap1->result() as $keyy => $valuey) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':P'.$rowy)->applyFromArray($contentcenter);
   
      $sheet->setCellValueByColumnAndRow(1, $rowy, $nouruty);
      $sheet->setCellValueByColumnAndRow(2, $rowy, strtoupper($valuey->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy, $valuey->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy, $valuey->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy, $valuey->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy, $valuey->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy, $valuey->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy, $valuey->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy, $valuey->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy, $valuey->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy, $valuey->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy, $valuey->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy, $valuey->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy, $valuey->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy, $valuey->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy, $valuey->jops);

     $sjml_ent += $valuey->jml_ent;
     $sjml_ext += $valuey->jml_ext;
     $sjml_rev += $valuey->jml_rev;
     $sjml_tot += $valuey->jml_tot;

     $sent_gto_single += $valuey->ent_gto_single;
     $sent_gto_multi += $valuey->ent_gto_multi;
     $sent_reg += $valuey->ent_reg;

     $sext_gto_multi += $valuey->ext_gto_multi;
     $sext_gto_single += $valuey->ext_gto_single; 
     $sext_rev += $valuey->ext_rev;

     $skpt += $valuey->kpt;
     $skspt += $valuey->kspt;
     $sktugt += $valuey->ktugt;
     $sjops += $valuey->jops;

     $nouruty++;
     $rowy++;
   }

   //set buat total tahap 1

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy.':B'.$rowy);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':B'.$rowy)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy)->setValue($sjml_ent); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy)->setValue($sjml_ext); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy)->setValue($sjml_rev); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy)->setValue($sjml_tot); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy)->setValue($sent_gto_single); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy)->setValue($sent_gto_multi);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy)->setValue($sent_reg);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy)->setValue($sext_gto_multi); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy)->setValue($sext_gto_single);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy)->setValue($sext_rev); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy)->setValue($skpt); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy)->setValue($skspt);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy)->setValue($sktugt);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy)->setValue($sjops);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy)->applyFromArray($contentcenter);  
 


  }elseif ($tahap == 2) {
  
  //tahap 1   
  $spreadsheet->getActiveSheet()->mergeCells('A1:P1');
  $spreadsheet->getActiveSheet()->mergeCells('A2:P2');
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A3:P5')->applyFromArray($styleArrayheaderJLO);
 
  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
  $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);

  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Sistem Operasi : Tertutup');
 

    $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B5');
  
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:L3');
    $spreadsheet->getActiveSheet()->mergeCells('M3:M5');
    $spreadsheet->getActiveSheet()->mergeCells('N3:N5');
    $spreadsheet->getActiveSheet()->mergeCells('O3:O5');
    $spreadsheet->getActiveSheet()->mergeCells('P3:P5');
    $spreadsheet->getActiveSheet()->mergeCells('C4:C5');
    $spreadsheet->getActiveSheet()->mergeCells('D4:D5');
    $spreadsheet->getActiveSheet()->mergeCells('E4:E5');
    $spreadsheet->getActiveSheet()->mergeCells('F4:F5');
    $spreadsheet->getActiveSheet()->mergeCells('G4:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J4:K4');
    $spreadsheet->getActiveSheet()->mergeCells('L4:L5');


    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M3')->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N3')->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P3')->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G5')->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I5')->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K5')->setValue('GTO Single'); 

    $sqljlotahap1 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 1 ");

    $count1 = $sqljlotahap1->num_rows();

     $rowy = 6;
     $nouruty = 1;

     $sjml_ent = 0;
     $sjml_ext = 0;
     $sjml_rev = 0;
     $sjml_tot = 0;

     $sent_gto_single = 0;
     $sent_gto_multi = 0;
     $sent_reg = 0;

     $sext_gto_multi = 0;
     $sext_gto_single = 0; 
     $sext_rev = 0;

     $skpt = 0;
     $skspt = 0;
     $sktugt = 0;
     $sjops = 0;


     foreach ($sqljlotahap1->result() as $keyy => $valuey) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':P'.$rowy)->applyFromArray($contentcenter);
   
      $sheet->setCellValueByColumnAndRow(1, $rowy, $nouruty);
      $sheet->setCellValueByColumnAndRow(2, $rowy, strtoupper($valuey->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy, $valuey->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy, $valuey->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy, $valuey->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy, $valuey->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy, $valuey->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy, $valuey->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy, $valuey->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy, $valuey->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy, $valuey->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy, $valuey->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy, $valuey->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy, $valuey->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy, $valuey->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy, $valuey->jops);

     $sjml_ent += $valuey->jml_ent;
     $sjml_ext += $valuey->jml_ext;
     $sjml_rev += $valuey->jml_rev;
     $sjml_tot += $valuey->jml_tot;

     $sent_gto_single += $valuey->ent_gto_single;
     $sent_gto_multi += $valuey->ent_gto_multi;
     $sent_reg += $valuey->ent_reg;

     $sext_gto_multi += $valuey->ext_gto_multi;
     $sext_gto_single += $valuey->ext_gto_single; 
     $sext_rev += $valuey->ext_rev;

     $skpt += $valuey->kpt;
     $skspt += $valuey->kspt;
     $sktugt += $valuey->ktugt;
     $sjops += $valuey->jops;

     $nouruty++;
     $rowy++;
   }

   //set buat total tahap 1

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy.':B'.$rowy);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':B'.$rowy)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy)->setValue($sjml_ent); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy)->setValue($sjml_ext); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy)->setValue($sjml_rev); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy)->setValue($sjml_tot); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy)->setValue($sent_gto_single); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy)->setValue($sent_gto_multi);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy)->setValue($sent_reg);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy)->setValue($sext_gto_multi); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy)->setValue($sext_gto_single);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy)->setValue($sext_rev); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy)->setValue($skpt); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy)->setValue($skspt);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy)->setValue($sktugt);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy)->setValue($sjops);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy)->applyFromArray($contentcenter);  
 

   //tahap 2
    $newline2 = $rowy+2;

  $spreadsheet->getActiveSheet()->getStyle('A'.$newline2)->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline2 + 1))->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline2 + 1).':P'.($newline2 + 3))->applyFromArray($styleArrayheaderJLO);

   $spreadsheet->getActiveSheet()->getCell('A'.$newline2)->setValue('Tahap 2');

   $spreadsheet->getActiveSheet()->mergeCells('A'.($newline2 + 1).':A'.($newline2 + 3));

   $spreadsheet->getActiveSheet()->mergeCells('B'.($newline2 + 1).':B'.($newline2 + 3));
  
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline2 + 1).':F'.($newline2 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline2 + 1).':L'.($newline2 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('M'.($newline2 + 1).':M'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('N'.($newline2 + 1).':N'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('O'.($newline2 + 1).':O'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('P'.($newline2 + 1).':P'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline2 + 2).':C'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('D'.($newline2 + 2).':D'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('E'.($newline2 + 2).':E'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('F'.($newline2 + 2).':F'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline2 + 2).':I'.($newline2 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('J'.($newline2 + 2).':K'.($newline2 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('L'.($newline2 + 2).':L'.($newline2 + 3));


    $spreadsheet->getActiveSheet()->getCell('A'.($newline2 + 1))->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B'.($newline2 + 1))->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C'.($newline2 + 1))->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 1))->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M'.($newline2 + 1))->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N'.($newline2 + 1))->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O'.($newline2 + 1))->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P'.($newline2 + 1))->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C'.($newline2 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D'.($newline2 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E'.($newline2 + 2))->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F'.($newline2 + 2))->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J'.($newline2 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L'.($newline2 + 2))->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 3))->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H'.($newline2 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I'.($newline2 + 3))->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J'.($newline2 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K'.($newline2 + 3))->setValue('GTO Single'); 
   
     
  $sqljlotahap2 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 2 ");

    $count2 = $sqljlotahap2->num_rows();

     $rowy2 = $newline2+4;
     $nouruty2 = 1;

     $sjml_ent2 = 0;
     $sjml_ext2 = 0;
     $sjml_rev2 = 0;
     $sjml_tot2 = 0;

     $sent_gto_single2 = 0;
     $sent_gto_multi2 = 0;
     $sent_reg2 = 0;

     $sext_gto_multi2 = 0;
     $sext_gto_single2 = 0; 
     $sext_rev2 = 0;

     $skpt2 = 0;
     $skspt2 = 0;
     $sktugt2 = 0;
     $sjops2 = 0;


     foreach ($sqljlotahap2->result() as $keyx => $valuex) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2.':P'.$rowy2)->applyFromArray($contentcenter);
     // $spreadsheet->getActiveSheet()->getCell('A'.$rowy2)->setValue($nouruty2);
      $sheet->setCellValueByColumnAndRow(1, $rowy2, $nouruty2);
      $sheet->setCellValueByColumnAndRow(2, $rowy2, strtoupper($valuex->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy2, $valuex->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy2, $valuex->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy2, $valuex->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy2, $valuex->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy2, $valuex->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy2, $valuex->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy2, $valuex->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy2, $valuex->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy2, $valuex->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy2, $valuex->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy2, $valuex->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy2, $valuex->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy2, $valuex->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy2, $valuex->jops);

     $sjml_ent2 += $valuex->jml_ent;
     $sjml_ext2 += $valuex->jml_ext;
     $sjml_rev2 += $valuex->jml_rev;
     $sjml_tot2 += $valuex->jml_tot;

     $sent_gto_single2 += $valuex->ent_gto_single;
     $sent_gto_multi2 += $valuex->ent_gto_multi;
     $sent_reg2 += $valuex->ent_reg;

     $sext_gto_multi2 += $valuex->ext_gto_multi;
     $sext_gto_single2 += $valuex->ext_gto_single; 
     $sext_rev2 += $valuex->ext_rev;

     $skpt2 += $valuex->kpt;
     $skspt2 += $valuex->kspt;
     $sktugt2 += $valuex->ktugt;
     $sjops2 += $valuex->jops;

     $nouruty2++;
     $rowy2++;
   }

   //set total tahap 2

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy2.':B'.$rowy2);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2.':B'.$rowy2)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy2)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy2)->setValue($sjml_ent2); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy2)->setValue($sjml_ext2); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy2)->setValue($sjml_rev2); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy2)->setValue($sjml_tot2); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy2)->setValue($sent_gto_single2); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy2)->setValue($sent_gto_multi2);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy2)->setValue($sent_reg2);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy2)->setValue($sext_gto_multi2); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy2)->setValue($sext_gto_single2);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy2)->setValue($sext_rev2); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy2)->setValue($skpt2); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy2)->setValue($skspt2);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy2)->setValue($sktugt2);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy2)->setValue($sjops2);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy2)->applyFromArray($contentcenter);  
 



  }elseif ($tahap == 3){


  //tahap 1   
  $spreadsheet->getActiveSheet()->mergeCells('A1:P1');
  $spreadsheet->getActiveSheet()->mergeCells('A2:P2');
  $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A3:P5')->applyFromArray($styleArrayheaderJLO);
 
  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
  $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
  $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
  $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);

  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Sistem Operasi : Tertutup');
 

    $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A5');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B5');
  
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:L3');
    $spreadsheet->getActiveSheet()->mergeCells('M3:M5');
    $spreadsheet->getActiveSheet()->mergeCells('N3:N5');
    $spreadsheet->getActiveSheet()->mergeCells('O3:O5');
    $spreadsheet->getActiveSheet()->mergeCells('P3:P5');
    $spreadsheet->getActiveSheet()->mergeCells('C4:C5');
    $spreadsheet->getActiveSheet()->mergeCells('D4:D5');
    $spreadsheet->getActiveSheet()->mergeCells('E4:E5');
    $spreadsheet->getActiveSheet()->mergeCells('F4:F5');
    $spreadsheet->getActiveSheet()->mergeCells('G4:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J4:K4');
    $spreadsheet->getActiveSheet()->mergeCells('L4:L5');


    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M3')->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N3')->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P3')->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J4')->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G5')->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I5')->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J5')->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K5')->setValue('GTO Single'); 

    $sqljlotahap1 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 1 ");

    $count1 = $sqljlotahap1->num_rows();

     $rowy = 6;
     $nouruty = 1;

     $sjml_ent = 0;
     $sjml_ext = 0;
     $sjml_rev = 0;
     $sjml_tot = 0;

     $sent_gto_single = 0;
     $sent_gto_multi = 0;
     $sent_reg = 0;

     $sext_gto_multi = 0;
     $sext_gto_single = 0; 
     $sext_rev = 0;

     $skpt = 0;
     $skspt = 0;
     $sktugt = 0;
     $sjops = 0;


     foreach ($sqljlotahap1->result() as $keyy => $valuey) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':P'.$rowy)->applyFromArray($contentcenter);
   
      $sheet->setCellValueByColumnAndRow(1, $rowy, $nouruty);
      $sheet->setCellValueByColumnAndRow(2, $rowy, strtoupper($valuey->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy, $valuey->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy, $valuey->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy, $valuey->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy, $valuey->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy, $valuey->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy, $valuey->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy, $valuey->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy, $valuey->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy, $valuey->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy, $valuey->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy, $valuey->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy, $valuey->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy, $valuey->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy, $valuey->jops);

     $sjml_ent += $valuey->jml_ent;
     $sjml_ext += $valuey->jml_ext;
     $sjml_rev += $valuey->jml_rev;
     $sjml_tot += $valuey->jml_tot;

     $sent_gto_single += $valuey->ent_gto_single;
     $sent_gto_multi += $valuey->ent_gto_multi;
     $sent_reg += $valuey->ent_reg;

     $sext_gto_multi += $valuey->ext_gto_multi;
     $sext_gto_single += $valuey->ext_gto_single; 
     $sext_rev += $valuey->ext_rev;

     $skpt += $valuey->kpt;
     $skspt += $valuey->kspt;
     $sktugt += $valuey->ktugt;
     $sjops += $valuey->jops;

     $nouruty++;
     $rowy++;
   }

   //set buat total tahap 1

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy.':B'.$rowy);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy.':B'.$rowy)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy)->setValue($sjml_ent); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy)->setValue($sjml_ext); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy)->setValue($sjml_rev); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy)->setValue($sjml_tot); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy)->setValue($sent_gto_single); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy)->setValue($sent_gto_multi);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy)->setValue($sent_reg);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy)->setValue($sext_gto_multi); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy)->setValue($sext_gto_single);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy)->setValue($sext_rev); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy)->setValue($skpt); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy)->setValue($skspt);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy)->setValue($sktugt);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy)->setValue($sjops);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy)->applyFromArray($contentcenter);  
 

   //tahap 2
    $newline2 = $rowy+2;

  $spreadsheet->getActiveSheet()->getStyle('A'.$newline2)->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline2 + 1))->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline2 + 1).':P'.($newline2 + 3))->applyFromArray($styleArrayheaderJLO);

   $spreadsheet->getActiveSheet()->getCell('A'.$newline2)->setValue('Tahap 2');

   $spreadsheet->getActiveSheet()->mergeCells('A'.($newline2 + 1).':A'.($newline2 + 3));

   $spreadsheet->getActiveSheet()->mergeCells('B'.($newline2 + 1).':B'.($newline2 + 3));
  
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline2 + 1).':F'.($newline2 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline2 + 1).':L'.($newline2 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('M'.($newline2 + 1).':M'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('N'.($newline2 + 1).':N'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('O'.($newline2 + 1).':O'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('P'.($newline2 + 1).':P'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline2 + 2).':C'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('D'.($newline2 + 2).':D'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('E'.($newline2 + 2).':E'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('F'.($newline2 + 2).':F'.($newline2 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline2 + 2).':I'.($newline2 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('J'.($newline2 + 2).':K'.($newline2 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('L'.($newline2 + 2).':L'.($newline2 + 3));


    $spreadsheet->getActiveSheet()->getCell('A'.($newline2 + 1))->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B'.($newline2 + 1))->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C'.($newline2 + 1))->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 1))->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M'.($newline2 + 1))->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N'.($newline2 + 1))->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O'.($newline2 + 1))->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P'.($newline2 + 1))->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C'.($newline2 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D'.($newline2 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E'.($newline2 + 2))->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F'.($newline2 + 2))->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J'.($newline2 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L'.($newline2 + 2))->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G'.($newline2 + 3))->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H'.($newline2 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I'.($newline2 + 3))->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J'.($newline2 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K'.($newline2 + 3))->setValue('GTO Single'); 
   
     
  $sqljlotahap2 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 2 ");

    $count2 = $sqljlotahap2->num_rows();

     $rowy2 = $newline2+4;
     $nouruty2 = 1;

     $sjml_ent2 = 0;
     $sjml_ext2 = 0;
     $sjml_rev2 = 0;
     $sjml_tot2 = 0;

     $sent_gto_single2 = 0;
     $sent_gto_multi2 = 0;
     $sent_reg2 = 0;

     $sext_gto_multi2 = 0;
     $sext_gto_single2 = 0; 
     $sext_rev2 = 0;

     $skpt2 = 0;
     $skspt2 = 0;
     $sktugt2 = 0;
     $sjops2 = 0;


     foreach ($sqljlotahap2->result() as $keyx => $valuex) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2.':P'.$rowy2)->applyFromArray($contentcenter);
     // $spreadsheet->getActiveSheet()->getCell('A'.$rowy2)->setValue($nouruty2);
      $sheet->setCellValueByColumnAndRow(1, $rowy2, $nouruty2);
      $sheet->setCellValueByColumnAndRow(2, $rowy2, strtoupper($valuex->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy2, $valuex->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy2, $valuex->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy2, $valuex->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy2, $valuex->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy2, $valuex->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy2, $valuex->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy2, $valuex->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy2, $valuex->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy2, $valuex->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy2, $valuex->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy2, $valuex->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy2, $valuex->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy2, $valuex->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy2, $valuex->jops);

     $sjml_ent2 += $valuex->jml_ent;
     $sjml_ext2 += $valuex->jml_ext;
     $sjml_rev2 += $valuex->jml_rev;
     $sjml_tot2 += $valuex->jml_tot;

     $sent_gto_single2 += $valuex->ent_gto_single;
     $sent_gto_multi2 += $valuex->ent_gto_multi;
     $sent_reg2 += $valuex->ent_reg;

     $sext_gto_multi2 += $valuex->ext_gto_multi;
     $sext_gto_single2 += $valuex->ext_gto_single; 
     $sext_rev2 += $valuex->ext_rev;

     $skpt2 += $valuex->kpt;
     $skspt2 += $valuex->kspt;
     $sktugt2 += $valuex->ktugt;
     $sjops2 += $valuex->jops;

     $nouruty2++;
     $rowy2++;
   }

   //set total tahap 2

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy2.':B'.$rowy2);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy2.':B'.$rowy2)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy2)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy2)->setValue($sjml_ent2); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy2)->setValue($sjml_ext2); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy2)->setValue($sjml_rev2); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy2)->setValue($sjml_tot2); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy2)->setValue($sent_gto_single2); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy2)->setValue($sent_gto_multi2);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy2)->setValue($sent_reg2);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy2)->setValue($sext_gto_multi2); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy2)->setValue($sext_gto_single2);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy2)->setValue($sext_rev2); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy2)->setValue($skpt2); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy2)->setValue($skspt2);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy2)->setValue($sktugt2);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy2)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy2)->setValue($sjops2);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy2)->applyFromArray($contentcenter);  
 


     //tahap 3 gardu

   $newline3 = $rowy2+2;

  $spreadsheet->getActiveSheet()->getStyle('A'.$newline3)->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline3 + 1))->applyFromArray($stylebold);
  $spreadsheet->getActiveSheet()->getStyle('A'.($newline3 + 1).':P'.($newline3 + 3))->applyFromArray($styleArrayheaderJLO);

   $spreadsheet->getActiveSheet()->getCell('A'.$newline3)->setValue('Tahap 3');

   $spreadsheet->getActiveSheet()->mergeCells('A'.($newline3 + 1).':A'.($newline3 + 3));

   $spreadsheet->getActiveSheet()->mergeCells('B'.($newline3 + 1).':B'.($newline3 + 3));
  
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline3 + 1).':F'.($newline3 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline3 + 1).':L'.($newline3 + 1));
    $spreadsheet->getActiveSheet()->mergeCells('M'.($newline3 + 1).':M'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('N'.($newline3 + 1).':N'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('O'.($newline3 + 1).':O'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('P'.($newline3 + 1).':P'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('C'.($newline3 + 2).':C'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('D'.($newline3 + 2).':D'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('E'.($newline3 + 2).':E'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('F'.($newline3 + 2).':F'.($newline3 + 3));
    $spreadsheet->getActiveSheet()->mergeCells('G'.($newline3 + 2).':I'.($newline3 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('J'.($newline3 + 2).':K'.($newline3 + 2));
    $spreadsheet->getActiveSheet()->mergeCells('L'.($newline3 + 2).':L'.($newline3 + 3));


    $spreadsheet->getActiveSheet()->getCell('A'.($newline3 + 1))->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B'.($newline3 + 1))->setValue('Gerbang Tol');
    $spreadsheet->getActiveSheet()->getCell('C'.($newline3 + 1))->setValue('Jumlah Lajur');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline3 + 1))->setValue('Gardu Tersedia');
    $spreadsheet->getActiveSheet()->getCell('M'.($newline3 + 1))->setValue('Kebutuhan Pengumpul Tol');
    $spreadsheet->getActiveSheet()->getCell('N'.($newline3 + 1))->setValue('Kebutuhan KSPT');
    $spreadsheet->getActiveSheet()->getCell('O'.($newline3 + 1))->setValue('Kebutuhan TUGT');
    $spreadsheet->getActiveSheet()->getCell('P'.($newline3 + 1))->setValue('Jadwal Operasi');

    $spreadsheet->getActiveSheet()->getCell('C'.($newline3 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('D'.($newline3 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('E'.($newline3 + 2))->setValue('Rev');
    $spreadsheet->getActiveSheet()->getCell('F'.($newline3 + 2))->setValue('Total');
    $spreadsheet->getActiveSheet()->getCell('G'.($newline3 + 2))->setValue('Ent');
    $spreadsheet->getActiveSheet()->getCell('J'.($newline3 + 2))->setValue('Ext');
    $spreadsheet->getActiveSheet()->getCell('L'.($newline3 + 2))->setValue('Rev'); 

    $spreadsheet->getActiveSheet()->getCell('G'.($newline3 + 3))->setValue('GTO Single');
    $spreadsheet->getActiveSheet()->getCell('H'.($newline3 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('I'.($newline3 + 3))->setValue('Reg'); 
    $spreadsheet->getActiveSheet()->getCell('J'.($newline3 + 3))->setValue('GTO Multi'); 
    $spreadsheet->getActiveSheet()->getCell('K'.($newline3 + 3))->setValue('GTO Single'); 
   
     
  $sqljlotahap3 = $this->db->query("select * from m_gardu  WHERE id_penawaran = '".$id_penawaran."' and tahap = 3 ");

    $count3 = $sqljlotahap3->num_rows();

     $rowy3 = $newline3+4;
     $nouruty3 = 1;

     $sjml_ent3 = 0;
     $sjml_ext3 = 0;
     $sjml_rev3 = 0;
     $sjml_tot3 = 0;

     $sent_gto_single3 = 0;
     $sent_gto_multi3 = 0;
     $sent_reg3 = 0;

     $sext_gto_multi3 = 0;
     $sext_gto_single3 = 0; 
     $sext_rev3 = 0;

     $skpt3 = 0;
     $skspt3 = 0;
     $sktugt3 = 0;
     $sjops3 = 0;


     foreach ($sqljlotahap3->result() as $keyz => $valuez) {
     $spreadsheet->getActiveSheet()->getStyle('A'.$rowy3.':P'.$rowy3)->applyFromArray($contentcenter);
     // $spreadsheet->getActiveSheet()->getCell('A'.$rowy2)->setValue($nouruty2);
      $sheet->setCellValueByColumnAndRow(1, $rowy3, $nouruty3);
      $sheet->setCellValueByColumnAndRow(2, $rowy3, strtoupper($valuez->nama_gt));
      $sheet->setCellValueByColumnAndRow(3, $rowy3, $valuez->jml_ent);
      $sheet->setCellValueByColumnAndRow(4, $rowy3, $valuez->jml_ext);
      $sheet->setCellValueByColumnAndRow(5, $rowy3, $valuez->jml_rev);
      $sheet->setCellValueByColumnAndRow(6, $rowy3, $valuez->jml_tot);
 
      $sheet->setCellValueByColumnAndRow(7, $rowy3, $valuez->ent_gto_single);
      $sheet->setCellValueByColumnAndRow(8, $rowy3, $valuez->ent_gto_multi);
      $sheet->setCellValueByColumnAndRow(9, $rowy3, $valuez->ent_reg);

      $sheet->setCellValueByColumnAndRow(10, $rowy3, $valuez->ext_gto_multi);
      $sheet->setCellValueByColumnAndRow(11, $rowy3, $valuez->ext_gto_single);
      $sheet->setCellValueByColumnAndRow(12, $rowy3, $valuez->ext_rev);
 

      $sheet->setCellValueByColumnAndRow(13, $rowy3, $valuez->kpt);
      $sheet->setCellValueByColumnAndRow(14, $rowy3, $valuez->kspt);
      $sheet->setCellValueByColumnAndRow(15, $rowy3, $valuez->ktugt);
      $sheet->setCellValueByColumnAndRow(16, $rowy3, $valuez->jops);

     $sjml_ent3 += $valuez->jml_ent;
     $sjml_ext3 += $valuez->jml_ext;
     $sjml_rev3 += $valuez->jml_rev;
     $sjml_tot3 += $valuez->jml_tot;

     $sent_gto_single3 += $valuez->ent_gto_single;
     $sent_gto_multi3 += $valuez->ent_gto_multi;
     $sent_reg3 += $valuez->ent_reg;

     $sext_gto_multi3 += $valuez->ext_gto_multi;
     $sext_gto_single3 += $valuez->ext_gto_single; 
     $sext_rev3 += $valuez->ext_rev;

     $skpt3 += $valuez->kpt;
     $skspt3 += $valuez->kspt;
     $sktugt3 += $valuez->ktugt;
     $sjops3 += $valuez->jops;

     $nouruty3++;
     $rowy3++;
   }

   //set total tahap 3

   $spreadsheet->getActiveSheet()->mergeCells('A'.$rowy3.':B'.$rowy3);
   
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getStyle('A'.$rowy3.':B'.$rowy3)->applyFromArray($contentcenter); 
   $spreadsheet->getActiveSheet()->getCell('A'.$rowy3)->setValue("TOTAL"); 
   $spreadsheet->getActiveSheet()->getCell('C'.$rowy3)->setValue($sjml_ent3); 
   $spreadsheet->getActiveSheet()->getStyle('C'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('D'.$rowy3)->setValue($sjml_ext3); 
   $spreadsheet->getActiveSheet()->getStyle('D'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('E'.$rowy3)->setValue($sjml_rev3); 
   $spreadsheet->getActiveSheet()->getStyle('E'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('F'.$rowy3)->setValue($sjml_tot3); 
   $spreadsheet->getActiveSheet()->getStyle('F'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('G'.$rowy3)->setValue($sent_gto_single3); 
   $spreadsheet->getActiveSheet()->getStyle('G'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('H'.$rowy3)->setValue($sent_gto_multi3);  
   $spreadsheet->getActiveSheet()->getStyle('H'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('I'.$rowy3)->setValue($sent_reg3);  
   $spreadsheet->getActiveSheet()->getStyle('I'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('J'.$rowy3)->setValue($sext_gto_multi3); 
   $spreadsheet->getActiveSheet()->getStyle('J'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('K'.$rowy3)->setValue($sext_gto_single3);
   $spreadsheet->getActiveSheet()->getStyle('K'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('L'.$rowy3)->setValue($sext_rev3); 
   $spreadsheet->getActiveSheet()->getStyle('L'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('M'.$rowy3)->setValue($skpt3); 
   $spreadsheet->getActiveSheet()->getStyle('M'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('N'.$rowy3)->setValue($skspt3);
   $spreadsheet->getActiveSheet()->getStyle('N'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('O'.$rowy3)->setValue($sktugt3);
   $spreadsheet->getActiveSheet()->getStyle('O'.$rowy3)->applyFromArray($contentcenter);
   $spreadsheet->getActiveSheet()->getCell('P'.$rowy3)->setValue($sjops3);
   $spreadsheet->getActiveSheet()->getStyle('P'.$rowy3)->applyFromArray($contentcenter);  

  }
  
    
   
   
  $spreadsheet->getActiveSheet()->setTitle("Gardu");

  //GANTI SHEETNYA , INI PRAOPS
  
  $spreadsheet->addSheet($myWorkSheetPraops, 4);
  $spreadsheet->setActiveSheetIndex(4);
  $spreadsheet->getActiveSheet()->mergeCells('A1:X1');
  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pra Operasi');
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == '1'){
  
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
       
      $sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

   
      $countpopst1 = $sqlpraopstahap1->num_rows();
    
      foreach (range(1,1) as $i) {
        
        $row = 5;
      $nourut = 1;
      $tempHead = ""; 
     
        foreach ($sqlpraopstahap1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
           
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
      }
 
      }
       

  }elseif ($tahap == '2') {
     
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
       
      $sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

      $sqlpraopstahap2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 ");
 
 
      $countpopst1 = $sqlpraopstahap1->num_rows();
      $countpopst2 = $sqlpraopstahap2->num_rows();
     
      foreach (range(1,2) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlpraopstahap1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlpraopstahap2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

 
 


      }

  }elseif ($tahap == '3') {
    

    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

    $spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
    $spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
    $spreadsheet->getActiveSheet()->mergeCells('R3:R4');
    $spreadsheet->getActiveSheet()->mergeCells('S3:V3');
    $spreadsheet->getActiveSheet()->mergeCells('W3:X3');

      $spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
    $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
       
      $sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

      $sqlpraopstahap2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 ");

      $sqlpraopstahap3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 1 ");
 
 
      $countpopst1 = $sqlpraopstahap1->num_rows();
      $countpopst2 = $sqlpraopstahap2->num_rows();
      $countpopst3 = $sqlpraopstahap3->num_rows();
     
      foreach (range(1,3) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlpraopstahap1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlpraopstahap2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

        //loop yang 3
        $rowy = 5;
      $nouruty = 1;
      $tempHeady = "";
       
     
        foreach ($sqlpraopstahap3->result() as $keyy => $valuey) {

          $resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
        
        

            if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
              $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
              $rowy++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
          $sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
          $sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
          $sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
          $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
          $tempHeady = $valuey->nama_komp_biaya;
          $nouruty++;
        $rowy++;
         
        }
 
      }
     
       
  }
   
    
  $spreadsheet->getActiveSheet()->setTitle("Praops");




  //GANTI SHEETNYA , INI YANTRANS
  
  $spreadsheet->addSheet($myWorkSheetYanTrans, 5);
  $spreadsheet->setActiveSheetIndex(5);
  $spreadsheet->getActiveSheet()->mergeCells('A1:X1');
  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Transaksi');
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == '1'){
  
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
       
      $sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

   
      $countpyantrans1 = $sqlyantrans1->num_rows();
    
      foreach (range(1,1) as $i) {
        
        $row = 5;
      $nourut = 1;
      $tempHead = ""; 
     
        foreach ($sqlyantrans1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
           
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
      }
 
      }
       

  }elseif ($tahap == '2') {
     
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
       
      $sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

      $sqlyantrans2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 ");
 
 
      $countpyantrans1 = $sqlyantrans1->num_rows();
      $countpyantrans2 = $sqlyantrans2->num_rows();
     
      foreach (range(1,2) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyantrans1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyantrans2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

 
 


      }

  }elseif ($tahap == '3') {
    

    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

    $spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
    $spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
    $spreadsheet->getActiveSheet()->mergeCells('R3:R4');
    $spreadsheet->getActiveSheet()->mergeCells('S3:V3');
    $spreadsheet->getActiveSheet()->mergeCells('W3:X3');

      $spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
    $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
       
      $sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

      $sqlyantrans2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 ");

      $sqlyantrans3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 5 ");
 
 
      $countpyantrans1 = $sqlyantrans1->num_rows();
      $countpyantrans2 = $sqlyantrans2->num_rows();
      $countpyantrans3 = $sqlyantrans3->num_rows();
     
      foreach (range(1,3) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyantrans1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyantrans2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

        //loop yang 3
        $rowy = 5;
      $nouruty = 1;
      $tempHeady = "";
       
     
        foreach ($sqlyantrans3->result() as $keyy => $valuey) {

          $resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
        
        

            if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
              $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
              $rowy++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
          $sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
          $sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
          $sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
          $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
          $tempHeady = $valuey->nama_komp_biaya;
          $nouruty++;
        $rowy++;
         
        }
 
      }
     
       
  }
   
    
  $spreadsheet->getActiveSheet()->setTitle("YanTrans");



  //GANTI SHEETNYA , INI YANLALIN
  
  $spreadsheet->addSheet($myWorkSheetYanLalin, 6);
  $spreadsheet->setActiveSheetIndex(6);
  $spreadsheet->getActiveSheet()->mergeCells('A1:X1');
  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Lalu Lintas');
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == '1'){
  
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
       
      $sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   
      $countpyanlalin1 = $sqlyanlalin1->num_rows();
    
      foreach (range(1,1) as $i) {
        
        $row = 5;
      $nourut = 1;
      $tempHead = ""; 
     
        foreach ($sqlyanlalin1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
           
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
      }
 
      }
       

  }elseif ($tahap == '2') {
     
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
       
      $sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
      $countpyanlalin1 = $sqlyanlalin1->num_rows();
      $countpyanlalin2 = $sqlyanlalin2->num_rows();
     
      foreach (range(1,2) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyanlalin1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyanlalin2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

 
 


      }

  }elseif ($tahap == '3') {
    

    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

    $spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
    $spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
    $spreadsheet->getActiveSheet()->mergeCells('R3:R4');
    $spreadsheet->getActiveSheet()->mergeCells('S3:V3');
    $spreadsheet->getActiveSheet()->mergeCells('W3:X3');

      $spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
    $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
       
      $sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

      $sqlyanlalin3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
      $countpyanlalin1 = $sqlyanlalin1->num_rows();
      $countpyanlalin2 = $sqlyanlalin2->num_rows();
      $countpyanlalin3 = $sqlyanlalin3->num_rows();
     
      foreach (range(1,3) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyanlalin1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyanlalin2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

        //loop yang 3
        $rowy = 5;
      $nouruty = 1;
      $tempHeady = "";
       
     
        foreach ($sqlyanlalin3->result() as $keyy => $valuey) {

          $resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
        
        

            if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
              $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
              $rowy++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
          $sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
          $sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
          $sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
          $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
          $tempHeady = $valuey->nama_komp_biaya;
          $nouruty++;
        $rowy++;
         
        }
 
      }
     
       
  }
    
  $spreadsheet->getActiveSheet()->setTitle("Yan Lalin");




  //GANTI SHEETNYA , INI YANPML
  
  $spreadsheet->addSheet($myWorkSheetYanPML, 7);
  $spreadsheet->setActiveSheetIndex(7);
  $spreadsheet->getActiveSheet()->mergeCells('A1:X1');
  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Pemeliharaan');
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == '1'){
  
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
       
      $sqlyanpml1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 ");

   
      $countpyanpml1 = $sqlyanpml1->num_rows();
    
      foreach (range(1,1) as $i) {
        
        $row = 5;
      $nourut = 1;
      $tempHead = ""; 
     
        foreach ($sqlyanpml1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
           
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
      }
 
      }
       

  }elseif ($tahap == '2') {
     
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
       
      $sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
      $countpyanlalin1 = $sqlyanlalin1->num_rows();
      $countpyanlalin2 = $sqlyanlalin2->num_rows();
     
      foreach (range(1,2) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyanlalin1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyanlalin2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

 
 


      }

  }elseif ($tahap == '3') {
    

    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

    $spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
    $spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
    $spreadsheet->getActiveSheet()->mergeCells('R3:R4');
    $spreadsheet->getActiveSheet()->mergeCells('S3:V3');
    $spreadsheet->getActiveSheet()->mergeCells('W3:X3');

      $spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
    $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
       
      $sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

      $sqlyanlalin3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
      $countpyanlalin1 = $sqlyanlalin1->num_rows();
      $countpyanlalin2 = $sqlyanlalin2->num_rows();
      $countpyanlalin3 = $sqlyanlalin3->num_rows();
     
      foreach (range(1,3) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlyanlalin1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlyanlalin2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

        //loop yang 3
        $rowy = 5;
      $nouruty = 1;
      $tempHeady = "";
       
     
        foreach ($sqlyanlalin3->result() as $keyy => $valuey) {

          $resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
        
        

            if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
              $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
              $rowy++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
          $sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
          $sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
          $sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
          $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
          $tempHeady = $valuey->nama_komp_biaya;
          $nouruty++;
        $rowy++;
         
        }
 
      }
     
       
  }
    
  $spreadsheet->getActiveSheet()->setTitle("Yan PML");
    


  //GANTI SHEETNYA , INI YANUMUM
  
  $spreadsheet->addSheet($myWorkSheetUmum, 8);
  $spreadsheet->setActiveSheetIndex(8);
  $spreadsheet->getActiveSheet()->mergeCells('A1:X1');
  $spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Umum');
  $sheet = $spreadsheet->getActiveSheet();

  if($tahap == '1'){
  
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
       
      $sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 ");

   
      $countpumum1 = $sqlumum1->num_rows();
    
      foreach (range(1,1) as $i) {
        
        $row = 5;
      $nourut = 1;
      $tempHead = ""; 
     
        foreach ($sqlumum1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
           
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
      }
 
      }
       

  }elseif ($tahap == '2') {
     
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
       
      $sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlumum2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
      $countpumum1 = $sqlumum1->num_rows();
      $countpumum2 = $sqlumum2->num_rows();
     
      foreach (range(1,2) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlumum1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlumum2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

 
 


      }

  }elseif ($tahap == '3') {
    

    $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
    $spreadsheet->getActiveSheet()->mergeCells('A3:A4');
    $spreadsheet->getActiveSheet()->mergeCells('B3:B4');
    $spreadsheet->getActiveSheet()->mergeCells('C3:F3');
    $spreadsheet->getActiveSheet()->mergeCells('G3:H3');

      $spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
    $spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

    $spreadsheet->getActiveSheet()->mergeCells('I2:P2');
    $spreadsheet->getActiveSheet()->mergeCells('I3:I4');
    $spreadsheet->getActiveSheet()->mergeCells('J3:J4');
    $spreadsheet->getActiveSheet()->mergeCells('K3:N3');
    $spreadsheet->getActiveSheet()->mergeCells('O3:P3');

      $spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
    $spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

    $spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
    $spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
    $spreadsheet->getActiveSheet()->mergeCells('R3:R4');
    $spreadsheet->getActiveSheet()->mergeCells('S3:V3');
    $spreadsheet->getActiveSheet()->mergeCells('W3:X3');

      $spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
    $spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
    $spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
    $spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
    $spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

    $spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
    $spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
    $spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
    $spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
    $spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
    $spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
       
      $sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

      $sqlumum2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

      $sqlumum3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
      LEFT JOIN m_pricelist b on b.id = a.id_pricelist
      LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
      LEFT JOIN m_satuan d on d.id = b.id_satuan
      WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
      $countpumum1 = $sqlumum1->num_rows();
      $countpumum2 = $sqlumum2->num_rows();
      $countpumum3 = $sqlumum3->num_rows();
     
      foreach (range(1,3) as $i) {
        //loop yang 1
        $row = 5;
      $nourut = 1;
      $tempHead = "";
       
     
        foreach ($sqlumum1->result() as $key => $value) {

          $resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
        
        

            if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(1, $row, $nourut);
              $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
              $row++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
          $sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
          $sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
          $sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
          $sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
          $tempHead = $value->nama_komp_biaya;
          $nourut++;
        $row++;
         
        }


        //loop yang 2
        $rows = 5;
      $nouruts = 1;
      $tempHeads = "";
       
     
        foreach ($sqlumum2->result() as $keys => $values) {

          $resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
        
        

            if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
              $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
              $rows++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
          $sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
          $sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
          $sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
          $sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
          $tempHeads = $values->nama_komp_biaya;
          $nouruts++;
        $rows++;
         
        }

        //loop yang 3
        $rowy = 5;
      $nouruty = 1;
      $tempHeady = "";
       
     
        foreach ($sqlumum3->result() as $keyy => $valuey) {

          $resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
          LEFT JOIN m_pricelist b on b.id = a.id_pricelist
          LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
          LEFT JOIN m_satuan d on d.id = b.id_satuan
          WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
        
        

            if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
               
              $sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
              $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
              $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
              $rowy++;
            }
         
           
           
          $sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
          $sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
          $sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
          $sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
          $sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
          $sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
          $sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
          $tempHeady = $valuey->nama_komp_biaya;
          $nouruty++;
        $rowy++;
         
        }
 
      }
     
       
  }
    
  $spreadsheet->getActiveSheet()->setTitle("Yan Umum");
  

    //INI PERINTAH BUAT GENERATE
    $writer = new Xlsx($spreadsheet);
    $filename = 'upload/test.xlsx';
    $writer->save($filename);
    echo 'saved to: ' . $filename . PHP_EOL;
  }
  
       


}
