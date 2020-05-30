<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
		Create new product for barcode
	 </h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
		 <?php
				$attributes = array('id'=>'barcode_form','method'=>'post','class'=>'form-horizontal');
		?>
		<?php echo form_open('product/add_barcode',$attributes); ?>  
          <div class="form-group">    
			<?php
					echo form_label('Product Name');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_name','placeholder'=>'Enter your product name','reqiured'=>'');
					echo form_input($data);							
			?> 
          </div>	  
          <div class="form-group">  
				<?php
					echo form_label('Description :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product_description','placeholder'=>'Enter your product description if any','reqiured'=>'');
					echo form_input($data);	
				 ?>	
		  </div>
		  <div class="form-group">  				
			<?php
				$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save product');
				
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