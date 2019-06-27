 
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
                                Karyawan
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
  
									<thead>
										<tr>
											<th style="width:5%;">No</th>
                                            
											<th style="width:5%;">NPP</th>
                                            <th style="width:5%;">Nama Karyawan</th> 
                                            <th style="width:5%;">Lokasi</th>							 
											<th style="width:5%;">Opsi</th> 
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
                                    <!-- hidden -->
									<div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_lokasi" id="id_lokasi" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariLokasi();" class="btn btn-primary"> Pilih Lokasi... </button>
                                                </span>
                                    </div>

									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="npp" id="npp" class="form-control" placeholder="NPP" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Nama karyawan" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-line">
                                            Upload Foto 
                                            <input type="file" name="user_image" id="user_image" class="form-control" onchange="PreviewGambar(this);" placeholder="Foto" />  
                                        </div>
                                           <input type="hidden" name="foto" id="foto">
                                    </div>
                                    <br>
                                    <img onerror="this.onerror=null;this.src='<?php echo base_url('upload/image_prev.jpg'); ?>';" id="image1" src="<?php echo base_url('upload/image_prev.jpg');?>" style="height: 300px;" alt="..." class="img-rounded img-responsive">
                                  <br>
									 

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari ruas -->
    <div class="modal fade" id="CariLokasiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Lokasi</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_lokasi" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Lokasi </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_lokasix">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

			
 
   <script type="text/javascript">
	function PreviewGambar(input) {
        if (input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image1').attr('src', e.target.result);
                $("#foto").val($('#user_image').val().replace(/C:\\fakepath\\/i, ''));
            };
            reader.readAsDataURL(input.files[0]);
            
        }
     }
     

    $('#daftar_lokasi').DataTable( {
            "ajax": "<?php echo base_url(); ?>karyawan/fetch_lokasi"           
    });

     
     
    function CariLokasi(){
        $("#CariLokasiModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_lokasi = $('#daftar_lokasi').DataTable();
     
        $('#daftar_lokasi tbody').on('click', 'tr', function () {
            
            var content = daftar_lokasi.row(this).data()
            console.log(content);
            $("#nama_lokasi").val(content[0]);
            $("#id_lokasi").val(content[1]);
            $("#CariLokasiModal").modal('hide');
        } );

       
 
       
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>karyawan/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#npp").val(result.npp);
                 $("#id_lokasi").val(result.id_lokasi);                 
                 $("#nama_karyawan").val(result.nama_karyawan);
                 $("#nama_lokasi").val(result.nama_lokasi);
                 $('#image1').attr('src',"upload/"+result.foto);
              
                  
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
            url : "<?php echo base_url('karyawan/hapus_data')?>/"+id,
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
		//setting semua data dalam form dijadikan 1 variabel 
		 var formData = new FormData($('#user_form')[0]); 

           
         var nama_karyawan = $("#nama_karyawan").val();
         
           

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>karyawan/simpan_data",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                
                 $("#defaultModal").modal('hide');
                 $('#example').DataTable().ajax.reload(); 
                 $('#user_form')[0].reset();
                 $("#image1").attr("src","<?php echo base_url(); ?>/upload/image_prev.jpg");
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
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});
		 
		var groupColumn = 3;
        var table = $('#example').DataTable({
            "ajax": "<?php echo base_url(); ?>karyawan/fetch_karyawan",
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 10,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="5"><b>'+group+'</b></td></tr>'
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