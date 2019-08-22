 
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
                                SO
                            </h2>
                            <br>
                            <a href="javascript:void(0);" id="addmodal" class="btn btn-primary waves-effect">  <i class="material-icons">add_circle</i>  Tambah Data </a>
                            
                        </div>
                        <div class="body"> 
                           
                             <div class="table-responsive">
                               <table class="table table-bordered table-striped table-hover js-basic-example" id="example" > 
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">No SO</th>  
                                            <th style="width:5%;">Customer</th> 
                                            <th style="width:5%;">Tanggal Terbit</th> 
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
    <div class="modal fade" id="defaultModal" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Form Tambah Data</h4>
                        </div>
                        <div class="modal-body">
                              <form method="post" id="user_form" enctype="multipart/form-data">   
                                 
                                    <input type="hidden" name="id" id="id">  

                                    <div class="form-group">
                                        <div class="form-line">
                                            <label> No Transaksi </label>
                                            <input type="text" name="no_so" id="no_so" class="form-control" placeholder="No Transaksi" readonly="readonly" />
                                        </div>
                                    </div> 
                                    
                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_customer" id="id_customer" required>
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariCustomer();" class="btn btn-primary"> Pilih Customer.. </button>
                                                </span>
                                    </div> 

                                    <br>
                                     
                                     <button type="button" class="btn btn-primary waves-effect" onclick="TambahDataChild();"> <i class="material-icons">add_circle</i>  Tambah Data</button>
 
                                        <br>
                                        &nbsp;
                                        <table class="table table-bordered table-striped table-hover js-basic-example" id="datalist"> 
  
                                        <thead>
                                            <tr>
                                                <th style="width:1%;">No</th>  
                                                <th style="width:2%;">Nama Produk</th>
                                                <th style="width:2%;">Jenis</th>
                                                <th style="width:2%;">Ukuran</th>
                                                <th style="width:2%;">Satuan</th>
                                                <th style="width:2%;">Qty</th>  
                                                <th style="width:5%;">Harga Satuan</th> 
                                                <th style="width:5%;">Total Harga</th>  
                                            </tr>
                                        </thead> 
                                        </table>

                                        <div id="teser" style="float:right; margin-right:10px; font-weight:bold;font-size:20px;"> 0 </div>
 
                                  
                                  <br>
                                   
                                   

                                  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan </button>

                                    <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form_Order();" > <i class="material-icons">clear</i> Batal</button>
                        </div>
                                 
                        </div>

                                   
                             </form>
                       </div>
                     
                    </div>
                </div>
    </div>
  

  <!-- form tambah child -->
  <div class="modal fade" id="defaultModalChild" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalChildLabel">Form Tambah Item</h4>
                        </div>
                        <div class="modal-body">
                              <form method="post" id="user_form_detail" enctype="multipart/form-data">   
                                 
                                    <input type="hidden" name="id" id="id"> 
                                    <input type="hidden" name="no_sox" id="no_sox">  

                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_produk" id="id_produk" required>
                                                    
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="Pilihproduk();" class="btn btn-primary"> Pilih Produk.. </button>
                                                </span>
                                    </div> 
 
                                  
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label> Qty </label>
                                            <input type="text" name="qty" id="qty" class="form-control" placeholder="Qty" />
                                        </div>
                                    </div> 
                                   
                                  
                                 
                                  
                                  <br>
                                  <button type="button" onclick="Simpan_DataItem();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan</button>

                                    <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:defaultModalChildClose();" > <i class="material-icons">clear</i> Batal</button>
                        </div>
                                 
                        </div>

                                   
                             </form>
                       </div>
                     
                    </div>
                </div>
    </div>
  
    
    <!-- modal cari produk -->
    <div class="modal fade" id="PilihprodukModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" > Pilih Produk </h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                <table width="100%" class="table table-bordered table-striped table-hover" id="daftar_produk" > 
                                     <thead>
                                        <tr>  
                                            <th style="width:5%;">Nama Produk</th>
                                            <th style="width:5%;">Jenis </th>
                                            <th style="width:5%;">Ukuran</th>    
                                            <th style="width:5%;">Satuan</th>    
                                            <th style="width:12%;">Action </th> 
                                         </tr>
                                    </thead> 
                                    <tbody>
                                        
                                    </tbody>  
                                </table> 

 
                       </div>
                     
                    </div>
                </div>
    </div>

    

    <!-- modal cari customer -->
    <div class="modal fade" id="CariCustomerModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Cari Customer</h4>
                        </div>
                        <div class="modal-body">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">X Tutup</button>

                                <br>
                                <hr>

                                 <table width="100%" class="table table-bordered table-striped table-hover " id="daftar_customer" >
                                  
                                    <thead>
                                        <tr>   
                                            <th style="width:98%;">Kode Customer </th> 
                                            <th style="width:98%;">Nama  </th> 
                                            <th style="width:98%;">Alamat </th> 
                                            <th style="width:98%;">Telp </th> 
                                            <th style="width:98%;">Email </th> 
                                         </tr>
                                    </thead> 
                                    <tbody id="daftar_customerx">

                                </tbody>
                                </table> 
                       </div>
                     
                    </div>
                </div>
    </div>
 
	
	<!-- detail data -->
	<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail SO</h4>
                        </div>
                        <div class="modal-body">

                        <div class="row clearfix">

                        <div class="col-lg-12">

                            <table class="table table-responsive">
                            <tr>
                                <td style="font-weight:bold;"> No SO</td>
                                <td> : </td>
                                <td> <p id="nosodtl"> </p> </td>
                                
                                <td style="font-weight:bold;"> Customer</td>
                                <td> : </td>
                                <td> <p id="custdtl"> </p> </td> 
                            </tr>
                            
                            <tr>
                                <td style="font-weight:bold;"> Date Assign</td>
                                <td> : </td>
                                <td> <p id="dateassign"> </p> </td>
                                
                                <td style="font-weight:bold;"> Status</td>
                                <td> : </td>
                                <td> <p id="statusdtl"> </p> </td> 
                            </tr>

                             
                            </table> 

                            <br>

                            <table width="100%" class="table table-bordered table-striped table-hover " id="tabeldetail" > 
                                    <thead>
                                            <tr>
                                                <th style="width:1%;">No</th>  
                                                <th style="width:2%;">Nama Produk</th>
                                                <th style="width:2%;">Jenis</th>
                                                <th style="width:2%;">Ukuran</th>
                                                <th style="width:2%;">Satuan</th>
                                                <th style="width:2%;">Qty</th>  
                                                <th style="width:2%;">Harga Satuan</th> 
                                                <th style="width:2%;">Total Harga</th>  
                                           
                                            </tr>
                                    </thead>
                                    <tbody>

                                    
                                        
                                    </tbody>  
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                            </table>  

                        </div>
 
                        <!-- No 	Nama produk 	Qty 	Source 	Keterangan -->
						 
							 <div class="modal-footer">
							  <button type="button" class="btn btn-danger" data-dismiss="modal"> X Tutup </button>
							 </div>
					
                           
					   </div>
                     
                    </div>
                </div>
    </div>
            


    
   
    <!-- form material -->
    <div class="modal fade" id="MaterialModal" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Form Input Material Data</h4>
                        </div>
                        <div class="modal-body">
                              <form method="post" id="user_form" enctype="multipart/form-data">   
                                 
                                    <input type="hidden" name="id" id="id">  

                                    <div class="form-group">
                                        <div class="form-line">
                                            <label> No Transaksi </label>
                                            <input type="text" name="no_so" id="no_so" class="form-control" placeholder="No Transaksi" readonly="readonly" />
                                        </div>
                                    </div> 
                                    
                                    <div class="input-group">
                                                <div class="form-line">
                                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control" required readonly="readonly" >
                                                    <input type="hidden" name="id_customer" id="id_customer" required>
                                                </div>
                                                <span class="input-group-addon">
                                                    <button type="button" onclick="CariCustomer();" class="btn btn-primary"> Pilih Customer.. </button>
                                                </span>
                                    </div> 

                                    <br>
                                     
                                     <button type="button" class="btn btn-primary waves-effect" onclick="TambahDataChild();"> <i class="material-icons">add_circle</i>  Tambah Data</button>
 
                                        <br>
                                        &nbsp;
                                        <table class="table table-bordered table-striped table-hover js-basic-example" id="datalist"> 
  
                                        <thead>
                                            <tr>
                                                <th style="width:1%;">No</th>  
                                                <th style="width:2%;">Nama Produk</th>
                                                <th style="width:2%;">Jenis</th>
                                                <th style="width:2%;">Ukuran</th>
                                                <th style="width:2%;">Satuan</th>
                                                <th style="width:2%;">Qty</th>  
                                                <th style="width:5%;">Harga Satuan</th> 
                                                <th style="width:5%;">Total Harga</th>  
                                            </tr>
                                        </thead> 
                                        </table>

                                        <div id="teser" style="float:right; margin-right:10px; font-weight:bold;font-size:20px;"> 0 </div>
 
                                  
                                  <br>
                                   
                                   

                                  <button type="button" onclick="Simpan_Data();" class="btn btn-success waves-effect"> <i class="material-icons">save</i> Simpan </button>

                                    <button type="button" name="cancel" id="cancel" class="btn btn-danger waves-effect" onclick="javascript:Bersihkan_Form_Order();" > <i class="material-icons">clear</i> Batal</button>
                        </div>
                                 
                        </div>

                                   
                             </form>
                       </div>
                     
                    </div>
                </div>
    </div>
  
    
       
   <script type="text/javascript">

    $('#daftar_customer').DataTable( {
            "ajax": "<?php echo base_url(); ?>customer/fetch_customer"           
    });
 
    function CariCustomer(){
        $("#CariCustomerModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
  

    // cari direktorat
    $('#daftar_instansi').DataTable( {
            "ajax": "<?php echo base_url(); ?>instansi/fetch_instansi"           
    });

     
     
    function PilihInstansi(){
        $("#PilihInstansiModal").modal({backdrop: 'static', keyboard: false,show:true});
    } 
   
 
        var daftar_customer = $('#daftar_customer').DataTable();
     
        $('#daftar_customer tbody').on('click', 'tr', function () {
            
            var content = daftar_customer.row(this).data()
            console.log(content);
            $("#nama_customer").val(content[1]);
            $("#id_customer").val(content[6]);
            $("#CariCustomerModal").modal('hide');
        } );




    function Simpan_DataItem(){
        
        
        var formData = new FormData($('#user_form_detail')[0]);  
        var no_sox = $("#no_sox").val();

            $.ajax({
             url:"<?php echo base_url(); ?>so/simpan_data_detail",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                TableListDetail(no_sox);
                //CalcWeight(no_sox);
                 $("#defaultModalChild").modal('hide');
                 //$("#example_list").DataTable.reload();
                 $('#user_form_detail')[0].reset();
                 
                 //ReloadListTableDetail(no_sox);
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

    
     

    function Pilihproduk(){
        $("#PilihprodukModal").modal({backdrop: 'static', keyboard: false,show:true});


        var no_sox = $("#no_sox").val();
         
        $('#daftar_produk').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('produk/item_list'); ?>",
                "data":{no_sox},
                "type":"POST" ,
                "dataSrc" : '' 
            },
  
            "columns" : [{
                "data" : "nama_produk"
            },{
                "data" : "nama_jenis"
            },{
                "data" : "ukuran"
            },{
                "data" : "nama_satuan"
            },{
                "data" : "action"
            }],
 
            "rowReorder": {
                "update": false
            },

            "destroy":true,
        });

    }


    function GetItemList(id){
        console.log(id);
        $.get("<?php echo base_url('so/fetch_item_list/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
           
            $("#id_produk").val(id);
            $("#nama_produk").val(parse.nama_produk); 
           
            $("#PilihprodukModal").modal('hide');
        });

    }
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

   
	 function Show_Detail(id){ 
         /*No	Nama Produk	Jenis	Ukuran	Satuan	Qty	Harga Satuan	Total Harga	Opsi Harga */
		$("#DetailModal").modal({backdrop: 'static', keyboard: false,show:true});

        $('#tabeldetail').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('so/listingdetail'); ?>",
                "data":{id},
                "type":"POST",
                dataSrc : '',

            },
           
            "columns" : [ {
                "data" : "no"
            },{
                "data" : "nama_produk"
            },{
                "data" : "nama_jenis"
            },{
                "data" : "ukuran"
            },{
                "data" : "nama_satuan"
            },{
                "data" : "qty"
            },{
                "data" : "harga_satuan"
            },{
                "data" : "total_harga"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,

            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                'Rp. '+addCommas(pageTotal)
            );
        }
        });
    

		$.ajax({
			 url:"<?php echo base_url(); ?>so/detailmodal/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){  
 
                 $("#nosodtl").html(result.no_so);
                 $("#custdtl").html(result.nama);
                 $("#dateassign").html(result.date_assign); 
                 
                 if(result.status == 1){
                    $("#statusdtl").html('Create'); 
                 }else if(result.status == 2){
                    $("#statusdtl").html('Approve'); 
                 }else if(result.status == 3){
                    $("#statusdtl").html('Reject'); 
                 }else if(result.status == 4){
                    $("#statusdtl").html('Pending'); 
                 }else if(result.status == 5){
                    $("#statusdtl").html('Process'); 
                 }else if(result.status == 6){
                    $("#statusdtl").html('Finishing'); 
                 }else if(result.status == 7){
                    $("#statusdtl").html('Package'); 
                 }
                
                 
			 	   
			 }
		 });
	 }
       

       
    // $('#daftar_produk').DataTable( {
    //     "ajax": "<?php echo base_url(); ?>produk/fetch_produk",
    //     "rowReorder": {
    //             "update": false
    //         },
    //     "destroy":true,
    // });

    //  var daftar_produk = $('#daftar_produk').DataTable();
     
    //     $('#daftar_produk tbody').on('click', 'tr', function () {
 
          
    //         var content = daftar_produk.row(this).data()
    //         console.log(content[5]+content[6]);
    //         alert(content[5]+content[6]);
    //         $("#nama_produk").val(content[2]);
    //         $("#id_produk").val(content[4]);
    //         $("#jkt").html(content[5])
    //         $("#sbg").html(content[6])
    //         $("#PilihprodukModal").modal('hide');
    //     } );

 
    function TableListDetail(no_sox=null){
   
      $.get("<?php echo base_url('so/datalist/'); ?>"+no_sox, function(data) {
          $("#datalist").html(data);
      });

      $.get("<?php echo base_url('so/countpay/');?>"+no_sox,function(res){
        $("#teser").html(res);
      });
    }
    function CalcWeight(no_sox){
      $.get("<?php echo base_url('so/calc_weight/'); ?>"+no_sox, function(data) {
          $("#total_berat").val(data);
      });
    }
 
     function TambahDataChild(){

        $("#defaultModalChild").modal({backdrop: 'static', keyboard: false,show:true});
        $("#defaultModalChildLabel").html("Form Tambah Order");  
        var no_so = $("#no_so").val();
        $("#no_sox").val(no_so);

         

        TableListDetail(no_so);

        $.get("<?php echo base_url('so/datalist/'); ?>"+no_so, function(data) {
          console.log(data);
          //$("#datalist").html(data);
      });
     }

     function defaultModalChildClose(){
        $("#defaultModalChild").modal('hide'); 
     }
     function CloseModalDetail(){
        $("#defaultModalChild").modal('hide'); 
     }
        $("#addmodal").on("click",function(){
          $("#defaultModal").modal({backdrop: 'static', keyboard: false,show:true});
          $("#defaultModalLabel").html("Form Tambah Data");
            var no_so = $("#no_so").val();
            $("#teser").html('Total Belanja : Rp. 0');
        
          $.ajax({
          url:"<?php echo base_url('so/get_last_id'); ?>",
          type:"GET",
          data:{id:1},
          success:function(result){

            $("#no_so").val(result);

            $.get("<?php echo base_url('so/datalist/'); ?>"+result, function(data) {
                //console.log(data); 
                $("#datalist").html(data);
            });
          
          } 
          }); 
          
        });

          

    function UploadBuktiBayar(no_so){
        $("#no_soy").val(no_so);
        $("#UploadBuktiBayarModal").modal({backdrop: 'static', keyboard: false,show:true});
    }


    function CariProduk(){
        $("#CariProdukModal").modal({backdrop: 'static', keyboard: false,show:true});

        var no_so = $("#no_so").val();
        TableListDetail(no_so);
        $('#tabel_produk').DataTable({
            "processing" : true,
            "ajax" : {
                "url" : "<?php echo base_url('so/produk_list'); ?>",
                "data":{no_so},
                "type":"POST" ,
                "dataSrc" : '' 
            },
  
            "columns" : [{
                "data" : "nama_produk"
            },{
                "data" : "nama_bahan"
            },{
                "data" : "ukuran"
            },{
                "data" : "nama_satuan"
            },{
                "data" : "berat_bahan"
            },{
                "data" : "harga"
            },{
                "data" : "foto"
            },{
                "data" : "action"
            }],

            "rowReorder": {
                "update": false
            },

            "destroy":true,
        });
    
 
    } 
 
    function GetDataProduk(id){
        console.log(id);
        $.get("<?php echo base_url('so/get_data_produk/'); ?>"+id,function(result){
            console.log(result);
            var parse = JSON.parse(result);
            var nf = new Intl.NumberFormat();
            $("#id_pricelist").val(id);
            $("#harga_hidden").val(parse.harga);
            $("#berat_bahan_hidden").val(parse.berat_bahan);
            $("#nama_produk").val(parse.nama_produk+' - '+parse.nama_bahan+' - '+parse.ukuran+' - '+parse.nama_satuan+' - '+parse.berat_bahan+' Gram - Rp. '+nf.format(parse.harga));
            $("#produk").html("<a href='upload/"+parse.foto+"' data-fancybox data-type='image' class='btn btn-success'> <i class='material-icons'>aspect_ratio</i> Lihat Produk</a>");
            $("#CariProdukModal").modal('hide');
        });

    }

        
     function Bersihkan_Form(){
        $(':input').val('');  
     }
 

    function Bersihkan_Form_Order(){
        
        var no_so = $("#no_so").val();
        swal({
        title: "Anda yakin ingin membatalkan transaksi ini?",
        text: "ini akan membatalkan transaksi "+no_so+" !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax(
                    {
                        type: "POST",
                        url: "<?php echo base_url('so/'); ?>hapus_no_so",
                        data: {no_so:$("#no_so").val()},
                        success: function(data){
                        }
                    }
                ).done(function(data) {
                    swal("Transaksi Batal!", "Transaksi berhasil dibatalkan", "success");
                    $("#defaultModal").modal('hide');
                    $(':input').val('');  
                    }); 
            }else{
            swal("Lanjut", "Transaksi tetap dilanjutkan", "success");
          }
        });
      
       
    }
  

     function HapusDetailList(id,no_so){
        swal({
        title: "Anda yakin ingin menghapus item ini?",
        text: "ini akan menghapus item dari daftar anda !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax(
                    {
                      type: "POST",
                      url: "<?php echo base_url('so/'); ?>hapus_data_detail",
                      data: {id:id,no_so:no_so},
                      success: function(data){
                      }
                    }
                ).done(function(data) {
                    swal("Item Dihapus!", "Item berhasil dihapus", "success");
                    TableListDetail(no_so);
                   // CalcWeight(no_so);
                    //$('#example').DataTable().ajax.reload(); 
                    //$("#defaultModal").modal('hide'); 
                    //$(':input').val('');  
                    }); 
            }else{
            swal("Batal", "Data Tidak Dihapus!", "info");
          }
        });  

     }

     function Hapus_Data(no_so){  
        swal({
        title: "Anda yakin ingin menghapus transaksi ini?",
        text: "ini akan menghapus transaksi "+no_so+" !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax(
                    {
                        type: "POST",
                        url: "<?php echo base_url('so/'); ?>hapus_data",
                        data: {no_so:no_so},
                        success: function(data){
                        }
                    }
                ).done(function(data) {
                    swal("Transaksi Dihapus!", "Transaksi berhasil dibatalkan", "success"); 
                    $('#example').DataTable().ajax.reload(); 
                    $("#defaultModal").modal('hide'); 
                    $(':input').val('');  
                    }); 
            }else{
            swal("Batal", "Data Tidak Dihapus!", "info");
          }
        }); 
 
    }
    
      
    function Simpan_Data(){

        var no_so = $("#no_so").val();
        var formData = new FormData($('#user_form')[0]);  
        swal({
        title: "Anda yakin ingin mengkonfirmasi pengeluaran produk ini?",
        text: "ini akan menyimpan transaksi dengan nomor transaksi "+no_so+" !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        
        closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"<?php echo base_url(); ?>so/simpan_summary",
                      type:"POST",
                      data:formData, 
                      contentType:false,  
                      processData:false,   
                       success:function(result){
                        console.log(result);
                       }
                });
               $("#defaultModal").modal('hide');

                //window.open('<?php echo base_url('invoice/print_invoice/'); ?>'+window.btoa(no_so), 'print_invoice', 'width=1366, height=768, status=1,scrollbar=yes'); 

               $(':input').val('');  
               swal("Lanjut", "Transaksi selesai", "success");
               $('#example').DataTable().ajax.reload(); 
            }else{
            swal("Lanjut", "Transaksi tetap dilanjutkan", "success");
          }
        });
    }

    function Simpan_Data_Detail(){ 
      
        var no_sox = $("#no_sox").val(); 
        var formData = new FormData($('#user_form_detail')[0]);  
       

            $.ajax({
             url:"<?php echo base_url(); ?>so/simpan_data_detail",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                TableListDetail(no_sox);
               // CalcWeight(no_sox);
                 $("#defaultModalChild").modal('hide');
                 //$("#example_list").DataTable.reload();
                 $('#user_form_detail')[0].reset();
                 //$('#teser').html('0');
                 $.get("<?php echo base_url('so/countpay/');?>"+no_sox,function(res){
                   console.log(res);
                });
                 //ReloadListTableDetail(no_sox);
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
 
    function Simpan_Data_BB(){
        //setting semua data dalam form dijadikan 1 variabel 

          

        var formData = new FormData($('#bukti_bayar_form')[0]);  
        //var nama_so = $("#nama_so").val(); 
            //transaksi dibelakang layar
            $.ajax({
             url:"<?php echo base_url(); ?>so/simpan_data_bb",
             type:"POST",
             data:formData,
             contentType:false,  
             processData:false,   
             success:function(result){ 
                
                 $("#UploadBuktiBayarModal").modal('hide');
                 $('#example').DataTable().ajax.reload(); 
                 $('#bukti_bayar_form')[0].reset();
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

      
      $("#slideongkir").slideUp(); 
      $('#example').DataTable({
        "ajax": "<?php echo base_url(); ?>so/fetch_so_list" 
      }); 
 
      });
  
        
         
    </script>