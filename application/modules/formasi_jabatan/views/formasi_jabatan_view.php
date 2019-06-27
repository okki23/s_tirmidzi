 
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
                                Formasi Jabatan
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>

                            &nbsp;

                          <!--   <a href="<?php echo base_url('formasi_jabatan/cetak_report'); ?>" target="_blank" class="btn btn-primary waves-effect">  <i class="material-icons">local_printshop</i>  Cetak Data Formasi Jabatan </a> -->
 
                        </div>
                        <div class="body">
                                
                            <div class="table-responsive">
							   <table class="table table-bordered table-striped table-hover js-basic-example" id="example" >
  
									<thead>
										<tr>
											<th style="width:5%;">No</th>
                                            
											<th style="width:5%;">Direktorat</th>
                                            <th style="width:5%;">Divisi</th> 
                                            <th style="width:5%;">Departemen</th>
                                            <th style="width:5%;">Seksi</th>
                                            <th style="width:5%;">Kls Jabatan</th> 
                                            <th style="width:5%;">Kel Jabatan</th>
                                            <th style="width:5%;">Nama Jabatan</th>
                                            <th style="width:5%;">NPP</th>
                                            <th style="width:5%;">Nama</th>
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
                                    <input type="hidden" name="valsep" id="valsep"> 
                                    <!-- hidden -->
									<div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_direktorat" id="nama_direktorat" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_direktorat" id="id_direktorat" readonly="readonly" >
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariDirektorat();" class="btn btn-primary"> Pilih Direktorat... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_divisi" id="nama_divisi" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_divisi" id="id_divisi" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariDivisi();" class="btn btn-primary"> Pilih Divisi... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_departemen" id="nama_departemen" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_departemen" id="id_departemen" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariDepartemen();" class="btn btn-primary"> Pilih Departemen... </button>
                                                </span>
                                    </div>
                                
                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_seksi" id="nama_seksi" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_seksi" id="id_seksi" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariSeksi();" class="btn btn-primary"> Pilih Seksi... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_parent" id="nama_parent" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_parent" id="id_parent" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariParent();" class="btn btn-primary"> Pilih Parent... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_kelompok_jabatan" id="nama_kelompok_jabatan" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_kelompok_jabatan" id="id_kelompok_jabatan" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariKelompokJabatan();" class="btn btn-primary"> Pilih Kelompok Jabatan... </button>
                                                </span>
                                    </div>

									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" placeholder="Nama Jabatan" />
                                        </div>
                                    </div>


                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="npp" id="npp" class="form-control" readonly="readonly" >
                                                    <input type="hidden" name="id_karyawan" id="id_karyawan" readonly="readonly">
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariNpp();" class="btn btn-primary"> Pilih NPP... </button>
                                                </span>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Nama Karyawan" readonly="readonly" />
                                        </div>
                                    </div>
                                     
									 

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari direktorat -->
    <div class="modal fade" id="CariDirektoratModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Direktorat</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_direktorat" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Direktorat </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_direktoratx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari divisi -->
    <div class="modal fade" id="CariDivisiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Divisi</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_divisi" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:15%;">Nama Divisi</th> 
                                            <th style="width:15%;">Action</th> 
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>

    <!-- modal cari departemen -->
    <div class="modal fade" id="CariDepartemenModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Departemen</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_departemen" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:15%;">Nama Departemen</th> 
                                            <th style="width:15%;">Action</th> 
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>

    <!-- modal cari seksi -->
    <div class="modal fade" id="CariSeksiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Seksi</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_seksi" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:15%;">Nama Seksi</th> 
                                            <th style="width:15%;">Action</th> 
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari parent seksi -->
    <div class="modal fade" id="CariParentModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Parent</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_parent" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:15%;">Jabatan</th>
                                            <th style="width:15%;">Nama</th>
                                      
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>

    <!-- modal cari kel jabatan -->
    <div class="modal fade" id="CariKelompokJabatanModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Kelompok Jabatan</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_kelompok_jabatan" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Kelompok Jabatan </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_kelompok_jabatanx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari npp -->
    <div class="modal fade" id="CariNppModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari NPP Karyawan </h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_npp" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:50%;">NPP </th> 
                                            <th style="width:50%;">Nama Karyawan</th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_kelompok_jabatanx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>
			
 
   <script type="text/javascript">
	
    function GetDataSeksi(id){
        console.log(id);
        $.get("<?php echo base_url('formasi_jabatan/fetch_nama_seksi_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_seksi").val(id);
            $("#nama_seksi").val(parse.nama_seksi);
            $("#CariSeksiModal").modal('hide');
        });

    }

 
    function CariSeksi(){
        $("#CariSeksiModal").modal({backdrop: 'static', keyboard: false,show:true});

        var id_departemen = $("#id_departemen").val();
        
        $('#tabel_seksi').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('formasi_jabatan/fetch_nama_seksi'); ?>",
                "data":{id_departemen},
                "type":"POST",
                 dataSrc : '',

            },
 

            "columns" : [ {
                "data" : "nama"
            },{
                "data" : "action"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,
        });
    
 
    } 


     // cari direktorat
    $('#daftar_parent').DataTable( {
            "ajax": "<?php echo base_url(); ?>formasi_jabatan/fetch_parent"           
    });

     
     
    function CariParent(){
        $('#daftar_parent').DataTable().ajax.reload(); 
        $("#CariParentModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_parent = $('#daftar_parent').DataTable();
     
        $('#daftar_parent tbody').on('click', 'tr', function () {
            
            var content = daftar_parent.row(this).data()
            console.log(content);
            $("#nama_parent").val(content[0]);
            $("#id_parent").val(content[2]);
            $("#CariParentModal").modal('hide');
        } );

    
    function GetDataDepartemen(id){
        console.log(id);
        $.get("<?php echo base_url('formasi_jabatan/fetch_nama_departemen_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_departemen").val(id);
            $("#nama_departemen").val(parse.nama_departemen);
            $("#CariDepartemenModal").modal('hide');
        });

    }

 
    function CariDepartemen(){
        $("#CariDepartemenModal").modal({backdrop: 'static', keyboard: false,show:true});

        var id_divisi = $("#id_divisi").val();
        
        $('#tabel_departemen').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('formasi_jabatan/fetch_nama_departemen'); ?>",
                "data":{id_divisi},
                "type":"POST",
                dataSrc : '',

            },
 

            "columns" : [ {
                "data" : "nama"
            },{
                "data" : "action"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,
        });
    
 
    } 

   
    function GetDataDivisi(id){
        console.log(id);
        $.get("<?php echo base_url('formasi_jabatan/fetch_nama_divisi_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_divisi").val(id);
            $("#nama_divisi").val(parse.nama_divisi);
            $("#CariDivisiModal").modal('hide');
        });

    }

 
    function CariDivisi(){
        $("#CariDivisiModal").modal({backdrop: 'static', keyboard: false,show:true});

         var id_direktorat = $("#id_direktorat").val();
        
        $('#tabel_divisi').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('formasi_jabatan/fetch_nama_divisi'); ?>",
                "data":{id_direktorat},
                "type":"POST",
                dataSrc : '',

            },
 

            "columns" : [ {
                "data" : "nama"
            },{
                "data" : "action"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,
        });
    
 
    } 



    // cari direktorat
    $('#daftar_direktorat').DataTable( {
            "ajax": "<?php echo base_url(); ?>formasi_jabatan/fetch_direktorat"           
    });

     
     
    function CariDirektorat(){
        $("#CariDirektoratModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_direktorat = $('#daftar_direktorat').DataTable();
     
        $('#daftar_direktorat tbody').on('click', 'tr', function () {
            
            var content = daftar_direktorat.row(this).data()
            console.log(content);
            $("#nama_direktorat").val(content[0]);
            $("#id_direktorat").val(content[1]);
            $("#CariDirektoratModal").modal('hide');
        } );


    // cari kelompok jabatan
    $('#daftar_kelompok_jabatan').DataTable( {
            "ajax": "<?php echo base_url(); ?>formasi_jabatan/fetch_kelompok_jabatan"           
    });

     
     
    function CariKelompokJabatan(){
        $("#CariKelompokJabatanModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_kelompok_jabatan = $('#daftar_kelompok_jabatan').DataTable();
     
        $('#daftar_kelompok_jabatan tbody').on('click', 'tr', function () {
            
            var content = daftar_kelompok_jabatan.row(this).data()
            console.log(content);
            $("#nama_kelompok_jabatan").val(content[0]);
            $("#id_kelompok_jabatan").val(content[1]);
            $("#CariKelompokJabatanModal").modal('hide');
        } );


    // cari npp
    $('#daftar_npp').DataTable( {
            "ajax": "<?php echo base_url(); ?>formasi_jabatan/fetch_npp"           
    });

     
     
    function CariNpp(){
        $("#CariNppModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_npp = $('#daftar_npp').DataTable();
     
        $('#daftar_npp tbody').on('click', 'tr', function () {
            
            var content = daftar_npp.row(this).data()
            console.log(content);
            $("#nama_karyawan").val(content[1]);
            $("#id_karyawan").val(content[2]);
            $("#npp").val(content[0]);
            $("#CariNppModal").modal('hide');
        } );

       
 
       
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>formasi_jabatan/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                 //$('input[name=type][value=2]').attr('checked', true); 
                 

                 if(result.is_separator == '1'){
                   $("#radio_1").attr('checked',true);
                   $("#radio_2").attr('checked',false);
                 }else{
                    $("#radio_2").attr('checked',true);
                    $("#radio_1").attr('checked',false);
                 }
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#nama_direktorat").val(result.nama_direktorat);
                 $("#id_direktorat").val(result.id_direktorat);
                 //$("#is_separator").val(result.is_separator);   
                 //$("#valsep").val(result.is_separator);                 
                 $("#nama_departemen").val(result.nama_departemen);
                 $("#id_departemen").val(result.id_departemen);
                 $("#nama_divisi").val(result.nama_divisi);
                 $("#id_divisi").val(result.id_divisi);
                 $("#nama_seksi").val(result.nama_seksi);
                 $("#id_seksi").val(result.id_seksi);
                  $("#id_parent").val(result.id_parent);
                  $("#nama_parent").val(result.nama_jabatan);
                 $("#nama_kelompok_jabatan").val(result.nama_kelompok_jabatan);
                 $("#id_kelompok_jabatan").val(result.id_kelompok_jabatan);
                 $("#nama_jabatan").val(result.nama_jabatan);

                 $("#nama_karyawan").val(result.nama_karyawan);
                 $("#npp").val(result.npp);
                 $("#id_karyawan").val(result.id_karyawan);
              
                  
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
            url : "<?php echo base_url('formasi_jabatan/hapus_data')?>/"+id,
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
                 url:"<?php echo base_url(); ?>formasi_jabatan/simpan_data",
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

        var dateObj = new Date();
        var month = dateObj.getUTCMonth() + 1; //months from 1-12
        var day = dateObj.getUTCDate();
        var year = dateObj.getUTCFullYear();
 
		 
		$('#example').append('<caption style="caption-side: top">   </caption>');
		$('#example').DataTable({
             
			"ajax": "<?php echo base_url(); ?>formasi_jabatan/fetch_formasi_jabatan",
                'filterDropDown': {                                       
                        columns: [
                            { 
                                idx: 1
                            },
                            { 
                                idx: 2
                            },
                            { 
                                idx: 3
                            } 

                        ],
                        bootstrap: true
                    },
            'rowsGroup': [3] ,
             dom: 'Bfrtip',
             buttons: [ 
                {
                extend: 'excelHtml5',
                exportOptions: {
                columns: [1,2,3,4,7,8,9]
                },
                title: 'Pemenuhan Formasi Jabatan '+day + " - " + month + " - " + year,

                //messageTop: 'Pemenuhan Formasi Jabatan '+day + "/" + month + "/" + year
                },
            //'colvis'
            ],
            "displayLength": 10,
            'order': [[ 0, 'asc' ], [ 4, 'asc' ]]
		});


	  
		 
	  });
  
		
		 
    </script>