<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_list_harga extends Parent_Model { 
  

  var $nama_tabel = 'm_list_harga';
  var $daftar_field = array('id','id_penawaran','nama_gt','jml_ent','jml_ext','jml_rev','jml_tot','ent_gto_single','ent_gto_multi','ent_reg','ext_gto_multi','ext_gto_single','ext_rev','kpt','kspt','ktugt','jops');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_list_harga(){   
   $sql = "select a.*,b.nama_harga from m_harsat_val a
LEFT JOIN m_harga b on b.id = a.id_kel_harsat
LEFT JOIN m_pricelist c on c.id = a.id_pricelist GROUP BY a.id_kel_harsat";
       $getdata = $this->db->query($sql)->result();
       $data = array();  
       $no = 1;
       
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_harga;  
                 
                 
                $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Detail('.$row->id_kel_harsat.');" > <i class="material-icons">create</i> Detail Harga </a>  &nbsp;  <a href="javascript:void(0)" class="btn btn-danger btn-xs waves-effect" id="edit" onclick="Hapus_Data('.$row->id_kel_harsat.');" > <i class="material-icons">delete</i> Hapus Harga </a>  ';   
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);

  }

  
  
	 
 
}
