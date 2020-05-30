 <!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	
	<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit medicine details</h4>
</div>
<div class="modal-body">

	<div class="row">
		<div class="box box-danger">
			<div class="box-body">
			     <button onclick="printDiv('print-section-model')" class="btn btn-default btn-lg btn-flat pull-right "><i class="fa fa-print pull-left"></i> Print 
			     </button>
				<div id="print-section-model" class="col-md-12">
					<?php
							$Edit_attributes = array('id'=>'Edit_Medicine_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('Medicine/edit',$Edit_attributes); ?>
					<div class="form-group">
						<?php
								echo form_label('Medicine Category:');
								
								$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'edit_medicine_id','value'=>$single_medicine[0]->id);
								echo form_input($data);
							

	                             if($catagory_list != NULL)
	                              {
	                                foreach ($catagory_list as $catagory)
	                                 {
	                                    $catagory_options[$catagory->id] = $catagory->category_name;
	                                 } 
	                              }
	                              else
	                              {
	                                 $catagory_options = array(
	                                                '0'  => 'No record available'
	                                  );
	                              }

	                         
	                         	 $extra = array(
	                                      'id'       => '',
	                                      'onChange' => '',
	                                      'class'=>'form-control select2'
	                                    );

	                          	echo form_dropdown('edit_category_id', $catagory_options, array($single_medicine[0]->category_id),$extra);

                          ?>           
					</div>
					<div class="form-group">
						<?php echo form_label('Brand Name:'); ?>
						<?php
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_medicine_name','value'=>$single_medicine[0]->medicine_name,'reqiured'=>'');
							echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Generic Name:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_formula_name','value'=>$single_medicine[0]->formula,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Mg:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_mg','value'=>$single_medicine[0]->mg,'reqiured'=>'');
								echo form_input($data);
							
						?>
					</div>
					<div class="form-group">
						<?php echo form_label(' Quantity:'); ?>
						<?php
								
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_quantity','value'=>$single_medicine[0]->	quantity,'reqiured'=>'');
								echo form_input($data);
							
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Company:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_company_name','value'=>$single_medicine[0]->company,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Barcode:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_barcode','value'=>$single_medicine[0]->barcode,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Min Stock:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_min_stock','value'=>$single_medicine[0]->min_stock,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
						<div class="form-group">
						<?php
								echo form_label('Medicine Supplier:');
									$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'edit_aupplier_id','value'=>$single_medicine[0]->supplier_id);
										echo form_input($data);
							
	                             if($supplier_list != NULL)
	                              {
	                                foreach ($supplier_list as $single_supplier)
	                                 {
	                                    $supplier_options[$single_supplier->id] = $single_supplier->supplier_name;
	                                 } 
	                              }
	                              else
	                              {
	                                 $supplier_options = array(
	                                                '0'  => 'No record available'
	                                  );
	                              }
	                         	 $extra = array(
	                                      'id'       => '',
	                                      'onChange' => '',
	                                      'class'=>'form-control'
	                                    );

	                          	echo form_dropdown('edit_supplier_id', $supplier_options, array($single_medicine[0]->supplier_id),$extra);
                          ?>           
					</div>
					<div class="form-group">
						<?php echo form_label('Cost Price :'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_purchase','value'=>$single_medicine[0]->purchase,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Selling Price :'); ?>
						<?php
							
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_retail','value'=>$single_medicine[0]->retail,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						
						<?php echo form_label(' Discout(%):'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_discount','value'=>$single_medicine[0]->discount,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label(' Pack Size:'); ?>
						<?php
							
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_packsize','value'=>$single_medicine[0]->packsize,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label(' SKU:'); ?>
						<?php
							
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_sku','value'=>$single_medicine[0]->sku,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label(' Location:'); ?>
						
						<?php	
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_location','value'=>$single_medicine[0]->location,'reqiured'=>'');
						?>
					</div>
					<div class="form-group">
						<?php echo form_label(' Tax:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_tax','value'=>$single_medicine[0]->tax,'reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					
					<div class="form-group">
						<?php echo form_label(' Expiry Date:'); ?>
						<?php
							
								$data = array('class'=>'form-control input-lg','type'=>'date','id'=>'Edit_datepicker','name'=>'edit_expiry_date','value'=>$single_medicine[0]->expire,'reqiured'=>'');
								echo form_input($data);
						
						?>
					</div>	
					<div class="form-group">
						
						<?php echo form_label(' Manufacturing Date:'); ?>
						<?php
							
						$data = array('class'=>'form-control input-lg','type'=>'date','id'=>'edit_manufacturing_date','name'=>'edit_manufacturing_date','value'=>$single_medicine[0]->manufacturing,'reqiured'=>'');
						echo form_input($data);
						
						?>	
					</div>
					<div class="form-group">
						
						<?php echo form_label(' Side Effects:'); ?>
						<?php
						
							$data = array('class'=>'form-control input-lg','type'=>'text','id'=>'edit_side_effects','name'=>'edit_side_effects','value'=>$single_medicine[0]->sideeffects,'reqiured'=>'');
							echo form_input($data);
						
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Description or Note:'); ?>
						<?php
							
								$data = array('class'=>'form-control input-lg','type'=>'text','id'=>'edit_description','name'=>'edit_description','value'=>$single_medicine[0]->description,'reqiured'=>'');
								echo form_input($data);
						
						?>	
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Medicine');
							
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