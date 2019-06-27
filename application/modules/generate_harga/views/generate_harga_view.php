 
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
                               Generate Harga
                            </h2>
                            
                        </div>
                        <div class="body">
                                
                              <form method="post" id="user_form" enctype="multipart/form-data">   
                                 
                                    <input type="hidden" name="id" id="id">    

                                     <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_asal_harga" id="nama_asal_harga" class="form-control" required readonly="readonly" >
                                                    <input type="text" name="id_asal_harga" id="id_asal_harga" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariAsalHarga();" class="btn btn-primary"> Pilih Asal Harga... </button>
                                                </span>
                                    </div>
                                     <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="persentase_kenaikan" id="persentase_kenaikan" class="form-control" placeholder="Persentase Kenaikan" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="nama_harga" id="nama_harga" class="form-control" placeholder="Nama Harga" />
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="year" id="year" class="form-control" placeholder="Tahun" />
                                        </div>
                                    </div>

                                     <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_country" id="nama_country" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_country" id="id_country" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariCountry();" class="btn btn-primary"> Pilih Country... </button>
                                                </span>
                                    </div>
                                     

                                   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Generate</button>

                                 
                             </form>

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
                                            <input type="text" name="nama_harga" id="nama_harga" class="form-control" placeholder="Nama Harga" />
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="year" id="year" class="form-control" placeholder="Tahun" />
                                        </div>
                                    </div>

                                     <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_country" id="nama_country" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_country" id="id_country" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariCountry();" class="btn btn-primary"> Pilih Country... </button>
                                                </span>
                                    </div>
                                     

                                   <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                   <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form();" data-dismiss="modal"> <i class="material-icons">clear</i> Batal</button>
                             </form>
                       </div>
                     
                    </div>
                </div>
    </div>


  
  
 
    <!-- modal cari contry -->
    <div class="modal fade" id="CariCountryModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Country</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_country" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:98%;">Country </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_countryx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>

      <!-- modal cari asal_harga -->
    <div class="modal fade" id="CariAsalHargaModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Asal Harga</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_asal_harga" >
  
                                    <thead>
                                        <tr>  
                                            <th style="width:3%;">No </th>
                                            <th style="width:10%;">Nama Harga </th>
                                            <th style="width:10%;">Tahun </th>
                                            <th style="width:10%;">Country </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_asal_hargax">

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
    
    $('#daftar_country').DataTable( {
            "ajax": "<?php echo base_url(); ?>harga/fetch_country"           
    });

    $('#daftar_asal_harga').DataTable( {
            "ajax": "<?php echo base_url(); ?>harga/fetch_harga"           
    });
     
     
    function CariCountry(){
        $("#CariCountryModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_country = $('#daftar_country').DataTable();
     
        $('#daftar_country tbody').on('click', 'tr', function () {
            
            var content = daftar_country.row(this).data()
            console.log(content);
            $("#nama_country").val(content[0]);
            $("#id_country").val(content[1]);
            $("#CariCountryModal").modal('hide');
        } );

    function CariAsalHarga(){
        $("#CariAsalHargaModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
        
        var daftar_asal_harga = $('#daftar_asal_harga').DataTable();
     
        $('#daftar_asal_harga tbody').on('click', 'tr', function () {
            
            var content = daftar_asal_harga.row(this).data()
            console.log(content);
            $("#nama_asal_harga").val(content[1]);
            $("#id_asal_harga").val(content[5]);
            $("#CariAsalHargaModal").modal('hide');
        } );
     
    function GetParentsVal(id){
        console.log(id);
        $.get("<?php echo base_url('harga/fetch_nama_parents_row/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            $("#id_parent_harga").val(id);
            $("#nama_harga_parent").val(parse.nama_harga);
            $("#CariParentModal").modal('hide');
        });

    }

   
   
         
       
     function Ubah_Data(id){
        $("#defaultModalLabel").html("Form Ubah Data");
        $("#defaultModal").modal('show');
 
        $.ajax({
             url:"<?php echo base_url(); ?>harga/get_data_edit/"+id,
             type:"GET",
             dataType:"JSON", 
             success:function(result){ 
                  
                 $("#defaultModal").modal('show'); 
                 $("#id").val(result.id);
                 $("#id_country").val(result.id_country);                 
                 $("#nama_harga").val(result.nama_harga);
                 $("#year").val(result.year);
                 $("#nama_country").val(result.country);
                
                  
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
            url : "<?php echo base_url('harga/hapus_data')?>/"+id,
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
   

            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>generate_harga/simpan_data",
             type:"POST",
             data:$("#user_form").serialize(),
             
             success:function(result){ 
                
                 
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
           

    
 
var g_dataFull = [];

/* Formatting function for row details - modify as you need */
function format ( d ) {
    var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%">';
      
    var dataChild = [];
    var hasChildren = false;
    $.each(g_dataFull, function(){
       if(this.id_parent_harga === d.id){
          html += 
            '<tr><td>' + $('<div>').text(this.nama_pelayanan).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_komp_biaya).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_harga).html() +'</td>' + 
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
            "ajax": "<?php echo base_url(); ?>harga/fetch_harga" 
               
        });
 
      
         
      });
  
        
         
    </script>