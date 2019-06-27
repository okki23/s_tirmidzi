 
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
                               Upload Harga
                            </h2>
                            
                        </div>
                        <div class="body">
                                
                               <form method="post" name="frmGroupUser" id="frmGroupUser" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id"> 
                                  
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="excel_file" id="excel_file"  class="form-control" placeholder="File AT4" />
                                        </div>
                                        <br>
                                   
                                           <a target="_blank" href="<?php echo base_url('assets/excel_template/pricelist_template.xls'); ?>"> <span class="btn btn-success"> <i class="material-icons">archive</i>   Download Template Disini </span></a> 
                                            <span class="btn btn-danger"> <i class="material-icons">warning</i> XLS file Only! Max 5 MB ! </span>
                                    </div>
                                   

                                   

                                   <button type="submit" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>
                                   <div id="loading">
                                    <div align="center">
                                      <img src="<?php echo base_url('assets/images/loadingku.gif');  ?>" style="width: 20%; height: 20%; ">
                                    </div>
                                    <br>
                                    <h3 align="center"> Mohon tunggu, data sedang di upload ... </h3>
                                  </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
         


        </div>
    </section>


 
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
    $("#loading").hide();
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

      $("#frmGroupUser").on("submit", function(event){
            var $btn = $("#myButton").button('Mohon Tunggu, data sedang di unggah!');
            event.preventDefault();
            var formData = new FormData(this);
         
             $.ajax({
                url : "<?php echo base_url('upload_harga/pro_upload'); ?>", 
                type : "post",
                data : formData,
                cache: false,
                contentType: false,
                processData: false, 
                beforeSend: function(){
                   $("#loading").show();
                 },
                 complete: function(){
                   $("#loading").hide();
                 },
                success: function(e){
                    $btn.button('reset')
                    alert('Data berhasil di upload!');
         
                },
                error: function(e){
                    $btn.button('reset')
                    alert('Data gagal di upload!');
                }
           });
       });
    
       

  
 

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