<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Jenis_layanan extends Parent_Controller {
 
  var $nama_tabel = 'm_jenis_pelayanan';
  var $daftar_field = array('id', 'nama_pelayanan');
  var $primary_key = 'id';
  
 	public function __construct(){
 		parent::__construct();
 		$this->load->model('m_jenis_layanan'); 
		if(!$this->session->userdata('username')){
		   echo "<script language=javascript>
				 alert('Anda tidak berhak mengakses halaman ini!');
				 window.location='" . base_url('login') . "';
				 </script>";
		}
 	}
 
	public function index(){
		$data['judul'] = $this->data['judul']; 
		$data['konten'] = 'jenis_layanan/jenis_layanan_view';
		$this->load->view('template_view',$data);		
   
	}

 


	public function print(){
	 	$id_penawaran = $this->uri->segment(3);
		$tahap = $this->uri->segment(4);

		//ENTE AKTIFIN DULU SI SPREADHSEETNYA DIMARIH..
		$spreadsheet = new Spreadsheet();

		// DIMARI ENTE SETTING NAMA DOKUMEN SAMA ATRIBUT LAIN
		$date = tanggalan(date('Y-m-d'));
		$spreadsheet->getProperties()->setCreator('OKKI SETYAWAN - JMTO')
		->setLastModifiedBy('Okki Setyawan - JMTO')
		->setTitle('Laporan Penawaran')
		->setSubject('Laporan Penawaran')
		->setDescription('Laporan Penawaran 5 Layanan Untuk Per Periode '.$date.'')
		->setKeywords('office 2007 openxml php')
		->setCategory('Test result file');

		//ENTE AMBIL DUDULS DATANYE DARI DB JON,BIKIN RESULT AJE SOALNYE DI LOOP
		$sqlpraops = $this->db->query("select b.nama_pricelist,a.kebutuhan,e.nama_satuan,c.harga,(a.kebutuhan * c.harga) as jumlahuraian,a.volume, ((a.kebutuhan * c.harga) * a.volume) as jumlahtahunan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_harsat_val c on c.id_pricelist = b.id 
			LEFT JOIN m_harga d on d.id = c.id_kel_harsat 
			LEFT JOIN m_satuan e on e.id = b.id_satuan
			WHERE a.id_pelayanan = 1 and a.id_penawaran = 1 and a.tahap = 1")->result(); 
		

		// NAH DIMARI ENTE KASIH NAMA BUAT SHEET SELANJUTNYE JON, MULAI DARI PRAOPS SAMPE UMUM DIMARI DIURUT JUGA INDEXNYE DIMULAI DARI ANGKA 0 YE JON, KEK PERTAMINA GITUH
		
		$myWorkSheetPraops = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Praops');
		$myWorkSheetYanTrans = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanTrans');
		$myWorkSheetYanLalin = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanLalin');
		$myWorkSheetYanPML = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanPML');
		$myWorkSheetUmum = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Umum'); 
		$myWorkSheetAsumsi = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Asumsi'); 
		$myWorkSheetRekap = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Rekap'); 

		// NAH UDEH MULAI JON, KITA SET BUAT SI PRAOPS DUDULS JON
		$spreadsheet->addSheet($myWorkSheetPraops, 0);
		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'BIAYA PRAOPS')
		->setCellValue('A2', 'TAHAP 1');
		 
		// INI DATA NYA SI PRAOPS
		// HEADER PRAOPS

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A3', 'KOMPONEN BIAYA')
		->setCellValue('B3', 'KEBUTUHAN')
		->setCellValue('C3', 'SATUAN')
		->setCellValue('D3', 'HARGA SATUAN')
		->setCellValue('E3', 'JUMLAH URAIAN')
		->setCellValue('F3', 'VOLUME')
		->setCellValue('G3', 'JUMLAH TAHUNAN');
		 
		// LOOP DATA PRAOPS
		$i=4; foreach($sqlpraops as $respraops) {

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $respraops->nama_pricelist)
		->setCellValue('B'.$i, $respraops->kebutuhan)
		->setCellValue('C'.$i, $respraops->nama_satuan)
		->setCellValue('D'.$i, $respraops->harga)
		->setCellValue('E'.$i, $respraops->kebutuhan * $respraops->harga)
		->setCellValue('F'.$i, $respraops->volume)
		->setCellValue('G'.$i, $respraops->volume * ($respraops->kebutuhan * $respraops->harga));
		$i++;
		}

		// KASIH NAMA WORKSHEET PRAOPS
		$spreadsheet->getActiveSheet()->setTitle("Praops");
		// BUAT PRA OPS END SAMPE DISINI

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan Penawaran 5 Layanan Untuk Per Periode '.$date.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}

	//asli ini buat ngetes!

	public function pusing(){
			$sqlpraops = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			WHERE a.id_penawaran = 1 and a.tahap = 1 and a.id_pelayanan = 1 GROUP 
			BY c.id")->result();

			$spreadsheet = new Spreadsheet();
			$spreadsheet->getActiveSheet()->mergeCells('A1:G1'); 
			$spreadsheet->getActiveSheet()->mergeCells('A2:G2');

			// DIMARI ENTE SETTING NAMA DOKUMEN SAMA ATRIBUT LAIN
			$date = tanggalan(date('Y-m-d'));
			$spreadsheet->getProperties()->setCreator('OKKI SETYAWAN - JMTO')
			->setLastModifiedBy('Okki Setyawan - JMTO')
			->setTitle('Laporan Penawaran')
			->setSubject('Laporan Penawaran')
			->setDescription('Laporan Penawaran 5 Layanan Untuk Per Periode '.$date.'')
			->setKeywords('office 2007 openxml php')
			->setCategory('Test result file');
			
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A3', 'KOMPONEN BIAYA');
			// LOOP DATA PRAOPS
			$i=4; foreach($sqlpraops as $respraops) {

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$i, $respraops->nama_pricelist);
			$i++;
			}

			// KASIH NAMA WORKSHEET PRAOPS
			$spreadsheet->getActiveSheet()->setTitle("Praops");
			// BUAT PRA OPS END SAMPE DISINI

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$spreadsheet->setActiveSheetIndex(0);

			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Laporan Penawaran 5 Layanan Untuk Per Periode '.$date.'.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
			exit;

	}
	public function loopdata($idkompbiaya){
		$sqla = $this->db->where('id',$idkompbiaya)->get('m_komp_biaya')->row();

		$sqlresall = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan ,SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as resall   from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			WHERE a.id_penawaran = 1 and a.tahap = 1 and a.id_pelayanan = 1 and c.id = '".$idkompbiaya."' ")->row();
		echo "<table width='100%' border='1' cellpadding='3' cellspacing='0'> 
		<tr>
		<td colspan=6> ". $sqla->nama_komp_biaya."</td>
		<td> ".$sqlresall->resall."</td>
		</tr>
		</table>";
 
		$sqlb = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = 1 and a.tahap = 1 and a.id_pelayanan = 1 and c.id = '".$sqla->id."' ")->result();
		echo "<table width='100%' border='1' cellpadding='3' cellspacing='0'>";
	 
		foreach ($sqlb as $key => $value) {
			echo "<tr> 
			<td> ".$value->nama_pricelist."</td>
			<td> ".$value->kebutuhan."</td>
			<td> ".$value->nama_satuan."</td>
			<td> ".$value->value_harsat."</td>
			<td> ".$value->jumlah_uraian."</td>
			<td> ".$value->volume."</td>
			<td> ".$value->jumlah_tahunan."</td>
			</tr>";
			 
		}
		echo "</table>";
	}



	public function testeryo(){
		$id_penawaran = $this->uri->segment(3);
		$tahap = $this->uri->segment(4);

		$sqlpraops = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			WHERE a.id_penawaran = 1 and a.tahap = 1 and a.id_pelayanan = 1 GROUP 
			BY c.id")->result();

		foreach ($sqlpraops as $key => $value) {
		 	$this->loopdata($value->idkompbiaya);
		}
	}
	public function tesprin(){
	$id_penawaran = $this->uri->segment(3);

	$get_tahap_byquery = $this->db->where('id',$id_penawaran)->get("m_penawaran")->row();
	//var_dump($get_tahap_byquery);
	//exit();

	$tahap = $get_tahap_byquery->tahap;
	
	// aktivasi module spreadsheet
	$spreadsheet = new Spreadsheet(); 

	//setting sheet nya
	$myWorkSheetPraops = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Praops');
	$myWorkSheetYanTrans = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanTrans');
	$myWorkSheetYanLalin = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanLalin');
	$myWorkSheetYanPML = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'YanPML');
	$myWorkSheetUmum = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Umum'); 
	$myWorkSheetRekap = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Rekapitulasi Penawaran');
	$myWorkSheetAsumsi = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Asumsi'); 

	//ini buat setting cellborder
	$styleArray = [ 
   'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ]
	];
		
	//ambil penawaran, ada berapa tahap di penawaran itu

	$sqlpe_thp = $this->db->query("select * from m_penawaran where id = '".$id_penawaran."' ")->row();

	//INI SHEET BUAT REKAP
 	
	//INI BUAT AMBIL SHEET  REKAP
	if($tahap == '1'){

		//ambil rekap nya 1 tahap
		$sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yantrans = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

	$spreadsheet->addSheet($myWorkSheetRekap, 0);
	$spreadsheet->setActiveSheetIndex(0);

	$sheet = $spreadsheet->getActiveSheet();
  
	$spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
	$spreadsheet->getActiveSheet()->mergeCells('A2:D2');

	$spreadsheet->getActiveSheet()->mergeCells('A16:B16');
	$spreadsheet->getActiveSheet()->mergeCells('A17:B17');
	$spreadsheet->getActiveSheet()->mergeCells('A18:B18');
	$spreadsheet->getActiveSheet()->mergeCells('A19:B19');
	$spreadsheet->getActiveSheet()->mergeCells('A20:B20');
	$spreadsheet->getActiveSheet()->mergeCells('A21:B21'); 
	 

	$spreadsheet->getActiveSheet()->getStyle('A1:D15')->applyFromArray($styleArray);
	$spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:B10');
  	
  	$spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue($sql_tahap1_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue($sql_tahap1_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue($sql_tahap1_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue($sql_tahap1_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue($sql_tahap1_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');


    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
    	$sql_tahap1_praops_val = 0;
    }else{
    	$sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
    	$sql_tahap1_yantrans_val = 0;
    }else{
    	$sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
    	$sql_tahap1_yanlalin_val = 0;
    }else{
    	$sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
    	$sql_tahap1_yanpml_val = 0;
    }else{
    	$sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
    	$sql_tahap1_umum_val = 0;
    }else{
    	$sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }
 

    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val);

    $manfee = ($subtotal * 8)/100;
    $submanfeetotal = $subtotal + $manfee;

    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C10')
    ->setValue($subtotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D10')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('Management Fee (8%)	'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue($manfee);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue($submanfeetotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue(ceil($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue(ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue(''); 
 
		 
	$spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

		 
	}elseif ($tahap == '2') {
		//ambil rekap nya 1 tahap

		//SECTION TAHAP 1
		$sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yantrans = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		//SECTION TAHAP 2
		$sql_tahap2_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yantrans = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

	$spreadsheet->addSheet($myWorkSheetRekap, 0);
	$spreadsheet->setActiveSheetIndex(0);

	$sheet = $spreadsheet->getActiveSheet();

	$spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
	$spreadsheet->getActiveSheet()->mergeCells('A2:D2');

	$spreadsheet->getActiveSheet()->mergeCells('A16:B16');
	$spreadsheet->getActiveSheet()->mergeCells('A17:B17');
	$spreadsheet->getActiveSheet()->mergeCells('A18:B18');
	$spreadsheet->getActiveSheet()->mergeCells('A19:B19');
	$spreadsheet->getActiveSheet()->mergeCells('A20:B20');
	$spreadsheet->getActiveSheet()->mergeCells('A21:B21'); 
	 

	$spreadsheet->getActiveSheet()->getStyle('A1:D21')->applyFromArray($styleArray);
	$spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:D10');
  	
  	$spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue($sql_tahap1_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue($sql_tahap1_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue($sql_tahap1_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue($sql_tahap1_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue($sql_tahap1_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');

  
    
    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Tahap 2');

     $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B11')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue($sql_tahap2_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B12')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue($sql_tahap2_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B13')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue($sql_tahap2_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B14')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue($sql_tahap2_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B15')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue($sql_tahap2_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue(''); 

    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
    	$sql_tahap1_praops_val = 0;
    }else{
    	$sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
    	$sql_tahap1_yantrans_val = 0;
    }else{
    	$sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
    	$sql_tahap1_yanlalin_val = 0;
    }else{
    	$sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
    	$sql_tahap1_yanpml_val = 0;
    }else{
    	$sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
    	$sql_tahap1_umum_val = 0;
    }else{
    	$sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }

    if($sql_tahap2_praops->semua == NULL || $sql_tahap2_praops->semua == ''){
    	$sql_tahap2_praops_val = 0;
    }else{
    	$sql_tahap2_praops_val = $sql_tahap2_praops->semua;
    }
    
    if($sql_tahap2_yantrans->semua == NULL || $sql_tahap2_yantrans->semua == ''){
    	$sql_tahap2_yantrans_val = 0;
    }else{
    	$sql_tahap2_yantrans_val = $sql_tahap2_yantrans->semua;
    }

    if($sql_tahap2_yanlalin->semua == NULL || $sql_tahap2_yanlalin->semua == ''){
    	$sql_tahap2_yanlalin_val = 0;
    }else{
    	$sql_tahap2_yanlalin_val = $sql_tahap2_yanlalin->semua;
    }

    if($sql_tahap2_yanpml->semua == NULL || $sql_tahap2_yanpml->semua == ''){
    	$sql_tahap2_yanpml_val = 0;
    }else{
    	$sql_tahap2_yanpml_val = $sql_tahap2_yanpml->semua;
    }

    if($sql_tahap2_umum->semua == NULL || $sql_tahap2_umum->semua == ''){
    	$sql_tahap2_umum_val = 0;
    }else{
    	$sql_tahap2_umum_val = $sql_tahap2_umum->semua;
    }


    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val) + intval($sql_tahap2_praops_val) + intval($sql_tahap2_yantrans_val) + intval($sql_tahap2_yanlalin_val) + intval($sql_tahap2_yanpml_val) + intval($sql_tahap2_umum_val);
    $manfee = ($subtotal * 8)/100;
    $submanfeetotal = $subtotal + $manfee;
    $spreadsheet->getActiveSheet()
    ->getCell('A16')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C16')
    ->setValue($subtotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D16')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A17')
    ->setValue('Management Fee (8%)	'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C17')
    ->setValue($manfee);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D17')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A18')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C18')
    ->setValue($submanfeetotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D18')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A19')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C19')
    ->setValue(ceil($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D19')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A20')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C20')
    ->setValue(ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D20')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A21')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C21')
    ->setValue(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D21')
    ->setValue(''); 
 

		 
	$spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

	}elseif ($tahap == '3') {
		//ambil rekap nya 3 tahap 

		//SECTION TAHAP 1
		$sql_tahap1_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yantrans = $this->db->query("SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		$sql_tahap1_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '1'  ")->row();

		//SECTION TAHAP 2
		$sql_tahap2_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yantrans = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		$sql_tahap2_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '2'  ")->row();

		//SECTION TAHAP 3
		$sql_tahap3_praops = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '1'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '3'  ")->row();

		$sql_tahap3_yantrans = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '5'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '3'  ")->row();

		$sql_tahap3_yanlalin =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '6'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '3'  ")->row();

		$sql_tahap3_yanpml = $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '7'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '3'  ")->row();

		$sql_tahap3_umum =  $this->db->query(" SELECT b.nama_pricelist,
	       a.kebutuhan,
	       e.nama_satuan,
	       c.harga,
	       ( a.kebutuhan * c.harga ) AS jumlahuraian,
	       a.volume,
	       ( ( a.kebutuhan * c.harga ) * a.volume )  AS jumlahtahunan,
	       sum(( ( a.kebutuhan * c.harga ) * a.volume )) AS semua
			FROM   t_harga_penawaran a
			       LEFT JOIN m_pricelist b
			              ON b.id = a.id_pricelist
			       LEFT JOIN m_harsat_val c
			              ON c.id_pricelist = b.id
			       LEFT JOIN m_harga d
			              ON d.id = c.id_kel_harsat
			       LEFT JOIN m_satuan e
			              ON e.id = b.id_satuan
			WHERE  a.id_pelayanan = '8'
			       AND a.id_penawaran = '".$id_penawaran."'
			       AND a.tahap = '3'  ")->row();

		$spreadsheet->addSheet($myWorkSheetRekap, 0);
	$spreadsheet->setActiveSheetIndex(0);

	$sheet = $spreadsheet->getActiveSheet();

	$spreadsheet->getActiveSheet()->mergeCells('A1:D1'); 
	$spreadsheet->getActiveSheet()->mergeCells('A2:D2');

	$spreadsheet->getActiveSheet()->mergeCells('A22:B22');
	$spreadsheet->getActiveSheet()->mergeCells('A23:B23');
	$spreadsheet->getActiveSheet() ->mergeCells('A24:B24');
	$spreadsheet->getActiveSheet()->mergeCells('A25:B25');
	$spreadsheet->getActiveSheet()->mergeCells('A26:B26');
	$spreadsheet->getActiveSheet()->mergeCells('A27:B27'); 
	 

	$spreadsheet->getActiveSheet()->getStyle('A1:D27')->applyFromArray($styleArray);
	$spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('REKAPITULASI BIAYA JASA PENGOPERASIAN');
    $spreadsheet->getActiveSheet()
    ->getCell('A2')
    ->setValue(strtoupper($sqlpe_thp->nama_penawaran));
    $spreadsheet->getActiveSheet()
    ->getCell('A3')
    ->setValue('No');
    $spreadsheet->getActiveSheet()
    ->getCell('B3')
    ->setValue('Uraian');
    $spreadsheet->getActiveSheet()
    ->getCell('C3')
    ->setValue('Perkiraan Biaya');
    $spreadsheet->getActiveSheet()
    ->getCell('D3')
    ->setValue('Keterangan');

    $spreadsheet->getActiveSheet()->mergeCells('A4:D4');
    $spreadsheet->getActiveSheet()->mergeCells('A10:D10');
    $spreadsheet->getActiveSheet()->mergeCells('A16:D16');
  	
  	$spreadsheet->getActiveSheet()
    ->getCell('A4')
    ->setValue('Tahap 1');
   
    $spreadsheet->getActiveSheet()
    ->getCell('A5')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B5')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C5')
    ->setValue($sql_tahap1_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D5')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A6')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B6')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C6')
    ->setValue($sql_tahap1_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D6')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A7')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B7')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C7')
    ->setValue($sql_tahap1_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D7')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A8')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B8')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C8')
    ->setValue($sql_tahap1_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D8')
    ->setValue('');

     $spreadsheet->getActiveSheet()
    ->getCell('A9')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B9')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C9')
    ->setValue($sql_tahap1_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D9')
    ->setValue('');

  
    
    $spreadsheet->getActiveSheet()
    ->getCell('A10')
    ->setValue('Tahap 2');

     $spreadsheet->getActiveSheet()
    ->getCell('A11')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B11')
    ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C11')
    ->setValue($sql_tahap2_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D11')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A12')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B12')
    ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C12')
    ->setValue($sql_tahap2_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D12')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A13')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B13')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C13')
    ->setValue($sql_tahap2_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D13')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A14')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B14')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C14')
    ->setValue($sql_tahap2_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D14')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A15')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B15')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C15')
    ->setValue($sql_tahap2_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D15')
    ->setValue('');

    $spreadsheet->getActiveSheet()
    ->getCell('A16')
    ->setValue('Tahap 3');

    $spreadsheet->getActiveSheet()
    ->getCell('A17')
    ->setValue('1');
    $spreadsheet->getActiveSheet()
    ->getCell('B17')
   ->setValue('Pekerjaan Persiapan Operasi');
    $spreadsheet->getActiveSheet()
    ->getCell('C17')
    ->setValue($sql_tahap3_praops->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D17')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A18')
    ->setValue('2');
    $spreadsheet->getActiveSheet()
    ->getCell('B18')
     ->setValue('Lingkup Pelayanan Transaksi');
    $spreadsheet->getActiveSheet()
    ->getCell('C18')
    ->setValue($sql_tahap3_yantrans->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D18')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A19')
    ->setValue('3');
    $spreadsheet->getActiveSheet()
    ->getCell('B19')
    ->setValue('Lingkup Pelayanan Lalin');
    $spreadsheet->getActiveSheet()
    ->getCell('C19')
    ->setValue($sql_tahap3_yanlalin->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D19')
    ->setValue(''); 

     $spreadsheet->getActiveSheet()
    ->getCell('A20')
    ->setValue('4');
    $spreadsheet->getActiveSheet()
    ->getCell('B20')
    ->setValue('Lingkup Pelayanan Pemeliharaan');
    $spreadsheet->getActiveSheet()
    ->getCell('C20')
    ->setValue($sql_tahap3_yanpml->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D20')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A21')
    ->setValue('5');
    $spreadsheet->getActiveSheet()
    ->getCell('B21')
    ->setValue('Beban Administrasi dan Umum');
    $spreadsheet->getActiveSheet()
    ->getCell('C21')
    ->setValue($sql_tahap3_umum->semua);
    $spreadsheet->getActiveSheet()
    ->getCell('D21')
    ->setValue(''); 

    //total disini
    if($sql_tahap1_praops->semua == NULL || $sql_tahap1_praops->semua == ''){
    	$sql_tahap1_praops_val = 0;
    }else{
    	$sql_tahap1_praops_val = $sql_tahap1_praops->semua;
    }
    
    if($sql_tahap1_yantrans->semua == NULL || $sql_tahap1_yantrans->semua == ''){
    	$sql_tahap1_yantrans_val = 0;
    }else{
    	$sql_tahap1_yantrans_val = $sql_tahap1_yantrans->semua;
    }

    if($sql_tahap1_yanlalin->semua == NULL || $sql_tahap1_yanlalin->semua == ''){
    	$sql_tahap1_yanlalin_val = 0;
    }else{
    	$sql_tahap1_yanlalin_val = $sql_tahap1_yanlalin->semua;
    }

    if($sql_tahap1_yanpml->semua == NULL || $sql_tahap1_yanpml->semua == ''){
    	$sql_tahap1_yanpml_val = 0;
    }else{
    	$sql_tahap1_yanpml_val = $sql_tahap1_yanpml->semua;
    }

    if($sql_tahap1_umum->semua == NULL || $sql_tahap1_umum->semua == ''){
    	$sql_tahap1_umum_val = 0;
    }else{
    	$sql_tahap1_umum_val = $sql_tahap1_umum->semua;
    }

    if($sql_tahap2_praops->semua == NULL || $sql_tahap2_praops->semua == ''){
    	$sql_tahap2_praops_val = 0;
    }else{
    	$sql_tahap2_praops_val = $sql_tahap2_praops->semua;
    }
    
    if($sql_tahap2_yantrans->semua == NULL || $sql_tahap2_yantrans->semua == ''){
    	$sql_tahap2_yantrans_val = 0;
    }else{
    	$sql_tahap2_yantrans_val = $sql_tahap2_yantrans->semua;
    }

    if($sql_tahap2_yanlalin->semua == NULL || $sql_tahap2_yanlalin->semua == ''){
    	$sql_tahap2_yanlalin_val = 0;
    }else{
    	$sql_tahap2_yanlalin_val = $sql_tahap2_yanlalin->semua;
    }

    if($sql_tahap2_yanpml->semua == NULL || $sql_tahap2_yanpml->semua == ''){
    	$sql_tahap2_yanpml_val = 0;
    }else{
    	$sql_tahap2_yanpml_val = $sql_tahap2_yanpml->semua;
    }

    if($sql_tahap2_umum->semua == NULL || $sql_tahap2_umum->semua == ''){
    	$sql_tahap2_umum_val = 0;
    }else{
    	$sql_tahap2_umum_val = $sql_tahap2_umum->semua;
    }

    if($sql_tahap3_praops->semua == NULL || $sql_tahap3_praops->semua == ''){
    	$sql_tahap3_praops_val = 0;
    }else{
    	$sql_tahap3_praops_val = $sql_tahap3_praops->semua;
    }
    
    if($sql_tahap3_yantrans->semua == NULL || $sql_tahap3_yantrans->semua == ''){
    	$sql_tahap3_yantrans_val = 0;
    }else{
    	$sql_tahap3_yantrans_val = $sql_tahap3_yantrans->semua;
    }

    if($sql_tahap3_yanlalin->semua == NULL || $sql_tahap3_yanlalin->semua == ''){
    	$sql_tahap3_yanlalin_val = 0;
    }else{
    	$sql_tahap3_yanlalin_val = $sql_tahap3_yanlalin->semua;
    }

    if($sql_tahap3_yanpml->semua == NULL || $sql_tahap3_yanpml->semua == ''){
    	$sql_tahap3_yanpml_val = 0;
    }else{
    	$sql_tahap3_yanpml_val = $sql_tahap3_yanpml->semua;
    }

    if($sql_tahap3_umum->semua == NULL || $sql_tahap3_umum->semua == ''){
    	$sql_tahap3_umum_val = 0;
    }else{
    	$sql_tahap3_umum_val = $sql_tahap2_umum->semua;
    }


    $subtotal = intval($sql_tahap1_praops_val) + intval($sql_tahap1_yantrans_val) + intval($sql_tahap1_yanlalin_val) + intval($sql_tahap1_yanpml_val) + intval($sql_tahap1_umum_val) + intval($sql_tahap2_praops_val) + intval($sql_tahap2_yantrans_val) + intval($sql_tahap2_yanlalin_val) + intval($sql_tahap2_yanpml_val) + intval($sql_tahap2_umum_val) +  intval($sql_tahap3_praops_val) + intval($sql_tahap3_yantrans_val) + intval($sql_tahap3_yanlalin_val) + intval($sql_tahap3_yanpml_val) + intval($sql_tahap3_umum_val);

    $manfee = ($subtotal * 8)/100;

    $submanfeetotal = $subtotal + $manfee;

    $spreadsheet->getActiveSheet()
    ->getCell('A22')
    ->setValue('Subtotal'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C22')
    ->setValue($subtotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D22')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A23')
    ->setValue('Management Fee (8%)	'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C23')
    ->setValue($manfee);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D23')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A24')
    ->setValue('Jumlah'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C24')
    ->setValue($submanfeetotal);//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D24')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A25')
    ->setValue('Pembulatan'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C25')
    ->setValue(ceil($submanfeetotal));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D25')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A26')
    ->setValue('PPN10%'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C26')
    ->setValue(ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D26')
    ->setValue(''); 

    $spreadsheet->getActiveSheet()
    ->getCell('A27')
    ->setValue('Jumlah Termasuk PPN'); 
    $spreadsheet->getActiveSheet()
    ->getCell('C27')
    ->setValue(ceil($submanfeetotal) + ceil(($submanfeetotal)*10/100));//nanti di kalkulasi 
     $spreadsheet->getActiveSheet()
    ->getCell('D27')
    ->setValue(''); 
 	$spreadsheet->getActiveSheet()->setTitle("Rekapitulasi Penawaran");

	}
  
	
	//GANTI SHEET, INI SHEET NYA ASUMSI

	$spreadsheet->addSheet($myWorkSheetAsumsi, 1);
	$spreadsheet->setActiveSheetIndex(1);
	
	$sheet = $spreadsheet->getActiveSheet();
	$spreadsheet->getActiveSheet()->mergeCells('A1:L1');
	$spreadsheet->getActiveSheet()
    ->getCell('A1')
    ->setValue('ASUMSI PERHITUNGAN PENAWARAN PT JMTO UNTUK :'); 
 
	 
	//kondisi si asumsi ini berapa?
 

	if($tahap == '1'){
		$spreadsheet->getActiveSheet()->getStyle('A2:F46')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

    	$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    	$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

		$sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
			LEFT JOIN m_asumsi b on b.id = a.id_asumsi
			LEFT JOIN m_satuan c on c.id = b.id_satuan 
			WHERE a.id_penawaran = '".$id_penawaran."' 
			and a.tahap = 1 ")->result();

		foreach (range(1,1) as $i) {
		 
		 $row = 4;
		 $nourut = 1;
		 foreach ($sqlasumsitahap1 as $keys => $values) {
		 	$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
			$sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
			$sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
			$sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
			$sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
		 $nourut++;
		 $row++;
		 } 
	    
		}  

	}elseif ($tahap == '2') {

		$spreadsheet->getActiveSheet()->getStyle('A2:L46')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

    	$spreadsheet->getActiveSheet()->mergeCells('H2:M2');
    	$spreadsheet->getActiveSheet()->getCell('H2')->setValue('Tahap 2');

    	$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    	$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

 
    	$spreadsheet->getActiveSheet()->getCell('H3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('I3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('L3')->setValue('Keterangan'); 

		$sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 ")->result();


		$sqlasumsitahap2 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 ")->result();

	 

		foreach (range(1,2) as $i) {
		 
		 $row = 4;
		 $nourut = 1;
		 foreach ($sqlasumsitahap1 as $keys => $values) {
		 	$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
			$sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
			$sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
			$sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
			$sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
		 $nourut++;
		 $row++;
		 }

		 $rowx = 4;
		 $nourutx = 1;
		 foreach ($sqlasumsitahap2 as $keyx => $valuex) {
 
			$sheet->setCellValueByColumnAndRow(8, $rowx, $valuex->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(9, $rowx, $valuex->vol);
			$sheet->setCellValueByColumnAndRow(10, $rowx, $valuex->nama_satuan);
			$sheet->setCellValueByColumnAndRow(11, $rowx, $valuex->safety_factor);
			$sheet->setCellValueByColumnAndRow(12, $rowx, $valuex->keterangan);
		 $nourutx++;
		 $rowx++;
		 }

		 
		  
	    
		}  


		  
	}elseif ($tahap == '3') {
		 $spreadsheet->getActiveSheet()->getStyle('A2:R46')->applyFromArray($styleArray);

		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');

    	$spreadsheet->getActiveSheet()->mergeCells('H2:M2');
    	$spreadsheet->getActiveSheet()->getCell('H2')->setValue('Tahap 2');

    	$spreadsheet->getActiveSheet()->mergeCells('N2:R2');
    	$spreadsheet->getActiveSheet()->getCell('N2')->setValue('Tahap 3');

    	$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
    	$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('D3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('E3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('F3')->setValue('Keterangan'); 

 
    	$spreadsheet->getActiveSheet()->getCell('H3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('I3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('L3')->setValue('Keterangan'); 

    	$spreadsheet->getActiveSheet()->getCell('N3')->setValue('Uraian');
    	$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Volume');
    	$spreadsheet->getActiveSheet()->getCell('P3')->setValue('Satuan');
    	$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('Safety Factor');
    	$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Keterangan'); 

		$sqlasumsitahap1 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 ")->result();


		$sqlasumsitahap2 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 ")->result();

		$sqlasumsitahap3 = $this->db->query("select a.*,b.nama_asumsi,c.nama_satuan from m_asumsi_list a
LEFT JOIN m_asumsi b on b.id = a.id_asumsi
LEFT JOIN m_satuan c on c.id = b.id_satuan WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 ")->result();

	 

		foreach (range(1,3) as $i) {
		 
		 $row = 4;
		 $nourut = 1;
		 foreach ($sqlasumsitahap1 as $keys => $values) {
		 	$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
			$sheet->setCellValueByColumnAndRow(2, $row, $values->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(3, $row, $values->vol);
			$sheet->setCellValueByColumnAndRow(4, $row, $values->nama_satuan);
			$sheet->setCellValueByColumnAndRow(5, $row, $values->safety_factor);
			$sheet->setCellValueByColumnAndRow(6, $row, $values->keterangan);
		 $nourut++;
		 $row++;
		 }

		 $rowx = 4;
		 $nourutx = 1;
		 foreach ($sqlasumsitahap2 as $keyx => $valuex) {
 
			$sheet->setCellValueByColumnAndRow(8, $rowx, $valuex->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(9, $rowx, $valuex->vol);
			$sheet->setCellValueByColumnAndRow(10, $rowx, $valuex->nama_satuan);
			$sheet->setCellValueByColumnAndRow(11, $rowx, $valuex->safety_factor);
			$sheet->setCellValueByColumnAndRow(12, $rowx, $valuex->keterangan);
		 $nourutx++;
		 $rowx++;
		 }

		 $rowy = 4;
		 $nouruty = 1;
		 foreach ($sqlasumsitahap3 as $keyy => $valuey) {
 
			$sheet->setCellValueByColumnAndRow(14, $rowy, $valuey->nama_asumsi);
			$sheet->setCellValueByColumnAndRow(15, $rowy, $valuey->vol);
			$sheet->setCellValueByColumnAndRow(16, $rowy, $valuey->nama_satuan);
			$sheet->setCellValueByColumnAndRow(17, $rowy, $valuey->safety_factor);
			$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->keterangan);
		 $nouruty++;
		 $rowy++;
		 }

		 
		  
	    
		}  


	}


	$spreadsheet->getActiveSheet()->setTitle("Asumsi");

	  

	//GANTI SHEETNYA , INI PRAOPS
	
	$spreadsheet->addSheet($myWorkSheetPraops, 2);
	$spreadsheet->setActiveSheetIndex(2);
	$spreadsheet->getActiveSheet()->mergeCells('A1:X1');
	$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pra Operasi');
	$sheet = $spreadsheet->getActiveSheet();

	if($tahap == '1'){
  
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
   		 
   		$sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

   
   		$countpopst1 = $sqlpraopstahap1->num_rows();
    
   		foreach (range(1,1) as $i) {
	   		
	   		$row = 5;
			$nourut = 1;
			$tempHead = ""; 
		 
	   		foreach ($sqlpraopstahap1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
		   		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   	}
 
   		}
   		 

	}elseif ($tahap == '2') {
		 
		
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

   		$sqlpraopstahap2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 ");
 
 
   		$countpopst1 = $sqlpraopstahap1->num_rows();
   		$countpopst2 = $sqlpraopstahap2->num_rows();
   	 
   		foreach (range(1,2) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlpraopstahap1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlpraopstahap2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

 
 


   		}

	}elseif ($tahap == '3') {
	 	

		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

 		$spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
		$spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
		$spreadsheet->getActiveSheet()->mergeCells('R3:R4');
		$spreadsheet->getActiveSheet()->mergeCells('S3:V3');
		$spreadsheet->getActiveSheet()->mergeCells('W3:X3');

    	$spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
 		$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlpraopstahap1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 ");

   		$sqlpraopstahap2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 ");

   		$sqlpraopstahap3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 1 ");
 
 
   		$countpopst1 = $sqlpraopstahap1->num_rows();
   		$countpopst2 = $sqlpraopstahap2->num_rows();
   		$countpopst3 = $sqlpraopstahap3->num_rows();
   	 
   		foreach (range(1,3) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlpraopstahap1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlpraopstahap2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

	   		//loop yang 3
	   		$rowy = 5;
			$nouruty = 1;
			$tempHeady = "";
			 
		 
	   		foreach ($sqlpraopstahap3->result() as $keyy => $valuey) {

	   			$resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 1 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
		   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
		   				$rowy++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
   				$sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
	   			$tempHeady = $valuey->nama_komp_biaya;
		   		$nouruty++;
				$rowy++;
	   		 
	   		}
 
   		}
	 	 
   		 
	}
	 
		
	$spreadsheet->getActiveSheet()->setTitle("Praops");




	//GANTI SHEETNYA , INI YANTRANS
	
	$spreadsheet->addSheet($myWorkSheetYanTrans, 3);
	$spreadsheet->setActiveSheetIndex(3);
	$spreadsheet->getActiveSheet()->mergeCells('A1:X1');
	$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Transaksi');
	$sheet = $spreadsheet->getActiveSheet();

	if($tahap == '1'){
  
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
   		 
   		$sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

   
   		$countpyantrans1 = $sqlyantrans1->num_rows();
    
   		foreach (range(1,1) as $i) {
	   		
	   		$row = 5;
			$nourut = 1;
			$tempHead = ""; 
		 
	   		foreach ($sqlyantrans1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
		   		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   	}
 
   		}
   		 

	}elseif ($tahap == '2') {
		 
		
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

   		$sqlyantrans2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 ");
 
 
   		$countpyantrans1 = $sqlyantrans1->num_rows();
   		$countpyantrans2 = $sqlyantrans2->num_rows();
   	 
   		foreach (range(1,2) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyantrans1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyantrans2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

 
 


   		}

	}elseif ($tahap == '3') {
	 	

		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

 		$spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
		$spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
		$spreadsheet->getActiveSheet()->mergeCells('R3:R4');
		$spreadsheet->getActiveSheet()->mergeCells('S3:V3');
		$spreadsheet->getActiveSheet()->mergeCells('W3:X3');

    	$spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
 		$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyantrans1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 ");

   		$sqlyantrans2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 ");

   		$sqlyantrans3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 5 ");
 
 
   		$countpyantrans1 = $sqlyantrans1->num_rows();
   		$countpyantrans2 = $sqlyantrans2->num_rows();
   		$countpyantrans3 = $sqlyantrans3->num_rows();
   	 
   		foreach (range(1,3) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyantrans1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyantrans2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

	   		//loop yang 3
	   		$rowy = 5;
			$nouruty = 1;
			$tempHeady = "";
			 
		 
	   		foreach ($sqlyantrans3->result() as $keyy => $valuey) {

	   			$resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 5 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
		   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
		   				$rowy++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
   				$sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
	   			$tempHeady = $valuey->nama_komp_biaya;
		   		$nouruty++;
				$rowy++;
	   		 
	   		}
 
   		}
	 	 
   		 
	}
	 
		
	$spreadsheet->getActiveSheet()->setTitle("YanTrans");



	//GANTI SHEETNYA , INI YANLALIN
	
	$spreadsheet->addSheet($myWorkSheetYanLalin, 4);
	$spreadsheet->setActiveSheetIndex(4);
	$spreadsheet->getActiveSheet()->mergeCells('A1:X1');
	$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Lalu Lintas');
	$sheet = $spreadsheet->getActiveSheet();

	if($tahap == '1'){
  
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
   		 
   		$sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   
   		$countpyanlalin1 = $sqlyanlalin1->num_rows();
    
   		foreach (range(1,1) as $i) {
	   		
	   		$row = 5;
			$nourut = 1;
			$tempHead = ""; 
		 
	   		foreach ($sqlyanlalin1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
		   		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   	}
 
   		}
   		 

	}elseif ($tahap == '2') {
		 
		
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
   		$countpyanlalin1 = $sqlyanlalin1->num_rows();
   		$countpyanlalin2 = $sqlyanlalin2->num_rows();
   	 
   		foreach (range(1,2) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyanlalin1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyanlalin2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

 
 


   		}

	}elseif ($tahap == '3') {
	 	

		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

 		$spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
		$spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
		$spreadsheet->getActiveSheet()->mergeCells('R3:R4');
		$spreadsheet->getActiveSheet()->mergeCells('S3:V3');
		$spreadsheet->getActiveSheet()->mergeCells('W3:X3');

    	$spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
 		$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

   		$sqlyanlalin3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
   		$countpyanlalin1 = $sqlyanlalin1->num_rows();
   		$countpyanlalin2 = $sqlyanlalin2->num_rows();
   		$countpyanlalin3 = $sqlyanlalin3->num_rows();
   	 
   		foreach (range(1,3) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyanlalin1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyanlalin2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

	   		//loop yang 3
	   		$rowy = 5;
			$nouruty = 1;
			$tempHeady = "";
			 
		 
	   		foreach ($sqlyanlalin3->result() as $keyy => $valuey) {

	   			$resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
		   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
		   				$rowy++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
   				$sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
	   			$tempHeady = $valuey->nama_komp_biaya;
		   		$nouruty++;
				$rowy++;
	   		 
	   		}
 
   		}
	 	 
   		 
	}
	  
	$spreadsheet->getActiveSheet()->setTitle("Yan Lalin");




	//GANTI SHEETNYA , INI YANPML
	
	$spreadsheet->addSheet($myWorkSheetYanPML, 5);
	$spreadsheet->setActiveSheetIndex(5);
	$spreadsheet->getActiveSheet()->mergeCells('A1:X1');
	$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Pelayanan Pemeliharaan');
	$sheet = $spreadsheet->getActiveSheet();

	if($tahap == '1'){
  
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
   		 
   		$sqlyanpml1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 ");

   
   		$countpyanpml1 = $sqlyanpml1->num_rows();
    
   		foreach (range(1,1) as $i) {
	   		
	   		$row = 5;
			$nourut = 1;
			$tempHead = ""; 
		 
	   		foreach ($sqlyanpml1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
		   		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   	}
 
   		}
   		 

	}elseif ($tahap == '2') {
		 
		
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
   		$countpyanlalin1 = $sqlyanlalin1->num_rows();
   		$countpyanlalin2 = $sqlyanlalin2->num_rows();
   	 
   		foreach (range(1,2) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyanlalin1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyanlalin2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

 
 


   		}

	}elseif ($tahap == '3') {
	 	

		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

 		$spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
		$spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
		$spreadsheet->getActiveSheet()->mergeCells('R3:R4');
		$spreadsheet->getActiveSheet()->mergeCells('S3:V3');
		$spreadsheet->getActiveSheet()->mergeCells('W3:X3');

    	$spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
 		$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlyanlalin1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlyanlalin2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

   		$sqlyanlalin3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
   		$countpyanlalin1 = $sqlyanlalin1->num_rows();
   		$countpyanlalin2 = $sqlyanlalin2->num_rows();
   		$countpyanlalin3 = $sqlyanlalin3->num_rows();
   	 
   		foreach (range(1,3) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlyanlalin1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlyanlalin2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

	   		//loop yang 3
	   		$rowy = 5;
			$nouruty = 1;
			$tempHeady = "";
			 
		 
	   		foreach ($sqlyanlalin3->result() as $keyy => $valuey) {

	   			$resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
		   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
		   				$rowy++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
   				$sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
	   			$tempHeady = $valuey->nama_komp_biaya;
		   		$nouruty++;
				$rowy++;
	   		 
	   		}
 
   		}
	 	 
   		 
	}
	  
	$spreadsheet->getActiveSheet()->setTitle("Yan PML");
  	


	//GANTI SHEETNYA , INI YANUMUM
	
	$spreadsheet->addSheet($myWorkSheetUmum, 6);
	$spreadsheet->setActiveSheetIndex(6);
	$spreadsheet->getActiveSheet()->mergeCells('A1:X1');
	$spreadsheet->getActiveSheet()->getCell('A1')->setValue('Biaya Umum');
	$sheet = $spreadsheet->getActiveSheet();

	if($tahap == '1'){
  
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 
   		 
   		$sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 ");

   
   		$countpumum1 = $sqlumum1->num_rows();
    
   		foreach (range(1,1) as $i) {
	   		
	   		$row = 5;
			$nourut = 1;
			$tempHead = ""; 
		 
	   		foreach ($sqlumum1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 7 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {  
		   		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   	}
 
   		}
   		 

	}elseif ($tahap == '2') {
		 
		
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlumum2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");
 
 
   		$countpumum1 = $sqlumum1->num_rows();
   		$countpumum2 = $sqlumum2->num_rows();
   	 
   		foreach (range(1,2) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlumum1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row(); 

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlumum2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nourut);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

 
 


   		}

	}elseif ($tahap == '3') {
	 	

		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:A4');
		$spreadsheet->getActiveSheet()->mergeCells('B3:B4');
		$spreadsheet->getActiveSheet()->mergeCells('C3:F3');
		$spreadsheet->getActiveSheet()->mergeCells('G3:H3');

    	$spreadsheet->getActiveSheet()->getCell('A2')->setValue('Tahap 1');
 		$spreadsheet->getActiveSheet()->getCell('A3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('B3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('C3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('G3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('C4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('D4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('E4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('F4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('G4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('H4')->setValue('Jumlah'); 

 		$spreadsheet->getActiveSheet()->mergeCells('I2:P2');
		$spreadsheet->getActiveSheet()->mergeCells('I3:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J3:J4');
		$spreadsheet->getActiveSheet()->mergeCells('K3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('O3:P3');

    	$spreadsheet->getActiveSheet()->getCell('I2')->setValue('Tahap 2');
 		$spreadsheet->getActiveSheet()->getCell('I3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('J3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('K3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('O3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('K4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('L4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('M4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('N4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('O4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('P4')->setValue('Jumlah');

 		$spreadsheet->getActiveSheet()->mergeCells('Q2:X2');
		$spreadsheet->getActiveSheet()->mergeCells('Q3:Q4');
		$spreadsheet->getActiveSheet()->mergeCells('R3:R4');
		$spreadsheet->getActiveSheet()->mergeCells('S3:V3');
		$spreadsheet->getActiveSheet()->mergeCells('W3:X3');

    	$spreadsheet->getActiveSheet()->getCell('Q2')->setValue('Tahap 3');
 		$spreadsheet->getActiveSheet()->getCell('Q3')->setValue('No');
 		$spreadsheet->getActiveSheet()->getCell('R3')->setValue('Komponen Biaya');
 		$spreadsheet->getActiveSheet()->getCell('S3')->setValue('Uraian Biaya');
 		$spreadsheet->getActiveSheet()->getCell('W3')->setValue('Tahunan');

 		$spreadsheet->getActiveSheet()->getCell('S4')->setValue('Kebutuhan');
 		$spreadsheet->getActiveSheet()->getCell('T4')->setValue('Satuan');
 		$spreadsheet->getActiveSheet()->getCell('U4')->setValue('Harga Satuan');
 		$spreadsheet->getActiveSheet()->getCell('V4')->setValue('Jumlah');
 		$spreadsheet->getActiveSheet()->getCell('W4')->setValue('Volume');
 		$spreadsheet->getActiveSheet()->getCell('X4')->setValue('Jumlah'); 
 
 
   		 
   		$sqlumum1 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 ");

   		$sqlumum2 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 ");

   		$sqlumum3 = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan from t_harga_penawaran a
			LEFT JOIN m_pricelist b on b.id = a.id_pricelist
			LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
			LEFT JOIN m_satuan d on d.id = b.id_satuan
			WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 ");
 
 
   		$countpumum1 = $sqlumum1->num_rows();
   		$countpumum2 = $sqlumum2->num_rows();
   		$countpumum3 = $sqlumum3->num_rows();
   	 
   		foreach (range(1,3) as $i) {
   			//loop yang 1
	   		$row = 5;
			$nourut = 1;
			$tempHead = "";
			 
		 
	   		foreach ($sqlumum1->result() as $key => $value) {

	   			$resulkompsum = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 1 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$value->idkompbiaya."' ")->row();
				
			  

		   			if($tempHead == "" || $tempHead != $value->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(1, $row, $nourut);
		   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($resulkompsum->allresult));
		   				$row++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(2, $row, $value->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(3, $row, $value->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(4, $row, $value->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(5, $row, number_format($value->value_harsat));
   				$sheet->setCellValueByColumnAndRow(6, $row, number_format($value->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(7, $row, $value->volume);
   				$sheet->setCellValueByColumnAndRow(8, $row, number_format($value->jumlah_tahunan));
	   			$tempHead = $value->nama_komp_biaya;
		   		$nourut++;
				$row++;
	   		 
	   		}


	   		//loop yang 2
	   		$rows = 5;
			$nouruts = 1;
			$tempHeads = "";
			 
		 
	   		foreach ($sqlumum2->result() as $keys => $values) {

	   			$resulkompsums = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 2 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$values->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeads == "" || $tempHeads != $values->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(9, $rows, $nouruts);
		   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($resulkompsums->allresult));
		   				$rows++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(10, $rows, $values->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(11, $rows, $values->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(12, $rows, $values->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(13, $rows, number_format($values->value_harsat));
   				$sheet->setCellValueByColumnAndRow(14, $rows, number_format($values->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(15, $rows, $values->volume);
   				$sheet->setCellValueByColumnAndRow(16, $rows, number_format($values->jumlah_tahunan));
	   			$tempHeads = $values->nama_komp_biaya;
		   		$nouruts++;
				$rows++;
	   		 
	   		}

	   		//loop yang 3
	   		$rowy = 5;
			$nouruty = 1;
			$tempHeady = "";
			 
		 
	   		foreach ($sqlumum3->result() as $keyy => $valuey) {

	   			$resulkompsumy = $this->db->query("SELECT a.*,b.nama_pricelist,c.id as idkompbiaya, c.nama_komp_biaya,(a.kebutuhan * a.value_harsat) as jumlah_uraian, ((a.kebutuhan * a.value_harsat) * a.volume) as jumlah_tahunan, d.nama_satuan, SUM(((a.kebutuhan * a.value_harsat) * a.volume)) as allresult from t_harga_penawaran a
					LEFT JOIN m_pricelist b on b.id = a.id_pricelist
					LEFT JOIN m_komp_biaya c on c.id = b.id_komp_biaya 
					LEFT JOIN m_satuan d on d.id = b.id_satuan
					WHERE a.id_penawaran = '".$id_penawaran."' and a.tahap = 3 and a.id_pelayanan = 6 and b.id_komp_biaya = '".$valuey->idkompbiaya."' ")->row();
				
			  

		   			if($tempHeady == "" || $tempHeady != $valuey->nama_komp_biaya) {   
		   		 		 
		   				$sheet->setCellValueByColumnAndRow(17, $rowy, $nouruty);
		   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_komp_biaya);
		   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($resulkompsumy->allresult));
		   				$rowy++;
		   			}
	   		 
	   			 
					 
   				$sheet->setCellValueByColumnAndRow(18, $rowy, $valuey->nama_pricelist);
   				$sheet->setCellValueByColumnAndRow(19, $rowy, $valuey->kebutuhan);
   				$sheet->setCellValueByColumnAndRow(20, $rowy, $valuey->nama_satuan);
   				$sheet->setCellValueByColumnAndRow(21, $rowy, number_format($valuey->value_harsat));
   				$sheet->setCellValueByColumnAndRow(22, $rowy, number_format($valuey->jumlah_uraian));
   				$sheet->setCellValueByColumnAndRow(23, $rowy, $valuey->volume);
   				$sheet->setCellValueByColumnAndRow(24, $rowy, number_format($valuey->jumlah_tahunan));
	   			$tempHeady = $valuey->nama_komp_biaya;
		   		$nouruty++;
				$rowy++;
	   		 
	   		}
 
   		}
	 	 
   		 
	}
	  
	$spreadsheet->getActiveSheet()->setTitle("Yan Umum");
  

  	//INI PERINTAH BUAT GENERATE
		$writer = new Xlsx($spreadsheet);
		$filename = 'upload/test.xlsx';
		$writer->save($filename);
		echo 'saved to: ' . $filename . PHP_EOL;
	}
 
  	public function fetch_jenis_layanan(){  
       $getdata = $this->m_jenis_layanan->fetch_jenis_layanan();
       echo json_encode($getdata);   
  	}  
	 
	public function get_data_edit(){
		$id = $this->uri->segment(3); 
		$get = $this->db->where($this->primary_key,$id)->get($this->nama_tabel)->row();
		echo json_encode($get,TRUE);
	}
	 
	public function hapus_data(){
		$id = $this->uri->segment(3);  
    

    $sqlhapus = $this->m_jenis_layanan->hapus_data($id);
		
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
	 
	public function simpan_data(){
    
    
    $data_form = $this->m_jenis_layanan->array_from_post($this->daftar_field);

    $id = isset($data_form['id']) ? $data_form['id'] : NULL; 
 

    $simpan_data = $this->m_jenis_layanan->simpan_data($data_form,$this->nama_tabel,$this->primary_key,$id);
 
		if($simpan_data){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);

	}
 
  
       


}
