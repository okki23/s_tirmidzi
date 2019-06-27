<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_seksi extends Parent_Model { 
  
  var $nama_tabel = 'm_seksi';
  var $daftar_field = array('id','id_departemen','nama_seksi');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_seksi(){ 
       $sql = "select a.*,b.nama_departemen from m_seksi a
               left join m_departemen b on b.id = a.id_departemen ORDER BY a.id ASC";
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;

           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                // $sub_array[] = $no;
                $sub_array[] = $row->nama_departemen;  
                $sub_array[] = $row->nama_seksi;                   
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

     public function fetch_departemen(){ 
       
       $getdata = $this->db->get('m_departemen')->result();
       $data = array();  
       $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
               
                $sub_array[] = $row->nama_departemen;
                $sub_array[] = $row->id;  
                            
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
