<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_produk extends Parent_Model { 
  
     var $nama_tabel = 'm_produk';
     var $daftar_field = array('id','nama_produk','id_satuan','harga_satuan','ukuran','id_jenis');
     var $primary_key = 'id'; 
    
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_produk(){ 
      
             $getdata = $this->db->query("select a.*,b.nama_jenis,c.nama_satuan from m_produk a
             left join m_jenis b on b.id = a.id_jenis
             left join m_satuan c on c.id = a.id_satuan")->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
              
                $sub_array[] = $row->nama_produk;  
                $sub_array[] = $row->nama_jenis;  
                $sub_array[] = $row->ukuran;
                $sub_array[] = $row->nama_satuan;
                $sub_array[] = "Rp. ".number_format($row->harga_satuan);
       
                $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; 
                <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>  &nbsp;';  
                $sub_array[] = $row->id;
               
                $data[] = $sub_array;  
                $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    } 
	 
 
}
