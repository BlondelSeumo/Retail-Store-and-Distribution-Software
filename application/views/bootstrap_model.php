    <script type="text/javascript">
    function show_modal_page(url)
    {



          // SHOWING AJAX PRELOADER IMAGE
        jQuery('#page_model_view_data .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url(); ?>assets/img/loader-1.gif" style="height:25px;" /></div>');
        
        // LOADING THE AJAX MODAL
        jQuery('#page_model_view_data').modal('show', {backdrop: 'true'});
        
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
               //alert(response);
                jQuery('#page_model_view_data .modal-body').html(response);
            }
        });
    }	

      function add_new_row(url)
    {   
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response)
            {
               //alert(response);
                jQuery('#transaction_table_body').append(response);
            }
        });
    }  
    
	</script>
        
     <!-- (Ajax Modal)-->
    <div class="modal fade" id="page_model_view_data">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div  class="modal-body" style="height:500px; overflow:auto;">
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> 