<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
	 	Add new town
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger">
        	<div class="box-body">
	         	<div class="col-md-12">
				 <?php
					$attributes = array('id'=>'town_form','method'=>'post','class'=>'form-horizontal');
				  ?>
					<?php echo form_open($link,$attributes); ?>  
			         <div class="form-group">    
						<?php
							echo form_label('Town Name:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'town_name','placeholder'=>'Enter Town Name','reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>				         
			         <div class="form-group">    
			         	<label>Region: 
			         		<a onclick="show_modal_page('<?php echo base_url().'initilization/popup/add_region_model'; ?>')" href="javascript:void(0)" >(Add new region)</a>
			         	</label>
						<?php

							if($region != NULL)
                              {
                                foreach ($region as $single_region)
                                 {
                                    $head_options[$single_region->name] = $single_region->name;
                                 } 
                              }
                              else
                              {
                                 $head_options = array(
                                                '0'  => 'No record available'
                                  );
                              }
                         	 $extra = array(
                                      'id'       => '',
                                      'onChange' => '',
                                      'class'=>'form-control input-lg '
                                    );
                          	echo form_dropdown('region', $head_options, '',$extra);
							?>	
			         </div>			          
					 <div class="form-group">  				
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Town');
							
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