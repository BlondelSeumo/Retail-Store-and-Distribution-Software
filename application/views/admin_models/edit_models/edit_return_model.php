<div id="Edit_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		
        <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Medicine details</h4>
      </div>
	  
	  
      <div class="modal-body">
        
		
		   <div class="row">

				<div class="box box-danger">

						<div class="box-body">
			
							<div class="col-md-12">
				
									
									<?php
											$Edit_attributes = array('id'=>'Edit_Return_items','method'=>'post','class'=>'form-horizontal');
									?>

									<?php echo form_open('Return_items/edit',$Edit_attributes); ?>
									  
									   <div class="form-group">

									   <?php 
										
											
													$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_medicine_id','value'=>'');
													echo form_input($data);
											
											
									   ?>
										
											
									  </div>
									   <div class="form-group">
									   
									   <?php echo form_label('Medicine quantity:'); ?>
						  
									   <?php
											
												$data = array('class'=>'form-control','type'=>'number','name'=>'edit_quantity','placeholder'=>'e.g 10','reqiured'=>'');
												echo form_input($data);
										
									   ?>

										</div>       
									   
									   <div class="form-group">
										
											 <?php echo form_label('Medicine description:'); ?>

										   <?php
											
												$data = array('class'=>'form-control','type'=>'text','id'=>'edit_description','name'=>'edit_description','placeholder'=>'e.g any description','reqiured'=>'');
												echo form_input($data);
										
											?>
								
									  </div>
									  
									  <div class="form-group">  				

										<?php
											$data = array('class'=>'btn btn-info btn-flat margin ','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Return List');
											
											echo form_button($data);
										 ?>   
										 
									  </div>
									  
									<?php echo form_close(); ?>
								</div>
						</div>

					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	