<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class formasi_jabatan extends Parent_Controller {
 
  var $nama_tabel = 'm_formasi_jabatan';
  var $daftar_field = array('id','id_direktorat','id_departemen','id_seksi','id_kelompok_jabatan','id_divisi','id_parent','id_karyawan','nama_jabatan');
  var $primary_key = 'id';

 

  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_formasi_jabatan'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}

 
  	public function index(){
  		$data['judul'] = $this->data['judul']; 
  		$data['konten'] = 'formasi_jabatan/formasi_jabatan_view';
  		$this->load->view('template_view',$data);		
     
  	}

    public function cetak_report(){
       // headers for download
      $filename = "Pemenuhan Formasi Jabatan  ".tanggalan(date('Y-m-d'))."xls";
 header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=\"Pemenuhan Formasi Jabatan ".tanggalan(date("Y-m-d")).".xls\"");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
 
      $sql = "SELECT g.nama_direktorat,f.nama_divisi,h.nama_departemen,e.nama_seksi,a.nama_jabatan,
              b.npp,b.nama_karyawan from m_formasi_jabatan a
              LEFT JOIN m_karyawan b on b.id = a.id_karyawan
              LEFT JOIN m_kelompok_jabatan c on c.id = a.id_kelompok_jabatan
              LEFT JOIN m_kelas_jabatan d on d.id = c.id_kelas_jabatan
              LEFT JOIN m_seksi e on e.id = a.id_seksi
              LEFT JOIN m_divisi f on f.id = a.id_divisi 
              LEFT JOIN m_direktorat g on g.id = a.id_direktorat
              LEFT JOIN m_departemen h on h.id = a.id_departemen";
      $get = $this->db->query($sql)->result();
      echo  "<table border='1' cellpadding='0' cellspacing='3'> 
            <tr> <h3><b>Pemenuhan Formasi Jabatan ".tanggalan(date("Y-m-d"))."</b></h3></tr>
            <tr>  </tr>

            <tr style='font-weight:bold; text-align:center;'>
            <td> No </td>
            <td> Direktorat </td>
            <td> Divisi </td>
            <td> Departemen </td>
            <td> Seksi </td>
            <td> Jabatan </td>
            <td> NPP </td>
            <td> Nama </td>
            </tr>
            ";
      $no = 1;
      foreach ($get as $key => $value) {
        echo "  <tr>
        <td> ".$no."</td>
            <td> ".$value->nama_direktorat."</td>
            <td> ".$value->nama_divisi."</td>
            <td> ".$value->nama_departemen."</td>
            <td> ".$value->nama_seksi."</td>
            <td> ".$value->nama_jabatan."</td>
            <td> ".$value->npp."</td>
            <td> ".$value->nama_karyawan."</td>
            </tr>";
       $no++;
      }
     
      echo "</table>";
    }
 
  	public function fetch_formasi_jabatan(){  
       $getdata = $this->m_formasi_jabatan->fetch_formasi_jabatan();
       echo json_encode($getdata);   
  	}

  	public function fetch_direktorat(){  
       $getdata = $this->m_formasi_jabatan->fetch_direktorat();
       echo json_encode($getdata);   
  	}  

    public function fetch_parent(){  
       $getdata = $this->m_formasi_jabatan->fetch_parent();
       echo json_encode($getdata);   
    }  

  	public function fetch_kelompok_jabatan(){  
       $getdata = $this->m_formasi_jabatan->fetch_kelompok_jabatan();
       echo json_encode($getdata);   
  	} 

  	public function fetch_npp(){  
       $getdata = $this->m_formasi_jabatan->fetch_npp();
       echo json_encode($getdata);   
  	}  
 
  	public function fetch_nama_divisi(){  
  	   
  	   $id_direktorat =  $this->input->post('id_direktorat');
       $sql = "select * from m_divisi";
   
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();

       foreach ($getdata as $key => $value) {
       	 $row_array['nama'] = $value->nama_divisi; 
       	 $row_array['action'] = "<button typpe='button' onclick='GetDataDivisi(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
       	 array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);
 
  	}  

  	public function fetch_nama_divisi_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_divisi')->row();
  		echo json_encode($data);
  	}


  	public function fetch_nama_departemen(){  
  	   
  	   $id_divisi =  $this->input->post('id_divisi');
       $sql = "select * from m_departemen where id_divisi = '".$id_divisi."' ";
   
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();

       foreach ($getdata as $key => $value) {
       	 $row_array['nama'] = $value->nama_departemen; 
       	 $row_array['action'] = "<button typpe='button' onclick='GetDataDepartemen(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
       	 array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);
 
  	}  
  	public function fetch_nama_departemen_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_departemen')->row();
  		echo json_encode($data);
  	}

  	public function fetch_nama_seksi(){  
  	   
  	   $id_departemen =  $this->input->post('id_departemen');
       $sql = "select * from m_seksi where id_departemen = '".$id_departemen."' ";
   
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();

       foreach ($getdata as $key => $value) {
       	 $row_array['nama'] = $value->nama_seksi; 
       	 $row_array['action'] = "<button typpe='button' onclick='GetDataSeksi(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
       	 array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);
 
  	}  
  	public function fetch_nama_seksi_row(){
  		$id = $this->uri->segment(3);
  		$data = $this->db->where('id',$id)->get('m_seksi')->row();
  		echo json_encode($data);
  	}

    public function fetch_nama_parent_seksi(){  
       
       $id_departemen =  $this->input->post('id_departemen');
       $sql = "select * from m_seksi where id_departemen = '".$id_departemen."' ";
   
       $getdata = $this->db->query($sql)->result();
       $return_arr = array();

       foreach ($getdata as $key => $value) {
         $row_array['nama'] = $value->nama_seksi; 
         $row_array['action'] = "<button typpe='button' onclick='GetDataSeksi(".$value->id.");' class = 'btn btn-warning'> Pilih </button>";  
         array_push($return_arr,$row_array);
       }
       echo json_encode($return_arr);
 
    }  
    public function fetch_nama_parent_seksi_row(){
      $id = $this->uri->segment(3);
      $data = $this->db->where('id',$id)->get('m_seksi')->row();
      echo json_encode($data);
    }



	 
	public function get_data_edit(){
		$id = $this->uri->segment(3);
		$sql = "SELECT a.*,b.id as id_karyawan,b.npp,b.nama_karyawan,c.nama_kelompok_jabatan,d.nama_kelas_jabatan,e.nama_seksi,f.nama_departemen,g.nama_divisi,h.nama_direktorat 
       from m_formasi_jabatan a
      LEFT JOIN m_karyawan b on b.id = a.id_karyawan
      LEFT JOIN m_kelompok_jabatan c on c.id = a.id_kelompok_jabatan
      LEFT JOIN m_kelas_jabatan d on d.id = c.id_kelas_jabatan
      LEFT JOIN m_seksi e on e.id = a.id_seksi
      LEFT JOIN m_departemen f on f.id = a.id_departemen
      LEFT JOIN m_divisi g on g.id = a.id_divisi
      LEFT JOIN m_direktorat h on h.id = a.id_direktorat where a.id = '".$id."' ";
		$get = $this->db->query($sql)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_formasi_jabatan->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_formasi_jabatan->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_formasi_jabatan->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
