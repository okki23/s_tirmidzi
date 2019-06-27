 
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
                                List Harga
                            </h2>
                            <br>
                     
                            <form method="post" id="user_form" enctype="multipart/form-data">  
                          <br>

                          
                        
                                 
                            
                        <div class="body">
                             
                         <table id="example" class="table table-bordered table-striped table-hover js-basic-examples">
                            <thead>
                            <tr>
                                        <td style="width: 5%;"> No </td>
                                        <td style="width: 20%;"> Nama Harga </td>
                                        <td style="width: 10%;"> Opsi </td>
                                         
                                    </tr>
                                </thead>
                                </table>
  
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
                            <h4 class="modal-title" > Detail Harga</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>
                                <input type="hidden" name="id_kel_harsat" id="id_kel_harsat">

                                 <table id="examplez" width="100%" class="table table-bordered table-striped table-hover js-basic-examplez">
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
                                 
                       </div>
                     
                    </div>
                </div>
    </div>
   
 
   <script type="text/javascript">
	 function Detail(id){
        $("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});
        
        

        $('#examplez').DataTable({
            "destroy": true,
            "processing" : true,
          
            "ajax" : {
                "url" : "<?php echo base_url('list_harga/list_detail_harga'); ?>",
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
			 url:"<?php echo base_url(); ?>list_harga/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 
                 $("#nama_list_harga").val(result.nama_list_harga);
              
                  
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
            url : "<?php echo base_url('list_harga/hapus_data')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
			   
               $('#example').DataTable().ajax.reload(); 
			   
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
             url:"<?php echo base_url(); ?>list_harga/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
             success:function(result){  
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
            url: "<?php echo base_url('list_harga/get_tahap_val'); ?>",  
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


  
        $('#example').DataTable({
           "ajax": "<?php echo base_url(); ?>list_harga/fetch_list_harga" ,
          
            "order": [[ 0, 'asc' ]],
         
            "displayLength": 10,
            
        } ); 
	  });
  
		
		 
    </script>