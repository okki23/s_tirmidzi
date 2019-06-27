<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_komp_biaya extends Parent_Model { 
  
  var $nama_tabel = 'm_komp_biaya';
  var $daftar_field = array('id','id_jenis_layanan','nama_komp_biaya');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_komp_biaya(){   
    $sql = $this->db->query("select a.*,b.nama_pelayanan from m_komp_biaya a left join m_jenis_pelayanan b on b.id = a.id_jenis_layanan");
		   
		   $data = array();  
		   $no = 1;
           foreach($sql->result() as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_pelayanan;  
                $sub_array[] = $row->nama_komp_biaya;  
                 
                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

  
  
	 
 
}
