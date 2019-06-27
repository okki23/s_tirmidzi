<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_generate_harga extends Parent_Model { 
  

  var $nama_tabel = 'm_harga';
  var $daftar_field = array('id','nama_harga','year','id_country');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_generate_harga(){   
      $sql = "select a.*,b.nama_satuan from m_asumsi a
LEFT JOIN m_satuan b on b.id = a.id_satuan";
       $getdata = $this->db->query($sql)->result();
       $data = array();  
       $no = 1;
       
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_asumsi;  
                 
                if($row->tipe == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly" style=" background-color:#D8D8D8;" name="vol[]" id="'.strtolower(str_replace(" ","_",$row->nama_asumsi)).'" class="form-control">';  
                }else{
                  $sub_array[] = '<input type="text" name="vol[]" id="'.strtolower(str_replace(" ","_",$row->nama_asumsi)).'" class="form-control">';  
                }
              

                $sub_array[] = $row->nama_satuan;   
                $sub_array[] = '<input type="text" name="safety_factor[][$i]" id="harga" class="form-control">'; 
                $sub_array[] = '<input type="text" name="keterangan[][$i]" id="harga" class="form-control">'; 
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
