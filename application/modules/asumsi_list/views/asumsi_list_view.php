 
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
                                Asumsi List
                            </h2>
                            <br>
                     
                            <form method="post" id="user_form" enctype="multipart/form-data">  
                          <br>
 
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
                        <div class="body">
                            <table id="example" class="table table-bordered table-striped table-hover js-basic-example">
                            <thead>
                            <tr>
                                        <td style="width: 2%;"> No </td>
                                        <td style="width: 5%;"> Uraian </td>
                                        <td style="width: 5%;"> Volume </td>
                                        <td style="width: 2%;"> Satuan </td>
                                        <td style="width: 5%;"> Safety Factor </td>
                                        <td style="width: 5%;"> Keterangan </td>
                                    </tr>
                                </thead>
                                </table>
                                <br>
                                   

                            </form>

                            <br>
                             <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Asumsi();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                                <br>
                                <h3 align="center"> List Asumsi  </h3>
                                 <table id="examples" class="table table-bordered table-striped table-hover js-basic-examples">
                            <thead>
                            <tr>
                                <td style="width: 2%"> No </td>
                                <td style="width: 5%"> Nama Penawaran </td>
                                <td style="width: 2%"> Tahap </td>
                              
                                <td style="width: 5%"> Opsi </td>

                            </tr>
                            </thead>
              
                        </table>
                             
                                  
                            <hr>
  
                        </div>
                    </div>
                </div>
            </div>
         


        </div>
    </section>

   
    <div class="modal fade" id="DetailAsumsiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Detail Asumsi</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                               

                               <table id="examplez" width="100%" class="table table-bordered table-striped table-hover js-basic-examplez">
                                <thead>
                                <tr>
                                        <td> No </td>
                                        <td> Uraian </td>
                                        <td> Volume </td>
                                        <td> Satuan </td>
                                        <td> Safety Factor </td>
                                        <td> Keterangan </td>
                                    </tr>
                                </thead>
                                </table>
                                 
                       </div>
                     
                    </div>
                </div>
    </div>

    <div class="modal fade" id="UbahAsumsiListModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Ubah Asumsi List</h4>
                        </div>
                        <div class="modal-body">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                                <form method="post" id="user_form_update" enctype="multipart/form-data">  
                               <input type="hidden" id="id_pe_ubah" name="id_pe_ubah">
                               <input type="hidden" id="id_tahapx_ubah" name="id_tahapx_ubah">

                               <table id="exampley" width="100%" class="table table-bordered table-striped table-hover js-basic-exampley">
                                <thead>
                                <tr>
                                        <td> No </td>
                                        <td> Uraian </td>
                                        <td> Volume </td>
                                        <td> Satuan </td>
                                        <td> Safety Factor </td>
                                        <td> Keterangan </td>
                                    </tr>
                                </thead>
                                </table>
                                <br>
                                  <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data_Update();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate_Asumsi_Update();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                                </form>
                       </div>
                     
                    </div>
                </div>
    </div>
            
 
   <script type="text/javascript">

     function Detail(id,idx){
        $("#DetailAsumsiModal").modal({backdrop: 'static', keyboard: false,show:true});

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('asumsi_list/list_detail_asumsi'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 

            "columns" : [ 
            {
                "data" : "no"
            },
            {
                "data" : "nama_asumsi"
            },
            {
                "data" : "vol"
            },
            {
                "data" : "nama_satuan"
            },
            {
                "data" : "safety_factor"
            },
            {
                "data" : "keterangan"
            }

             ],

            "rowReorder": {
                "update": false
            },
             "order": [[ 0, 'asc' ]] 
            
        });
    
 
    }  
     function GetAdditional(){
        var penawaran = $("#id_pe").val();
        var tahap = $("#id_tahapx").val(); 
       
        $.ajax({
             url:"<?php echo base_url(); ?>asumsi_list/get_additional/",
             type:"POST",
             data:{penawaran:penawaran,tahap:tahap},
             contentType:false,  
             processData:false,   
             success:function(result){ 
              // console.log(result);
               $("#additional_result").val(result);            
           }
         }); 
         
     }

	 function Calculate_Asumsi(){

        var id_pe = $("#id_pe").val();
        var id_tahapx = $("#id_tahapx").val();

        if(id_pe == ''){
            alert('Penawaran Belum Anda Pilih');
        }else{
        
        var panjang_jalan = parseInt($("#panjang_jalan").val());
        var sum_kr_patroli =  Math.ceil(((panjang_jalan * 0.8)/15));
        var sum_kr_rescue_shift =  Math.ceil(((panjang_jalan * 0.8)/50));
        var sum_kr_ambulance_shift =  Math.ceil(((panjang_jalan * 0.8)/25));
        var lhr = parseInt($("#lhr").val());
 
        var kr_ks_patroli_shift  = parseInt($("#kr_ks_patroli_shift").val());
        //alert(kr_patroli);
        $("#jumlah_kanit_pjr").val(kr_ks_patroli_shift);
        $("#kr_kamtib_shift").val(kr_ks_patroli_shift);

        $("#kr_patroli_shift").val(sum_kr_patroli);
        $("#kr_rescue_shift").val(sum_kr_rescue_shift);
        $("#kr_ambulance_shift").val(sum_kr_ambulance_shift);
        $("#lhr").val();
        //ambil jumlah_gerbang


        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_jumlah_gerbang'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success : function(result){
                //console.log(result);
                $("#jumlah_gerbang").val(result);
               // console.log($("#jumlah_gerbang").val());
                $("#pos_tol").val(($("#jumlah_gerbang").val() - $("#kantor_wilayah_gerbang_tol").val()));
                $("#jumlah_interchange_junction").val(result);
            }
        });

        //ambil jumlah lajur transaksi
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_jumlah_lajur_trans'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success : function(result){
                //console.log(result);
                $("#jumlah_lajur_transaksi").val(result);
                 
            }
        });

        //hitung kr_derek_shift
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_kr_derek_shift'); ?>",
            type:"POST",
            data:{panjang_jalan:panjang_jalan,lhr:lhr},
            success : function(result){
                console.log(result);
                $("#kr_derek_shift").val(result);
                 
            }
        });

        //hitung pjr_derek_shift
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_pjr_derek_shift'); ?>",
            type:"POST",
            data:{panjang_jalan:panjang_jalan,lhr:lhr},
            success : function(result){
                console.log(result);
                $("#kr_pjr_shift").val(result);
                 
            }
        });
        
        }
      


     }


     function Calculate_Asumsi_Update(){
        var panjang_jalan_update = parseInt($("#panjang_jalan_update").val());
        var sum_kr_patroli_update =  Math.ceil(((panjang_jalan_update * 0.8)/15));
        var sum_kr_rescue_shift_update =  Math.ceil(((panjang_jalan_update * 0.8)/50));
        var sum_kr_ambulance_shift_update =  Math.ceil(((panjang_jalan_update * 0.8)/25));
        var lhr_update = parseInt($("#lhr_update").val());
        //alert(kr_patroli);
        $("#kr_patroli_shift_update").val(sum_kr_patroli_update);
        $("#kr_rescue_shift_update").val(sum_kr_rescue_shift_update);
        $("#kr_ambulance_shift_update").val(sum_kr_ambulance_shift_update);
        $("#lhr_update").val();
        //ambil jumlah_gerbang

        var id_pe = $("#id_pe_ubah").val();
        var id_tahapx = $("#id_tahapx_ubah").val();

        var kr_ks_patroli_shift_update  = parseInt($("#kr_ks_patroli_shift_update").val());
        //alert(kr_patroli);
        $("#jumlah_kanit_pjr_update").val(kr_ks_patroli_shift_update);
        $("#kr_kamtib_shift_update").val(kr_ks_patroli_shift_update);

        $("#jumlah_kanit_pjr").val(kr_ks_patroli_shift);
        $("#kr_kamtib_shift").val(kr_ks_patroli_shift);


        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_jumlah_gerbang'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success : function(result){
                //console.log(result);
                $("#jumlah_gerbang_update").val(result);
               // console.log($("#jumlah_gerbang").val());
                $("#pos_tol_update").val(($("#jumlah_gerbang_update").val() - $("#kantor_wilayah_gerbang_tol_update").val()));
                $("#jumlah_interchange_junction_update").val(result);
            }
        });

        //ambil jumlah lajur transaksi
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_jumlah_lajur_trans'); ?>",
            type:"POST",
            data:{id_pe:id_pe,id_tahapx:id_tahapx},
            success : function(result){
                //console.log(result);
                $("#jumlah_lajur_transaksi_update").val(result);
                 
            }
        });

        //hitung kr_derek_shift
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_kr_derek_shift'); ?>",
            type:"POST",
            data:{panjang_jalan:panjang_jalan_update,lhr:lhr_update},
            success : function(result){
                console.log(result);
                $("#kr_derek_shift_update").val(result);
                 
            }
        });

        //hitung pjr_derek_shift
        $.ajax({
            url:"<?php echo base_url('asumsi_list/call_pjr_derek_shift'); ?>",
            type:"POST",
            data:{panjang_jalan:panjang_jalan_update,lhr:lhr_update},
            success : function(result){
                console.log(result);
                $("#kr_pjr_shift_update").val(result);
                 
            }
        });
        
        


     }

	 function Ubah_Data(id,idx){
		 $("#UbahAsumsiListModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_pe_ubah").val(id);
        $("#id_tahapx_ubah").val(idx);
        

        $('#exampley').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('asumsi_list/list_detail_asumsi_update'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 
            "displayLength": 50,

            "columns" : [ 
            {
                "data" : "no"
            },
            {
                "data" : "nama_asumsi"
            },
            {
                "data" : "vol"
            },
            {
                "data" : "nama_satuan"
            },
            {
                "data" : "safety_factor"
            },
            {
                "data" : "keterangan"
            }

             ],

            "rowReorder": {
                "update": false
            },
             "order": [[ 0, 'asc' ]] 
            
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
            url : "<?php echo base_url('asumsi_list/hapus_data')?>/"+id+"/"+idx,
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
    
      
  
	function Simpan_Data(){
        var tbl = $("#example").DataTable();
		if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>asumsi_list/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
             success:function(result){  
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
        var tbl = $("#exampley").DataTable();
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>asumsi_list/simpan_data_update",
             type:"POST",
             data:$("#user_form_update").serialize(),
             success:function(result){  
                $('#examples').DataTable().ajax.reload(); 
                $("#UbahAsumsiListModal").modal('hide');
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
        
 
 
        $.ajax({
            type: "POST",  
            url: "<?php echo base_url('asumsi_list/get_tahap_val'); ?>",  
            data: {id_pe : $("#id_pe").val()}, 
            success: function(response){  
                
                console.log(response);
                $("#restahap").html(response);
            } 
        });
   

       }
          

       $(document).ready(function() {
		   
		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});


        $('#examples').DataTable({
           "ajax": "<?php echo base_url(); ?>asumsi_list/list_store_asumsi_list" 
        });

        $('#example').DataTable({
           "ajax": "<?php echo base_url(); ?>asumsi_list/fetch_asumsi_list" ,
          
            "order": [[ 0, 'asc' ]],
         
            "displayLength": 50,
            
        } ); 
	  });
  
		
		 
    </script>