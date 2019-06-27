<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_jlo_sdm_val extends Parent_Model { 

  var $nama_tabel = 'm_jlo_sdm_val';
  var $daftar_field = array('id','id_penawaran','tahap','id_jlo_sdm_list','kantor','gt','ht','base','k_ops','k_shuttle');
  var $primary_key = 'id';
	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_jlo_sdm_val(){
       $sql = "select a.*,b.cat_jlo_sdm from m_jlo_sdm_list a
LEFT JOIN m_jlo_sdm_cat b on b.id = a.id_cat_jlo_sdm";
               
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
              
                $sub_array[] = $row->sdm_list.'<input type="hidden" name="id_jlo_sdm_list[]" value="'.$row->id.'" >';  
                
                if($row->tipe_field_kantor == 'calculated'){
                    $sub_array[] = '<input type="text" readonly="readonly" name="kantor[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_kantor" class="form-control" style="width:80%;  background-color:#D8D8D8;" value = "0">  ';  
                }else{
                  $sub_array[] = '<input type="text" name="kantor[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_kantor" class="form-control" style="width:80%;"  value = "0"> ';
                }
                
                if($row->tipe_field_gt == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly"  name="gt[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_gt" class="form-control" style="width:100%; background-color:#D8D8D8;" value = "0">';    
                }else{
                  $sub_array[] = '<input type="text" name="gt[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_gt" class="form-control" style="width:100%;"  value = "0">';    
                }

                $sub_array[] = '<input type="text" readonly="readonly" name="total[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_total" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "0">';   

                if($row->tipe_field_ht == 'calculated'){ 
                  $sub_array[] = '<input type="text" readonly="readonly" name="ht[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_ht" class="form-control" style="width:100%; background-color:#D8D8D8;"  value = "0">';  
                }else{
                  $sub_array[] = '<input type="text" name="ht[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_ht" class="form-control" style="width:100%;"  value = "0">';  
                }

                if($row->tipe_field_base == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly" name="base[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_base" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "0">';    
                }else{
                  $sub_array[] = '<input type="text" name="base[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_base" class="form-control" style="width:80%;"  value = "0">';   
                }

                if($row->tipe_field_kops == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly" name="k_ops[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_ops" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "0">';   
                }else{
                  $sub_array[] = '<input type="text" name="k_ops[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_ops" class="form-control" style="width:80%;" value = "0">';   
                }              

                if($row->tipe_field_kshuttle == 'calculated'){
                  $sub_array[] = '<input type="text" readonly="readonly" name="k_shuttle[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_shuttle" class="form-control" style="width:80%; background-color:#D8D8D8;"  value = "0">';  
                }else{
                  $sub_array[] = '<input type="text" name="k_shuttle[]" id="'.strtolower(str_replace(array(' ','/'),"_",$row->sdm_list)).'_k_shuttle" class="form-control" style="width:80%;"  value = "0">'; 
                }               
                
               
                $sub_array[] = $row->cat_jlo_sdm;  
               
               
                $data[] = $sub_array;  
            
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
