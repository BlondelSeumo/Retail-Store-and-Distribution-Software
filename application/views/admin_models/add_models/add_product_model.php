<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Product/Service </h4>
	<small>
		Products and services that you buy from vendors are used as items on Bills to record those purchases, and the ones that you sell to customers are used as items on Invoices to record those sales.
	</small>
</div>
 <div class="modal-body">
	<div class="row">
      	<div class="box box-danger">
        	<div class="box-body">
          		<div class="col-md-12">
					<?php
						$attributes = array('id'=>'product_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('services/add_product',$attributes); ?>  
		          	<div class="form-group">    
						<?php
								echo form_label('Name:');
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_name','placeholder'=>'e.g Inventory');
								echo form_input($data);							
						?>           
		          	</div>	  
		            <div class="form-group">  
						<?php
							echo form_label('Description :');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','reqiured'=>'');
							echo form_input($data);	
						 ?>	
				    </div>  
				    <div class="form-group">
				    	<label>Product/Service Type :</label>
				    	 <select name="product_type" onchange="check_type(this.value)" class="form-control input-lg">
		                        <option value="0">Service</option>
		                </select>
				    </div>
				  	<div class="form-group">  
						<?php
							echo form_label('Fee/Charges :');
							$data = array('class'=>'form-control input-lg','type'=>'number','step'=>'any','name'=>'price','value'=>'0');
							echo form_input($data);	
						 ?>	
				    </div>        
				    <div class="form-group">  
						<label> Income account : (<a onclick="show_modal_page('<?php echo base_url(); ?>accounts/popup/add_chart_of_accounts')"  href="javascript:void(0)"> <i class="fa fa-plus-circle" aria-hidden="true"></i>  Add new head </a>) </label>

		                <select name="income_account" class="form-control input-lg">
		                    <?php 
		                    foreach ($income_heads as $single_head) 
		                    {
		                    ?>
		                        <option value="<?php echo $single_head->id; ?>">
		                            <?php echo $single_head->name; ?>     
		                        </option>
		                    <?php 
		                     }
		                    ?>
		                </select>
				    </div>    
				    <div class="form-group">  
						<?php
							echo form_label('Tax (%):');

							$data = array('class'=>'form-control input-lg','type'=>'number','step'=>'any','name'=>'sales_tax','value'=>'0');
							echo form_input($data);	

							$data = array('type'=>'hidden','name'=>'redirect_link','value'=>$redirect_link);
							echo form_input($data);	
						 ?>	
				    </div> 
				    <div class="form-group">  				
					<?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save');
						
						echo form_button($data);	
					 ?>    
		            </div>
				   <?php echo form_close(); ?>			    		
        		</div>	
	      	</div>				  
	    </div>
	</div>
</div>
<script type="text/javascript">
	function check_type(type)
	{
		if(type == 1)
		{
			$("#cost_per_item").css("display", "block");
		}
		else
		{
			$("#cost_per_item").css("display", "none");
		}
	}
</script>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>