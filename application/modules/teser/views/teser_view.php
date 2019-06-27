 
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                 
            </div>
            <!-- Basic tesers -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            
 
                        </div>
                        <div class="body">
                             
                        
                        <table id="example" class="table table-bordered table-striped table-hover js-basic-example">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Pelayanan</th>
                                <th>Komp Biaya</th>
                                <th>Pricelist</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>

                     
                        </table>

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
var g_dataFull = [];

/* Formatting function for row details - modify as you need */
function format ( d ) {
    var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%">';
      
    var dataChild = [];
    var hasChildren = false;
    $.each(g_dataFull, function(){
       if(this.parent === d.nama_pricelist){
          html += 
            '<tr><td>' + $('<div>').text(this.nama_pelayanan).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_komp_biaya).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.nama_pricelist).html() +'</td>' + 
            '<td>' +  $('<div>').text(this.nama_satuan).html() + '</td></tr>';
         
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
    var table = $('#example').DataTable( {
        "ajax": {
          "url": "<?php echo base_url('pricelist/dataget'); ?>",
          "dataSrc": function(d){
            
             g_dataFull = d.data;
             var dataParent = []
             $.each(d.data, function(){
                if(this.parent === "null"){
                   dataParent.push(this);  
                }
             });
            
             return dataParent;
          }
        },
         
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "nama_pelayanan" },
            { "data": "nama_komp_biaya" },
            { "data": "nama_pricelist" },
            { "data": "nama_satuan" }
        ],
        "order": [[1, 'asc']]
    } );
    
    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
 
} );
		 
    </script>