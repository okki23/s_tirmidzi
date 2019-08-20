 
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
                                Material
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>
 
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
  
									<thead>
										<tr> 
											<th style="width:5%;">Nomor Material</th>
                                            <th style="width:5%;">Nama Material</th>
                                            <th style="width:5%;">Satuan</th>  
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
                                   

									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="no_material" id="no_material" class="form-control" placeholder="Nomor Material" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_material" id="nama_material" class="form-control" placeholder="Nama Material" />
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_satuan" id="nama_satuan" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_satuan" id="id_satuan" readonly="readonly" >
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariSatuan();" class="btn btn-primary"> Pilih Satuan... </button>
                                                </span>
                                    </div>

                                                         
                                    
 

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari satuan -->
    <div class="modal fade" id="CariSatuanModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Satuan</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_satuan" >
  
                                    <thead>
                                        <tr>   
                                            <th style="width:98%;">Satuan </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_satuanx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

 
     <!-- modal detail -->
     <div class="modal fade" id="DetailModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Detail</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>
                                <br>
                                <hr>
                                <table class="table table-bordered table-hovered">
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td><div id="nipdtl"> </div></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td><div id="namadtl"> </div></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><div id="alamatdtl"> </div></td>
                                </tr>
                                <tr>
                                    <td>Telp</td>
                                    <td>:</td>
                                    <td><div id="telpdtl"> </div></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><div id="emaildtl"> </div></td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td><div id="jabatandtl"> </div></td>
                                </tr>
                                
                                </table>
                                 
                       </div>
                     
                    </div>
                </div>
    </div>

 
 
   <script type="text/javascript"> 

     
    $('#daftar_satuan').DataTable( {
            "ajax": "<?php echo base_url(); ?>satuan/fetch_satuan"           
    });
 
    function CariSatuan(){
        $("#CariSatuanModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 

    function Detail(id){
        $("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});
 
		$.ajax({
			 url:"<?php echo base_url(); ?>material/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 //$("#DetailModal").modal('show'); 
				 $("#nipdtl").html(result.nip);
                 $("#namadtl").html(result.nama);
                 $("#alamatdtl").html(result.alamat);
                 $("#telpdtl").html(result.telp);
                 $("#emaildtl").html(result.email);  
                 $("#jabatandtl").html(result.nama_jabatan);  
                  
			 }
		 });
    } 
   
        
        var daftar_satuan = $('#daftar_satuan').DataTable();
     
        $('#daftar_satuan tbody').on('click', 'tr', function () {
            
            var content = daftar_satuan.row(this).data()
            console.log(content);
            $("#nama_satuan").val(content[0]);
            $("#id_satuan").val(content[2]);
            $("#CariSatuanModal").modal('hide');
        } );

   
 
       
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>material/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#no_material").val(result.no_material);
                 $("#nama_material").val(result.nama_material);
                 $("#nama_satuan").val(result.nama_satuan);
                 $("#id_satuan").val(result.id_satuan); 
                  
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
            url : "<?php echo base_url('material/hapus_data')?>/"+id,
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
 
                 //transaksi dibelakang layar
                 $.ajax({
                 url:"<?php echo base_url(); ?>material/simpan_data",
                 type:"POST",
                 data:formData,
                 contentType:false,  
                 processData:false,   
                 success:function(result){ 
                    
                     $("#defaultModal").modal('hide');
                     $('#example').DataTable().ajax.reload(); 
                     $('#user_form')[0].reset();
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
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		}); 
  
		$('#example').DataTable({
             
			"ajax": "<?php echo base_url(); ?>material/fetch_material",

		});


	  
		 
	  });
  
		
		 
    </script>