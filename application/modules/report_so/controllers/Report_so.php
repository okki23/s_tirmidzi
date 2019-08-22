<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Report_so extends Parent_Controller { 

 	public function __construct(){
 		parent::__construct(); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'report_so/report_so_view';
		$this->load->view('template_view',$data);		
   
	} 

	public function wadah(){
		$filename ="report_so.xls";
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
			
		$from = $this->input->post('from');
		$to = $this->input->post('to');

	 
		$sql = " select a.*,b.nama,b.kode_pelanggan from t_so a
		left join m_customer b on b.id = a.id_customer
		where a.date_assign BETWEEN '".$from."' AND '".$to."' ";
		
		$s = $this->db->query($sql);
		var_dump($s);
			
	 
	}
	public function cetak_report(){
		$filename ="report_so_".date('Y-m-d').".xls";
		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$st = 0;
			
		$sql = " select a.*,b.nama,b.kode_pelanggan from t_so a
		left join m_customer b on b.id = a.id_customer
		where a.date_assign BETWEEN '".$from."' AND '".$to."' ";

		//status_help
		$exsql = $this->db->query($sql)->result();
		echo ' 
		<table width="100%" border="1" cellpadding="3" cellspacing="0"> 
		<tr>
			<th> No SO </th>
			<th> Kode Pelanggan</th>
			<th> Nama Pelanggan</th>  
			<th> Tanggal Keluar </th>
			<th> Status </th> 
		</tr> 
		'; 
		foreach($exsql as $k=>$v){
		echo '
		<tr> 
			<td align="center">'."'".$v->no_so.'</td>
			<td align="center">'.$v->kode_pelanggan.'</td>
			<td align="center">'.$v->nama.'</td> 
			<td align="center">'.tanggalan($v->date_assign).'</td>	 
			<td align="center">'.status_help($v->status).'</td>
		</tr> 
	 
	 <tr>
	 <td colspan="5" align="center"><b> Detail </b> </td>
	 </tr>
			 <tr>
				 <td align="center"> <b> Nama Produk </b> </td>
				 <td align="center"> <b> Qty </b> </td> 
				 <td align="center"> <b> Harga Satuan </b> </td>
				 <td align="center"> <b> Total Harga </b> </td>  
				 <td colspan="1" align="center"> &nbsp; </td>
			 </tr>';

			 $listdetail = $this->db->query("select a.*,b.nama_produk,b.harga_satuan from t_so_detail a
			 left join m_produk b on b.id = a.id_produk where a.no_so = '".$v->no_so."' ");
			foreach($listdetail->result() as $ky=>$vy){
				$st+=($vy->harga_satuan * $vy->qty);
				echo '
				<tr>
					<td align="center">'.$vy->nama_produk.'</td>
					<td align="center"> '.$vy->qty.'</td>
					<td align="center"> Rp. '.number_format($vy->harga_satuan).'</td>
					<td align="center"> Rp. '.number_format(($vy->harga_satuan * $vy->qty)).'</td> 
					<td colspan="1" align="center"> &nbsp; </td>
				</tr>';
			}
			echo '
			<tr>
				 
					<td colspan="3" align="center"> <b>Total </b> </td>
					<td align="center"  align="center"> Rp. '.number_format($st).'</td>
					<td align="center">  &nbsp; </td>
				</tr>';
	 
	 
		 echo ' 
		 <tr>
			<td colspan="5" style="background-color:blue;"> &nbsp; </td> 
		</tr>
		  ';
		}
		 
		echo '</table>';

	}
	   


}
