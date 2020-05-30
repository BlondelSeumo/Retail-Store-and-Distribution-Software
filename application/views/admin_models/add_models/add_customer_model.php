<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 		Add new customer
    </h4>
</div>  
<div class="modal-body">
	<div class="row">
        <div class="">
            <div class="box-body">
              <div class="col-md-12">
				<?php
					$attributes = array('id'=>'Customer_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open_multipart($link,$attributes); ?>
	              	<div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              			<label class="box-label"><b>CUSTOMER BAISC INFO</b></label>
	              			</h4>
			              	<div class="col-md-5 field-agjust">	
				              <div class="form-group">	
								 <?php echo form_label('Customer Name:'); ?>
								  <?php
									$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_name','placeholder'=>'Enter your Customer Name','reqiured'=>'');
									echo form_input($data);
								?>
				              </div>
				            </div>
				            <div class="col-md-5 field-agjust">	
							   <div class="form-group">
								<?php echo form_label('Customer Email:'); ?>
				                <?php
								$data = array('class'=>'form-control input-lg','type'=>'email','name'=>'customer_email','placeholder'=>'e.g Shop@gmail.com','reqiured'=>'');
										echo form_input($data);
								
									?>
				              </div>
			              	</div>
			              	<div class="col-md-5 field-agjust" >	
							   <div class="form-group">
							     <?php echo form_label('National ID No:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_cnic','placeholder'=>'e.g 5248222154','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							     <?php echo form_label('Type:'); ?>
								  <select name="customer_type" class="form-control input-lg">
								  	<option value="Regular"> Regular</option>
								  	<option value="Visitor" > Visitor</option>
								  </select>
				              </div>
			              </div>
		              </div>
	              </div>
	              	<div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              				<label class="box-label"><b>CUSTOMER ADDRESS DETAILS</b></label>
	              			</h4>
			              	<div class="col-md-5 field-agjust">	
							   <div class="form-group">
							   <?php echo form_label('Customer Address:'); ?>
				               <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_address','placeholder'=>'e.g 11th Commercial Street DHA ,Karachi','reqiured'=>'');
										echo form_input($data);
							  ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							  <?php echo form_label('Customer Phone:'); ?>
								<?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contatc1','placeholder'=>'e.g 00659855487','reqiured'=>'');
										echo form_input($data);
							   ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							   <div class="form-group">
							     <?php echo form_label('Customer Mobile :'); ?>
				                   <?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contact_two','placeholder'=>'e.g 00659855487','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							   <div class="form-group">
							     <?php echo form_label('Company:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_company','placeholder'=>'e.g Pepsico','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							     <?php echo form_label('Region:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_region','placeholder'=>'e.g Istanbol','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>

			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							     <?php echo form_label('Town:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_town','placeholder'=>'e.g ','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			            </div>
			        </div>
			        <div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              			  <label class="box-label"><b>CUSTOMER IMAGE</b></label>
	              			</h4>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
				                <label>Upload Customer Picture (Optional)</label>
									 <div class="input-group">
				                
				          		<input type="file" name="customer_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
				                </div>
				              </div>
			              </div>
			            </div>
			        </div>			        
			        <div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<label class="box-label"><b>CUSTOMER OPTIONAL DETAILS</b></label>
			              <div class="col-md-12 field-agjust">	
							   <div class="form-group">
							   <?php echo form_label('Any Description:'); ?>
				               <?php
									$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_description','placeholder'=>'e.g extra information about customer ','reqiured'=>'');
									echo form_input($data);
								?>
				              </div>
			              </div>
			            </div>
			        </div>

	              <div class="col-md-5">	
					  <div class="form-group">  				
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Customer');
							
							echo form_button($data);
						 ?>   
	             	 </div>
             	 </div>
						<?php echo form_close(); ?>
        		</div>
			</div>
 		</div>
	</div>
</div>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>