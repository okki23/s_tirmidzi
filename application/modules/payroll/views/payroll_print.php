<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style type="text/css">
    .invoice-title h2, .invoice-title h3 {
    display: inline-block;
      }

      .table > tbody > tr > .no-line {
          border-top: none;
      }

      .table > thead > tr > .no-line {
          border-bottom: none;
      }

      .table > tbody > tr > .thick-line {
          border-top: 2px solid;
      }
  </style>
</head>
<body>
<img src="<?php echo base_url('assets/images/mgp.jpeg'); ?>" style="width: 1000%; height: 500%; ">
 
<div class="container">
    <div class="row">
      
 
    
</div>

<h3 align="left"> SLIP GAJI 201801 </h3>  
<br>
<h5> Tanggal Generate : <?php echo $info->date_generate; ?>
<br>
<h5> Tanggal Cetak : <?php echo date('Y-m-d H:i:s'); ?>
<br>
&nbsp;
<hr>
<hr>
<br>
&nbsp;

<table border="1" cellpadding="3" cellspacing="0"> 

      <?php
      foreach($listing as $k => $v){

      
      ?>
      <tr> 
        <td> NIP </td>
        <td> : </td>
        <td> <?php echo $v->nip; ?></td>
      </tr>
      <tr> 
        <td> Nama </td>
        <td> : </td>
        <td> <?php echo $v->nama; ?></td>
      </tr>
      <tr> 
        <td> Telp </td>
        <td> : </td>
        <td> <?php echo $v->telp; ?></td>
      </tr>
      <tr> 
        <td> Email </td>
        <td> : </td>
        <td> <?php echo $v->email; ?></td>
      </tr>
      <tr> 
        <td> Alamat </td>
        <td> : </td>
        <td> <?php echo $v->alamat; ?></td>
      </tr>
      <tr> 
        <td> Jabatan </td>
        <td> : </td>
        <td> <?php echo $v->nama_jabatan; ?></td>
      </tr>
      <tr> 
        <td> Status </td>
        <td> : </td>
        <td> <?php echo $v->nama_status; ?></td>
      </tr> 
      <tr> 
        <td> Gapok </td>
        <td> : </td>
        <td> <?php echo "Rp. ". number_format($v->gapok); ?></td>
      </tr>
      <tr> 
        <td> Tunjangan </td>
        <td> : </td>
        <td> <?php echo "Rp. ". number_format($v->tunjangan); ?></td>
      </tr>
      <tr> 
        <td> Total Gaji </td>
        <td> : </td>
        <td> <?php echo  "Rp. ". number_format((($v->gapok) + ($v->tunjangan))); ?></td>
      </tr>
      <tr> 
        <td> Potongan PPH21 (10%) </td>
        <td> : </td>
        <td> <?php echo  "Rp. ". number_format( ((($v->gapok) + ($v->tunjangan)) * 3) / 100 ); ?> </td>
      </tr>
      <tr>
        <td colspan="3">
          &nbsp; <br>
          &nbsp; <br>
          &nbsp; <br>
          &nbsp; <br>
          &nbsp; <br>

        </td>
      </tr>
      <?php
      }
    ?>

</table>
              
                 

 
   
</body>
</html>