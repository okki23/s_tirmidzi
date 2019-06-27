<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_divisi extends Parent_Model { 
  
  var $nama_tabel = 'm_divisi';
  var $daftar_field = array('id','id_direktorat','nama_divisi');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_divisi(){ 
       $sql = "select a.*,b.nama_direktorat  from m_divisi a
               left join m_direktorat b on b.id = a.id_direktorat";
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;

           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                 $sub_array[] = $no;
                $sub_array[] = $row->nama_direktorat;  
                $sub_array[] = $row->nama_divisi;                   
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

     public function fetch_direktorat(){ 
       
       $getdata = $this->db->get('m_direktorat')->result();
       $data = array();  
       $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
               
                $sub_array[] = $row->nama_direktorat;
                $sub_array[] = $row->id;  
                            
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
