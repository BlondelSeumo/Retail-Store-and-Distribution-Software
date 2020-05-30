<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-money" aria-hidden="true"></i>
		Edit customer payments
	 </h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
		 <?php 
				$attributes = array('id'=>'customer_payment','method'=>'post','class'=>'form-horizontal');
		?>
		<?php echo form_open('customers/edit_customer_payments',$attributes); ?>  
			<div class="form-group">
	       		<?php echo form_label('Customer Name'); ?>
	       		<?php

	       			$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'post_id','value'=>$customer_payments[0]->id,'reqiured'=>'');
					echo form_input($data);	

                    if($customer_list != NULL)
                  {
                    foreach ($customer_list as $single_customer)
                    {
                        $customer_options[$single_customer->id] = $single_customer->customer_name;
                    } 
                  }
                  else
                  {
                    $customer_options = array(
                                    '0'  => 'No record available'
                      );
                  }

                 $extra = array(
                          'id'       => '',
                          'onChange' => '',
                          'class'=>'form-control select2'
                        );

                echo form_dropdown('customer_id', $customer_options, array($customer_payments[0]->customer_id),$extra); 
                ?>
	        </div>	          	          
	      <div class="form-group">    
			<?php
					echo form_label('Amount:');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'amount','value'=>$customer_payments[0]->amount,'reqiured'=>'');
					echo form_input($data);							
			?>           
	      </div>	  
          <div class="form-group">  
				<?php
					echo form_label('Description :');
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','value'=>$customer_payments[0]->description,'reqiured'=>'');
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