<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-upload" aria-hidden="true"></i> Upload CSV file </h4>
</div>
      <div class="modal-body">
		<div class="row">
         <div class="box box-danger">
           <div class="box-body">
		    <div class="col-md-12">
			<?php
					$attributes = array('id'=>'csv_form','method'=>'post','class'=>'form-horizontal');
			?>
			<?php echo form_open_multipart($path,$attributes); ?>
			   <div class="form-group"> 
			   <?php echo form_label('Choose to upload :'); ?>
					<input type="file" name="upload_file" class="form-control input-lg" />	
              </div>
			   
			  	<div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-flat  btn-lg','type' => 'submit','name'=>'btn_submit_Item','value'=>'true', 'content' => '<i class="fa fa-upload" aria-hidden="true"></i> Upload CSV ');
					
					echo form_button($data);
				 ?>   
              </div> 
			<?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>