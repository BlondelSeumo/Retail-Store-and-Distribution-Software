
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>		
	<h4 class="modal-title text-center"> Change Picture</h4>
</div>  
<div class="modal-body"> 
	<?php
			$attributes = array('id'=>'Picture_Model_admin','method'=>'post');
	?>
	<?php echo form_open_multipart('profile/change_profile_picture',$attributes); ?>
	<?php
			$labelAttributes = array(
					'class' => 'label',
					'style' => 'color: #000;'
			);
	?>
	<div class="form-group ">
			<div class="input-group center-block">
				<input type="file" class="input-lg form-control " name="customer_picture" id="customer_picture" data-validate="required" data-message-required="Value Required" >
			</div>
	</div>
	<div class="form-group text-center">	
		<?php
			$data = array('class'=>'btn btn-info margin  btn-set btn-lg','name'=>'btn_submit','value'=>'Change Picture');
			
			echo form_submit($data);
		 ?> 
	</div> 		  
	<?php echo form_close(); ?>		
</div>   