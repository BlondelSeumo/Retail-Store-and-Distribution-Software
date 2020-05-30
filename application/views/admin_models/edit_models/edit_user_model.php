<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
		 <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit user details:</h4>
</div>
<div class="modal-body">
   <div  id="print-section-model" class="row">
        <div class="box box-danger">
            <div  class="box-body">
            	<button onclick="printDiv('print-section-model')" class="btn btn-default btn-flat pull-right btn-lg"><i class="fa fa-print pull-left"></i> Print 
			     </button>
               <div  class="col-md-12">
				<?php
						$Edit_attributes = array('id'=>'Edit_User_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open_multipart('users/edit',$Edit_attributes); ?>
	              <div class="form-group">	
					 <?php echo form_label('User Name:'); ?>
					  <?php
						
						$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'Edit_user_id','value'=>$single_user[0]->id);
						echo form_input($data);
								
								
						$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'Edit_user_name','value'=>$single_user[0]->user_name,'reqiured'=>'');
						echo form_input($data);
					
					?>
	              </div>
				   <div class="form-group">
					<?php echo form_label('User Email:'); ?>
	                   <?php
						
							$data = array('class'=>'form-control input-lg','type'=>'email','name'=>'Edit_user_email','value'=>$single_user[0]->user_email,'reqiured'=>'');
							echo form_input($data);
						?>
	              </div>
				   <div class="form-group">
				   <?php echo form_label('User Address:'); ?>
	               <?php
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'Edit_User_Address','value'=>$single_user[0]->user_address,'reqiured'=>'');
							echo form_input($data);
					
				  ?>
	                </div>
				   <div class="form-group">
				   <?php echo form_label('User Contact1:'); ?>
					<?php
						
							$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'Edit_User_Contatc1','value'=>$single_user[0]->user_contact_1,'reqiured'=>'');
							echo form_input($data);
				   ?>
	              </div>
				   <div class="form-group">
				     <?php echo form_label('User Contact2(Optional):'); ?>
	                   <?php
						
							$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'Edit_User_Contatc2','value'=>$single_user[0]->user_contact_2,'reqiured'=>'');
							echo form_input($data);
						?>
	              </div>
			      <div class="form-group">
				   <?php echo form_label('description:'); ?>
                   <?php
						$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'Edit_User_description','value'=>$single_user[0]->user_description,'reqiured'=>'');
						echo form_input($data);
				
					?>
              	  </div>
				   <div class="form-group">
	                   <?php
						
							echo img(array('width'=>'100','height'=>'100','class'=>'img-circle','name'=>'edit_user_picture','src'=>base_url().'uploads/users/'.$single_user[0]->cus_picture));
						?>	
					</div>
				   <div class="form-group">
	                <label>Upload User Picture (Optional)</label>
						 <div class="input-group">
	                
	          		<input type="file" name="edit_user_picture" data-validate="required" data-message-required="Value Required" >
	                </div>
	              </div>
				  <div class="form-group">  				
					<?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_usertomer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update user');
						
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