<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-money" aria-hidden="true"></i>
		Edit supplier payments
	 </h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
		 	<?php
				$attributes = array('id'=>'supplier_payment','method'=>'post','class'=>'form-horizontal');
			?>
			<?php echo form_open('supplier/edit_supplier_payments',$attributes); ?>  
				<div class="form-group">
		       		<?php echo form_label('Supplier Name'); ?>
		       		<?php
		       			$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'status_id','value'=>$supplier_payments[0]->id,'reqiured'=>'');
						echo form_input($data);	

	                    if($supplier_list != NULL)
	                  {
	                    foreach ($supplier_list as $single_supplier)
	                    {
	                        $supplier_options[$single_supplier->id] = $single_supplier->customer_name;
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
	                          'class'=>'form-control select2'
	                        );

	                echo form_dropdown('pur_supplier', $supplier_options, array($supplier_payments[0]->supplier_id),$extra); 
	                ?>
	        	</div>	          	          
			      <div class="form-group">    
					<?php
							echo form_label('Amount:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'amount','value'=>$supplier_payments[0]->amount,'reqiured'=>'');
							echo form_input($data);							
					?>           
			      </div>	  
		          <div class="form-group">  
						<?php
							echo form_label('Description :');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','value'=>$supplier_payments[0]->description,'reqiured'=>'');
							echo form_input($data);	
						 ?>	
				  </div>
				  <div class="form-group">  				
					<?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Payment');
						
						echo form_button($data);	
					 ?>    
		          </div>
				<?php echo form_close(); ?>			    		
		        </div>	
	      </div>				  
	    </div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>