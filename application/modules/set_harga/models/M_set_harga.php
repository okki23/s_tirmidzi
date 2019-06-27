<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_set_harga extends Parent_Model { 
  

  var $nama_tabel = 'm_harsat_val';
  var $daftar_field = array('id','id_kel_harsat','id_pricelist','harga');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_pricelist(){   
      $sql = "select a.*,b.nama_komp_biaya,c.nama_pelayanan,d.nama_satuan from m_pricelist a
              LEFT JOIN m_komp_biaya b on b.id = a.id_komp_biaya
              LEFT JOIN m_jenis_pelayanan c on c.id = a.id_pelayanan
              LEFT JOIN m_satuan d on d.id = a.id_satuan order by a.id ASC";
       $getdata = $this->db->query($sql)->result();
       $data = array();  
       $no = 1;
       
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_pricelist;  
                 
                 
                $sub_array[] = '<input type="text" name="harga[]" id="harga" class="form-control" value="0"> <input type="hidden" name="id_pricelist[]" id="id_pricelist" value="'.$row->id.'" class="form-control"> ';  
                
                $sub_array[] = $row->nama_pelayanan;
                $sub_array[] = $row->nama_komp_biaya;
             
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

     public function fetch_pricelistx(){   
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
