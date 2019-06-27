<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_kelompok_jabatan extends Parent_Model { 
  
  var $nama_tabel = 'm_kelompok_jabatan';
  var $daftar_field = array('id','id_kelas_jabatan','nama_kelompok_jabatan');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_kelompok_jabatan(){
       $sql = "select a.*,b.nama_kelas_jabatan from m_kelompok_jabatan a
               left join m_kelas_jabatan b on b.id = a.id_kelas_jabatan";
               
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_kelas_jabatan;  
                $sub_array[] = $row->nama_kelompok_jabatan;  
                 
                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

     public function fetch_kelas_jabatan(){
      
       $getdata = $this->db->get('m_kelas_jabatan')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->nama_kelas_jabatan;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
