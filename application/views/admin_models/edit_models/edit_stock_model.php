 <!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	
	<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit stock details</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">
			     <button onclick="printDiv('print-section-model')" class="btn btn-default btn-lg btn-flat pull-right "><i class="fa fa-print pull-left"></i> Print 
			     </button>
				<div id="print-section-model" class="col-md-12">
					<?php
							$edit_attributes = array('id'=>'Edit_product_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('product/edit_stock',$edit_attributes); ?>
					<div class="form-group">
						<?php
								echo form_label('Product Name:');
								
										$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_stock_id','value'=>$single_stock[0]->id);
										echo form_input($data);
							
	                             if($product_record_list != NULL)
	                              {
	                                foreach ($product_record_list as $single_product)
	                                 {
	                                    $product_options[$single_product->id] = $single_product->product_name.' | Weight '.$single_product->mg.' '.$single_product->unit_type;
	                                 } 
	                              }
	                              else
	                              {
	                                 $product_options = array(
	                                                '0'  => 'No record available'
	                                  );
	                              }
	                         	 $extra = array(
	                                      'id'       => '',
	                                      'onChange' => '',
	                                      'class'=>'form-control select2'
	                                    );

	                          	echo form_dropdown('edit_product_id', $product_options, array($single_stock[0]->mid),$extra);
                          ?>           
					</div>
					<div class="form-group">
						<?php echo form_label('Manufacturing Date:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'edit_manufacturing','value'=>$single_stock[0]->manufacturing,'reqiured'=>'');
								echo form_input($data);
							
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Expiry Date:'); ?>
						<?php
								
								$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'edit_expiry','value'=>$single_stock[0]->expiry,'reqiured'=>'');

								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Quantity:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_qty','value'=>$single_stock[0]->qty,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>					
					<div class="form-group">
						<?php echo form_label('Internal Notes:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_description','value'=>$single_stock[0]->description,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_stock','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Stock');
							
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
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>