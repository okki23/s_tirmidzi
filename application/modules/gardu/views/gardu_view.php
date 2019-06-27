 
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
                                Gardu
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

                           <table align="left">
                               <tr align="left">
                                <td align="left" >  <a style="float: left;" class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i>&nbsp;Tambah Data</a>    </td>
                               </tr>
                           </table>
                           <br>
                           &nbsp;
                           <br>
                           &nbsp;
                                <div class="table-responsive">   
                               
                                <table style="width: 100%;" border="1"   cellspacing="0" cellpadding="3" class="table table-bordered" id="tbl_posts">
                                <thead>
                                <tr>
                                <td style="width: 100%;" rowspan="3">#</td>
                                <td style="width: 100%;" rowspan="3">Gerbang Tol</td>
                                <td style="width: 100%;" colspan="4">Jumlah Lajur</td>
                                <td style="width: 100%;" colspan="6">Gardu Tersedia</td>
                                <td style="width: 100%;" rowspan="3">Kebutuhan Pengumpul Tol</td>
                                <td style="width: 100%;" rowspan="3">Kebutuhan KSPT</td>
                                <td style="width: 100%;" rowspan="3">Kebutuhan TUGT</td>
                                <td style="width: 100%;" rowspan="3">Jadwal Operasi</td>
                                </tr>
                                <tr>
                                <td style="width: 100%;" rowspan="2">Ent</td>
                                <td style="width: 100%;" rowspan="2">Ext</td>
                                <td style="width: 100%;" rowspan="2">Rev</td>
                                <td style="width: 100%;" rowspan="2">Total</td>
                                <td style="width: 100%;" colspan="3">Ent</td>
                                <td style="width: 100%;" colspan="2">Ext</td>
                                <td style="width: 100%;" rowspan="2">Rev</td>
                                </tr>
                                <tr>
                                <td style="width: 100%;">GTO Single</td>
                                <td style="width: 100%;">GTO Multi</td>
                                <td style="width: 100%;">Reg</td>
                                <td style="width: 100%;">GTO Multi</td>
                                <td style="width: 100%;">GTO Single</td>
                                </tr>
                                </thead>
                                <tbody id="tbl_posts_body">
                                <tr id="rec-1">
                                <td style="width: 100%;"><a class="btn btn-xs delete-record" data-id="2"><i class="glyphicon glyphicon-trash"></i></a></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="nama_gt[]"  id="nama_gt" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control"name="jml_ent[]" value="0" id="jml_ent" style="width: 200px;" readonly="readonly"   ></td>
                                <td style="width: 100%;"><input type="text" class="form-control"  name="jml_ext[]" value="0" id="jml_ext" style="width: 200px;" readonly="readonly"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="jml_rev[]" value="0" id="jml_rev" style="width: 200px;" readonly="readonly"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="jml_tot[]" value="0" id="jml_tot" style="width: 200px;" readonly="readonly"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ent_gto_single[]" value="0" id="ent_gto_single" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ent_gto_multi[]" value="0" id="ent_gto_multi" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ent_reg[]" value="0" id="ent_reg" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ext_gto_multi[]" value="0" id="ext_gto_multi" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ext_gto_single[]" value="0" id="ext_gto_single" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ext_rev[]" value="0" id="ext_rev" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="kpt[]" value="0" id="kpt" readonly="readonly" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="kspt[]" value="0" id="kspt" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="ktugt[]" value="0"  id="ktugt" style="width: 200px;"></td>
                                <td style="width: 100%;"><input type="text" class="form-control" name="jops[]" value="0" id="jops" style="width: 200px;"></td>
                                </tr>
                                </tbody>
                                </table>
 
                                </div>
                                <br> 
                                <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp; <button type="button" onclick="Calculate();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Calculate</button> </td>
                                    </tr>
                                </table>
                                  
                                   <br>
                                   

                            </form>

                            <br>
                            <hr>


                            <div class="table-responsive">
                              
                              <h4 align="center"> List Gardu </h4>
                                <table id="examples" class="table table-bordered table-striped table-hover js-basic-examples">
                            <thead>
                            <tr>
                                <td style="width: 2%"> No </td>
                                <td style="width: 5%"> Nama Penawaran </td>
                                <td style="width: 2%"> Tahap </td>
                                <td style="width: 5%"> User Insert </td>
                                <td style="width: 5%"> Date Insert </td>
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
    </section>

  
 
    <div class="modal fade" id="DetailModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Detail Gardu</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                                <input type="hidden" name="id_penawaranx" id="id_penawaranx">

                                <table id="examplez" class="table table-bordered table-striped table-hover js-basic-examplez">
                                    <thead>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;" rowspan="3">No</td>
                                    <td style="width: 50.8px; text-align: center;" rowspan="3">Gerbang Tol</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="4" rowspan="2">Jumlah Lajur</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="6">Gardu Tersedia</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan Pengumpul Tol</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan KSPT</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan TUGT</td>
                                    <td style="width: 50.8px;" rowspan="3">Jadwal Operasi</td>
                                    </tr>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;" colspan="3">Ent</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="2">Ext</td>
                                    <td style="width: 50.8px; text-align: center;" rowspan="2">Rev</td>
                                    </tr>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;">Ent</td>
                                    <td style="width: 50.8px; text-align: center;">Ext</td>
                                    <td style="width: 50.8px; text-align: center;">Rev</td>
                                    <td style="width: 50.8px; text-align: center;">Total</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Multi</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Single</td>
                                    <td style="width: 50.8px; text-align: center;">Reg</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Single</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Multi</td>
                                    </tr>
                                    </thead>
                      
                                </table>
                                 
                       </div>
                     
                    </div>
                </div>
    </div>


    <div class="modal fade" id="UbahGarduListModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Ubah Gardu List</h4>
                        </div>
                        <div class="modal-body">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                                <form method="post" id="user_form_update" enctype="multipart/form-data">  

                               <input type="hidden" id="id_pe_ubah" name="id_pe_ubah">
                               <input type="hidden" id="id_tahapx_ubah" name="id_tahapx_ubah">

                               <table id="exampley" class="table table-bordered table-striped table-hover js-basic-examplez">
                                    <thead>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;" rowspan="3">No</td>
                                    <td style="width: 50.8px; text-align: center;" rowspan="3">Gerbang Tol</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="4" rowspan="2">Jumlah Lajur</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="6">Gardu Tersedia</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan Pengumpul Tol</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan KSPT</td>
                                    <td style="width: 50.8px;" rowspan="3">Kebutuhan TUGT</td>
                                    <td style="width: 50.8px;" rowspan="3">Jadwal Operasi</td>
                                    </tr>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;" colspan="3">Ent</td>
                                    <td style="width: 50.8px; text-align: center;" colspan="2">Ext</td>
                                    <td style="width: 50.8px; text-align: center;" rowspan="2">Rev</td>
                                    </tr>
                                    <tr>
                                    <td style="width: 50.8px; text-align: center;">Ent</td>
                                    <td style="width: 50.8px; text-align: center;">Ext</td>
                                    <td style="width: 50.8px; text-align: center;">Rev</td>
                                    <td style="width: 50.8px; text-align: center;">Total</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Multi</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Single</td>
                                    <td style="width: 50.8px; text-align: center;">Reg</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Single</td>
                                    <td style="width: 50.8px; text-align: center;">GTO Multi</td>
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


  <div style="display:none;">
    <table id="sample_table">
      <tr id="">
       <td style="width: 100%;"><a class="btn btn-xs delete-record" data-id="0"><i class="glyphicon glyphicon-trash"></i></a></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="nama_gt[]"  id="nama_gt" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control"name="jml_ent[]" value="0" id="jml_ent" style="width: 200px;" readonly="readonly"   ></td>
       <td style="width: 100%;"><input type="text" class="form-control"  name="jml_ext[]" value="0" id="jml_ext" style="width: 200px;" readonly="readonly"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="jml_rev[]" value="0" id="jml_rev" style="width: 200px;" readonly="readonly"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="jml_tot[]" value="0" id="jml_tot" style="width: 200px;" readonly="readonly"></td>

       <td style="width: 100%;"><input type="text" class="form-control" name="ent_gto_single[]" value="0" id="ent_gto_single" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ent_gto_multi[]" value="0" id="ent_gto_multi" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ent_reg[]" value="0" id="ent_reg" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ext_gto_multi[]" value="0" id="ext_gto_multi" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ext_gto_single[]" value="0" id="ext_gto_single" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ext_rev[]" value="0" id="ext_rev" style="width: 200px;"></td>

       <td style="width: 100%;"><input type="text" class="form-control" name="kpt[]" value="0" id="kpt" style="width: 200px;" readonly="readonly"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="kspt[]" value="0" id="kspt" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="ktugt[]" value="0"  id="ktugt" style="width: 200px;"></td>
       <td style="width: 100%;"><input type="text" class="form-control" name="jops[]" value="0" id="jops" style="width: 200px;"></td>

     </tr>
   </table>
 </div> 
			
 <style type="text/css"> 
     #jml_ent,#jml_ext,#jml_rev,#jml_tot,#kpt{
        background-color:#D8D8D8;
     } 
      #jml_ent_update,#jml_ext_update,#jml_rev_update,#jml_tot_update,#kpt_update{
        background-color:#D8D8D8;
     } 
 </style>
 
   <script type="text/javascript">
	
    
    function Detail(id,idx){
        $("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_penawaranx").val(id);
        

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('gardu/list_detail_gardu'); ?>",
                "data":{id:id,idx:idx},
                "type":"POST",
                 dataSrc : '',

            }, 

            "columns" : [ 
            {
                "data" : "no"
            },
            {
                "data" : "nama_gt"
            },
            {
                "data" : "jml_ent"
            },
             {
                "data" : "jml_ext"
            },
             {
                "data" : "jml_rev"
            },
            {
                "data" : "jml_tot"
            },
            {
                "data" : "ent_gto_single"
            },
            {
                "data" : "ent_gto_multi"
            },
            {
                "data" : "ent_reg"
            },
            {
                "data" : "ext_gto_multi"
            },
            {
                "data" : "ext_gto_single"
            },
            {
                "data" : "ext_rev"
            },
            {
                "data" : "kpt"
            },
            {
                "data" : "kspt"
            },
            {
                "data" : "ktugt"
            },
            {
                "data" : "jops"
            }],

            "rowReorder": {
                "update": false
            },

     
            
        });
    
 
    } 
       
	 // function Ubah_Data(id){
		// $("#defaultModalLabel").html("Form Ubah Data");
		// $("#defaultModal").modal('show');
 
		// $.ajax({
		// 	 url:"<?php echo base_url(); ?>gardu/get_data_edit/"+id,
		// 	 type:"GET",
		// 	 dataType:"JSON", 
		// 	 success:function(result){ 
                  
		// 		 $("#defaultModal").modal('show'); 
		// 		 $("#id").val(result.id);
                 
  //                $("#nama_gardu").val(result.nama_gardu);
              
                  
		// 	 }
		//  });
	 // }

      function Ubah_Data(id,idx){
        $("#UbahGarduListModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_pe_ubah").val(id);
        $("#id_tahapx_ubah").val(idx);
        

        $('#exampley').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('gardu/list_detail_gardu_ubah'); ?>",
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
                "data" : "nama_gt"
            },
            {
                "data" : "jml_ent"
            },
             {
                "data" : "jml_ext"
            },
             {
                "data" : "jml_rev"
            },
            {
                "data" : "jml_tot"
            },
            {
                "data" : "ent_gto_single"
            },
            {
                "data" : "ent_gto_multi"
            },
            {
                "data" : "ent_reg"
            },
            {
                "data" : "ext_gto_multi"
            },
            {
                "data" : "ext_gto_single"
            },
            {
                "data" : "ext_rev"
            },
            {
                "data" : "kpt"
            },
            {
                "data" : "kspt"
            },
            {
                "data" : "ktugt"
            },
            {
                "data" : "jops"
            }],

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
            url : "<?php echo base_url('gardu/hapus_data')?>/"+id+"/"+idx,
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
        var id_pe = $("#id_pe").val();
        if(id_pe == ''){
            alert('Anda belum memilih penawaran dan tahap!');
        }else{

          
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>gardu/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
             success:function(result){ 
             console.log(result); 

             if(result == "1"){

                    $.notify("Data berhasil ditambahkan!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                    },{
                    type: 'success'
                    });
                    $('#tbl_posts tbody').html('');
                     var content = $('#sample_table tr'),
     size = $('#tbl_posts >tbody >tr').length + 1,
     element = null,    
     element = content.clone();
     element.attr('id', 'rec-'+size);
     element.find('.delete-record').attr('data-id', size);
     element.appendTo('#tbl_posts_body');
     element.find('.sn').html(size);

                    //location.reload();
                    $('#examples').DataTable().ajax.reload(); 
                    //tbl.row().remove().draw();
          
    
                    $("#id_penawaran").val('');
                    $("#id_tahapx").val('');
     
                return true;
             }else{
                 $('#tbl_posts tbody').html('');
                  var content = $('#sample_table tr'),
     size = $('#tbl_posts >tbody >tr').length + 1,
     element = null,    
     element = content.clone();
     element.attr('id', 'rec-'+size);
     element.find('.delete-record').attr('data-id', size);
     element.appendTo('#tbl_posts_body');
     element.find('.sn').html(size);
                 $.notify("Data gagal ditambahkan, anda sudah pernah mengisi data ini sebelumnya!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                 },{
                    type: 'danger'
                    });
                  $('#examples').DataTable().ajax.reload(); 
                  //tbl.row().remove().draw();
                      
                    $("#id_penawaran").val('');
                    $("#id_tahapx").val('');
                
                   //location.reload();
                 return true;
             }


             },
             error: function (jqXHR, textStatus, errorThrown){
                alert('Error submit data');
             }
             }); 
   
        } 

        }
        
           

	}

    function Simpan_Data_Update(){
        var tbl = $("#example").DataTable();
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan kalkulasi telah dilakukan !')){
          $.ajax({
             url:"<?php echo base_url(); ?>gardu/simpan_data_update",
             type:"POST",
             data:$("#user_form_update").serialize(),
             success:function(result){ 
             console.log(result); 
             $("#UbahGarduListModal").modal('hide');
                  $.notify("Data berhasil ditambahkan!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                    },{
                    type: 'success'
                    });
                $('#examples').DataTable().ajax.reload(); 
 


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
            url: "<?php echo base_url('gardu/get_tahap_val'); ?>",  
            data: {id_pe : $("#id_pe").val()}, 
            success: function(response){  
                
                console.log(response);
                $("#restahap").html(response);
            } 
        });
   

       }

       function GantiTahap(){
        var isi = $("#id_tahapx").val();
        //console.log(isi);
        $("#tahap").val(isi);

       }

      function Calculate(){
        var isitotrev = $("input[name='ext_rev[]']").val();
        var idx = 0;
        var rev = $("input[name='jml_rev[]']");
        var revs = $("input[name='jml_ent[]']");
        var revx = $("input[name='jml_ext[]']");
        var revz = $("input[name='jml_tot[]']");
        var revk = $("input[name='kpt[]']");
        var egs = parseInt($("input[name='ent_gto_single[]']").val());
        var egm = $("input[name='ent_gto_multi[]']").val();
        var etg = $("input[name='ent_reg[]']").val();


        var jml_entx = parseInt(egs) + parseInt(egm) + parseInt(etg);

        $('input[name="ext_rev[]"]').each(function(){
            rev.eq(idx).val(this.value);
            
            revs.eq(idx).val(parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ent_gto_multi[]']").eq(idx).val()) + parseInt($("input[name='ent_reg[]']").eq(idx).val()));
            
            revx.eq(idx).val(parseInt($("input[name='ext_gto_multi[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) );
            
            //revk.eq(idx).val(Math.ceil(parseInt($("input[name='ent_gto_multi[]']").eq(idx).val()) / 2 ) + Math.ceil(parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi[]']").eq(idx).val()) / 3 ));
            revk.eq(idx).val( (Math.ceil((parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi[]']").eq(idx).val()))/3) + Math.ceil(parseInt($("input[name='ent_gto_multi[]']").eq(idx).val()) / 2 )) * 5 );
            //revk.eq(idx).val( (Math.ceil((parseInt($("input[name='ent_gto_multi[]']").eq(idx).val())) / 2) + Math.ceil( (parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi[]']").eq(idx).val() )))) * 5  );
            
            revz.eq(idx).val(parseInt($("input[name='jml_ent[]']").eq(idx).val()) + parseInt($("input[name='jml_ext[]']").eq(idx).val()) + parseInt($("input[name='jml_rev[]']").eq(idx).val()) );
            idx++;
 
        });
       

       }

       function Calculate_Update(){
        var isitotrev = $("input[name='ext_rev_update[]']").val();
        var idx = 0;
        var rev = $("input[name='jml_rev_update[]']");
        var revs = $("input[name='jml_ent_update[]']");
        var revx = $("input[name='jml_ext_update[]']");
        var revz = $("input[name='jml_tot_update[]']");
        var revk = $("input[name='kpt_update[]']");
        var egs = parseInt($("input[name='ent_gto_single_update[]']").val());
        var egm = $("input[name='ent_gto_multi_update[]']").val();
        var etg = $("input[name='ent_reg_update[]']").val();


        var jml_entx = parseInt(egs) + parseInt(egm) + parseInt(etg);

        $('input[name="ext_rev_update[]"]').each(function(){
            rev.eq(idx).val(this.value);
            
            revs.eq(idx).val(parseInt($("input[name='ent_gto_single_update[]']").eq(idx).val()) + parseInt($("input[name='ent_gto_multi_update[]']").eq(idx).val()) + parseInt($("input[name='ent_reg_update[]']").eq(idx).val()));
            
            revx.eq(idx).val(parseInt($("input[name='ext_gto_multi_update[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single_update[]']").eq(idx).val()) );
            
            //revk.eq(idx).val(Math.ceil(parseInt($("input[name='ent_gto_multi[]']").eq(idx).val()) / 2 ) + Math.ceil(parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi[]']").eq(idx).val()) / 3 ));
            revk.eq(idx).val( (Math.ceil((parseInt($("input[name='ent_gto_single_update[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single_update[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi_update[]']").eq(idx).val()))/3) + Math.ceil(parseInt($("input[name='ent_gto_multi_update[]']").eq(idx).val()) / 2 )) * 5 );
            //revk.eq(idx).val( (Math.ceil((parseInt($("input[name='ent_gto_multi[]']").eq(idx).val())) / 2) + Math.ceil( (parseInt($("input[name='ent_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_single[]']").eq(idx).val()) + parseInt($("input[name='ext_gto_multi[]']").eq(idx).val() )))) * 5  );
            
            revz.eq(idx).val(parseInt($("input[name='jml_ent_update[]']").eq(idx).val()) + parseInt($("input[name='jml_ext_update[]']").eq(idx).val()) + parseInt($("input[name='jml_rev_update[]']").eq(idx).val()) );
            idx++;
 
        });
       

       }


 // forceNumeric() plug-in implementation
 jQuery.fn.forceNumeric = function () {
     return this.each(function () {
         $(this).keydown(function (e) {
             var key = e.which || e.keyCode;

             if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
             // numbers   
                 key >= 48 && key <= 57 ||
             // Numeric keypad
                 key >= 96 && key <= 105 ||
             // comma, period and minus, . on keypad
                key == 190 || key == 188 || key == 109 || key == 110 ||
             // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
             // Home and End
                key == 35 || key == 36 ||
             // left and right arrows
                key == 37 || key == 39 ||
             // Del and Ins
                key == 46 || key == 45)
                 return true;

             return false;
         });
     });
 }

       $(document).ready(function() {
        
         $(document).delegate('a.add-record', 'click', function(e) {
     e.preventDefault();    
     var content = $('#sample_table tr'),
     size = $('#tbl_posts >tbody >tr').length + 1,
     element = null,    
     element = content.clone();
     element.attr('id', 'rec-'+size);
     element.find('.delete-record').attr('data-id', size);
     element.appendTo('#tbl_posts_body');
     element.find('.sn').html(size);
   });
    $(document).delegate('a.delete-record', 'click', function(e) {
     e.preventDefault();    
     var didConfirm = confirm("kamu mau hapus field ini?");
     if (didConfirm == true) {
      var id = $(this).attr('data-id');
      var targetDiv = $(this).attr('targetDiv');
      $('#rec-' + id).remove();
      
    //regnerate index number on table
    $('#tbl_posts_body tr').each(function(index){
        $(this).find('span.sn').html(index+1);
    });
    return true;
  } else {
    return false;
  }
});


		$.fn.dataTable.ext.errMode = 'none';
        
        $("#ent_gto_single").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});
		 
        $('#examples').DataTable({
           "ajax": "<?php echo base_url(); ?>gardu/list_store_gardu" 
        });

	    var t = $('#example').DataTable();
        var counter = 1;
 
 
   
        $('#addRow').on( 'click', function () {
            t.row.add( [ 
                '<a class="btn btn-xs delete-record" data-id="1"><i class="glyphicon glyphicon-trash"></i></a>',
                '<input type="text" class="form-control" name="nama_gt[]"  id="nama_gt">',
                '<input type="text" class="form-control"name="jml_ent[]" value="0" id="jml_ent" readonly="readonly"   >',
                '<input type="text" class="form-control"  name="jml_ext[]" value="0" id="jml_ext" readonly="readonly">',
                '<input type="text" class="form-control" name="jml_rev[]" value="0" id="jml_rev" readonly="readonly">',
                '<input type="text" class="form-control" name="jml_tot[]" value="0" id="jml_tot" readonly="readonly">',
                '<input type="text" class="form-control" name="ent_gto_single[]" value="0" id="ent_gto_single">',
                '<input type="text" class="form-control" name="ent_gto_multi[]" value="0" id="ent_gto_multi">',
                '<input type="text" class="form-control" name="ent_reg[]" value="0" id="ent_reg">',
                '<input type="text" class="form-control" name="ext_gto_multi[]" value="0" id="ext_gto_multi">',
                '<input type="text" class="form-control" name="ext_gto_single[]" value="0" id="ext_gto_single">',
                '<input type="text" class="form-control" name="ext_rev[]" value="0" id="ext_rev">',
                '<input type="text" class="form-control" name="kpt[]" value="0" id="kpt" readonly="readonly">',
                '<input type="text" class="form-control" name="kspt[]" value="0" id="kspt">',
                '<input type="text" class="form-control" name="ktugt[]" value="0"  id="ktugt">',
                '<input type="text" class="form-control" name="jops[]" value="0" id="jops">'
            ] ).draw( false );
     
            counter++;
        } );

  
    		 
	  });
  
		
		 
    </script>