<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_so extends Parent_Model { 
  
  var $nama_tabel = 't_pengeluaran';
  var $daftar_field = array('id','no_transaksi','id_instansi','keterangan','id_pegawai','date_assign');  
  var $primary_key = 'id';
    
  public function __construct(){
        parent::__construct();
        $this->load->database();
  }

  public function get_no(){
    $query = $this->db->query("SELECT SUBSTR(MAX(no_so),-7) AS id  FROM t_so");
         
    return $query;
  }

   
  public function fetch_solist_table(){
       $getdata = $this->db->query("select 
                  SELECT a.*,b.harga,c.nama_produk FROM t_so_detail a
                  LEFT JOIN m_pricelist b on b.id = a.id_pricelist
                  LEFT JOIN m_produk c on c.id = b.id_produk")->result();
       $data = array();  
       $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $no;
                $sub_array[] = $row->nama_produk;   
                $sub_array[] = $row->design_file_upload;   
                $sub_array[] = $row->qty;  
                $sub_array[] = $row->total;  
          
                $sub_array[] = "<button typpe='button' onclick='HapusDetailList(".$value->id.");' class = 'btn btn-danger'> <i class='material-icons'>delete_forever</i> Hapus </button>  ";  
               
                $data[] = $sub_array;  
                 $no++;
           }  
          
       return $output = array("data"=>$data);
  }

  public function list_order_customer(){
      $getdata = $this->db->query('select * from t_so where id_pelanggan = "'.$this->session->userdata('userid').'" ')->result();
      $data = array();  
          $no = 1;
           foreach($getdata as $row)  
           {  
                $sub_array = array();  
             
                $sub_array[] = $no;  
                $sub_array[] = $row->no_order; 
                $sub_array[] = "<button typpe='button' onclick='Hapus(".$row->id.");' class = 'btn btn-primary'> <i class='material-icons'>aspect_ratio</i> Detail </button> &nbsp; <button typpe='button' onclick='Hapus(".$row->id.");' class = 'btn btn-danger'> <i class='material-icons'>delete_forever</i> Hapus </button>";  
                 
                  
                $data[] = $sub_array;  
          $no++;
           }  
          
       return $output = array("data"=>$data);
  }

  public function fetch_so_list(){
      
       $getdata = $this->db->query("select a.*,b.nama from t_so a
       left join m_customer b on b.id = a.id_customer")->result();
       $data = array();  
           $no = 1;
         
           foreach($getdata as $row)  
           {  
                
                $sub_array = array();  
                $sub_array[] = $row->no_so;
                $sub_array[] = $row->nama;
                $sub_array[] = $row->date_assign; 
                $sub_array[] = '<div class="dropdown">
                                   <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opsi
                                   <span class="caret"></span></button>
                                   <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)" onclick="Input_Material('.$row->no_so.');" > <i class="material-icons">aspect_ratio</i> Input Material</a></li>                       
                                        <li><a href="javascript:void(0)" onclick="Show_Detail('.$row->no_so.');" > <i class="material-icons">aspect_ratio</i> Detail</a></li>                  
                                        <li><a href="javascript:void(0)" onclick="Hapus_Data('.$row->no_so.');" > <i class="material-icons">delete</i> Delete</a></li>
                                   </ul>
                              </div>';  
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
  
   
 
}
