<?php
date_default_timezone_set("Asia/Jakarta");
defined('BASEPATH') OR exit('No direct script access allowed');
 
class So extends Parent_Controller {
  
  var $nama_tabel = 't_so'; 
  var $daftar_field = array('id','no_so','no_spk','status','is_paid','date_assign','user_assign','id_customer');  
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_so'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	   public function index(){
		  $data['judul'] = $this->data['judul']; 
		  $data['konten'] = 'so/so_view';
		  $data['userid'] = $this->session->userdata('userid');
		  $this->load->view('template_view',$data);		
   
	   }
     public function simpan_data_detail(){
      $field = array('id','no_so','id_produk','qty');   
      
      $data_form = $this->m_so->array_from_post($field); 
  
      $sql = $this->db->query("insert into t_so_detail (no_so,id_produk,qty) values ( '".$this->input->post('no_sox')."','".$this->input->post('id_produk')."','".$this->input->post('qty')."') "); 
       
      
      if($sql){
        $result = array("response"=>array('message'=>'success'));
      }else{
        $result = array("response"=>array('message'=>'failed'));
      }
      
      echo json_encode($result,TRUE);
  
    }
    public function fetch_item_list(){
      $id = $this->uri->segment(3);
      $sql = $this->db->where('id',$id)->get('m_produk')->row();
        echo json_encode($sql,TRUE);
    }
  	public function fetch_so_list(){  
       $getdata = $this->m_so->fetch_so_list();
       echo json_encode($getdata);   
    }
    
    public function hapus_no_so(){
      $no_so = $this->input->post('no_so');
      echo $no_so;
 
      $this->db->query("delete from t_so where no_so = '".$no_so."' ");

    }


    public function produk_list(){  
       
      $no_order =  $this->input->post('no_order');
       
        $sql = "select 
        a.*,b.nama_produk,c.nama_bahan,c.ukuran,d.nama_satuan,c.berat_bahan from 
        m_pricelist a
        LEFT JOIN m_produk b on b.id = a.id_produk
        LEFT JOIN m_bahan c on c.id = a.id_bahan
        LEFT JOIN m_satuan d on d.id= c.id_satuan  order by a.id asc";
        $exsql = $this->db->query($sql)->result();
      
        $dataparse = array();  
           foreach ($exsql as $key => $value) {  
                $sub_array['nama_produk'] = $value->nama_produk;
                $sub_array['nama_bahan'] = $value->nama_bahan;  
                $sub_array['ukuran'] = $value->ukuran;
                $sub_array['nama_satuan'] = $value->nama_satuan;
                $sub_array['berat_bahan'] = $value->berat_bahan;
                $sub_array['harga'] = "Rp. ".number_format($value->harga);
                //$sub_array['foto'] = "x";
                $sub_array['foto'] = "<a href='upload/".$value->foto."' data-fancybox data-type='image' data-caption='".$value->nama_produk ." - ". $value->nama_bahan ." - ". $value->ukuran ." ". $value->nama_satuan ." - ". $value->berat_bahan ." Gram - Rp. ". number_format($value->harga)."'> View </a> ";
                $sub_array['action'] =  "<button typpe='button' onclick='GetDataProduk(".$value->id.");' class = 'btn btn-primary'> <i class='material-icons'>shopping_cart</i> Pilih </button>";  
   
               array_push($dataparse,$sub_array); 
            }  
       
        echo json_encode($dataparse);
 
    }


    public function listingdetail(){  
      //No 	Nama Barang 	Qty 	Source 	Keterangan
      $id =  $this->input->post('id');
       
      $sql = "select a.*,b.nama_barang, CASE a.source
      WHEN 'jkt' THEN 'Jakarta'
      WHEN 'sbg' THEN 'Subang'
      ELSE NULL
      END as 'src' from t_pengeluaran_detail a
      left join m_barang b on b.id = a.id_barang
                  where a.no_transaksi = '".$id."' ";
        $exsql = $this->db->query($sql)->result();
      
          $dataparse = array();  
          $no = 1;
           foreach ($exsql as $key => $value) {  
                $sub_array['no'] = $no;
                $sub_array['nama_barang'] = $value->nama_barang;  
                $sub_array['qty'] = $value->qty;
                $sub_array['source'] = $value->src;
                $sub_array['keterangan'] = $value->keterangan; 
               array_push($dataparse,$sub_array); 
               $no++;
            }  
       
        echo json_encode($dataparse);
 
    }

    public function calc_weight(){
       $data = $this->uri->segment(3);
       $res = 0;
       $sql = $this->db->query(" 
                  SELECT a.*,b.harga,c.nama_produk,d.berat_bahan FROM t_so_detail a
                  LEFT JOIN m_pricelist b on b.id = a.id_pricelist
                  LEFT JOIN m_produk c on c.id = b.id_produk
                  LEFT JOIN m_bahan d on d.id = b.id_bahan
                  where a.no_order = '".$data."' ")->result();
       foreach ($sql as $key => $value) {
         $res += $value->total_berat;
       }
       echo $res;
    }

    public function datalist(){
      $data = $this->uri->segment(3);
      //echo $data;
 
      $sql = $this->db->query("select a.*,b.nama_produk,c.nama_jenis,d.nama_satuan,b.harga_satuan,b.ukuran from t_so_detail a
      left join m_produk b on b.id = a.id_produk 
      left join m_jenis c on c.id = b.id_jenis
      left join m_satuan d on d.id = b.id_satuan where a.no_so = '".$data."' ");
      
      $no = 1;

      if($sql->num_rows() > 0){
 
        echo "<thead>
                <tr>
                    <th style='width:1%; text-align:center;'>No</th>  
                    <th style='width:2%; text-align:center;'>Nama Produk</th>
                    <th style='width:2%; text-align:center;'>Jenis</th>
                    <th style='width:2%; text-align:center;'>Ukuran</th>
                    <th style='width:5%; text-align:center;'>Satuan</th> 
                    <th style='width:5%; text-align:center;'>Qty</th> 
                    <th style='width:5%; text-align:center;'>Harga Satuan</th> 
                    <th style='width:5%; text-align:center;'>Total Harga</th>  
                    <th style='width:5%; text-align:center;'>Opsi</th>  
                </tr>
            </thead>";
        foreach ($sql->result() as $key => $value) {
          echo "<tr>
                    <td align='center'>".$no."</td>
                    <td align='center'>".$value->nama_produk."</td>
                    <td align='center'>".$value->nama_jenis."</td>
                    <td align='center'>".$value->ukuran."</td>
                    <td align='center'>".$value->nama_satuan."</td>
                    <td align='center'>".$value->qty."</td> 
                    <td align='center'> Rp. ".number_format($value->harga_satuan)."</td> 
                    <td align='center'> Rp. ".number_format(($value->qty * $value->harga_satuan))."</td> 
                    <td align='center'><button type='button' onclick='HapusDetailList(".$value->id.",".$value->no_so.");' class = 'btn btn-danger btn-xs'> <i class='material-icons'>delete_forever</i> Hapus </button> 
  
                    </td>
                </tr>";
       
        $no++;
        } 

      }else{
        echo "<thead>
        <tr>
                    <th style='width:1%; text-align:center;'>No</th>  
                    <th style='width:2%; text-align:center;'>Nama Produk</th>
                    <th style='width:2%; text-align:center;'>Jenis</th>
                    <th style='width:2%; text-align:center;'>Ukuran</th>
                    <th style='width:5%; text-align:center;'>Satuan</th> 
                    <th style='width:5%; text-align:center;'>Qty</th> 
                    <th style='width:5%; text-align:center;'>Harga Satuan</th> 
                    <th style='width:5%; text-align:center;'>Total Harga</th>  
                    <th style='width:5%; text-align:center;'>Opsi</th>  
                </tr>
        <tr>
        <td colspan='9'>Tidak ada data order</td> 
      </tr>
    </thead>";
      }
    
 
    }

    public function list_order_customer(){
       $getdata = $this->m_so->list_order_customer();
       echo json_encode($getdata);   
    }

    public function list_sodetail_bycustomer(){  
  
      $data =  $this->input->post('data');
       
        $sql = "select 
        a.*,b.nama_produk,c.nama_bahan,c.ukuran,d.nama_satuan,c.berat_bahan from 
        m_pricelist a
        LEFT JOIN m_produk b on b.id = a.id_produk
        LEFT JOIN m_bahan c on c.id = a.id_bahan
        LEFT JOIN m_satuan d on d.id= c.id_satuan where a.no_order = '".$data."'  order by a.id asc";
        $exsql = $this->db->query($sql)->result();
      
        $dataparse = array();  
           foreach ($exsql as $key => $value) {  

                $sub_array['no'] = $no;
                $sub_array['produk'] = $row->nama_produk;   
                $sub_array['design'] = $row->design_file_upload;   
                $sub_array['qty'] = $row->qty;  
                $sub_array['total'] = $row->total;  
                $sub_array['action'] = "<button type='button' onclick='HapusDetailList(".$value->id.",".$data.");'> Hapus </button>";
                // $sub_array['action'] =  "<button type='button' onclick='HapusDetailList(".$value->id.",".$data.");' class = 'btn btn-danger'> <i class='material-icons'>delete_forever</i> Hapus </button>";  
   
               array_push($dataparse,$sub_array); 
            }  
       
        echo json_encode($dataparse);
 
    }

 

  	public function get_last_id(){
    $params = date('Ymd');
		echo $this->transaksi_id($params); 
    $dataid = $this->transaksi_id($params); 
    //store
    $sql = "insert into t_so (no_so) values ('".$this->transaksi_id($params)."')";
    $this->db->query($sql);

	  }

    public function hapus_no_order(){
      $no_order = $this->input->post('no_order');
      echo $no_order;
      $this->db->query("delete from t_so where no_order = '".$no_order."' ");

    }
 
     
	  public function transaksi_id($param = '') {
        $data = $this->m_so->get_no();
        $lastid = $data->row();
        $idnya = $lastid->id;


        if($idnya == '') { // bila data kosong
            $ID = $param . "0000001";
            //00000001
        }else {
            $MaksID = $idnya;
            $MaksID++;
            if ($MaksID < 10)
                $ID = $param . "000000" . $MaksID;
            else if ($MaksID < 100)
                $ID = $param . "00000" . $MaksID;
            else if ($MaksID < 1000)
                $ID = $param . "0000" . $MaksID;
            else if ($MaksID < 10000)
                $ID = $param . "000" . $MaksID;
            else if ($MaksID < 100000)
                $ID = $param . "00" . $MaksID;
            else if ($MaksID < 1000000)
                $ID = $param . "0" . $MaksID;
            else
                $ID = $MaksID;
        }

        return $ID;
    }  	

    public function invoice_id($param = '') {
        $data = $this->m_so->get_invoice_no();
        $lastid = $data->row();
        $idnya = $lastid->id;


        if($idnya == '') { // bila data kosong
            $ID = $param . "0000001";
            //00000001
        }else {
            $MaksID = $idnya;
            $MaksID++;
            if ($MaksID < 10)
                $ID = $param . "000000" . $MaksID;
            else if ($MaksID < 100)
                $ID = $param . "00000" . $MaksID;
            else if ($MaksID < 1000)
                $ID = $param . "0000" . $MaksID;
            else if ($MaksID < 10000)
                $ID = $param . "000" . $MaksID;
            else if ($MaksID < 100000)
                $ID = $param . "00" . $MaksID;
            else if ($MaksID < 1000000)
                $ID = $param . "0" . $MaksID;
            else
                $ID = $MaksID;
        }

        return $ID;
    }   
   
	  
  public function get_data_produk(){
    $id = $this->uri->segment(3);
    $sql = "select 
        a.*,b.nama_produk,c.nama_bahan,c.ukuran,d.nama_satuan,c.berat_bahan from 
        m_pricelist a
        LEFT JOIN m_produk b on b.id = a.id_produk
        LEFT JOIN m_bahan c on c.id = a.id_bahan
        LEFT JOIN m_satuan d on d.id= c.id_satuan where a.id = '".$id."' ";
    $get = $this->db->query($sql)->row();
    echo json_encode($get,TRUE);
  }
 
	
   public function hapus_data_detail(){
 
    $id = $this->input->post('id');
    $no_so = $this->input->post('no_so');

    $arr = array('id'=>$id,'no_so'=>$no_so);
    $get = $this->db->where($arr)->get('t_so_detail')->row();
 
    
    $arr = array('id'=>$id,'no_so'=>$no_so);
 
      $delitem = $this->db->where($arr)->delete('t_so_detail');
      
      if($delitem){
        $result = array("response"=>array('message'=>'success')); 
      }else{
        $result = array("response"=>array('message'=>'failed'));
      }
 
    
    echo json_encode($result,TRUE);
  }

  public function detailmodal(){
    $no_transaksi = $this->uri->segment(3);
     
    $sql = "select a.*,c.pic,c.nama_instansi,c.alamat,c.telp,d.nama,d.nip,e.nama_kategori_instansi from t_pengeluaran a
    left join t_pengeluaran_detail b on b.no_transaksi = a.no_transaksi
    left join m_instansi c on c.id = a.id_instansi
    left join m_pegawai d on d.id = a.id_pegawai
    left join m_kategori_instansi e on e.id = c.id_kategori_instansi where a.no_transaksi = '".$no_transaksi."' ";
    $parse = $this->db->query($sql)->row();
    echo json_encode($parse,TRUE);
  }
  public function hapus_data(){
    $no_so = $this->input->post('no_so'); 
    
    $sa = $this->db->query("select * from t_so where no_so = '".$no_so."' ")->result();
    
    $delete_so = $this->db->where('no_so',$no_so)->delete('t_so');
    $delete_so_detail = $this->db->where('no_so',$no_so)->delete('t_so_detail');
     
    if($delete_so && $delete_so_detail){
      $result = array("response"=>array('message'=>'success')); 
    }else{
      $result = array("response"=>array('message'=>'failed'));
    }

  
  echo json_encode($result,TRUE);
	}

	function berkas_file_upload(){  
	    if(isset($_FILES["berkas_file_upload"])){  
	        $extension = explode('.', $_FILES['berkas_file_upload']['name']);   
	        $destination = './upload/' . $_FILES['berkas_file_upload']['name'];  
	        return move_uploaded_file($_FILES['berkas_file_upload']['tmp_name'], $destination);  
	         
	    }  
  	} 

    function bukti_bayar_upload(){  
      if(isset($_FILES["bukti_bayar_upload"])){  
          $extension = explode('.', $_FILES['bukti_bayar_upload']['name']);   
          $destination = './upload/' . $_FILES['bukti_bayar_upload']['name'];  
          return move_uploaded_file($_FILES['bukti_bayar_upload']['tmp_name'], $destination);  
           
      }  
    } 
 
   public function simpan_data_bb(){
    $no_ordery = $this->input->post('no_ordery');
    $bukti_bayar_upload_file = $this->input->post('bukti_bayar_upload_file');
    
    $data_form = $this->m_so->array_from_post($this->daftar_field);
    $bukti_bayar_upload = $this->bukti_bayar_upload();
    $sql = $this->db->query("update t_so set bukti_bayar_upload = '".$bukti_bayar_upload_file."', bukti_bayar_upload_date = '".date('Y-m-d H:i:s')."',  status ='2' where no_order = '".$no_ordery."' ");

    if($sql && $bukti_bayar_upload){
      $result = array("response"=>array('message'=>'success'));
    }else{
      $result = array("response"=>array('message'=>'failed'));
    }
    
    echo json_encode($result,TRUE);
 
   }

	public function simpan_data(){
    
    
    $data_form = $this->m_so->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 

    $berkas_file_upload = $this->berkas_file_upload();

    if($id == '' || $id == NULL){
    	//query insert
    	$sql = $this->db->query("insert into t_so (no_order,id_pelanggan,date_create,berkas_file,status) values ('".$data_form['no_order']."','".$data_form['id_pelanggan']."','".$data_form['date_create']."','".$data_form['berkas_file']."','1')");
    }else{
    	$sql = $this->db->query("update t_so set no_order = '".$data_form['no_order']."', id_pelanggan = '".$data_form['id_pelanggan']."', berkas_file = '".$data_form['berkas_file']."' where id = '".$id."' ");
    }

    //$simpan_data = $this->m_so->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($sql && $berkas_file_upload){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}

  public function fetch_solist_table(){
    $getdata = $this->m_so->fetch_solist_table();
    echo json_encode($getdata);
  }
            
  public function simpan_summary(){
    $no_transaksi = $this->input->post('no_transaksi');

    //$paraminvoice = "INV".date('Ymd');
    //$no_invoice = $this->invoice_id($paraminvoice);

    //$kurir = $this->input->post('kurir');
 
    $id_instansi = $this->input->post('id_instansi');
    $keterangan = $this->input->post('keterangan');
    $userid = $this->session->userdata('userid');
 
    
    $store = array("id_instansi"=>$id_instansi,"keterangan"=>$keterangan,"id_pegawai"=>$userid,"date_assign"=>date('Y-m-d'));
    $this->db->where('no_transaksi', $no_transaksi);
    $this->db->update('t_pengeluaran', $store);
   


  }
   function upload_file_design(){  
    if(isset($_FILES["file_design_upload"])){  
        $extension = explode('.', $_FILES['file_design_upload']['name']);   
        $destination = './upload/' . str_replace(" ","_", $_FILES['file_design_upload']['name']);  
        return move_uploaded_file($_FILES['file_design_upload']['tmp_name'], $destination);  
         
    }  
  } 




 


}
