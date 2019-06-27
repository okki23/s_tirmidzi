<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_formasi_jabatan extends Parent_Model { 
  
 var $nama_tabel = 'm_formasi_jabatan';
  var $daftar_field = array('id','id_direktorat','id_departemen','id_seksi','id_kelompok_jabatan','id_divisi','id_parent','id_karyawan','nama_jabatan');
  var $primary_key = 'id';

  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_formasi_jabatan(){
       $sql = "SELECT a.*,b.npp,b.nama_karyawan,c.nama_kelompok_jabatan,d.nama_kelas_jabatan,e.nama_seksi,f.nama_departemen,g.nama_divisi,h.nama_direktorat 
       from m_formasi_jabatan a
      LEFT JOIN m_karyawan b on b.id = a.id_karyawan
      LEFT JOIN m_kelompok_jabatan c on c.id = a.id_kelompok_jabatan
      LEFT JOIN m_kelas_jabatan d on d.id = c.id_kelas_jabatan
      LEFT JOIN m_seksi e on e.id = a.id_seksi
      LEFT JOIN m_departemen f on f.id = a.id_departemen
      LEFT JOIN m_divisi g on g.id = a.id_divisi
      LEFT JOIN m_direktorat h on h.id = a.id_direktorat";
               
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_direktorat;  
                $sub_array[] = $row->nama_divisi;  
                $sub_array[] = $row->nama_departemen;
                $sub_array[] = $row->nama_seksi;
                $sub_array[] = $row->nama_kelas_jabatan;
                $sub_array[] = $row->nama_kelompok_jabatan;
                $sub_array[] = $row->nama_jabatan;
                $sub_array[] = $row->npp;
                $sub_array[] = $row->nama_karyawan;
                
                 
			          $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; &nbsp; &nbsp; &nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
                $sub_array[] = $row->id;
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

    public function fetch_direktorat(){
      
       $getdata = $this->db->get('m_direktorat')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->nama_direktorat;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

    // public function fetch_atasan(){
      
    //    $getdata = $this->db->query('SELECT a.*,b.nama_karyawan,c.nama_kelompok_jabatan,
    //           d.nama_kelas_jabatan,e.nama_seksi from m_formasi_jabatan a
    //               LEFT JOIN m_karyawan b on b.id = a.id_karyawan
    //               LEFT JOIN m_kelompok_jabatan c on c.id = a.id_kelompok_jabatan
    //               LEFT JOIN m_kelas_jabatan d on d.id = c.id_kelas_jabatan
    //               LEFT JOIN m_seksi e on e.id = a.id_seksi where a.id_karyawan != "" ')->result();
    //    $data = array();  
      
    //        foreach($getdata as $row)  
    //        {  
    //             $sub_array = array();  
             
    //             $sub_array[] = $row->npp; 
    //             $sub_array[] = $row->nama_karyawan;  
    //             $sub_array[] = $row->id;  
                 
                  
    //             $data[] = $sub_array;  
              
    //        }  
          
    //    return $output = array("data"=>$data);
        
    // }

    public function fetch_kelompok_jabatan(){
      
       $getdata = $this->db->get('m_kelompok_jabatan')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->nama_kelompok_jabatan;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

    public function fetch_npp(){
      
       $getdata = $this->db->get('m_karyawan')->result();
       $data = array();  
      
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->npp;
                $sub_array[] = $row->nama_karyawan;  
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

    public function fetch_parent(){
        
       $sql = $this->db->query("select a.*,b.nama_karyawan from m_formasi_jabatan a left join m_karyawan b on b.id = a.id_karyawan");
       //$getdata = $this->db->get('m_formasi_jabatan')->result();
       $data = array();  
      
           foreach($sql->result() as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $row->nama_jabatan;
                $sub_array[] = $row->nama_karyawan;
     
                $sub_array[] = $row->id;  
                 
                  
                $data[] = $sub_array;  
              
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
