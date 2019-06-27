 
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
                                JMTO SDM List
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
  
									<thead>
										<tr>
										 
                                            
											<th style="width:5%;">Kategori</th>
                                            <th style="width:5%;">SDM List</th> 
                                             							 
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
                                                    <input type="text" name="cat_jlo_sdm" id="cat_jlo_sdm" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_cat_jlo_sdm" id="id_cat_jlo_sdm" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariCatSDM();" class="btn btn-primary"> Pilih Kategori... </button>
                                                </span>
                                    </div>

									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="sdm_list" id="sdm_list" class="form-control" placeholder="SDM List" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    
                                        <label> Tipe Field Kantor  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_kantor" id="tipe_field_kantor">

                                        <button type="button" id="calculatedkantorbtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualkantorbtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>
                                
                                    <div class="form-group">
                                    
                                        <label> Tipe Field GT  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_gt" id="tipe_field_gt">

                                        <button type="button" id="calculatedgtbtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualgtbtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>

                                    <div class="form-group">
                                    
                                        <label> Tipe Field HT  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_ht" id="tipe_field_ht">

                                        <button type="button" id="calculatedhtbtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualhtbtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>

                                    <div class="form-group">
                                    
                                        <label> Tipe Field Base  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_base" id="tipe_field_base">

                                        <button type="button" id="calculatedbasebtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualbasebtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>

                                    <div class="form-group">
                                    
                                        <label> Tipe Field Kendaraan Operasional  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_kops" id="tipe_field_kops">

                                        <button type="button" id="calculatedkopsbtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualkopsbtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>

                                    <div class="form-group">
                                    
                                        <label> Tipe Field Kendaraan Shuttle  </label>
                                        <br>
                                        <input type="hidden" name="tipe_field_kshuttle" id="tipe_field_kshuttle">

                                        <button type="button" id="calculatedkshuttlebtn" class="btn btn-default waves-effect "> Calculated </button>

                                        <button type="button" id="manualkshuttlebtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                    </div>
                               
                               
                               
                               
                               

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari kategori -->
    <div class="modal fade" id="CariCatSDMModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Kategori</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_kategori" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Kategori</th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_kategorix">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

			
 
   <script type="text/javascript">
    //kantor
    $("#calculatedkantorbtn").on("click",function(){
        $("#tipe_field_kantor").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualkantorbtn").attr('class','btn btn-default');

    });

    $("#manualkantorbtn").on("click",function(){
        $("#tipe_field_kantor").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedkantorbtn").attr('class','btn btn-default');

         
    });

    //gt
    $("#calculatedgtbtn").on("click",function(){
        $("#tipe_field_gt").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualgtbtn").attr('class','btn btn-default');

    });

    $("#manualgtbtn").on("click",function(){
        $("#tipe_field_gt").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedgtbtn").attr('class','btn btn-default');

         
    });

    //ht
    $("#calculatedhtbtn").on("click",function(){
        $("#tipe_field_ht").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualhtbtn").attr('class','btn btn-default');

    });

    $("#manualhtbtn").on("click",function(){
        $("#tipe_field_ht").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedhtbtn").attr('class','btn btn-default');

         
    });

     //base
    $("#calculatedbasebtn").on("click",function(){
        $("#tipe_field_base").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualbasebtn").attr('class','btn btn-default');

    });

    $("#manualbasebtn").on("click",function(){
        $("#tipe_field_base").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedbasebtn").attr('class','btn btn-default');

         
    });

     //kops
    $("#calculatedkopsbtn").on("click",function(){
        $("#tipe_field_kops").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualkopsbtn").attr('class','btn btn-default');

    });

    $("#manualkopsbtn").on("click",function(){
        $("#tipe_field_kops").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedkopsbtn").attr('class','btn btn-default');

         
    });

     //kshuttle
    $("#calculatedkshuttlebtn").on("click",function(){
        $("#tipe_field_kshuttle").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualkshuttlebtn").attr('class','btn btn-default');

    });

    $("#manualkshuttlebtn").on("click",function(){
        $("#tipe_field_kshuttle").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedkshuttlebtn").attr('class','btn btn-default');

         
    });
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
     

    $('#daftar_kategori').DataTable( {
            "ajax": "<?php echo base_url(); ?>jlo_sdm_list/fetch_kategori"           
    });

     
     
    function CariCatSDM(){
        $("#CariCatSDMModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_kategori = $('#daftar_kategori').DataTable();
     
        $('#daftar_kategori tbody').on('click', 'tr', function () {
            
            var content = daftar_kategori.row(this).data()
            console.log(content);
            $("#cat_jlo_sdm").val(content[0]);
            $("#id_cat_jlo_sdm").val(content[1]);
            $("#CariCatSDMModal").modal('hide');
        } );

       
 
       
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>jlo_sdm_list/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#id_cat_jlo_sdm").val(result.id_cat_jlo_sdm);
                 $("#cat_jlo_sdm").val(result.cat_jlo_sdm);                 
                 $("#sdm_list").val(result.sdm_list);

                 if(result.tipe_field_kantor == 'calculated'){
                    $("#calculatedkantorbtn").attr('class','btn btn-primary');
                    $("#manualkantorbtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedkantorbtn").attr('class','btn btn-default');
                    $("#manualkantorbtn").attr('class','btn btn-primary');
                 }

                 if(result.tipe_field_gt == 'calculated'){
                    $("#calculatedgtbtn").attr('class','btn btn-primary');
                    $("#manualgtbtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedgtbtn").attr('class','btn btn-default');
                    $("#manualgtbtn").attr('class','btn btn-primary');
                 }

                 if(result.tipe_field_ht == 'calculated'){
                    $("#calculatedhtbtn").attr('class','btn btn-primary');
                    $("#manualhtbtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedhtbtn").attr('class','btn btn-default');
                    $("#manualhtbtn").attr('class','btn btn-primary');
                 }

                 if(result.tipe_field_base == 'calculated'){
                    $("#calculatedbasebtn").attr('class','btn btn-primary');
                    $("#manualbasebtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedbasebtn").attr('class','btn btn-default');
                    $("#manualbasebtn").attr('class','btn btn-primary');
                 }

                 if(result.tipe_field_kops == 'calculated'){
                    $("#calculatedkopsbtn").attr('class','btn btn-primary');
                    $("#manualkopsbtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedkopsbtn").attr('class','btn btn-default');
                    $("#manualkopsbtn").attr('class','btn btn-primary');
                 }

                 if(result.tipe_field_kshuttle == 'calculated'){
                    $("#calculatedkshuttlebtn").attr('class','btn btn-primary');
                    $("#manualkshuttlebtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedkshuttlebtn").attr('class','btn btn-default');
                    $("#calculatedkshuttlebtn").attr('class','btn btn-primary');
                 }

                 $("#tipe_field_kantor").val(result.tipe_field_kantor);
                 $("#tipe_field_gt").val(result.tipe_field_gt);
                 $("#tipe_field_ht").val(result.tipe_field_ht);
                 $("#tipe_field_base").val(result.tipe_field_base);
                 $("#tipe_field_kops").val(result.tipe_field_kops);
                 $("#tipe_field_kshuttle").val(result.tipe_field_kshuttle);



                  
			 }
		 });
	 }
 
	 function Bersihkan_Form(){
        $(':input').val(''); 
        $("#calculatedkantorbtn").attr('class','btn btn-default');
        $("#manualkantorbtn").attr('class','btn btn-default');
        $("#calculatedgtbtn").attr('class','btn btn-default');
        $("#manualgtbtn").attr('class','btn btn-default');
        $("#calculatedhtbtn").attr('class','btn btn-default');
        $("#manualhtbtn").attr('class','btn btn-default');
        $("#calculatedbasebtn").attr('class','btn btn-default');
        $("#manualbasebtn").attr('class','btn btn-default');
        $("#calculatedkopsbtn").attr('class','btn btn-default');
        $("#manualkopsbtn").attr('class','btn btn-default');
        $("#calculatedkshuttlebtn").attr('class','btn btn-default');
        $("#manualkshuttlebtn").attr('class','btn btn-default');
         
     }

	 function Hapus_Data(id){
		if(confirm('Anda yakin ingin menghapus data ini?'))
        {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('jlo_sdm_list/hapus_data')?>/"+id,
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

           
         var nama_jlo_sdm_list = $("#nama_jlo_sdm_list").val();
         
           

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>jlo_sdm_list/simpan_data",
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
		 
		var groupColumn = 0;
        var table = $('#example').DataTable({
            "ajax": "<?php echo base_url(); ?>jlo_sdm_list/fetch_jlo_sdm_list",
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ 2, 'asc' ]],
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