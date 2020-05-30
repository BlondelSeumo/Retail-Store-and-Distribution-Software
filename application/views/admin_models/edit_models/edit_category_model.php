<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Category</h4>
</div>
<div class="modal-body">
   <div class="row">
	  	<div class="box box-danger">
		    <div class="box-body">
		     	<div class="col-md-12">
			 	<?php
					$Edit_attributes = array('id'=>'Edit_Category_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open('Category/edit/',$Edit_attributes); ?>	  
			      <div class="form-group">    
					<?php
							echo form_label('Category Name:');
							$data = array('class'=>'form-control ','type'=>'hidden','name'=>'edit_category_id','value'=>$single_category[0]->id);
							echo form_input($data);	
							$data = array('class'=>'form-control input-lg','type'=>'text','value'=>$single_category[0]->category_name,'name'=>'edit_category_name');
							echo form_input($data);									
					?>          
			      </div>	
			      <div class="form-group">    
					<?php
							echo form_label('Description:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_category_description','value'=>$single_category[0]->description);
							echo form_input($data);						
					?>           
			      </div>
				  <div class="form-group">  				
			         <?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Category ');
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