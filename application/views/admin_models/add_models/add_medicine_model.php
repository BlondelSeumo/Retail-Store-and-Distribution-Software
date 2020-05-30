<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Add New Medicine
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'Medicine_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('medicine/add_medicine',$attributes); ?>				
					<div class="form-group">
						<label>Medicine Category: <a onclick="show_modal_page('<?php echo base_url();?>category/popup/add_category_model')" href="#"> (add category)</a></label>				
						<select class="form-control select2" name="category_id" id="category_id"  style="width: 100%;">
							<?php
							//category_names from mp_category table;
							if($catagory_list != NULL)
							{		
									foreach ($catagory_list as $obj_catagory_list){
							?>
							<option value="<?php echo $obj_catagory_list->id; ?>" ><?php echo $obj_catagory_list->category_name; ?> </option>
							
							<?php
									}
								}
								else
								{
									echo "No Record Found";
								}
							?>	
						</select>
					</div>
					<div class="form-group">
						<?php echo form_label('Brand Name:'); ?>
						<?php
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'medicine_name','placeholder'=>'Enter your Medicine Name','reqiured'=>'');
							echo form_input($data);
						?>	
					</div>
					<div class="form-group">
						<?php echo form_label('Generic Name:'); ?>
						<?php			
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'formula_name','placeholder'=>'e.g Paracetamol','reqiured'=>'');
								echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Medicine Mg:'); ?>
						<?php				
								$data = array('class'=>'form-control input-lg','type'=>'number','id'=>'medicine_mg','name'=>'medicine_mg','placeholder'=>'e.g 250','reqiured'=>'');
								echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Medicine quantity:'); ?>
						<?php				
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'quantity','placeholder'=>'e.g 10','reqiured'=>'');
								echo form_input($data);				
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Medicine Company:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'company_name','placeholder'=>'e.g gsk','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Barcode'); ?>
						<?php
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'barcode','placeholder'=>'e.g 000025444255658','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Minimum stock :'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'min_stock','placeholder'=>'e.g 20','reqiured'=>'');
								echo form_input($data);
						?>
						<small>Use to give alert when stock level is less then this</small>
					</div>
					<div class="form-group">	
						<label> Supplier: <a onclick="show_modal_page('<?php echo base_url();?>supplier/popup/add_supplier_model')" href="#"> (add supplier)</a></label>					
						<select class="form-control select2" name="supplier_id" id="supplier_id"  style="width: 100%;">
							<?php
							//category_names from mp_category table;
							if($supplier_list != NULL)
							{		
									foreach ($supplier_list as $single_supplier){
							?>
							<option value="<?php echo $single_supplier->id; ?>" ><?php echo $single_supplier->supplier_name; ?> </option>
							
							<?php
									}
								}
								else
								{
									echo "No Record Found";
								}
							?>	
						</select>
					</div>
					<div class="form-group">
						<?php echo form_label('Cost Price:'); ?>
						<?php				
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'purchase','placeholder'=>'e.g 150','step'=>'any','reqiured'=>'');
								echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Selling Price:'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'retail','placeholder'=>'e.g 200','step'=>'any','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Discount Offer(%)'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'discount','placeholder'=>'e.g 10','step'=>'any','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Pack Size'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'packsize','placeholder'=>'e.g Enter pack size','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('SKU'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'sku','placeholder'=>'Enter SKU','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Part Location in shop'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'location','placeholder'=>'Top right corner','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Sales Tax (%)'); ?>
						<?php
								$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'tax','placeholder'=>'e.g 12','step'=>'any','reqiured'=>'');
								echo form_input($data);
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Medicine Expiry Date:'); ?>
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'date','id'=>'datepicker','name'=>'expiry_date','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Medicine Manufacturing Date:'); ?>
						<?php
											
							$data = array('class'=>'form-control input-lg','type'=>'date','id'=>'manufacturing','name'=>'manufacturing_date','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Side Effects:'); ?>
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'text','id'=>'sideeffects','name'=>'side_effects','placeholder'=>'e.g Side Effects','reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Internal Notes:'); ?>
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'text','id'=>'description','name'=>'description','placeholder'=>'e.g Any description or note','reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Medicine');
							
							echo form_button($data);
						?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Select2 -->
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>