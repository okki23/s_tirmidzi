 
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
                                Pricelist
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
											<th style="width:5%;">Jenis Pelayanan</th>
                                            <th style="width:5%;">Komp Pembiayaan</th>
                                            <th style="width:5%;">Pricelist</th> 
                                            <th style="width:5%;">Satuan</th> 							 
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
                                                    <input type="text" name="nama_pelayanan" id="nama_pelayanan" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_pelayanan" id="id_pelayanan" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariPelayanan();" class="btn btn-primary"> Pilih Pelayanan... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_komp_biaya" id="nama_komp_biaya" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_komp_biaya" id="id_komp_biaya" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariKompBiaya();" class="btn btn-primary"> Pilih Komponen Biaya... </button>
                                                </span>
                                    </div>

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_satuan" id="nama_satuan" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_satuan" id="id_satuan" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariSatuan();" class="btn btn-primary"> Pilih Satuan... </button>
                                                </span>
                                    </div>


                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_pricelist_parent" id="nama_pricelist_parent" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_parent_pricelist" id="id_parent_pricelist" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariParents();" class="btn btn-primary"> Pilih Parent... </button>
                                                </span>
                                    </div>

                                      <div class="form-group">
                                    <label> Tipe </label>
                                    <br>
                                    <input type="hidden" name="tipe" id="tipe">

                                    <button type="button" id="calculatedbtn" class="btn btn-default waves-effect "> Calculated </button>

                                    <button type="button" id="manualbtn" class="btn btn-default waves-effect "> Manual </button>
                                    
                                </div>

									<div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_pricelist" id="nama_pricelist" class="form-control" placeholder="Nama pricelist" />
                                        </div>
                                    </div>
									 

								   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
							 </form>
					   </div>
                     
                    </div>
                </div>
    </div>


    <!-- modal cari pelayanan -->
    <div class="modal fade" id="CariPelayananModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Pelayanan</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_pelayanan" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Nama Pelayanan </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_pelayananx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

    <!-- modal cari komp biaya -->
    <div class="modal fade" id="CariKompBiayaModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Komponen Biaya</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_komp_biaya" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:15%;">Nama Komponen Biaya</th> 
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
                                            <th style="width:98%;">Nama Satuan </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_satuanx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

     <!-- modal cari parent  -->
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

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="tabel_parent" > 
                                    <thead>
                                        <tr>  
                                            <th style="width:5%;">Jenis Pelayanan</th>
                                            <th style="width:5%;">Komp. Biaya</th> 
                                            <th style="width:5%;">Pricelist</th>
                                            <th style="width:5%;">Satuan</th>
                                            <th style="width:5%;">Action</th> 
                                         </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>  
                                </table>  
                       </div>
                     
                    </div>
                </div>
    </div>

 
 
<style type="text/css">
    td.details-control {
    background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('https://raw.githubusercontent.com/DataTables/DataTables/1.10.7/examples/resources/details_close.png') no-repeat center center;
}
</style>
   <script type="text/javascript">
	 $("#calculatedbtn").on("click",function(){
        $("#tipe").val('calculated');
        $(this).attr('class','btn btn-primary');
        $("#manualbtn").attr('class','btn btn-default');

    });

    $("#manualbtn").on("click",function(){
        $("#tipe").val('manual');
       $(this).attr('class','btn btn-primary');
        $("#calculatedbtn").attr('class','btn btn-default');

         
    });

    $('#daftar_pelayanan').DataTable( {
            "ajax": "<?php echo base_url(); ?>pricelist/fetch_pelayanan"           
    });

    $('#daftar_komp_biaya').DataTable( {
            "ajax": "<?php echo base_url(); ?>pricelist/fetch_komp_biaya"           
    });

    $('#daftar_satuan').DataTable( {
            "ajax": "<?php echo base_url(); ?>pricelist/fetch_satuan"           
    });

    $('#daftar_pricelist_parent').DataTable( {
            "ajax": "<?php echo base_url(); ?>pricelist/fetch_pricelist_parent"           
    });

    function CariParents(){
        var id = $("#id").val();
        var id_pelayanan  = $("#id_pelayanan").val();
        var id_komp_biaya = $("#id_komp_biaya").val();
        $("#CariParentModal").modal({backdrop: 'static', keyboard: false,show:true});

        $('#tabel_parent').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('pricelist/fetch_nama_parent'); ?>",
                "data":{id:id,id_pelayanan:id_pelayanan,id_komp_biaya:id_komp_biaya},
                "type":"POST",
                dataSrc : '',

            },
 

            "columns" : [
            {
                "data" : "jenis_pelayanan"
            },
            {
                "data" : "komp_biaya"
            },
            {
                "data" : "nama_pricelist"
            },
            {
                "data" : "nama_satuan"
            },
            {
                "data" : "action"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,
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

     
    function CariPelayanan(){
        $("#CariPelayananModal").modal({backdrop: 'static', keyboard: false,show:true});
        $("#id_komp_biaya").val('');
        $("#nama_komp_biaya").val('');
        $("#id_parent_pricelist").val('');
        $("#nama_pricelist_parent").val('');
    } 
   
        
        var daftar_pelayanan = $('#daftar_pelayanan').DataTable();
     
        $('#daftar_pelayanan tbody').on('click', 'tr', function () {
            
            var content = daftar_pelayanan.row(this).data()
            console.log(content);
            $("#nama_pelayanan").val(content[0]);
            $("#id_pelayanan").val(content[1]);
            $("#CariPelayananModal").modal('hide');
        } );


    function CariKompBiaya(){
        $("#CariKompBiayaModal").modal({backdrop: 'static', keyboard: false,show:true});
        var id_pelayanan = $("#id_pelayanan").val();

        $("#id_parent_pricelist").val('');
        $("#nama_pricelist_parent").val('');

        $('#tabel_komp_biaya').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('pricelist/fetch_nama_komp_biaya'); ?>",
                "data":{id_pelayanan},
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

 


    function GetDataKompBiaya(id){
        console.log(id);
        $.get("<?php echo base_url('pricelist/fetch_nama_komp_biaya_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_komp_biaya").val(id);
            $("#nama_komp_biaya").val(parse.nama_komp_biaya);
            $("#CariKompBiayaModal").modal('hide');
        });

    }

    function GetParentsVal(id){
        console.log(id);
        $.get("<?php echo base_url('pricelist/fetch_nama_parents_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_parent_pricelist").val(id);
            $("#nama_pricelist_parent").val(parse.nama_pricelist);
            $("#CariParentModal").modal('hide');
        });

    }

   
   
        
      
    function CariSatuan(){
        $("#CariSatuanModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_satuan = $('#daftar_satuan').DataTable();
     
        $('#daftar_satuan tbody').on('click', 'tr', function () {
            
            var content = daftar_satuan.row(this).data()
            console.log(content);
            $("#nama_satuan").val(content[0]);
            $("#id_satuan").val(content[1]);
            $("#CariSatuanModal").modal('hide');
        } );

    //  function CariParent(){
    //     $("#CariParentModal").modal({backdrop: 'static', keyboard: false,show:true});
    //     $('#daftar_pricelist_parent').DataTable().ajax.reload(); 
 
    // } 
   
        
    //     var daftar_pricelist_parent = $('#daftar_pricelist_parent').DataTable();
     
    //     $('#daftar_pricelist_parent tbody').on('click', 'tr', function () {
            
    //         var content = daftar_pricelist_parent.row(this).data()
    //         console.log(content);
    //         $("#nama_pricelist_parent").val(content[0]);
    //         $("#id_parent_pricelist").val(content[4]);
    //         $("#CariParentModal").modal('hide');
    //     } );

       
 
       
	 function Ubah_Data(id){
		$("#defaultModalLabel").html("Form Ubah Data");
		$("#defaultModal").modal('show');
 
		$.ajax({
			 url:"<?php echo base_url(); ?>pricelist/get_data_edit/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){ 
                  
				 $("#defaultModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#id_pelayanan").val(result.id_pelayanan);                 
                 $("#id_satuan").val(result.id_satuan);
                 $("#id_komp_biaya").val(result.id_komp_biaya);
                 $("#id_parent_pricelist").val(result.id_parent_pricelist);
                 $("#nama_pelayanan").val(result.nama_pelayanan);                 
                 $("#nama_satuan").val(result.nama_satuan);
                 $("#nama_komp_biaya").val(result.nama_komp_biaya);
                 $("#nama_pricelist").val(result.nama_pricelist);
                 $("#nama_pricelist_parent").val(result.nama_pricelist_parent);
                 if(result.tipe == 'calculated'){
                    $("#calculatedbtn").attr('class','btn btn-primary');
                    $("#manualbtn").attr('class','btn btn-default');
                 }else{
                    $("#calculatedbtn").attr('class','btn btn-default');
                    $("#manualbtn").attr('class','btn btn-primary');
                 }
                 $("#tipe").val(result.tipe);
                  
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
            url : "<?php echo base_url('pricelist/hapus_data')?>/"+id,
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

           
         var nama_pricelist = $("#nama_pricelist").val();
          var id_satuan = $("#id_satuan").val();
       
        if(id_satuan == ''){
            alert("Satuan Belum anda masukkan!");
            $("#id_satuan").parents('.form-line').addClass('focused error');
            $("#id_satuan").focus();
        }else{

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>pricelist/simpan_data",
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
           

          
         

	}
      
 
var g_dataFull = [];

/* Formatting function for row details - modify as you need */
function format ( d ) {
    var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%">';
      
    var dataChild = [];
    var hasChildren = false;
    $.each(g_dataFull, function(){
       if(this.id_parent_pricelist === d.id){
          html += 
            '<tr><td>' + $('<div>').text(this.nama_pelayanan).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_komp_biaya).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_pricelist).html() +'</td>' + 
            '<td>' +  $('<div>').text(this.nama_satuan).html() + '</td>'+
            '<td>' +  $('<div>').text(this.action).html() + '</td></tr>';

         
          hasChildren = true;
       }
    });
  
    if(!hasChildren){
        html += '<tr><td>There are no items in this view.</td></tr>';
     
    }
  
 
    html += '</table>';
    return html;
}
 

       $(document).ready(function() {
		   
		$("#addmodal").on("click",function(){
			$("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
            $("#method").val('Add');
            $("#defaultModalLabel").html("Form Tambah Data");
		});
		 
      
		
	 $('#example').DataTable( {
            "ajax": "<?php echo base_url(); ?>pricelist/fetch_pricelist" 
               
        });
 
      
		 
	  });
  
		
		 
    </script>