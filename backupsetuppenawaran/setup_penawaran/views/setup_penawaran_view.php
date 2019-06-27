 
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                 
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              Setup Penawaran
                            </h2>
                          
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
                               
                            <form method="post" id="user_form" enctype="multipart/form-data">   
                                 
                                    <input type="hidden" name="id" id="id">    

                                    <div class="form-group">
                                     

                                    <div class="input-group">
                                        <label>Pilih Penawaran</label>
                                          <select name="id_pe" id="id_pe" onchange="GantiPenawar();" class="form-control">
                                                <option value=""> --Pilih Penawaran </option>
                                                <?php
                                                foreach ($list_penawaran as $key => $value) {
                                                    echo '<option value="'.$value->id.'">  '.$value->nama_penawaran.' </option>';
                                                }
                                                ?>
                                            </select> 
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="form-line">
                                            <label>Tahap</label>
                                            <input type="text" name="tahap" id="year" class="form-control" placeholder="Tahap" />
                                        
                                        </div>
                                    </div> -->
                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="hidden" name="id_harga" id="id_harga" class="form-control" required readonly="readonly" >
                                                    <input type="text" name="nama_harga" id="nama_harga" readonly="readonly" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariHarsat();" class="btn btn-primary"> Pilih Harga ... </button>
                                                </span>
                                    </div>
                                    <div class="input-group">
                                                
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="SetupPenawaranPopup();" class="btn btn-block btn-primary"> Setup Penawaran... </button>
                                                </span>
                                    </div>
                                  
                             </form>
                                 <br>
                            <hr>


                            <div class="table-responsive">
                              
                              <h4 align="center"> List Harga Penawaran </h4>
                                <table id="examples" class="table table-bordered table-striped table-hover js-basic-examples">
                            <thead>
                            <tr>
                                <td style="width: 2%"> No </td>
                                <td style="width: 10%"> Nama Penawaran </td>
                                <td style="width: 5%"> Tahap </td>
                 
                                <td style="width: 15%"> Opsi </td>

                            </tr>
                            </thead>
              
                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         


        </div>
    </section>

    <!-- modal setup penawaran -->
   
    <div class="modal fade" id="SetupPenawaranModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Setup Penawaran</h4>
                        </div>
                        <div class="modal-body">


                                <div class="form-group">
                                        <div class="form-line">
                                            <label>Tahap</label>
                                           <!--  <input type="text" name="tahap" id="year" class="form-control" placeholder="Tahap" /> -->
                                            <div id="restahap"> </div>
                                        </div>
                                </div>

                                <div class="card">
                        <div class="header">
                            <h2>ADVANCED FORM EXAMPLE WITH VALIDATION</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" method="POST">
                                <h3>Account Information</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="username" required>
                                            <label class="form-label">Username*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="password" id="password" required>
                                            <label class="form-label">Password*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="confirm" required>
                                            <label class="form-label">Confirm Password*</label>
                                        </div>
                                    </div>
                                </fieldset>

                                <h3>Profile Information</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control" required>
                                            <label class="form-label">First Name*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="surname" class="form-control" required>
                                            <label class="form-label">Last Name*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="email" name="email" class="form-control" required>
                                            <label class="form-label">Email*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="address" cols="30" rows="3" class="form-control no-resize" required></textarea>
                                            <label class="form-label">Address*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input min="18" type="number" name="age" class="form-control" required>
                                            <label class="form-label">Age*</label>
                                        </div>
                                        <div class="help-info">The warning step will show up if age is less than 18</div>
                                    </div>
                                </fieldset>

                                <h3>Terms & Conditions - Finish</h3>
                                <fieldset>
                                    <input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>
                                    <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                                <form method="post" id="user_form_setup" enctype="multipart/form-data">

                                <input type="hidden" name="id_penawaran" id="id_penawaran">
                                <input type="hidden" name="tahap" id="tahap">

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_penawaran" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:5%;">Komponen Biaya</th> 
                                            <th style="width:5%;">Kebutuhan</th> 
                                            <th style="width:5%;">Satuan</th>
                                            <th style="width:5%;">Harga Satuan</th> 
                                             
                                            <th style="width:5%;">Volume</th>  
                                            
                                          
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                                <br> 
                                <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                            </form>
                       </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari harga -->
    <div class="modal fade" id="CariHarsatModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Harga</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_harga" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Nama Harga </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_hargax">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

    <div class="modal fade" id="DetailModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Detail Harga Penawaran</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>
                                 

                                <br>
                                <hr>
                                
                                <table id="examplez" class="table table-bordered table-striped table-hover js-basic-examplez">
                                    <thead>
                                        <tr>  
                                            <th style="width:5%;">Komponen Biaya</th> 
                                            <th style="width:5%;">Kebutuhan</th> 
                                            <th style="width:5%;">Satuan</th>
                                            <th style="width:5%;">Harga Satuan</th> 
                                            <th style="width:5%;">Jumlah Uraian</th>
                                            
                                            <th style="width:5%;">Volume</th> 
                                            
                                            <th style="width:5%;">Jumlah Tahunan</th> 
                                            <th style="width:5%;">Jenis Layanan</th>  
                                            <th style="width:5%;">Komponen Biaya</th> 
                                         </tr>
                                    </thead>
                                 
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>

    <div class="modal fade" id="UbahHPModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Ubah Harga Penawaran</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>
                                 
                                <br>
                                <hr>
                                <form method="post" id="user_form_ubah_hp" enctype="multipart/form-data">

                                <input type="hidden" name="id_penawaranx" id="id_penawaranx">
                                 <input type="hidden" name="id_tahapx" id="id_tahapx">

                                <table id="exampley" class="table table-bordered table-striped table-hover js-basic-examplez">
                                    <thead>
                                        <tr>  
                                            <th style="width:5%;">Komponen Biaya</th> 
                                            <th style="width:5%;">Kebutuhan</th> 
                                            <th style="width:5%;">Satuan</th>
                                            <th style="width:5%;">Harga Satuan</th> 
                                         
                                            
                                            <th style="width:5%;">Volume</th> 
                                            
                                       
                                            <th style="width:5%;">Jenis Layanan</th>  
                                            <th style="width:5%;">Komponen Biaya</th> 
                                         </tr>
                                    </thead>
                                 
                                </table>  
                                 
                        
                                <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Ubah();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Update();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                            </form>
                       </div>
                     
                    </div>
                </div>
    </div>


     


 
 
<style type="text/css">
    td.details-control {
    background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_close.png') no-repeat center center;
}
</style>
   <script type="text/javascript">
    function Detail_HP(id,idx){
        $("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});
       
        

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('setup_penawaran/listing_hp'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 

            "columns" : [  
            {
                "data" : "nama_pricelist"
            },
            {
                "data" : "kebutuhan"
            },
            {
                "data" : "nama_satuan"
            },
            {
                "data" : "value_harsat"
            },
            {
                "data" : "jumlah_uraian"
            },
            {
                "data" : "volume"
            },
            {
                "data" : "jumlah_tahunan"
            },
            {
                "data" : "nama_pelayanan"
            },
            {
                "data" : "nama_komp_biaya"
            }],

            "rowReorder": {
                "update": false
            },
             'rowsGroup': [7,8],
            "displayLength": 200     
            
        });
    
 
    } 

    function Ubah_HP(id,idx){
        $("#UbahHPModal").modal({backdrop: 'static', keyboard: false,show:true});
       
        

        $('#exampley').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('setup_penawaran/listing_hp_ubah'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 

            "columns" : [  
            {
                "data" : "nama_pricelist"
            },
            {
                "data" : "kebutuhan"
            },
            {
                "data" : "nama_satuan"
            },
            {
                "data" : "value_harsat"
            },
            {
                "data" : "volume"
            },
            {
                "data" : "nama_pelayanan"
            },
            {
                "data" : "nama_komp_biaya"
            }],

            "rowReorder": {
                "update": false
            },
             'rowsGroup': [7,8],
            "displayLength": 200    
            
        });
    
 
    } 

     function Hapus_Data(id,idx){
        if(confirm('Anda yakin ingin menghapus data ini?'))
        {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('setup_penawaran/hapus_list_data')?>/"+id+"/"+idx,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               
               $('#examples').DataTable().ajax.reload(); 
               
                $.notify("Data berhasil dihapus!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                 },{
                    type: 'success'
                    });
                 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
   
    }
    }

    function Calculate(){
        var id_penawaran = $("#id_penawaran").val(); 
        var tahap = $("#tahap").val(); 

        var pro_akomodasi_tim_rekrutmen_dan_seleksi = parseInt($("#kebutuhan_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak").val()) * parseInt($("#harga_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak").val());
       
        $("#jumlah_uraian_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak").val(pro_akomodasi_tim_rekrutmen_dan_seleksi);

        var biaya_proses_seleksi = parseInt($("#kebutuhan_biaya_proses_seleksi").val()) * parseInt($("#harga_biaya_proses_seleksi").val());
        $("#jumlah_uraian_biaya_proses_seleksi").val(biaya_proses_seleksi); 
        
        var pengumuman = parseInt($("#kebutuhan_pengumuman").val()) * parseInt($("#harga_pengumuman").val());
        
        $("#jumlah_uraian_pengumuman").val(pengumuman);
        
        //ambil biaya materai
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_biaya_materai');?>",
            type:"POST",
            data:{id_penawaran:id_penawaran,tahap:tahap},
            success:function(result){
                console.log(result);
                $("#kebutuhan_biaya_materai").val(result);
                $("#jumlah_uraian_biaya_materai").val(parseInt($("#harga_biaya_materai").val()) * result);
                $("#kebutuhan_verifikasi_dan_klarifikasi_data").val(result);
            }
        });
    

        $("#kebutuhan_verifikasi_dan_klarifikasi_data").val();
        $("#kebutuhan_biaya_materai").val();
        $("#harga_biaya_materai").val();
        $("#harga_verifikasi_dan_klarifikasi_data").val();
        // $("#jumlah_uraian_biaya_materai").val(parseInt($("#kebutuhan_biaya_materai").val()) * parseInt($("#harga_biaya_materai").val()));
        $("#jumlah_uraian_verifikasi_dan_klarifikasi_data").val();
 

    }

    function Calculate_Update(){
        var id_penawaran = $("#id_penawaran").val(); 
        var tahap = $("#tahap").val(); 

        var pro_akomodasi_tim_rekrutmen_dan_seleksi_update = parseInt($("#kebutuhan_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak_update").val()) * parseInt($("#harga_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak_update").val());
       
        $("#jumlah_uraian_akomodasi_tim_rekrutmen_dan_seleksi_-_kontrak_update").val(pro_akomodasi_tim_rekrutmen_dan_seleksi);

        var biaya_proses_seleksi_update = parseInt($("#kebutuhan_biaya_proses_seleksi_update").val()) * parseInt($("#harga_biaya_proses_seleksi_update").val());
        $("#jumlah_uraian_biaya_proses_seleksi_update").val(biaya_proses_seleksi_update); 
        
        var pengumuman_update = parseInt($("#kebutuhan_pengumuman_update").val()) * parseInt($("#harga_pengumuman_update").val());
        
        $("#jumlah_uraian_pengumuman_update").val(pengumuman_update);
        
        //ambil biaya materai
        $.ajax({
            url:"<?php echo base_url('setup_penawaran/call_kebutuhan_biaya_materai');?>",
            type:"POST",
            data:{id_penawaran:id_penawaran,tahap:tahap},
            success:function(result){
                console.log(result);
                 $("#kebutuhan_biaya_materai_update").val(result);
                 $("#jumlah_uraian_biaya_materai_update").val(parseInt($("#harga_biaya_materai_update").val()) * result);
                  $("#kebutuhan_verifikasi_dan_klarifikasi_data_update").val(result);
            }
        });
    

        $("#kebutuhan_verifikasi_dan_klarifikasi_data_update").val();
        $("#kebutuhan_biaya_materai_update").val();
        $("#harga_biaya_materai_update").val();
        $("#harga_verifikasi_dan_klarifikasi_data_update").val();
        // $("#jumlah_uraian_biaya_materai").val(parseInt($("#kebutuhan_biaya_materai").val()) * parseInt($("#harga_biaya_materai").val()));
        $("#jumlah_uraian_verifikasi_dan_klarifikasi_data_update").val();
 

    }

    function SetupPenawaranPopup(){

       
        var penawaran = $("#id_pe").val();
        var harga = $("#id_harga").val();
        window.open('<?php echo base_url('setup_penawaran/link_setup_penawaran/'); ?>'+penawaran+'/'+harga, 'ubah_setup_penawaran', 'width=1366, height=768, status=1,scrollbar=yes'); 
        return false;
    }
    function SetupPenawaran(){

        window.open('http://www.yellowweb.id', 'Kursus Web di Bekasi', 'width=800, height=600, status=1,scrollbar=yes'); 
        return false;

        // var penawaran = $("#id_pe").val();

        // if(penawaran == ''){
        //     alert("Kamu belum memilih penawaran dan tahap!");
        // }else{  

        // $("#SetupPenawaranModal").modal({backdrop: 'static', keyboard: false,show:true});

        // var id_harga = $("#id_harga").val();
      
        // $("#id_penawaran").val(parseInt($("#id_pe").val()));
        // $("#tahap").val(parseInt($("#id_tahapx").val()));

        // $('#tabel_penawaran').DataTable({
        //     "processing" : true,
        //     "ajax" : {
        //         "url" : "<?php echo base_url('setup_penawaran/fetch_setup_penawaran_modal'); ?>",
        //         "data":{id_harga:id_harga},
        //         "type":"POST",
        //          dataSrc : '',

        //     }, 
        //     "columns" : [ {
        //         "data" : "nama_pricelist"
        //     },{
        //         "data" : "kebutuhan"
        //     },{
        //         "data" : "nama_satuan"
        //     },{
        //         "data" : "harga"
        //     },{
        //         "data" : "volume"
        //     }, 
        //     ], 
        //     "displayLength": 200,
        //     "rowReorder": {
        //         "update": false
        //     },

        //     "destroy":true,
        // });
        // }
       
    
 
    } 


   $('#daftar_harga').DataTable( {
            "ajax": "<?php echo base_url(); ?>setup_penawaran/fetch_harga"           
    });

     
     
    function CariHarsat(){
        $("#CariHarsatModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_harga = $('#daftar_harga').DataTable();
     
        $('#daftar_harga tbody').on('click', 'tr', function () {
            
            var content = daftar_harga.row(this).data()
            console.log(content);
            $("#nama_harga").val(content[0]);
            $("#id_harga").val(content[1]);
            $("#CariHarsatModal").modal('hide');
        } );

       

   //function CariHarsat(){

    // var id_tahapx = $("#id_tahapx").val();
    //     if(id_tahapx == ''){
    //         alert("penawaran dan tahap belum anda pilih !");
    //     }else{
    //           $("#CariHarsatModal").modal({backdrop: 'static', keyboard: false,show:true});
    //     $("#id_pe_ubah").val();
    //     $("#id_tahapx").val();
        

    //     $('#exampleg').DataTable({
    //         "destroy": true,
    //         "processing" : true,
          
    //         "ajax" : {
    //             "url" : "<?php echo base_url('setup_penawaran/list_harga'); ?>",
    //             "data":{id_pe_ubah:id_pe_ubah,id_tahapx:id_tahapx},
    //             "type":"POST",
    //              dataSrc : '',

    //         }, 
    //         "displayLength": 50,

    //         "columns" : [ 
    //         {
    //             "data" : "no"
    //         },
    //         {
    //             "data" : "nama_harga"
    //         },
    //         {
    //             "data" : "opsi"
    //         }],

    //         "rowReorder": {
    //             "update": false
    //         },
    //          "order": [[ 0, 'asc' ]] 
            
    //     });
    
    //     }
      

    //}

       function GantiPenawar(){
        var isi = $("#id_pe").val();
        
        $("#id_penawaran").val(isi);
        $("#id_tahap").val('');
 
        $.ajax({
            type: "POST",  
            url: "<?php echo base_url('setup_penawaran/get_tahap_val'); ?>",  
            data: {id_pe : $("#id_pe").val()}, 
            success: function(response){   
                console.log(response);
                $("#restahap").html(response);
            } 
        });
   

       }
  
         
       
     function UbahDataPopup(idpenawaran,tahap){

         
        window.open('<?php echo base_url('setup_penawaran/ubah_setup_penawaran/'); ?>'+idpenawaran+'/'+tahap, 'ubah_setup_penawaran', 'width=1366, height=768, status=1,scrollbar=yes'); 
        return false;


        // $("#defaultModalLabel").html("Form Ubah Data");
        // $("#defaultModal").modal('show');
 
        // $.ajax({
        //      url:"<?php echo base_url(); ?>setup_penawaran/get_data_edit/"+id,
        //      type:"GET",
        //      dataType:"JSON", 
        //      success:function(result){ 
                  
        //          $("#defaultModal").modal('show'); 
        //          $("#id").val(result.id);
        //          $("#id_country").val(result.id_country);                 
        //          $("#nama_setup_penawaran").val(result.nama_setup_penawaran);
        //          $("#year").val(result.year);
        //          $("#nama_country").val(result.country);
                
                  
        //      }
        //  });
     }
 
     function Bersihkan_Form(){
        $(':input').val(''); 
         
     }

      
    
      
  
    function Simpan_Data(){
        //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_setup')[0]); 

         // var id_penawaran
         // var tahap
         // var harsat
         // var id_pricelit
         // var volume
         // var kebutuhan
 
  

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                
                 $("#SetupPenawaranModal").modal('hide');
                 $('#examples').DataTable().ajax.reload(); 
                 // $('#examplez').DataTable().ajax.reload(); 
                 //$('#daftar_asal_setup_penawaran').DataTable().ajax.reload(); 
                 $('#user_form_setup')[0].reset();
                 Bersihkan_Form();
                 $.notify("Data berhasil disimpan!", {
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

         function Simpan_Ubah(){
        //setting semua data dalam form dijadikan 1 variabel 
         var formData = new FormData($('#user_form_ubah_hp')[0]); 

         // var id_penawaran
         // var tahap
         // var harsat
         // var id_pricelit
         // var volume
         // var kebutuhan
 
  

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>setup_penawaran/simpan_data_ubah",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                
                 $("#SetupPenawaranModal").modal('hide');
                 $('#examples').DataTable().ajax.reload(); 
                 // $('#examplez').DataTable().ajax.reload(); 
                 //$('#daftar_asal_setup_penawaran').DataTable().ajax.reload(); 
                 $('#user_form_setup')[0].reset();
                 Bersihkan_Form();
                 $.notify("Data berhasil disimpan!", {
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
             

       $(document).ready(function() {
           
        $("#addmodal").on("click",function(){
            $("#defaultModal").modal({backdrop: 'static', keyboard: false, show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
        });
         
         
       $('#examples').DataTable({
           "ajax": "<?php echo base_url(); ?>setup_penawaran/list_store_setup_penawaran",
           'rowsGroup': [1],
        });
        
         
      
         
      });
  
        
         
    </script>