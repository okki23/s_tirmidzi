<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_jlo_sdm_list extends Parent_Model { 

  var $nama_tabel = 'm_jlo_sdm_list';
  var $daftar_field = array('id','id_cat_jlo_sdm','sdm_list','tipe_field_kantor','tipe_field_gt','tipe_field_ht','tipe_field_base','tipe_field_kops','tipe_field_kshuttle');
  var $primary_key = 'id';
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_jlo_sdm_list(){
       $sql = "select a.*,b.id as idcat,b.cat_jlo_sdm from m_jlo_sdm_list a
               LEFT JOIN m_jlo_sdm_cat b on b.id = a.id_cat_jlo_sdm";
               
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
       
                $sub_array[] = $row->cat_jlo_sdm;  
                $sub_array[] = $row->sdm_list;  
               
                
                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
                $sub_array[] = $row->idcat;  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

     public function fetch_kategori(){
      
       $getdata = $this->db->get('m_jlo_sdm_cat')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->cat_jlo_sdm;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
