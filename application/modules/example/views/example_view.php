 
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                 
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            
 
                        </div>
                        <div class="body">
                                <div class="tree">
                                <?php 
                                echo $dataparse;
                                ?>
                              
</div>
                           
 <br>
   

                        </div>
                    </div>
                </div>
            </div>
         


        </div>
    </section>
 
			
 
   <script type="text/javascript">
	
    $(document).ready(function () {
    // create a tree
    $("#tree-data").jOrgChart({
        chartElement: $("#tree-view"), 
        nodeClicked: nodeClicked
    });
    
    // lighting a node in the selection
    function nodeClicked(node, type) {
        node = node || $(this);
        $('.jOrgChart .selected').removeClass('selected');
            node.addClass('selected');
        }
    });

		
		 
    </script>