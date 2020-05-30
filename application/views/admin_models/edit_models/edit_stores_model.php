<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> 
		Edit region
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'edit_store_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open($link,$attributes); ?>		
					<div class="form-group">
						<label> Region </label>		
						<?php 
							$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_store_id','value'=>$single_store[0]->id);
							echo form_input($data);
						 ?>
						
						<?php			
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'store_name','value'=>$single_store[0]->name,'reqiured'=>'');
							echo form_input($data);			
						?>
					</div>		
					<div class="form-group">
						<label>Code </label>				
						<?php			
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'code','value'=>$single_store[0]->code,'reqiured'=>'');
							echo form_input($data);			
						?>		
					</div>					
					<div class="form-group">
						<label>Address </label>				
						<?php			
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'address','value'=>$single_store[0]->address,'reqiured'=>'');
							echo form_input($data);			
						?>		
					</div>					
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-pencil" aria-hidden="true"></i> Update Store');
							
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