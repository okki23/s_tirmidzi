 
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
                                Waktu Transaksi
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
									<thead>
										<tr>
											<th style="width:2%;">No</th>
                                            <th style="width:3%;">Jenis Gardu</th>  
											<th style="width:3%;">Waktu Transaksi</th>  
											<th style="width:5%;">Periode Start</th> 
											<th style="width:5%;">Periode End</th> 
											<th style="width:10%;">Opsi</th> 
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


   
	<!-- form tambah dan ubah data -->
	<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Form Tambah Data</h4>
                        </div>
                        <div class="modal-body">
                              <form method="post" id="user_form" enctype="multipart/form-data">   
                                
                                    <input type="hidden" name="id" id="id"> 
									 <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="jenis_gardu" id="jenis_gardu" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_jenis_gardu" id="id_jenis_gardu" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariJenisGardu();" class="btn btn-primary"> Pilih Jenis Gardu... </button>
                                                </span>
                                    </div>
									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="waktu_transaksi" id="waktu_transaksi" class="form-control" placeholder="Waktu Transaksi" />
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="periode_start" id="periode_start"  class="form-control datepicker" placeholder="Periode" />
                                        </div>
                                    </div> 

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari jenis gardu -->
    <div class="modal fade" id="CariJenisGarduModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Jenis Gardu</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_jenis_gardu" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:55%;">Jenis Gardu</th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_jenis_gardux">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

	 
   <script type="text/javascript">
	  $('#daftar_jenis_gardu').DataTable( {
            "ajax": "<?php echo base_url(); ?>waktu_transaksi/fetch_jenis_gardu" 
        });
     
    function CariJenisGardu(){
        $("#CariJenisGarduModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 

    var daftar_jenis_gardu = $('#daftar_jenis_gardu').DataTable();
     
        $('#daftar_jenis_gardu tbody').on('click', 'tr', function () {
            
            var content = daftar_jenis_gardu.row(this).data()
            console.log(content);
            $("#jenis_gardu").val(content[0]);
            $("#id_jenis_gardu").val(content[1]);
            $("#CariJenisGarduModal").modal('hide');
        } );

      
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>waktu_transaksi/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                
				         $("#defaultModal").modal('show'); 
				         $("#id").val(result.id);
                 $("#jenis_gardu").val(result.jenis_gardu);
                 $("#id_jenis_gardu").val(result.id_jenis_gardu);
                 $("#periode_start").val(result.periode_start);
                 $("#waktu_transaksi").val(result.waktu_transaksi);
				 
                  
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
            url : "<?php echo base_url('waktu_transaksi/hapus_data')?>/"+id,
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
	 
		 var formData = new FormData($('#user_form')[0]); 
 
  
         var id_jenis_gardu = $("#id_jenis_gardu").val();
         var waktu_transaksi = $("#waktu_transaksi").val();
         var periode_start = $("#periode_start").val();
		  
            $.ajax({
             url:"<?php echo base_url(); ?>waktu_transaksi/simpan_data",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                
                 $("#defaultModal").modal('hide');
                 $('#example').DataTable().ajax.reload(); 
                 $('#user_form')[0].reset();
                
                 $.notify("Data berhasil disimpan!", {
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                 } 
                 } );
             }
            });  
	}
     

	 $('.datepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false
     });

	 
       $(document).ready(function() {
		   
		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});
		 
		
		$('#example').DataTable( {
			"ajax": "<?php echo base_url(); ?>waktu_transaksi/fetch_waktu_transaksi" 
		});
	 
	 
		 
	  });
  
		
		 
    </script>