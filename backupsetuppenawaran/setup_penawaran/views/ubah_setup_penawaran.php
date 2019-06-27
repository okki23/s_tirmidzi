<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $judul; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
 
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
     
    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />
    
    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
 
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
	
	<link href="<?php echo base_url(); ?>assets/css/card_custom.css" rel="stylesheet" />
    
    <!-- Jquery Core Js -->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
 
   
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>

    <script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>js/filterDropDown.js"></script>
 
    <script src="<?php echo base_url(); ?>assets/js/dataTables.rowsGroup.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script> 
 
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.numeric.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
   
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script> 
 
    <script src="<?php echo base_url(); ?>assets/plugins/autosize/autosize.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/ui/notifications.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/momentjs/moment.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>   
    <script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
  
 
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/forms/form-wizard.js"></script>

   
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Mohon Tunggu...</p>
        </div>
    </div>
    
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                 
                <a class="navbar-brand" href="javascript::void(0);"> Setup Penawaran </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
              
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
     
 
        <div class="container-fluid" style="margin-top: 80px;">
            <div class="block-header">
                 
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card responsive">
                        <div class="header">
                            <h2>
                            Setup Penawaran

                            </h2>
                          
 
                        </div>
                        <div class="body">
                                
                             Pilih Tahap :  <b> <?php echo $tahap; ?> </b>
                              <br>
  
                              
                              <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#pra_ops" data-toggle="tab">Pra Ops</a></li>
                                <li role="presentation"><a href="#yan_trans" data-toggle="tab">Yan Trans</a></li>
                                <li role="presentation"><a href="#yan_lalin" data-toggle="tab">Yan Lalin</a></li>
                                <li role="presentation"><a href="#yan_pml" data-toggle="tab">Yan PML</a></li>
                                <li role="presentation"><a href="#umum" data-toggle="tab">Umum</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="pra_ops">
                                   <form method="post" id="user_form_praops" enctype="multipart/form-data">  

                                     <input type="hidden" name="id_penawaranx" id="id_penawaranx" value="<?php echo $this->uri->segment(3); ?>">
                                      <input type="hidden" name="tahapx" id="tahapx" value="<?php echo $this->uri->segment(4); ?>">

                                      <table class="table table-responsive table-bordered table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Komponen Biaya</th>
                                                    <th style="width: 5%;">Kebutuhan</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 10%;">Harga Satuan</th>
                                                    <th style="width: 5%;">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($list_praops as $key=>$value){
                                                ?>
                                                <tr>

                        <td>
                            <?php echo $value->nama_pricelist."<input type='hidden' name='id[]' value=".$value->id."> "; ?>
                            
                        </td> 
                        <td> 
                            <?php echo "<input type='text' name='kebutuhan[]' class='form-control'  value='".$value->kebutuhan."' id='kebutuhan_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$value->nama_pricelist))."_".$value->id_komp_biaya."' >"; ?> 
                        </td>
                        <td>
                       <?php echo $value->nama_satuan; ?> 
                        </td>
                        <td> <?php echo "Rp. ".number_format($value->value_harsat); ?>  </td>
                         <td>   <?php echo "<input type='text' name='volume[]' class='form-control'   value='0' id='volume_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$value->nama_pricelist))."_".$value->id_komp_biaya."' >"; ?> </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                <td colspan="5"> 
                                                    <h3 align="center" > 
                                                        <p id ="msg_praops_form"> </p> 
                                                    </h3> 

                                                     <div id="loading_praops">
                                                     <div align="center">
                                                        <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                                     </div>
                                                     <br>
                                                     <h3 align="center"> Mohon tunggu, data sedang di rubah ... </h3>
                                                     </div>
                                                </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        <br>
                                         <table>
                                    <tr>
                                        <td>  <button type="button" id="simpan_data_praops_btn" onclick="Simpan_Data_Ubah_Praops();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Ubah Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" id="calc_data_praops_btn" onclick="Calculate_Praops();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                    
                                </table>
                                    </form>

                                        <br>


                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="yan_trans">
                                  <form method="post" id="user_form_yantrans" enctype="multipart/form-data">  
  

                                     <input type="hidden" name="id_penawaran_trans" id="id_penawaran_trans" value="<?php echo $this->uri->segment(3); ?>">
                                      <input type="hidden" name="tahap_trans" id="tahap_trans" value="<?php echo $this->uri->segment(4); ?>">
 
                                      <table class="table table-responsive table-bordered table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Komponen Biaya</th>
                                                    <th style="width: 5%;">Kebutuhan</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 10%;">Harga Satuan</th>
                                                    <th style="width: 5%;">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($list_yan_trans as $keys=>$values){
                                                ?>
                                                <tr>

                                                <td>
                                                    <?php echo $values->nama_pricelist."<input type='hidden' name='id[]' value=".$values->id."> "; ?> 
                                                </td> 
                                                <td> 
                                                    <?php echo "<input type='text' name='kebutuhan[]' class='form-control'  value='".$values->kebutuhan."' id='kebutuhan_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$values->nama_pricelist))."_".$values->idku."' >"; ?> 
                                                </td>
                                                <td>
                                               <?php echo $values->nama_satuan; ?> 
                                                </td>
                                                 <td> <?php echo "Rp. ".number_format($values->value_harsat); ?>  </td>
                                                 <td>   <?php echo "<input type='text' name='volume[]' class='form-control'   value='".$values->volume."' id='volume_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$values->nama_pricelist))."_".$values->id."' >"; ?> </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                <td colspan="5"> 
                                                    <h3 align="center" > 
                                                        <p id ="msg_yantrans_form"> </p> 
                                                    </h3> 

                                                     <div id="loading_yantrans">
                                                     <div align="center">
                                                        <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                                     </div>
                                                     <br>
                                                     <h3 align="center"> Mohon tunggu, data sedang di rubah ... </h3>
                                                     </div>
                                                </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        <br>
                                         <table>
                                    <tr>
                                        <td>  <button type="button" id="simpan_data_yantrans_btn" onclick="Simpan_Data_Ubah_YanTrans();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Ubah Data </button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" id="calc_data_yantrans_btn" onclick="Calculate_YanTrans();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate </button> </td>
                                    </tr>
                                    
                                </table>
                                    </form>
                                    <br>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="yan_lalin">
                                       <form method="post" id="user_form_yanlalin" enctype="multipart/form-data">  
  

                                        <input type="hidden" name="id_penawaran_lalin" id="id_penawaran_lalin" value="<?php echo $this->uri->segment(3); ?>">

                                        <input type="hidden" name="tahap_lalin" id="tahap_lalin" value="<?php echo $this->uri->segment(4); ?>">
                                     
                                        <table class="table table-responsive table-bordered table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Komponen Biaya</th>
                                                    <th style="width: 5%;">Kebutuhan</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 10%;">Harga Satuan</th>
                                                    <th style="width: 5%;">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($list_yan_lalin as $keyz=>$valuez){
                                                ?>
                                                <tr>

                                                <td>
                                                    <?php echo $valuez->nama_pricelist."<input type='hidden' name='id[]' value=".$valuez->id.">   "; ?> 
                                                </td> 
                                                <td> 
                                                    <?php echo "<input type='text' name='kebutuhan[]' class='form-control'  value='".$valuez->kebutuhan."' id='kebutuhan_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuez->nama_pricelist))."_".$valuez->id_pricelist."' >"; ?> 
                                                </td>
                                                <td>
                                               <?php echo $valuez->nama_satuan; ?> 
                                                </td>
                                                 <td> <?php echo "Rp. ".number_format($valuez->value_harsat); ?>  </td>
                                                 <td>   <?php echo "<input type='text' name='volume[]' class='form-control'   value='".$valuez->volume."' id='volume_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuez->nama_pricelist))."_".$valuez->id."' >"; ?> </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                <td colspan="5"> 
                                                    <h3 align="center" > 
                                                        <p id ="msg_yanlalin_form"> </p> 
                                                    </h3> 

                                                     <div id="loading_yanlalin">
                                                     <div align="center">
                                                        <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                                     </div>
                                                     <br>
                                                     <h3 align="center"> Mohon tunggu, data sedang di rubah ... </h3>
                                                     </div>
                                                </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </form>
                                        
                                        <br>
                                         <table>
                                    <tr>
                                        <td>  <button type="button" id="simpan_data_lalin_btn" onclick="Simpan_Data_Ubah_Lalin();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Lalin();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="yan_pml">

                                     <form method="post" id="user_form_yanpmls" enctype="multipart/form-data">  
  

                                        <input type="hidden" name="id_penawaran_yanpml" id="id_penawaran_yanpml" value="<?php echo $this->uri->segment(3); ?>">

                                        <input type="hidden" name="tahap_pml" id="tahap_pml" value="<?php echo $this->uri->segment(4); ?>">

                                       
 
                                     
                                     <table class="table table-responsive table-bordered table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Komponen Biaya</th>
                                                    <th style="width: 5%;">Kebutuhan</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 10%;">Harga Satuan</th>
                                                    <th style="width: 5%;">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($list_yan_pml as $keyc=>$valuec){
                                                ?>
                                                <tr>

                                             <td>
                                                    <?php echo $valuec->nama_pricelist."<input type='hidden' name='id[]' value=".$valuec->id.">   "; ?> 
                                                </td> 
                                                <td> 
                                                    <?php echo "<input type='text' name='kebutuhan[]' class='form-control'  value='".$valuec->kebutuhan."' id='kebutuhan_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuec->nama_pricelist))."_".$valuec->id_pricelist."' >"; ?> 
                                                </td>
                                                <td>
                                               <?php echo $valuec->nama_satuan; ?> 
                                                </td>
                                                 <td> <?php echo "Rp. ".number_format($valuec->value_harsat); ?>  </td>
                                                 <td>   <?php echo "<input type='text' name='volume[]' class='form-control'   value='".$valuec->volume."' id='volume_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuec->nama_pricelist))."_".$valuec->id."' >"; ?> </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                 <tr>
                                                <td colspan="5"> 
                                                    <h3 align="center" > 
                                                        <p id ="msg_yanpml_form"> </p> 
                                                    </h3> 

                                                     <div id="loading_yanpml">
                                                     <div align="center">
                                                        <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                                     </div>
                                                     <br>
                                                     <h3 align="center"> Mohon tunggu, data sedang di rubah ... </h3>
                                                     </div>
                                                </td>
                                                </tr>
                                               
                                               
                                            </tbody>
                                        </table>
                                    </form>
                                    
                                         <br>
                                         <table>
                                    <tr>
                                        <td>  &nbsp; </td>
                                        <td>
                                         <button type="button" onclick="Simpan_Data_Ubah_Pml();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button>  &nbsp; <button type="button" onclick="Calculate_Pml();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="umum">

                                     <form method="post" id="user_form_umum" enctype="multipart/form-data">  
  

                                        <input type="hidden" name="id_penawaran_umum" id="id_penawaran_umum" value="<?php echo $this->uri->segment(3); ?>">

                                        <input type="hidden" name="tahap_umum" id="tahap_umum" value="<?php echo $this->uri->segment(4); ?>">
                                    <table class="table table-responsive table-bordered table-hovered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Komponen Biaya</th>
                                                    <th style="width: 5%;">Kebutuhan</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 10%;">Harga Satuan</th>
                                                    <th style="width: 5%;">Volume</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($list_umum as $keyv=>$valuev){
                                                ?>
                                                  <tr>

                                             <td>
                                                    <?php echo $valuev->nama_pricelist."<input type='hidden' name='id[]' value=".$valuev->id.">   "; ?> 
                                                </td> 
                                                <td> 
                                                    <?php echo "<input type='text' name='kebutuhan[]' class='form-control'  value='".$valuev->kebutuhan."' id='kebutuhan_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuev->nama_pricelist))."_".$valuev->id_pricelist."' >"; ?> 
                                                </td>
                                                <td>
                                               <?php echo $valuev->nama_satuan; ?> 
                                                </td>
                                                 <td> <?php echo "Rp. ".number_format($valuev->value_harsat); ?>  </td>
                                                 <td>   <?php echo "<input type='text' name='volume[]' class='form-control'   value='".$valuev->volume."' id='volume_".strtolower(str_replace(array(" ","/","-",".","(",")","+",":",",","'"),"",$valuev->nama_pricelist))."_".$valuev->id."' >"; ?> </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>

                                                 <tr>
                                                <td colspan="5"> 
                                                    <h3 align="center" > 
                                                        <p id ="msg_umum_form"> </p> 
                                                    </h3> 

                                                     <div id="loading_umum">
                                                     <div align="center">
                                                        <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                                     </div>
                                                     <br>
                                                     <h3 align="center"> Mohon tunggu, data sedang di rubah ... </h3>
                                                     </div>
                                                </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </form>
                                         <br>
                                         <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data_Ubah_Umum();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Umum();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                                </div>
                            </div>


 




                               </div>
                    </div>
                </div>
            </div>
         


        </div>
 
  

 
</body>

</html>
<script type="text/javascript">
   $('#id_tahapx').on('change',function(){
        var data = $("#id_tahapx").val(); 
            $("#tahap_trans").val(data);
            $("#tahapx").val(data);
        });

      function Simpan_Data_Ubah_Umum(){
      
         var formData = new FormData($('#user_form_umum')[0]);  
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah_umum",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false, 
                beforeSend: function(){
                   $("#loading_umum").show();
                    $("#msg_umum_form").html("");
                 },
                 complete: function(){
                   $("#loading_umum").hide();
                    $("#msg_umum_form").html("Data sudah di rubah!");
                 },  
                success:function(result){ 
                
                  
                 $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 },{
                    type: 'success'
                });
             }
            }); 

    }

      function Simpan_Data_Ubah_Pml(){
     
          //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_yanpmls')[0]); 
 
        
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah_pml",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false, 
              beforeSend: function(){
                   $("#loading_yanpml").show();
                    $("#msg_yanpml_form").html("");
                 },
                 complete: function(){
                   $("#loading_yanpml").hide();
                    $("#msg_yanpml_form").html("Data sudah di rubah!");
                 },  
             success:function(result){ 
                
                  
                 $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 },{
                    type: 'success'
                });
             }
            }); 

    }

    function Simpan_Data_Ubah_Lalin(){
        //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_yanlalin')[0]); 

           
        
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah_lalin",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false, 
              beforeSend: function(){
                   $("#loading_yanlalin").show();
                    $("#msg_yanlalin_form").html("");
                 },
                 complete: function(){
                   $("#loading_yanlalin").hide();
                    $("#msg_yanlalin_form").html("Data sudah di rubah!");
                 },  
             success:function(result){ 
                
                 //$("#UbahHargaModal").modal('hide');
                 //$('#example').DataTable().ajax.reload(); 
                 // $('#examplez').DataTable().ajax.reload(); 
      
                 //$('#user_form_update')[0].reset();
                 //Bersihkan_Form();
                 $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 },{
                    type: 'success'
                });
             }
            }); 

  
       
    }

    function Simpan_Data_Ubah_Praops(){
        //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_praops')[0]); 

           
        
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah_praops",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false, 
              beforeSend: function(){
                   $("#loading_praops").show();
                    $("#msg_praops_form").html("");
                 },
                 complete: function(){
                   $("#loading_praops").hide();
                    $("#msg_praops_form").html("Data sudah di rubah!");
                 },  
             success:function(result){ 
                
                 //$("#UbahHargaModal").modal('hide');
                 //$('#example').DataTable().ajax.reload(); 
                 // $('#examplez').DataTable().ajax.reload(); 
      
                 //$('#user_form_update')[0].reset();
                 //Bersihkan_Form();
                 $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 },{
                    type: 'success'
                });
             }
            }); 

  
      
            

    }

    function Simpan_Data_Ubah_YanTrans(){
        //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_yantrans')[0]); 

           
        
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah_yantrans",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false, 
              beforeSend: function(){
                   $("#loading_yantrans").show();
                    $("#msg_yantrans_form").html("");
                 },
                 complete: function(){
                   $("#loading_yantrans").hide();
                    $("#msg_yantrans_form").html("Data sudah di rubah!");
                 },  
             success:function(result){ 
                
                 //$("#UbahHargaModal").modal('hide');
                 //$('#example').DataTable().ajax.reload(); 
                 // $('#examplez').DataTable().ajax.reload(); 
      
                 //$('#user_form_update')[0].reset();
                 //Bersihkan_Form();
                 $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 },{
                    type: 'success'
                });
             }
            }); 

  
      
            

    }

    function Calculate_Umum(){

  var id_penawaranx = $("#id_penawaran_umum").val(); 
        var tahapx = $("#tahap_umum").val();  

        if(tahapx == ''){
            alert("anda belum memilih tahap!");
        }else{


            
            var tiket_senior = (parseInt($("#kebutuhan_direksi_434").val()) + parseInt($("#kebutuhan_kepalabirodivisi_435").val()));
            $("#kebutuhan_tiket_436").val(tiket_senior)
            
             var tiket_senior_sosman = (parseInt($("#kebutuhan_setingkatkepalabagian_439").val()) + parseInt($("#kebutuhan_setingkatkepalasubbagian_440").val()) + parseInt($("#kebutuhan_setingkatjuru_441").val()) );
            $("#kebutuhan_tiket_442").val(tiket_senior_sosman)
            
            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_grup_e');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_formulirkartukendali2ply_411").val(result);
                    $("#kebutuhan_formulirtandaterima2ply_412").val(result);
                    $("#kebutuhan_fomulirijinmeninggalkankantor_413").val(result);
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_teh_celup');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_tehcelup_446").val(result);
                   
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_sabun_cuci_piring');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_sabunpencucipiring_447").val(result);
                   
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_tissue');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_tissue_451").val(result);
                   
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_gas_elpiji');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_gaselpijiisiulang_453").val(result);
                   
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_pembasmi_serangga');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_pembasmiserangga_454").val(result);
                   
                }
            });

            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_sewagalondispenser');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_sewagalondandispenserkantordangerbang_456").val(result);
                   
                }
            });

             $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_kotakp3kantor');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_kotakp3kkantorgerbangtoldankendaraan_457").val(result);
                   
                }
            });

              
            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_airminumkantortamu');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_airminumkantortamu_455").val(result);
                   
                }
            });
 
             

             $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_sabun_cair_handsoap');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_sabuncairhandsoap_450").val(result);
                   
                }
            }); 
 
            $.ajax({
                  url:"<?php echo base_url('setup_penawaran/call_umum_bast_tugas');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_beritaacaraserahterimatugas_419").val(result);
                    
                }
            });
            
            $.ajax({
                  url:"<?php echo base_url('setup_penawaran/call_umum_penjilidan');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_biayapenjilidan_432").val(result);
                    
                }
            });

 

            $.ajax({
                  url:"<?php echo base_url('setup_penawaran/call_umum_bast_operasional');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_beritaacarakejadianoperasional_420").val(result);
                      
                }
            })

           
            $.ajax({
                url:"<?php echo base_url('setup_penawaran/call_umum_grup_f');?>",
                type:"POST",
                data:{id_penawaran:id_penawaranx,tahap:tahapx},
                success:function(result){
                    console.log(result);
                    $("#kebutuhan_kertashvsa4_427").val(result);
                    $("#kebutuhan_tonercartridge_428").val(result);
                     
                }
            });
 
            
            //1
            $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_umum_grup_a');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#volume_formulirkartukendali2ply_411").val(result);
                $("#volume_formulirtandaterima2ply_412").val(result);
                $("#volume_kopsurat_414").val(result);
                $("#volume_formulirspt_415").val(result);
                $("#volume_formulirkecelakaanumum_416").val(result);
                $("#volume_formulirpenyuluhan_417").val(result);
                $("#volume_formulirlaporanhasiltugaspengamanan_418").val(result);
                $("#volume_beritaacaraserahterimatugas_419").val(result);
                $("#volume_beritaacarakejadianoperasional_420").val(result);
                $("#volume_formulirlaporankerusakanperalatansaranatol_421").val(result);
                $("#volume_meterairp3000_424").val(result);
                $("#volume_meterairp6000_425").val(result); 
                $("#volume_tangga_458").val(result); 
                
            }
            });  
            
            //7
            $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_umum_grup_b');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result); 
                $("#volume_fomulirijinmeninggalkankantor_413").val(result);
                $("#volume_pengadaanperangkokirimantercatat_423").val(result);
                $("#volume_kertashvsa4_427").val(result);
                $("#volume_kebutuhanatklainlain_429").val(result);
                $("#volume_biayafotocopy_431").val(result);
                $("#volume_biayapenjilidan_432").val(result);

                $("#volume_gulapasir_444").val(result);
                $("#volume_kopi_445").val(result);
                $("#volume_tehcelup_446").val(result);
                $("#volume_sabunpencucipiring_447").val(result);
                $("#volume_busapencucipiring_448").val(result);
                $("#volume_sabuncair_449").val(result);
                $("#volume_sabuncairhandsoap_450").val(result);
                $("#volume_tissue_451").val(result);
                $("#volume_tehtehseduh_452").val(result);
                $("#volume_gaselpijiisiulang_453").val(result);
                $("#volume_pembasmiserangga_454").val(result);
                $("#volume_airminumkantortamu_455").val(result);
                $("#volume_sewagalondandispenserkantordangerbang_456").val(result);
 
         
            }
            });  

            //3
            $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_umum_grup_c');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result); 
                $("#volume_tonercartridge_428").val(result);
                $("#volume_tiket_436").val(result);
                $("#volume_tiket_442").val(result);
                $("#volume_kotakp3kkantorgerbangtoldankendaraan_457").val(result);
               
            }
            });  

            //6
            $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_umum_grup_d');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result); 
                $("#volume_direksi_434").val(result);
                $("#volume_kepalabirodivisi_435").val(result);
                $("#volume_sewakendaraanbbmdansupir_437").val(result);
                $("#volume_setingkatkepalabagian_439").val(result);
                $("#volume_setingkatkepalasubbagian_440").val(result);
                $("#volume_setingkatjuru_441").val(result); 
                $("#volume_sewakendaraanbbmdansupir2_443").val(result); 
         
            }
            });  
        }
  
 
        }
    function Calculate_Pml(){


        var id_penawaranx = $("#id_penawaran_yanpml").val(); 
        var tahapx = $("#tahap_pml").val();  

        if(tahapx == ''){
            alert("anda belum memilih tahap!");
        }else{
 
     
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_asmen_pemeliharaaan');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_asistenmanagerpemeliharaan_378").val(result);
                $("#kebutuhan_asistenmanagerpemeliharaan_381").val(result);
              
            }
        });

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_pml_grup_a');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#volume_asistenmanagerpemeliharaan_378").val(result);
                $("#volume_jurutatausahapemeliharaan_379").val(result);
                $("#volume_tupemeliharaanteknisiinspektor_380").val(result);
                $("#volume_asistenmanagerpemeliharaan_381").val(result);
                $("#volume_inspeksipml_382").val(result);
                $("#volume_bahanpembersih_387").val(result);
                $("#volume_pemotonganrumput_400").val(result);
                $("#volume_pembabatansemak_401").val(result);
                $("#volume_pemeliharaangenset_406").val(result);
                $("#volume_sapujalan_408").val(result);
         
             
            }
        });


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_pml_grup_b');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#volume_bbmasistenmanager_383").val(result);
                $("#volume_bbminspeksipml_384").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_pml_grup_c');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#volume_pemeliharaanacgardutol_402").val(result); 
                $("#volume_pemeliharaanackantorgerbang_403").val(result);
                $("#volume_pemeliharaanackantoroperasi_404").val(result);
                $("#volume_pembersihansalurandrainase_405").val(result);
             
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_pml_grup_d');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#volume_obkantor_385").val(result);
                $("#volume_obgerbang_386").val(result);
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_jutu_pml');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_jurutatausahapemeliharaan_379").val(result);
   
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_jutu_pml');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_jurutatausahapemeliharaan_379").val(result);
   
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_teknisi_inspektor');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_tupemeliharaanteknisiinspektor_380").val(result);
   
                
            }
        });

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_inspeksi_pml');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_inspeksipml_382").val(result);
   
                
            }
        });

      
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_bbm_asmens');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bbmasistenmanager_383").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_bbm_inspeksi_pml');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bbminspeksipml_384").val(result); 
            }
        });


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_ob_kantor');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_obkantor_385").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_ob_gerbang');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_obgerbang_386").val(result); 
            }
        });

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_kebersihan');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bahanpembersih_387").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_potong_rumput');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pemotonganrumput_400").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_potong_semak');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pembabatansemak_401").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_sum_ac_gardu_toll');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pemeliharaanacgardutol_402").val(result); 
            }
        });
 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_ac_kantor_gerbang');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pemeliharaanackantorgerbang_403").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_ac_kantor_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pemeliharaanackantoroperasi_404").val(result); 
            }
        });


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_drainase');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pembersihansalurandrainase_405").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_plhgenset');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pemeliharaangenset_406").val(result); 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pml_sapujalan');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_sapujalan_408").val(result); 
            }
        });
 
 

        }
  
 
        }

 function Calculate_YanTrans(){


        var id_penawaranx = $("#id_penawaran_trans").val(); 
        var tahapx = $("#tahap_trans").val();  

        if(tahapx == ''){
            alert("anda belum memilih tahap!");
        }else{
 
     
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_manager_area_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_managerarea_231").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_manager_area_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_managerarea_231").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_juru_tata_usaha_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_jurutatausaha_232").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_asisten_manager_transaksi_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_asistenmanagertransaksi_233").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kepala_shift_pengumpul_tol_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pengumpultol_235").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_tuadministrasigt_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_tuadministrasigerbangtol_236").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_kendaraan_shuttle_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_sewakendaraanshuttle_237").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_bbm_shuttle_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bbmshuttle_238").val(result);
                 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pengemuditahunkontrak_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pengemuditahunkontrak_239").val(result);
                 
            }
        }); 
 
        }

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_sewa_kendaraan_manager_area');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_sewakendaraanmanagerarea_240").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_kendaraan_asisten_manager_transaksi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_sewakendaraanasistenmanagertransaksi_241").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_bbm_manager_area');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bbmmanagerarea_242").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_bbm_asisten_manager');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_bbmasistenmanager_243").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_yantrans_rollpaper');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_rollpaper57x110mm_244").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_yantrans_kttm');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_kttm_245").val(result);
                 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_yantrans_continious_form');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_continousformuk912x112ply1000sheet_247").val(result);
            $("#kebutuhan_continousformuk1478x112ply1000sheet_248").val(result);
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_laserjet_toner');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_tonerlaserjet_249").val(result);
            $("#kebutuhan_cartridge_250").val(result);
            }
        }); 

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kertas_hvs_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_kertasa4_251").val(result);
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_vol_kontrak');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#volume_managerarea_231").val(result);
            $("#volume_jurutatausaha_232").val(result);
            $("#volume_asistenmanagertransaksi_233").val(result);
            $("#volume_kepalashiftpengumpulantol_234").val(result);
            $("#volume_pengumpultol_235").val(result);
            $("#volume_tuadministrasigerbangtol_236").val(result);
            $("#volume_sewakendaraanshuttle_237").val(result);
            $("#volume_pengemuditahunkontrak_239").val(result);
            $("#volume_sewakendaraanmanagerarea_240").val(result);
            $("#volume_sewakendaraanasistenmanagertransaksi_241").val(result);
            $("#volume_continousformuk912x112ply1000sheet_247").val(result);
            $("#volume_continousformuk1478x112ply1000sheet_248").val(result);
            $("#volume_cartridge_250").val(result);
            $("#volume_kertasa4_251").val(result);
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_vol_toner_lasjet_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#volume_tonerlaserjet_249").val(result);
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_vol_toner_lasjet_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#volume_tonerlaserjet_249").val(result);
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_vol_tahunan_yantrans');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#volume_bbmshuttle_238").val(result);
            $("#volume_bbmmanagerarea_242").val(result);
            $("#volume_bbmasistenmanager_243").val(result);
            $("#volume_rollpaper57x110mm_244").val(result);
 
            }
        }); 
  
 
        }


    

    



    function Calculate_Praops(){


        var id_penawaranx = $("#id_penawaranx").val(); 
        var tahapx = $("#tahapx").val();  

     
 
        //ambil biaya materai
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_biaya_materai');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_biayamaterai_3").val(result);
                $("#jumlah_uraian_biaya_materai_3").val(parseInt($("#harga_biaya_materai").val()) * result);
                $("#kebutuhan_verifikasidanklarifikasidata_3").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_fotocopy_perjanjian');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_fotocopyperjanjian_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_pulsa_telepon');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_pulsatelepon_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_manager_area');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksimanagerarea_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_asisten_manager');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksiasistenmanager_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kspt_ks_patroli');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksiksptdankspatroli_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_pik');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksipik_3").val(result);
            
            }
        });


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_jtu');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksijtu_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_tu');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_seleksitu_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_seleksi_narkoba');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_tesnarkoba_3").val(result);
            
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_honor_pengajar');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpengajar_7").val(result);
                $("#kebutuhan_tiket_7").val(result);
                $("#kebutuhan_perjalanandinas_7").val(result);
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_akomodasi_pelatihan');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_akomodasipelatihan_7").val(result);
               
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_kendaraan_bus');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_sewakendaraanbus_7").val(result);
               
            }
        });

        //new segment
        //kebutuhan_honorpengajar_9
        //kebutuhan_tiket_9
        //kebutuhan_perjalanandinas_9
        //kebutuhan_akomodasipelatihan_9
        //kebutuhan_tunjanganbelajar_9
        //Pelatihan SOP KSPT dan KS Patroli
        //pelatihan_sop_kspt_dan_ks_patroli
         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_honor_pengajar_pelatihan_sop_kspt_dan_ks_patroli');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpengajar_9").val(result);
                $("#kebutuhan_tiket_9").val(result);
                $("#kebutuhan_perjalanandinas_9").val(result);
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_akomodasi_pelatihan_pelatihan_sop_kspt_dan_ks_patroli');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_akomodasipelatihan_9").val(result);
               
                
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_tunjangan_belajar_pelatihan_sop_kspt_dan_ks_patroli');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_tunjanganbelajar_9").val(result);
               
            }
        });

        var pro_tiket_jm = (parseInt($("#kebutuhan_setingkatahliutama_11").val()) + parseInt($("#kebutuhan_setingkatahlimadya_11").val()) + parseInt($("#kebutuhan_setingkatahlimuda_11").val()) + parseInt($("#kebutuhan_pelaksanateknisi_11").val()));

        $("#kebutuhan_tiketpp_11").val(pro_tiket_jm);


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_manager_area_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honormanagerarea_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_asisten_manager_yantran_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorasistenmanageryantran_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_kepala_shift_pengumpulantol_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorkepalashiftpengumpulantol_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_pengumpultol_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpengumpultol_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_asisten_manager_pelayanan_lalin_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorasistenmanagerpelayananlalulintas_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_asisten_manager_pelayanan_lalin_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorasistenmanagerpelayananlalulintas_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_petugas_patroli_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpetugaspatroli_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_petugas_derek_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpetugasderek_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_honor_petugas_ambulan_pra_kelaikan_operasi');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_honorpetugasambulan_11").val(result);
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_displayled24touchscreen_peralatan_komputer');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_displayled24touchscreen_12").val(result);
                $("#kebutuhan_automaticvoltageregulationavr120v_12").val(result);
                $("#kebutuhan_kabelutpcard5e100meter_12").val(result); 
                $("#kebutuhan_kartuperdanapulsa_12").val(result); 
                $("#kebutuhan_kelistrikan_12").val(result); 
                $("#kebutuhan_komputerintelcorei34gbddr31tbhdd_12").val(result); 
                $("#kebutuhan_mejadesainkhusus_12").val(result); 
                $("#kebutuhan_mesinabsensitersetting_12").val(result); 
                $("#kebutuhan_modem_12").val(result);
                $("#kebutuhan_routertersetting_12").val(result); 
                $("#kebutuhan_switchhub_12").val(result); 
                $("#kebutuhan_tc_12").val(result); 
                $("#kebutuhan_biayatransportasi_12").val(result); 
                $("#kebutuhan_pemasanganaplikasijmtocoidkiosk_12").val(result); 
                $("#kebutuhan_tenagapembuatanlan_12").val(result); 
                $("#kebutuhan_networkkantoroperasi_12").val(result); 
                $("#kebutuhan_komputeradministrasidanmanager_12").val(result); 
                $("#kebutuhan_printerepsonadministrasi_12").val(result);
                $("#kebutuhan_mejadesainkhusus_12").val(result); 
                $("#kebutuhan_tenagajkebutuhan_komputereopa_12aringan_12").val(result);
                $("#kebutuhan_kabeljaringan_12").val(result);
                $("#kebutuhan_routerkantor_12").val(result); 
                $("#kebutuhan_instalasidanaktivasiperlokasipadasaatinstalasi_12").val(result); 
                $("#kebutuhan_router_12").val(result); 
 $("#kebutuhan_intelcorei361004gbddr31tbhdddvd±rwvganvidiagt705graphics1gbnicwifibluetoothnonos_12").val(result);
 $("#kebutuhan_displayled1519_12").val(result);
 $("#kebutuhan_oskomputercim_12").val(result);
 $("#kebutuhan_oskomputereopa_12").val(result);
 $("#kebutuhan_automaticvoltageregulationavr_12").val(result);
 $("#kebutuhan_biayakirimupscim_12").val(result);
 $("#kebutuhan_mejadesainkhususkomputercimdaneopa_12").val(result);
 $("#kebutuhan_biayakirimmejakomputercimdaneopa_12").val(result);
 $("#kebutuhan_biayakirimkomputercim_12").val(result);
 $("#kebutuhan_printerepsonl350_12").val(result);
 $("#kebutuhan_mejakomputercimdaneopa_12").val(result);
 $("#kebutuhan_biayakirimkomputereopa_12").val(result);
 $("#kebutuhan_upscim_12").val(result);
 $("#kebutuhan_komputereopa_12").val(result);
 $("#kebutuhan_tenagajaringan_12").val(result);
 

            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_rj_amp_peralatan_komputer');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_rj45ampisi100_12").val(result);
              
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_meja_desain_kirim_peralatan_komputer');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_mejadesainkhususkomputercimdaneopa_12").val(result);
                $("#kebutuhan_biayakirimmejakomputercimdaneopa_12").val(result);
              
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_utpcard_peralatan_komputer');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
                $("#kebutuhan_kabelutpcard5e100meter_12").val(result);
                 
            }
        });
 
 
       
 
    }


function Calculate_Lalin(){
      var id_penawaranx = $("#id_penawaran_lalin").val(); 
        var tahapx = $("#tahap_lalin").val();  

        if(tahapx == ''){
            alert("anda belum memilih tahap!");
        }else{
       

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_assman_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_asistenmanagerpelayananlalulintas_252").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_kepala_shift_patroli_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_kepalashiftpatroli_253").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_petugas_patroli_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_petugaspatroli_254").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_pik_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_petugasinformasikomunikasi_255").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_tu_pelayanlalin_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_tupelayananlalulintas_256").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_sewa_pickup_patroli_doublecab');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_sewakendaraanpickuppatrolidoublecabin_257").val(result);
             
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_lalin_bbm_ljt');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_bbmljt_258").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_derek_10ton_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_10ton_262").val(result);
             
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_derek_25ton_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_25ton_263").val(result);
             
            }
        }); 

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_bbm_derek_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_bbmderek_264").val(result);
             
            }
        }); 

          $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_petugasderektahunan_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_petugasderektahunkontrak_266").val(result);
             
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_a');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#kebutuhan_seragam2stel_267").val(result);
            $("#kebutuhan_rompikeselamatan_268").val(result);
            $("#kebutuhan_sepatusafety_269").val(result);
            $("#kebutuhan_jaket_270").val(result);
            $("#kebutuhan_jashujan_271").val(result);
            $("#kebutuhan_kacamata_272").val(result);
            $("#kebutuhan_sarungtangan_273").val(result);
            $("#kebutuhan_topi_274").val(result);
            $("#kebutuhan_helm_275").val(result);
            $("#kebutuhan_pelatihanpetugasderek_276").val(result);
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_b');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
            $("#volume_asistenmanagerpelayananlalulintas_252").val(result);
            $("#volume_kepalashiftpatroli_253").val(result);
            $("#volume_petugaspatroli_254").val(result);
            $("#volume_petugasinformasikomunikasi_255").val(result);
            $("#volume_tupelayananlalulintas_256").val(result);
            $("#volume_sewakendaraanpickuppatrolidoublecabin_257").val(result);
            $("#volume_10ton_262").val(result);
            $("#volume_25ton_263").val(result);
            $("#volume_sewakendaraanpickuppatrolidoublecabin_257").val(result);
            $("#volume_pengawasderektahunkontrak_265").val(result);
            $("#volume_petugasderektahunkontrak_266").val(result);
            $("#volume_sewakendaraanperalatanrescue_278").val(result);
            $("#volume_petugasrescuetahunkontrak_280").val(result);
            $("#volume_sewakendaraanambulance_291").val(result);
            $("#volume_paramedistahunkontrak_294").val(result);
            $("#volume_pengemuditahunkontrak_295").val(result);
            $("#volume_obatobatan_296").val(result); 
            $("#volume_interkomterpusat_298").val(result);
            $("#volume_sewaht_299").val(result);
            $("#volume_sewabasestation_300").val(result); 
            $("#volume_insentiftilangumumpjr_303").val(result); 
            $("#volume_pengawaskamtibdansatpam_312").val(result); 
            $("#volume_patrolikamtib_313").val(result);
            $("#volume_satuanpengamanangerbangtol_314").val(result); 
            $("#volume_sewaminibus_321").val(result); 
            $("#volume_sewakendaraanasistenmanagerpelayananlalulintas_330").val(result); 
            $("#volume_rubbercone_335").val(result); 
            $("#volume_bbmsurveywaktutempuh_372").val(result); 
            $("#volume_pembuatanlaporan_373").val(result); 
            $("#volume_konsumsi_374").val(result); 
            $("#volume_penggantiankepadapemakaijalantol_375").val(result); 
            $("#volume_sewakendaraanpjr_376").val(result); 
            $("#volume_ob_329").val(result); 
              
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_c');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#volume_bbmljt_258").val(result);
                    $("#volume_bbmderek_264").val(result);
                    $("#volume_bbmrescue_279").val(result);
                    $("#volume_bbmambulance_292").val(result);
                    $("#volume_bbmsatuanpengamanan_322").val(result);
                    $("#volume_bbmasistenmanager_331").val(result);
                    $("#volume_bbmpjr_377").val(result);
                    $("#volume_kanit_325").val(result);
                    $("#volume_panit_326").val(result);
                    $("#volume_anggota_327").val(result);
                    $("#volume_staf_328").val(result);
                     
         
            }
        }); 

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_d');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#volume_benderamerah_336").val(result);
                    $("#volume_serbukgergaji_353").val(result);
                    $("#volume_skop_354").val(result);
                    $("#volume_sapulidi_355").val(result);
                    $("#volume_lapkanebo_356").val(result);
                    $("#volume_biayaevakuasikendaraanberat_357").val(result);
                    $("#volume_koordinasikepolisian_323").val(result);
              
            }
        }); 
 

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_e');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#volume_bbmljt_258").val(result);
                    
            
            }
        }); 

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_sewa_kendaraan_prescue_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_sewakendaraanperalatanrescue_278").val(result);
                    
            
            }
        }); 
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_bbm_rescue_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_bbmrescue_279").val(result);
                    
            
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_f');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_petugasrescuetahunkontrak_280").val(result);
                    $("#kebutuhan_seragam2stel_281").val(result);
                    $("#kebutuhan_rompikeselamatan_282").val(result);
                    $("#kebutuhan_sepatusafety_283").val(result);
                    $("#kebutuhan_jaket_284").val(result);
                    $("#kebutuhan_jashujan_285").val(result);
                    $("#kebutuhan_kacamata_286").val(result);
                    $("#kebutuhan_sarungtangan_287").val(result);
                    $("#kebutuhan_topi_288").val(result);
                    $("#kebutuhan_helm_289").val(result);
                    $("#kebutuhan_pelatihanpetugasrescue_290").val(result);  
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_g');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_benderamerah_336").val(result);
                    $("#kebutuhan_kabeljumper_337").val(result);
                    $("#kebutuhan_kuncipalang_338").val(result);
                    $("#kebutuhan_dongkrakbuaya_339").val(result);
                    $("#kebutuhan_jerigenplastik_340").val(result);
                    $("#kebutuhan_tempatairminum_341").val(result);
                    $("#kebutuhan_senterbiasa_342").val(result);
                    $("#kebutuhan_senterpengarah_343").val(result);
                    $("#kebutuhan_lampusorottangan_344").val(result);
                    $("#kebutuhan_kuncitoolkit_345").val(result);
                    $("#kebutuhan_rollmeter_346").val(result);
                    $("#kebutuhan_clipboard_347").val(result);
                    $("#kebutuhan_platbesi_349").val(result);
                    $("#kebutuhan_linggis_350").val(result);
                    $("#kebutuhan_serbukgergaji_353").val(result);
                    $("#kebutuhan_skop_354").val(result);
                    $("#kebutuhan_sapulidi_355").val(result);
                    $("#kebutuhan_lapkanebo_356").val(result); 
            }
        }); 


        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_h');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_pengadaanjashujanpetugaspelayananlalulintas_367").val(result); 
                    $("#kebutuhan_pengadaanjaketpetugaspelayananlalulintas_368").val(result); 
                    $("#kebutuhan_pengadaansafetyshoespetugaspelayananlalulintas_369").val(result); 

                    $("#kebutuhan_pengadaantopipetugaspelayananlalulintaskhusus_370").val(result);
                    $("#kebutuhan_atributlainnyasabukpluitemblemnamadanjabatan_371").val(result); 

                    $("#kebutuhan_sarungtangan_348").val(result); 
                    $("#kebutuhan_kacamatagoogle_351").val(result); 
              
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_ken_ambulance_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_sewakendaraanambulance_291").val(result); 
                    $("#kebutuhan_obatobatan_296").val(result); 
                
 
            }
        });
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_bbm_ken_ambulance_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_bbmambulance_292").val(result); 
                     
 
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_paramedis_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_paramedistahunkontrak_294").val(result); 
                    $("#kebutuhan_pengemuditahunkontrak_295").val(result);  
                    $("#kebutuhan_pelatihanpetugasparamedis_297").val(result);  
               
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_ht_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_sewaht_299").val(result); 
                    
               
            }
        }); 
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_base_station_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_sewabasestation_300").val(result); 
                    
               
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_insentilang_pjr_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_insentiftilangumumpjr_303").val(result); 
                    
               
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_kamtibsatpam_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_pengawaskamtibdansatpam_312").val(result); 
                    
               
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_patroli_kamtib_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_patrolikamtib_313").val(result); 
                    
               
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_satpeng_gerbangtol_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    $("#kebutuhan_satuanpengamanangerbangtol_314").val(result); 
                    
               
            }
        }); 

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_lalin_grup_i');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                    console.log(result);
                    var data = parseInt(result);
                    var datab = parseInt($("#kebutuhan_satuanpengamananpostol_315").val());
                    $("#kebutuhan_sepatusafety_318").val(data+datab); 
                    $("#kebutuhan_rompikeselamatan_317").val(data+datab); 
                    $("#kebutuhan_sabukpentungandll_319").val(data+datab); 
                 
            }
        }); 
    
    

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_minibus_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_sewaminibus_321").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_bbm_satpem_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_bbmsatuanpengamanan_322").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_kend_asmenlalin_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_sewakendaraanasistenmanagerpelayananlalulintas_330").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_bbm_asisten_managers_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_bbmasistenmanager_331").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_apab50_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_apab50kg_333").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_rubbercone_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_rubbercone_335").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_bbmsurveywtmpuh_lalin');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_bbmsurveywaktutempuh_372").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_sewa_kendaraan_pjr_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_sewakendaraanpjr_376").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_bbm_pjr_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_bbmpjr_377").val(result);
            }
        });

         $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kanit_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_kanit_325").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_panit_ob_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_panit_326").val(result);
            $("#kebutuhan_ob_329").val(result);
 
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_anggota_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_anggota_327").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_staff_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_staf_328").val(result);
            }
        });

        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_apar_lalins');?>",
            type:"POST",
            data:{id_penawaran:id_penawaranx,tahap:tahapx},
            success:function(result){
                console.log(result);
    
            $("#kebutuhan_aparkantorgerbangtoldankendaraan_332").val(result);
            }
        });
     
 
        }
    
}


    $(document).ready(function(){
         $("#loading_praops").hide();
         $("#loading_yantrans").hide();
         $("#loading_yanlalin").hide();
         $("#loading_yanpml").hide();
         $("#loading_umum").hide();
    });
</script>