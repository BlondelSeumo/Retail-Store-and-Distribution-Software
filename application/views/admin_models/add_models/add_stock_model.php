<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
 	Add New Pending Stock 
</h4>
</div>
      <div class="modal-body">
		<div class="row">
         <div class="box box-danger">
           <div class="box-body">
		    <div class="col-md-12">
			<?php
					$attributes = array('id'=>'stock_items_form','method'=>'post','class'=>'form-horizontal');
			?>
			<?php echo form_open('product/add_stock_item',$attributes); ?>
			   <div class="form-group"> 
			   <?php echo form_label('Product Name:'); ?> 
				    <label >
				  		 (<a href="<?php echo base_url('product/add_new_product'); ?>">Add new </a>)
					</label>
					<select class="form-control select2" onchange="set_stock_charges()" name="item_id" id="stock_item_id" style="width: 100%;" >
						<option 
							data-packsize="0" 
							data-retail="0" 
							data-purchase="0" 
							data-packretail="0" 
							data-packpurchase="0"
							value="0"
							> Select Product </option>
						<?php
							if($product_record_list != NULL)
							{	
								foreach ($product_record_list as $single_product_list)
								{	
							?>
								    <option  data-retail="<?php echo $single_product_list->retail; ?>" data-purchase="<?php echo $single_product_list->purchase; ?>" data-packretail="<?php echo $single_product_list->whole_sale; ?>" data-packpurchase="<?php echo $single_product_list->pack_cost; ?>" data-packsize="<?php echo $single_product_list->packsize; ?>" value="<?php echo $single_product_list->id; ?>" ><?php echo 'Product '.$single_product_list->product_name.' | Weight '.$single_product_list->mg.' '.$single_product_list->unit_type.' | Quantity '.$single_product_list->quantity.
								  	  ' | Barcode '.$single_product_list->barcode.
								  	  ' | Min stock level '.$single_product_list->min_stock; ?> 
								  	</option>	 
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
			   <?php echo form_label('Manufacturing Date:'); ?>
               <?php
					$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'manufacturing','placeholder'=>'e.g 10','reqiured'=>'');
					echo form_input($data);
			  ?>
                </div>			   
                <div class="form-group">
					<?php echo form_label('Expiry Date:'); ?>
					<?php
							$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'expiry','placeholder'=>'e.g 10','reqiured'=>'');
							echo form_input($data);
					?>
                </div>			   
                <div class="form-group">
					<?php echo form_label('Packs:'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'quantity','value'=>'0','id'=>'quantity');
						echo form_input($data);
					?>
                </div> 
				<div class="form-group">
					<?php echo form_label('Cost per item:'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'cost','value'=>'0','id'=>'cost','step'=>'any');
						echo form_input($data);
					?>
                </div> 
				<div class="form-group">
					<?php echo form_label('Retail per item:'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','step'=>'any','type'=>'number','name'=>'retail','value'=>'0','step'=>'any','id'=>'retial');
						echo form_input($data);
					?>
                </div> 
				<div class="form-group">
					<?php echo form_label('Pack Retail :'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','step'=>'any','type'=>'number','name'=>'pack_retail','value'=>'0','step'=>'any','id'=>'pack_retail');
						echo form_input($data);
					?>
                </div> 
				<div class="form-group">
					<?php echo form_label('Pack Cost:'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','step'=>'any','type'=>'number','name'=>'pack_cost','value'=>'0','id'=>'pack_cost');
						echo form_input($data);
					?>
                </div>                 
                <div class="form-group">
					<?php echo form_label('Internal Notes:'); ?>
					<?php
						$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'note','placeholder'=>'any note','reqiured'=>'');
						echo form_input($data);
					?>
                </div>
			  	<div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-flat  btn-lg','type' => 'submit','name'=>'btn_submit_Item','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Stock ');					
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