<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_asumsi_list extends Parent_Model { 
  

  var $nama_tabel = 'm_asumsi_list';
  var $daftar_field = array('id','id_penawaran','tahap','id_asumsi','vol','safety_factor','keterangan');
  var $primary_key = 'id';
  
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_asumsi_list(){   
      $sql = "select a.*,b.nama_satuan from m_asumsi a
LEFT JOIN m_satuan b on b.id = a.id_satuan";
       $getdata = $this->db->query($sql)->result();
       $data = array();  
       $no = 1;
       
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_asumsi.'<input type="hidden" name="id_asumsi[]" id="id_asumsi" class="form-control" value="'.$row->id.'">';  
                 
                if($row->tipe == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly" style=" background-color:#D8D8D8;" name="vol[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->nama_asumsi)).'" class="form-control">';  
                }else{
                  $sub_array[] = '<input type="text" name="vol[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->nama_asumsi)).'" class="form-control">';  
                }
              

                $sub_array[] = $row->nama_satuan;   
                $sub_array[] = '<input type="text" name="safety_factor[]" id="safety_factor" class="form-control">'; 
                $sub_array[] = '<input type="text" name="keterangan[]" id="keterangan" class="form-control">'; 
                $data[] = $sub_array;  
                $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

  
  
	 
 
}
