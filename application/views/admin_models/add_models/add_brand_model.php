<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
	 Add new brand 
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger">
        	<div class="box-body">
	         	<div class="col-md-12">
				 <?php
					$attributes = array('id'=>'brand_form','method'=>'post','class'=>'form-horizontal');
				  ?>
					<?php echo form_open($link,$attributes); ?> 
					 <div class="form-group">    
						<?php
							echo form_label('Company:');		
						?> 
						<select name="company_id" class="form-control input-lg">
                            <?php 
                            if($company_list != NULL)
                            {
                                foreach ($company_list as $single_company) 
                                {
                            ?>
                                <option value="<?php echo $single_company->id; ?>">
                                    <?php echo $single_company->customer_name; ?>     
                                </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>          
			         </div>	   
			         <div class="form-group">    
						<?php
							echo form_label('Name:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'brand_name','placeholder'=>'Enter your Brand Name','reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>	  
					 <div class="form-group">  				
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Brand');
							
							echo form_button($data);	
						 ?>    
			         </div>
						<?php echo form_close(); ?>			    		
	        	</div>	
     		</div>				  
		</div>
	</div>
</div>
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>