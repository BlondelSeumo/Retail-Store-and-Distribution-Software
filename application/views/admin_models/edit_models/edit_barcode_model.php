<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
		Edit Product
	 </h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
		<?php
			$attributes = array('id'=>'edit_barcode','method'=>'post','class'=>'form-horizontal');
		?>
		<?php echo form_open('product/edit_barcode',$attributes); ?>  
          <div class="form-group">    
			<?php
					$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_barcode_id','value'=>$single_product[0]->id);
					echo form_input($data);	
					
					echo form_label('Product Name');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_name','value'=>$single_product[0]->barcode,'reqiured'=>'');
					echo form_input($data);							
			?> 
          </div>	  
          <div class="form-group">  
				<?php
					echo form_label('Description :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_description','value'=>$single_product[0]->description,'reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>
		  <div class="form-group">  				
			<?php
				$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Product');
				
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