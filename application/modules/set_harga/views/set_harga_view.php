 
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                 
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <form method="post" id="user_form" enctype="multipart/form-data"> 
                        <div class="header">

                            <h2>
                                Set Harga
                            </h2>
                            <br>
                     
                             
                             
                            <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <td> Kelompok Harsat </td>
                                        <td> : </td>
                                        <td> 
                                             
                                            <select name="id_kel_harsat" id="id_kel_harsat" class="form-control">
                                                <option value=""> --Pilih Harsat </option>
                                                <?php

                                                foreach ($list_kelharsat as $key => $value) {
                                                      echo '<option value="'.$value->id.'">  '.$value->nama_harga.' </option>';
                                                }
                                                ?>
                                            </select> 
                                        </td>
                                    </tr>
                                  
                                </table>
                           
                          
                          
                        
                                 
                        </div>
                        <div class="body">
                                
                         
                                <table id="example" class="table table-bordered table-striped table-hover js-basic-example">
                            <thead>
                            <tr>
                                        <td> No </td>
                                        <td> Nama Harga </td>
                                        <td> Harga </td>
                                        <td> Jenis Layanan </td>
                                        <td> Komponen Biaya</td>
                                    </tr>
                                </thead>
                                </table>
                                <br>
                                   

                       

                            <br>
                             <table>
                                    <tr>
                                        <td>  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan Data</button> &nbsp; </td>
                                        <td> &nbsp;  </td>
                                    </tr>
                                </table>
                                      </form>
                            <hr>
                            <br>
                    <hr>
                      
                    </div>
                   
                        </div>
                   
                     
                    

                </div>
            </div>
         


        </div>
    </section>


 <div class="modal fade" id="load_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                             
                        </div>
                        <div class="modal-body">
                              <div align="center">
                                      <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                    </div>
                                    <br>
                                    <h3 align="center"> Mohon tunggu, data sedang di upload ... </h3>
                       </div>
                     
                    </div>
                </div>
    </div>
 
   <script type="text/javascript">
	 function Detail(id){
        $("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_kel_harsat").val(id_kel_harsat);
        

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('set_harga/list_detail_harga'); ?>",
                "data":{id},
                "type":"POST",
                 dataSrc : '',

            }, 

            "columns" : [ 
            {
                "data" : "no"
            },
            {
                "data" : "nama_pricelist"
            },
            {
                "data" : "harga"
            },
            {
                "data" : "nama_pelayanan"
            },
            {
                "data" : "nama_komp_biaya"
            } ],

            "rowReorder": {
                "update": false
            },
             "order": [[ 0, 'asc' ]],
            'rowsGroup': [3,4],

     
            
        });
    
 
    } 
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>set_harga/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 
                 $("#nama_set_harga").val(result.nama_set_harga);
              
                  
			 }
		 });
	 }
 
	 function Bersihkan_Form(){
        $(':input').val(''); 
         
     }

	 function Hapus_Data(id){
		if(confirm('Anda yakin ingin menghapus data ini?'))
        {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('set_harga/hapus_data_harga')?>/"+id,
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
        var id_kel_harsat = $("#id_kel_harsat").val();
        
        if(confirm('Anda yakin ingin menyimpan data ini? pastikan harga sudah anda inputkan dengan benar!')){

         if(id_kel_harsat == ''){
            alert('Anda belum memilih kelompok harsat!');
         }else{
            $("#load_modal").modal({backdrop: 'static', keyboard: false,show:true});
            $.ajax({
             url:"<?php echo base_url(); ?>set_harga/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
              
             success:function(result){ 
             //console.log(result); 
            $('#example').DataTable().ajax.reload(); 
            //$('#examples').DataTable().ajax.reload(); 
             if(result == "1"){
                    $('#load_modal').modal('hide');
                    $.notify("Data berhasil ditambahkan!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                    },{
                    type: 'success'
                    });
                   
                  
                     
    
                    $("#id_kel_harsat").val('');
                    
                return true;
             }else{
                 $.notify("Data gagal ditambahkan, anda sudah pernah mengisi data ini sebelumnya!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    }  
                 },{
                    type: 'danger'
                    });
             
      
                     $("#id_kel_harsat").val('');
                
                    
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
     
    
 

 
    
          

       $(document).ready(function() {
		  $("#load_modal").hide();
		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});


  
        $('#example').DataTable({
           "ajax": "<?php echo base_url(); ?>set_harga/fetch_pricelist" ,
          
            "order": [[ 0, 'asc' ]],
            'rowsGroup': [3,4],
            "displayLength": 500,
            
        } );

        $('#examples').DataTable({
           "ajax": "<?php echo base_url(); ?>set_harga/fetch_pricelistx" ,
          
           
            "displayLength": 10,
            
        } );
     
     
         
  
    		 
	  });
  
		
		 
    </script>