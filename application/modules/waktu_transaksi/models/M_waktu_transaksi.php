<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_waktu_transaksi extends Parent_Model { 
  
  var $nama_tabel = 'm_waktu_transaksi';
  var $daftar_field = array('id','id_jenis_gardu','waktu_transaksi','periode_start','periode_end');
  var $primary_key = 'id';

	  
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }
  public function fetch_waktu_transaksi(){   
       $sql = "select a.*,b.jenis_gardu from m_waktu_transaksi a 
               left join m_jenis_gardu b on b.id = a.id_jenis_gardu";
		   $getdata = $this->db->query($sql)->result();
		   $data = array();  
		   $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->jenis_gardu;   
			          $sub_array[] = $row->waktu_transaksi;   
                $sub_array[] = $row->periode_start;  
			          $sub_array[] = $row->periode_end;  
         
			    $sub_array[] = '<a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a> 
								&nbsp; <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>';  
               
                $data[] = $sub_array;  
                 $no++;
           }  
          
		   return $output = array("data"=>$data);
		    
    }

     public function fetch_jenis_gardu(){   
       $getdata = $this->db->get('m_jenis_gardu')->result();
       $data = array();  
       $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $row->jenis_gardu;   
                $sub_array[] = $row->id;    
                $data[] = $sub_array;  
                 $no++;
           }  
          
       return $output = array("data"=>$data);
        
    }

    public function simpan_waktu_transaksi($data_form,$nama_tabel,$pk,$id){
      //kalau data id kosong
      
      if($id == NULL || empty($id)){

        $start_date = $data_form['periode_start'];
 
        $set_end_date = date('Y-m-d', strtotime($start_date . " -1 days"));

        $sqlcek = "select * from m_waktu_transaksi where periode_end IS NULL";

        $ecsqlcek = $this->db->query($sqlcek);

        if($ecsqlcek->num_rows() > 0){  
          $this->db->query("update m_waktu_transaksi set periode_end = '".$set_end_date."' where periode_end IS NULL"); 
        }

        $sql = "insert into m_waktu_transaksi (id_jenis_gardu,waktu_transaksi,periode_start) VALUES ('".$data_form['id_jenis_gardu']."','".$data_form['waktu_transaksi']."','".$data_form['periode_start']."')";

      }else{
        $sql = "update m_waktu_transaksi SET id_jenis_gardu =  '".$data_form['id_jenis_gardu']."', waktu_transaksi = '".$data_form['waktu_transaksi']."', periode_start = '".$data_form['periode_start']."' where id = '".$id."' ";
      }

      return $this->db->query($sql);
     
 
    }
  
  
	 
 
}
