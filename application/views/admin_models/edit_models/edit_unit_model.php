<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
		Edit Unit
	</h4>
</div>
<div class="modal-body">
   <div class="row">
	  	<div class="box box-danger">
		     	<div class="col-md-12">
		    <div class="box-body">
			 	<?php
					$Edit_attributes = array('id'=>'unit_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open($link,$Edit_attributes); ?>	  
			      <div class="form-group">    
					<?php
						echo form_label('Unit Name:');
						$data = array('class'=>'','type'=>'hidden','name'=>'edit_unit_id','value'=>$single_unit[0]->id);
						echo form_input($data);	

						$data = array('class'=>'form-control input-lg','type'=>'text','value'=>$single_unit[0]->name,'name'=>'unit_name');
						echo form_input($data);									
					?>          
			      </div>			      
			      <div class="form-group">    
					<?php
						echo form_label('Symbol:');

						$data = array('class'=>'form-control input-lg','type'=>'text','value'=>$single_unit[0]->symbol,'name'=>'symbol');
						echo form_input($data);									
					?>          
			      </div>	
				  <div class="form-group">  				
			         <?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Unit ');
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