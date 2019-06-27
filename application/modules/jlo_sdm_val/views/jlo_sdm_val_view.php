 
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
                                JLO SDM Val
                            </h2>
                            <br>
                           
                        </div>
                        <div class="body">
                                   <form method="post" id="user_form" enctype="multipart/form-data">   
                                 <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <td> Penawaran </td>
                                        <td> : </td>
                                        <td> 
                                            <select name="id_pe" id="id_pe" onchange="GantiPenawar();" class="form-control">
                                                <option value=""> --Pilih Penawaran </option>
                                                <?php
                                                foreach ($list_penawaran as $key => $value) {
                                                    echo '<option value="'.$value->id.'">  '.$value->nama_penawaran.' </option>';
                                                }
                                                ?>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Tahap </td>
                                        <td> : </td>
                                        <td> 
                                            <div id="restahap"> </div>
                                        </td>
                                    </tr>
                                  
                                </table>
                           </div>
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
  
                                 <thead>
                                    <tr> 
                                        <th style="width:10%;" rowspan="2">Jabatan</th>
                                        <th style="width:10%;" colspan="3">Jumlah Personel</th>
                                        <th style="width:10%;" colspan="4">Fasilitas</th>
                                    </tr>
                                    <tr>
                                        <th style="width:10%;">KANTOR  </th> 
                                        <th style="width:10%;">GT  </th>
                                        <th style="width:10%;">Total  </th>
                                        <th style="width:10%;">HT  </th>
                                        <th style="width:10%;">Base  </th> 
                                        <th style="width:10%;">Kendaraan Ops  </th> 
                                        <th style="width:10%;">Kendaraan Shuttle  </th>
                                    </tr>
                                </thead> 
								</table> 
                                <br> 
                                <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                                </div>
                            </form>

                                   <br>
                             <br>
                                <h3 align="center"> List JLO SDM Value  </h3>
                                 <table id="examples" class="table table-bordered table-striped table-hover js-basic-examples">
                            <thead>
                            <tr>
                                <td style="width: 2%"> No </td>
                                <td style="width: 5%"> Nama Penawaran </td>
                                <td style="width: 2%"> Tahap </td>
                              
                                <td style="width: 10%"> Opsi </td>

                            </tr>
                            </thead>
              
                        </table>
                             
                                  
                            <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         


        </div>
    </section>

 

    <div class="modal fade" id="DetailSDMValModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Detail JLO SDM List Value</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                              <table id="examplez" width="100%" class="table table-bordered table-striped table-hover js-basic-examplez">
 
                                 <thead>
                                    <tr>
                                        
                                      
                                        <th style="width:3%;" rowspan="2">Jabatan</th>
                                        <th style="width:3%;" colspan="3">Jumlah Personel</th>
                                        <th style="width:3%;" colspan="4">Fasilitas</th>
                                    </tr>
                                    <tr>
                                        <th style="width:3%;">KANTOR  </th> 
                                        <th style="width:10%;">GT  </th>
                                        <th style="width:10%;">Total  </th>
                                        <th style="width:10%;">HT  </th>
                                        <th style="width:5%;">Base  </th> 
                                        <th style="width:3%;">Kendaraan Ops  </th> 
                                        <th style="width:3%;">Kendaraan Shuttle  </th>
                                    </tr>
                                </thead> 
                                </table> 


                             
                       </div>
                     
                    </div>
                </div>
    </div>

      <div class="modal fade" id="UbahSDMValModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Ubah JLO SDM List Value</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>
                                <form method="post" id="user_form_update" enctype="multipart/form-data"> 
                                 <input type="hidden" id="id_pe_ubah" name="id_pe_ubah">
                               <input type="hidden" id="id_tahapx_ubah" name="id_tahapx_ubah">  
                                <br>
                                <hr>
                              <table id="exampley" width="100%" class="table table-bordered table-striped table-hover js-basic-exampley">
 
                                 <thead>
                                    <tr>
                                        
                                      
                                        <th style="width:3%;" rowspan="2">Jabatan</th>
                                        <th style="width:3%;" colspan="3">Jumlah Personel</th>
                                        <th style="width:3%;" colspan="4">Fasilitas</th>
                                    </tr>
                                    <tr>
                                        <th style="width:3%;">KANTOR  </th> 
                                        <th style="width:10%;">GT  </th>
                                        <th style="width:10%;">Total  </th>
                                        <th style="width:10%;">HT  </th>
                                        <th style="width:5%;">Base  </th> 
                                        <th style="width:3%;">Kendaraan Ops  </th> 
                                        <th style="width:3%;">Kendaraan Shuttle  </th>
                                    </tr>
                                </thead> 
                                </table> 
                                <br>
                                  <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data_Update();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Update();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                            </form>

                             
                       </div>
                     
                    </div>
                </div>
    </div>
            
			
 
   <script type="text/javascript">
        function Ubah_Data(id,idx){
        $("#UbahSDMValModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_pe_ubah").val(id);
        $("#id_tahapx_ubah").val(idx);
        

        $('#exampley').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('jlo_sdm_val/list_detail_sdm_val_ubah'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 
            "displayLength": 50,

            "columns" : [ 
            {
                "data" : "sdm_list"
            },
            {
                "data" : "kantor"
            },
            {
                "data" : "gt"
            },
             {
                "data" : "total"
            },
             {
                "data" : "ht"
            },
            {
                "data" : "base"
            },
            {
                "data" : "k_ops"
            },
            {
                "data" : "k_shuttle"
            }],

            "rowReorder": {
                "update": false
            },
             "order": [[ 0, 'asc' ]] 
            
        });
    

     }
     function Detail(id,idx){
        $("#DetailSDMValModal").modal({backdrop: 'static', keyboard: false,show:true});
        
        

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('jlo_sdm_val/list_detail_sdm_val'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 
            "displayLength": 50,
            "columns" : [ 
            {
                "data" : "sdm_list"
            },
            {
                "data" : "kantor"
            },
            {
                "data" : "gt"
            },
            {
                "data" : "total"
            },
            {
                "data" : "ht"
            },
            {
                "data" : "base"
            },
            {
                "data" : "k_ops"
            },
            {
                "data" : "k_shuttle"
            }


             ],

            "rowReorder": {
                "update": false
            },
             "order": [[ 0, 'asc' ]] 
            
        });
    
 
    }  
    function Simpan_Data(){

        var tbl = $("#example").DataTable();
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>jlo_sdm_val/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
             success:function(result){  
                console.log(result);
                $('#examples').DataTable().ajax.reload(); 
                 if(result == "1"){

                    $.notify("Data berhasil ditambahkan!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                    },{
                    type: 'success'
                    });
                    
    
                    Bersihkan_Form();
                    $("#id_pe").val('');
                    
                return true;
             }else{
                $('#examples').DataTable().ajax.reload(); 
                 $.notify("Data gagal ditambahkan, anda sudah pernah mengisi data ini sebelumnya!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                 },{
                    type: 'danger'
                    });
                    Bersihkan_Form();
                    $("#id_pe").val('');
                   
                 return true;
             }

             },
             error: function (jqXHR, textStatus, errorThrown){
                alert('Error submit data');
             }
             }); 
   
        } 
           

    }


    function Simpan_Data_Update(){
        //var tbl = $("#exampley").DataTable();
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>jlo_sdm_val/simpan_data_update",
             type:"POST",
             data:$("#user_form_update").serialize(),
             success:function(result){  
                $('#examples').DataTable().ajax.reload(); 
                $("#UbahSDMValModal").modal('hide');
                    $.notify("Data berhasil dirubah!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                    },{
                    type: 'success'
                    }); 

                    Bersihkan_Form(); 
                    return true;
        

             },
             error: function (jqXHR, textStatus, errorThrown){
                alert('Error submit data');
             }
             }); 
   
        } 
           

    }
      function GantiPenawar(){
        var isi = $("#id_pe").val();
        
        $("#id_penawaran").val(isi);
        $("#id_tahap").val('');
 
        $.ajax({
            type: "POST",  
            url: "<?php echo base_url('jlo_sdm_val/get_tahap_val'); ?>",  
            data: {id_pe : $("#id_pe").val()}, 
            success: function(response){   
                console.log(response);
                $("#restahap").html(response);
            } 
        });
   

       }
 
	 function Bersihkan_Form(){
        $(':input').val(''); 
        
     }
     function Hapus_Data(id,idx){
        if(confirm('Anda yakin ingin menghapus data ini?'))
        {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('jlo_sdm_val/hapus_data')?>/"+id+"/"+idx,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
               
               $('#examples').DataTable().ajax.reload(); 
                //$('#examplez').DataTable().ajax.reload(); 
               
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
        var id_pe = $("#id_pe").val(); 
        var id_tahapx = $("#id_tahapx").val(); 
        var asisten_manager_transaksi_gt = $("#asisten_manager_transaksi_gt").val(); 
        var val_asisten_manager_transaksi_kantor = parseInt($("#asisten_manager_transaksi_kantor").val());

        var val_asisten_manager_transaksi_gt = parseInt($("#asisten_manager_transaksi_gt").val());

        var kepala_shift_pengumpulan_tol_gt = $("#kepala_shift_pengumpulan_tol_gt").val();
        var pengumpul_tol_gt = $("#pengumpul_tol_gt").val();
        var tu_administrasi_gerbang_tol_gt = $("#tu_administrasi_gerbang_tol_gt").val();
        var kepala_shift_patroli_kantor = $("#kepala_shift_patroli_kantor").val();
        var petugas_patroli_kantor = $("#petugas_patroli_kantor").val();
        var asisten_manager_transaksi_ht = $("#asisten_manager_transaksi_ht").val();
        var kepala_shift_pengumpulan_tol_ht = $("#kepala_shift_pengumpulan_tol_ht").val();
        var petugas_balancing_ht = $("#petugas_balancing_ht").val();
        var asisten_manager_pelayanan_lalu_lintas_ht = $("#asisten_manager_pelayanan_lalu_lintas_ht").val();
        var kepala_shift_patroli_ht = $("#kepala_shift_patroli_ht").val();
        var petugas_patroli_ht = $("#petugas_patroli_ht").val();
        var kamtib_ht = $("#kamtib_ht").val();
        var pjr_ht = $("#pjr_ht").val();
        var asisten_manager_transaksi_base = $("#asisten_manager_transaksi_base").val();
        var kepala_shift_pengumpulan_tol_base = $("#kepala_shift_pengumpulan_tol_base").val();
        var pengumpul_tol_base = $("#pengumpul_tol_base").val();
        var tu_administrasi_gerbang_tol_base = $("#tu_administrasi_gerbang_tol_base").val();
        var petugas_balancing_base = $("#petugas_balancing_base").val();
        var asisten_manager_pelayanan_lalu_lintas_base = $("#asisten_manager_pelayanan_lalu_lintas_base").val();
        var kepala_shift_patroli_base = $("#kepala_shift_patroli_base").val();
        var petugas_patroli_base  = $("#petugas_patroli_base").val();
        var derek_base = $("#derek_base").val();
        var rescue_base = $("#rescue_base").val();
        var ambulance_base = $("#ambulance_base").val();
        var kamtib_base = $("#kamtib_base").val();
        var pjr_base = $("#pjr_base").val();
        var asisten_manager_pemeliharaan_ht = $("#asisten_manager_pemeliharaan_ht").val();
        var asisten_manager_pemeliharaan_base = $("#asisten_manager_pemeliharaan_base").val();
        var asisten_manager_transaksi_k_ops = $("#asisten_manager_transaksi_k_ops").val();
        var petugas_balancing_k_ops = $("#petugas_balancing_k_ops").val();
        var asisten_manager_pelayanan_lalu_lintas_k_ops = $("#asisten_manager_pelayanan_lalu_lintas_k_ops").val();
        var kepala_shift_patroli_k_ops = $("#kepala_shift_patroli_k_ops").val();
        var petugas_patroli_k_ops = $("#petugas_patroli_k_ops").val();

        var petugas_patroli_k_ops  = $("#petugas_patroli_k_ops").val();
        var derek_k_ops = $("#derek_k_ops").val();
        var rescue_k_ops = $("#rescue_k_ops").val();
        var ambulance_k_ops = $("#ambulance_k_ops").val();
        var kamtib_k_ops = $("#kamtib_k_ops").val();
        var pjr_k_ops = $("#pjr_k_ops").val();
        var asisten_manager_pemeliharaan_base = $("#asisten_manager_pemeliharaan_base").val();
        var pengumpul_tol_k_shuttle = parseInt($("#pengumpul_tol_k_shuttle").val());
        
        if(id_pe == ''){
            alert('penawaran dan tahap masih kosong!');
        }else{
            //ambil Asisten Manager Transaksi GT
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_asisten_manager_transaksi_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
           
          

                $("#asisten_manager_transaksi_gt").val(result);
                //asisten_manager_transaksi_ht
                $("#asisten_manager_transaksi_ht").val(parseInt($("#asisten_manager_transaksi_gt").val()) + parseInt($("#asisten_manager_transaksi_kantor").val()));
                $("#asisten_manager_transaksi_base").val(parseInt($("#asisten_manager_transaksi_gt").val()) + parseInt($("#asisten_manager_transaksi_kantor").val()));
                $("#asisten_manager_transaksi_k_ops").val(parseInt($("#asisten_manager_transaksi_gt").val()) + parseInt($("#asisten_manager_transaksi_kantor").val()));

                $("#asisten_manager_transaksi_total").val(parseInt($("#asisten_manager_transaksi_gt").val()) + parseInt($("#asisten_manager_transaksi_kantor").val()));
            }
            });

            //kepala_shift_patroli_kantor
             $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_patroli_kantor'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kepala_shift_patroli_kantor").val(result);
                $("#kepala_shift_patroli_total").val((parseInt(result) + parseInt($("#kepala_shift_patroli_gt").val())));
            }
            });

            //petugas_patroli_kantor
             $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_petugas_patroli_kantor'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#petugas_patroli_kantor").val(result);
                 $("#petugas_patroli_total").val((parseInt(result) + parseInt($("#petugas_patroli_gt").val())));
            }
            });


            //kepala_shift_pengumpulan_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_pengumpulan_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kepala_shift_pengumpulan_tol_total").val((parseInt(result) + parseInt($("#kepala_shift_pengumpulan_tol_kantor").val())));
                $("#kepala_shift_pengumpulan_tol_gt").val(result);

            }
            });

            //pengumpul_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_pengumpul_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                
                $("#pengumpul_tol_gt").val(result);
                $("#pengumpul_tol_total").val((parseInt(result) + parseInt($("#pengumpul_tol_kantor").val())));
            }
            });

            //tu_administrasi_gerbang_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_tu_administrasi_gerbang_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                 $("#tu_administrasi_gerbang_tol_total").val((parseInt(result) + parseInt($("#tu_administrasi_gerbang_tol_kantor").val())));
                $("#tu_administrasi_gerbang_tol_gt").val(result);
               
            }
            });
            

            //kepala_shift_pengumpulan_tol_ht
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_pengumpulan_tol_ht'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kepala_shift_pengumpulan_tol_ht").val(result);
                $("#kepala_shift_pengumpulan_tol_base").val(result);
                $("#pengumpul_tol_base").val((parseInt(result) + parseInt($("#pengumpul_tol_k_shuttle").val())));
                $("#tu_administrasi_gerbang_tol_base").val((parseInt(result) + parseInt($("#pengumpul_tol_k_shuttle").val())));

            }
            }); 

            //petugas_balancing_total

            $("#petugas_balancing_total").val(parseInt($("#petugas_balancing_kantor").val()) + parseInt($("#petugas_balancing_gt").val()));
            $("#petugas_balancing_ht").val(parseInt($("#petugas_balancing_kantor").val()) + parseInt($("#petugas_balancing_gt").val()));
            $("#petugas_balancing_base").val(parseInt($("#petugas_balancing_kantor").val()) + parseInt($("#petugas_balancing_gt").val()));
            $("#petugas_balancing_k_ops").val(parseInt($("#petugas_balancing_kantor").val()) + parseInt($("#petugas_balancing_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_total").val()

            $("#tu_pemeliharaan_teknisi_inspektor_total").val(parseInt($("#tu_pemeliharaan_teknisi_inspektor_kantor").val()) + parseInt($("#tu_pemeliharaan_teknisi_inspektor_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_total").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_ht").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_total").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_ht").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_base").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_k_ops").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt").val()));

            $("#kepala_shift_patroli_total").val(parseInt($("#kepala_shift_patroli_gt").val()) + parseInt($("#kepala_shift_patroli_kantor").val()));

            $("#kepala_shift_patroli_ht").val(parseInt($("#kepala_shift_patroli_gt").val()) + parseInt($("#kepala_shift_patroli_kantor").val()));

            $("#kepala_shift_patroli_base").val(parseInt($("#kepala_shift_patroli_gt").val()) + parseInt($("#kepala_shift_patroli_kantor").val()));

            $("#kepala_shift_patroli_k_ops").val(parseInt($("#kepala_shift_patroli_gt").val()) + parseInt($("#kepala_shift_patroli_kantor").val()));

            $("#petugas_patroli_total").val(parseInt($("#petugas_patroli_gt").val()) + parseInt($("#petugas_patroli_kantor").val()));

            $("#petugas_patroli_ht").val(parseInt($("#petugas_patroli_gt").val()) + parseInt($("#petugas_patroli_kantor").val()));

            $("#petugas_patroli_base").val(parseInt($("#petugas_patroli_gt").val()) + parseInt($("#petugas_patroli_kantor").val()));

            $("#petugas_patroli_k_ops").val(parseInt($("#petugas_patroli_gt").val()) + parseInt($("#petugas_patroli_kantor").val()));

            //kamtib_ht
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kamtib_ht'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kamtib_ht").val(result);
                $("#kamtib_base").val(result);
                $("#kamtib_k_ops").val(result);
               
            }
            });

            //derek_base
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_derek_base'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#derek_base").val(result); 
            }
            });

            //derek_k_ops
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_derek_k_ops'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#derek_k_ops").val(result);  
            }
            });

            //rescue
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_rescue'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#rescue_base").val(result);  
                $("#rescue_k_ops").val(result);  
            }
            });

            //ambulance
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_ambulance'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#ambulance_base").val(result);  
                $("#ambulance_k_ops").val(result);   
            }
            });

            //manager_area
            $("#manager_area_total").val(parseInt($("#manager_area_kantor").val()) + parseInt($("#manager_area_gt").val()));

            $("#manager_area_ht").val(parseInt($("#manager_area_kantor").val()) + parseInt($("#manager_area_gt").val()));

            $("#manager_area_base").val(parseInt($("#manager_area_kantor").val()) + parseInt($("#manager_area_gt").val()));

            $("#manager_area_k_ops").val(parseInt($("#manager_area_kantor").val()) + parseInt($("#manager_area_gt").val()));
            //manager_area

           
            $("#juru_tata_usaha_pelayanan_lalu_lintas_total").val(parseInt($("#juru_tata_usaha_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#juru_tata_usaha_pelayanan_lalu_lintas_gt").val()));

            $("#petugas_informasi_komunikasi_total").val(parseInt($("#petugas_informasi_komunikasi_kantor").val()) + parseInt($("#petugas_informasi_komunikasi_gt").val()));

            $("#tu_pelayanan_lalu_lintas_total").val(parseInt($("#tu_pelayanan_lalu_lintas_kantor").val()) + parseInt($("#tu_pelayanan_lalu_lintas_gt").val()));

            $("#derek_total").val(parseInt($("#derek_kantor").val()) + parseInt($("#derek_gt").val())); 

            $("#rescue_total").val(parseInt($("#rescue_kantor").val()) + parseInt($("#rescue_gt").val())); 

            $("#ambulance_total").val(parseInt($("#ambulance_kantor").val()) + parseInt($("#ambulance_gt").val()));

            $("#kamtib_total").val(parseInt($("#kamtib_kantor").val()) + parseInt($("#kamtib_gt").val())); 

            $("#pjr_total").val(parseInt($("#pjr_kantor").val()) + parseInt($("#pjr_gt").val()));

            $("#asisten_manager_pemeliharaan_total").val(parseInt($("#asisten_manager_pemeliharaan_kantor").val()) + parseInt($("#asisten_manager_pemeliharaan_gt").val()));

            $("#asisten_manager_pemeliharaan_ht").val(parseInt($("#asisten_manager_pemeliharaan_kantor").val()) + parseInt($("#asisten_manager_pemeliharaan_gt").val()));

            $("#asisten_manager_pemeliharaan_base").val(parseInt($("#asisten_manager_pemeliharaan_kantor").val()) + parseInt($("#asisten_manager_pemeliharaan_gt").val()));

            $("#asisten_manager_pemeliharaan_k_ops").val(parseInt($("#asisten_manager_pemeliharaan_kantor").val()) + parseInt($("#asisten_manager_pemeliharaan_gt").val()));

            $("#juru_tata_usaha_pemeliharaan_total").val(parseInt($("#juru_tata_usaha_pemeliharaan_kantor").val()) + parseInt($("#juru_tata_usaha_pemeliharaan_gt").val()));   

            $("#juru_tata_usaha_pelayanan_transaksi_total").val(parseInt($("#juru_tata_usaha_pelayanan_transaksi_kantor").val()) + parseInt($("#juru_tata_usaha_pelayanan_transaksi_gt").val()));

            $("#juru_tata_usaha_total").val(parseInt($("#juru_tata_usaha_kantor").val()) + parseInt($("#juru_tata_usaha_gt").val()));   


        }
        
 
       }

        function Calculate_Update(){
        var id_pe = $("#id_pe_ubah").val(); 
        var id_tahapx = $("#id_tahapx_ubah").val(); 

        var asisten_manager_transaksi_gt_update = $("#asisten_manager_transaksi_gt_update").val(); 

        var val_asisten_manager_transaksi_kantor_update = parseInt($("#asisten_manager_transaksi_kantor_update").val());

        var val_asisten_manager_transaksi_gt_update = parseInt($("#asisten_manager_transaksi_gt_update").val());

        var kepala_shift_pengumpulan_tol_gt_update = $("#kepala_shift_pengumpulan_tol_gt_update").val();

        var pengumpul_tol_gt_update = $("#pengumpul_tol_gt_update").val();

        var tu_administrasi_gerbang_tol_gt_update = $("#tu_administrasi_gerbang_tol_gt_update").val();

        var kepala_shift_patroli_kantor_update = $("#kepala_shift_patroli_kantor_update").val();

        var petugas_patroli_kantor_update = $("#petugas_patroli_kantor_update").val();

        var asisten_manager_transaksi_ht_update = $("#asisten_manager_transaksi_ht_update").val();

        var kepala_shift_pengumpulan_tol_ht_update = $("#kepala_shift_pengumpulan_tol_ht_update").val();

        var petugas_balancing_ht_update = $("#petugas_balancing_ht_update").val();

        var asisten_manager_pelayanan_lalu_lintas_ht_update = $("#asisten_manager_pelayanan_lalu_lintas_ht_update").val();

        var kepala_shift_patroli_ht_update = $("#kepala_shift_patroli_ht_update").val();

        var petugas_patroli_ht_update = $("#petugas_patroli_ht_update").val();

        var kamtib_ht_update = $("#kamtib_ht_update").val();

        var pjr_ht_update = $("#pjr_ht_update").val();

        var asisten_manager_transaksi_base_update = $("#asisten_manager_transaksi_base_update").val();

        var kepala_shift_pengumpulan_tol_base_update = $("#kepala_shift_pengumpulan_tol_base_update").val();

        var pengumpul_tol_base_update = $("#pengumpul_tol_base_update").val();

        var tu_administrasi_gerbang_tol_base_update = $("#tu_administrasi_gerbang_tol_base_update").val();

        var petugas_balancing_base_update = $("#petugas_balancing_base_update").val();
        var asisten_manager_pelayanan_lalu_lintas_base_update = $("#asisten_manager_pelayanan_lalu_lintas_base_update").val();

        var kepala_shift_patroli_base_update = $("#kepala_shift_patroli_base_update").val();
        var petugas_patroli_base_update  = $("#petugas_patroli_base_update").val();

        var derek_base_update = $("#derek_base_update").val();

        var rescue_base_update = $("#rescue_base_update").val();

        var ambulance_base_update = $("#ambulance_base_update").val();

        var kamtib_base_update = $("#kamtib_base_update").val();

        var pjr_base_update = $("#pjr_base_update").val();

        var asisten_manager_pemeliharaan_ht_update = $("#asisten_manager_pemeliharaan_ht_update").val();

        var asisten_manager_pemeliharaan_base_update = $("#asisten_manager_pemeliharaan_base_update").val();

        var asisten_manager_transaksi_k_ops_update = $("#asisten_manager_transaksi_k_ops_update").val();

        var petugas_balancing_k_ops_update = $("#petugas_balancing_k_ops_update").val();

        var asisten_manager_pelayanan_lalu_lintas_k_ops_update = $("#asisten_manager_pelayanan_lalu_lintas_k_ops_update").val();

        var kepala_shift_patroli_k_ops_update = $("#kepala_shift_patroli_k_ops_update").val();
        var petugas_patroli_k_ops_update = $("#petugas_patroli_k_ops_update").val();

        var petugas_patroli_k_ops_update  = $("#petugas_patroli_k_ops_update").val();

        var derek_k_ops_update = $("#derek_k_ops_update").val();

        var rescue_k_ops_update = $("#rescue_k_ops_update").val();

        var ambulance_k_ops_update = $("#ambulance_k_ops_update").val();

        var kamtib_k_ops_update = $("#kamtib_k_ops_update").val();

        var pjr_k_ops_update = $("#pjr_k_ops_update").val();

        var asisten_manager_pemeliharaan_base_update = $("#asisten_manager_pemeliharaan_base_update").val();

        var pengumpul_tol_k_shuttle_update = parseInt($("#pengumpul_tol_k_shuttle_update").val());
        
        
            //ambil Asisten Manager Transaksi GT
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_asisten_manager_transaksi_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
           
          

                $("#asisten_manager_transaksi_gt_update").val(result);
                //asisten_manager_transaksi_ht
                $("#asisten_manager_transaksi_ht_update").val(parseInt($("#asisten_manager_transaksi_gt_update").val()) + parseInt($("#asisten_manager_transaksi_kantor_update").val()));
                $("#asisten_manager_transaksi_base_update").val(parseInt($("#asisten_manager_transaksi_gt_update").val()) + parseInt($("#asisten_manager_transaksi_kantor_update").val()));
                $("#asisten_manager_transaksi_k_ops_update").val(parseInt($("#asisten_manager_transaksi_gt_update").val()) + parseInt($("#asisten_manager_transaksi_kantor_update").val()));

                $("#asisten_manager_transaksi_total_update").val(parseInt($("#asisten_manager_transaksi_gt_update").val()) + parseInt($("#asisten_manager_transaksi_kantor_update").val()));
            }
            });

            //kepala_shift_patroli_kantor
             $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_patroli_kantor'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kepala_shift_patroli_kantor_update").val(result);
                $("#kepala_shift_patroli_total_update").val((parseInt(result) + parseInt($("#kepala_shift_patroli_gt_update").val())));
            }
            });

            //petugas_patroli_kantor
             $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_petugas_patroli_kantor'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#petugas_patroli_kantor_update").val(result);
                 $("#petugas_patroli_total_update").val((parseInt(result) + parseInt($("#petugas_patroli_gt_update").val())));
            }
            });


            //kepala_shift_pengumpulan_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_pengumpulan_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
 $("#kepala_shift_pengumpulan_tol_total_update").val((parseInt(result) + parseInt($("#kepala_shift_pengumpulan_tol_kantor_update").val())));
                //$("#kepala_shift_pengumpulan_tol_gt").val(result);
                $("#kepala_shift_pengumpulan_tol_gt_update").val(result);
            }
            });

            //pengumpul_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_pengumpul_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                 
                $("#pengumpul_tol_gt_update").val(result);
                 $("#pengumpul_tol_total_update").val((parseInt(result) + parseInt($("#pengumpul_tol_kantor_update").val())));
            }
            });

            //tu_administrasi_gerbang_tol_gt
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_tu_administrasi_gerbang_tol_gt'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#tu_administrasi_gerbang_tol_gt_update").val(result);
                $("#tu_administrasi_gerbang_tol_total_update").val((parseInt(result) + parseInt($("#tu_administrasi_gerbang_tol_kantor_update").val())));
            }
            });
            

            //kepala_shift_pengumpulan_tol_ht
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kepala_shift_pengumpulan_tol_ht'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kepala_shift_pengumpulan_tol_ht_update").val(result);
                $("#kepala_shift_pengumpulan_tol_base_update").val((parseInt(result) + parseInt($("#pengumpul_tol_k_shuttle_update").val())));
                $("#pengumpul_tol_base_update").val((parseInt(result) + parseInt($("#pengumpul_tol_k_shuttle_update").val())));
                $("#tu_administrasi_gerbang_tol_base_update").val((parseInt(result) + parseInt($("#pengumpul_tol_k_shuttle_update").val())));

            }
            }); 

            //petugas_balancing_total

            $("#petugas_balancing_total_update").val(parseInt($("#petugas_balancing_kantor_update").val()) + parseInt($("#petugas_balancing_gt_update").val()));
            $("#petugas_balancing_ht_update").val(parseInt($("#petugas_balancing_kantor_update").val()) + parseInt($("#petugas_balancing_gt_update").val()));
            $("#petugas_balancing_base_update").val(parseInt($("#petugas_balancing_kantor_update").val()) + parseInt($("#petugas_balancing_gt_update").val()));
            $("#petugas_balancing_k_ops_update").val(parseInt($("#petugas_balancing_kantor_update").val()) + parseInt($("#petugas_balancing_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_total_update").val()

            $("#asisten_manager_pelayanan_lalu_lintas_total_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_ht_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_total_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_ht_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_base_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#asisten_manager_pelayanan_lalu_lintas_k_ops_update").val(parseInt($("#asisten_manager_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#asisten_manager_pelayanan_lalu_lintas_gt_update").val()));

            $("#kepala_shift_patroli_total_update").val(parseInt($("#kepala_shift_patroli_gt_update").val()) + parseInt($("#kepala_shift_patroli_kantor_update").val()));

            $("#kepala_shift_patroli_ht_update").val(parseInt($("#kepala_shift_patroli_gt_update").val()) + parseInt($("#kepala_shift_patroli_kantor_update").val()));

            $("#kepala_shift_patroli_base_update").val(parseInt($("#kepala_shift_patroli_gt_update").val()) + parseInt($("#kepala_shift_patroli_kantor_update").val()));

            $("#kepala_shift_patroli_k_ops_update").val(parseInt($("#kepala_shift_patroli_gt_update").val()) + parseInt($("#kepala_shift_patroli_kantor_update").val()));

            $("#petugas_patroli_total_update").val(parseInt($("#petugas_patroli_gt_update").val()) + parseInt($("#petugas_patroli_kantor_update").val()));

            $("#petugas_patroli_ht_update").val(parseInt($("#petugas_patroli_gt_update").val()) + parseInt($("#petugas_patroli_kantor_update").val()));

            $("#petugas_patroli_base_update").val(parseInt($("#petugas_patroli_gt_update").val()) + parseInt($("#petugas_patroli_kantor_update").val()));

            $("#petugas_patroli_k_ops_update").val(parseInt($("#petugas_patroli_gt_update").val()) + parseInt($("#petugas_patroli_kantor_update").val()));

            //kamtib_ht
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_kamtib_ht'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#kamtib_ht_update").val(result);
                $("#kamtib_base_update").val(result);
                $("#kamtib_k_ops_update").val(result);
               
            }
            });

            //derek_base
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_derek_base'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#derek_base_update").val(result); 
            }
            });

            //derek_k_ops
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_derek_k_ops'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#derek_k_ops_update").val(result);  
            }
            });

            //rescue
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_rescue'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#rescue_base_update").val(result);  
                $("#rescue_k_ops_update").val(result);  
            }
            });

            //ambulance
            $.ajax({
            url:"<?php echo base_url('jlo_sdm_val/call_ambulance'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success:function(result){
                $("#ambulance_base_update").val(result);  
                $("#ambulance_k_ops_update").val(result);   
            }
            });

            $("#manager_area_total_update").val(parseInt($("#manager_area_kantor_update").val()) + parseInt($("#manager_area_gt_update").val()));

            $("#juru_tata_usaha_total_update").val(parseInt($("#juru_tata_usaha_kantor_update").val()) + parseInt($("#juru_tata_usaha_gt_update").val()));

            $("#juru_tata_usaha_pelayanan_lalu_lintas_total_update").val(parseInt($("#juru_tata_usaha_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#juru_tata_usaha_pelayanan_lalu_lintas_gt_update").val()));

            $("#petugas_informasi_komunikasi_total_update").val(parseInt($("#petugas_informasi_komunikasi_kantor_update").val()) + parseInt($("#petugas_informasi_komunikasi_gt_update").val()));

            $("#tu_pelayanan_lalu_lintas_total_update").val(parseInt($("#tu_pelayanan_lalu_lintas_kantor_update").val()) + parseInt($("#tu_pelayanan_lalu_lintas_gt_update").val()));

            $("#derek_total_update").val(parseInt($("#derek_kantor_update").val()) + parseInt($("#derek_gt_update").val())); 

            $("#rescue_total_update").val(parseInt($("#rescue_kantor_update").val()) + parseInt($("#rescue_gt_update").val())); 

            $("#ambulance_total_update").val(parseInt($("#ambulance_kantor_update").val()) + parseInt($("#ambulance_gt_update").val()));

            $("#kamtib_total_update").val(parseInt($("#kamtib_kantor_update").val()) + parseInt($("#kamtib_gt_update").val())); 

            $("#pjr_total_update").val(parseInt($("#pjr_kantor_update").val()) + parseInt($("#pjr_gt_update").val()));

            $("#asisten_manager_pemeliharaan_total_update").val(parseInt($("#asisten_manager_pemeliharaan_kantor_update").val()) + parseInt($("#asisten_manager_pemeliharaan_gt_update").val()));

            $("#asisten_manager_pemeliharaan_ht_update").val(parseInt($("#asisten_manager_pemeliharaan_kantor_update").val()) + parseInt($("#asisten_manager_pemeliharaan_gt_update").val()));

            $("#asisten_manager_pemeliharaan_base_update").val(parseInt($("#asisten_manager_pemeliharaan_kantor_update").val()) + parseInt($("#asisten_manager_pemeliharaan_gt_update").val()));

            $("#asisten_manager_pemeliharaan_k_ops_update").val(parseInt($("#asisten_manager_pemeliharaan_kantor_update").val()) + parseInt($("#asisten_manager_pemeliharaan_gt_update").val()));

            $("#juru_tata_usaha_pemeliharaan_total_update").val(parseInt($("#juru_tata_usaha_pemeliharaan_kantor_update").val()) + parseInt($("#juru_tata_usaha_pemeliharaan_gt_update").val()));   

            $("#juru_tata_usaha_pelayanan_transaksi_total_update").val(parseInt($("#juru_tata_usaha_pelayanan_transaksi_kantor_update").val()) + parseInt($("#juru_tata_usaha_pelayanan_transaksi_gt_update").val()));   


        
        
 
       }
      
	 
       $(document).ready(function() {
	
		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});

        $('#examples').DataTable({
           "ajax": "<?php echo base_url(); ?>jlo_sdm_val/list_store_sdm_val" 
        });
		 
		var groupColumn = 8;
        var table = $('#example').DataTable({
            "ajax": "<?php echo base_url(); ?>jlo_sdm_val/fetch_jlo_sdm_val",
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
              "order": [[ 8, 'asc' ]],
            "displayLength": 50,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="7"><b>'+group+'</b></td></tr>'
                        );
     
                        last = group;
                    }
                } );
            }
        } );
     
        // Order by the grouping
        $('#example tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                table.order( [ groupColumn, 'asc' ] ).draw();
            }
            else {
                table.order( [ groupColumn, 'asc' ] ).draw();
            }
        } );
 
		 
	  });
  
		
		 
    </script>