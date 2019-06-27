<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_gardu extends Parent_Model { 
  

  var $nama_tabel = 'm_gardu';
  var $daftar_field = array('id','id_penawaran','tahap','nama_gt','jml_ent','jml_ext','jml_rev','jml_tot','ent_gto_single','ent_gto_multi','ent_reg','ext_gto_multi','ext_gto_single','ext_rev','kpt','kspt','ktugt','jops');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_gardu(){   
		   $getdata = $this->db->get($this->nama_tabel)->result();
		   $data = array();  
		   $no = 1;
       
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_gardu;  
                 
                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a> &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-warning btn-xs waves-effect" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

  
  
	 
 
}
