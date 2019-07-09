<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_barang extends Parent_Model { 
  
     var $nama_tabel = 'm_barang';
     var $daftar_field = array('id','nama_barang','qty','id_jenis');
     var $primary_key = 'id'; 
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_barang(){
       $sql = "select a.*,b.nama_jenis from m_barang a
       left join m_jenis b on b.id = a.id_jenis";
               
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
 
                $sub_array[] = $row->nama_barang;  
                $sub_array[] = $row->nama_jenis;  
                $sub_array[] = $row->qty; 
                $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; 
                <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>  &nbsp;';  
                $sub_array[] = $row->id;
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

    public function fetch_jabatan(){
      
       $getdata = $this->db->get('m_jabatan')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->nama_jabatan;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    } 

    public function fetch_status(){
      
     $getdata = $this->db->get('m_status')->result();
     $data = array();  
    
         foreach($getdata as $row)  
         {  
              $sub_array = array();  
           
              $sub_array[] = $row->nama_status;  
              $sub_array[] = $row->id;  
               
                
              $data[] = $sub_array;  
            
         }  
        
     return $output = array("data"=>$data);
      
  } 
	 
 
}
