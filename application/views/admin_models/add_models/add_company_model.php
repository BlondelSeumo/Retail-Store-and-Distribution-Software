<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
    	Add new company
    </h4>
</div>  
<div class="modal-body">
	<div class="row">
        <div class="">
            <div class="box-body">
              <div class="col-md-12">
				<?php
					$attributes = array('id'=>'company_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open_multipart('company/add_company',$attributes); ?>
	              	<div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              			<label class="box-label"><b>Company Basic Info</b></label>
	              			</h4>
			              	<div class="col-md-5 field-agjust">	
				              <div class="form-group">	
								 <?php echo form_label('Company Name:'); ?>
								  <?php
									$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_name','placeholder'=>'e.g Nestle','reqiured'=>'');
									echo form_input($data);
								?>
				              </div>
				            </div>
				            <div class="col-md-5 field-agjust">	
							   <div class="form-group">
								<?php echo form_label('Company Email:'); ?>
				                <?php
								$data = array('class'=>'form-control input-lg','type'=>'email','name'=>'customer_email','placeholder'=>'e.g Pencil@gmail.com','reqiured'=>'');
										echo form_input($data);
								
									?>
				              </div>
			              	</div>
			              	<div class="col-md-5 field-agjust" >	
							   <div class="form-group">
							     <?php echo form_label('NTN No:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_cnic','placeholder'=>'e.g 5248222154-8','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
		              </div>
	              </div>
	              	<div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              				<label class="box-label"><b>Company address details</b></label>
	              			</h4>
			              	<div class="col-md-5 field-agjust">	
							   <div class="form-group">
							   <?php echo form_label('Company Address:'); ?>
				               <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_address','placeholder'=>'e.g 11th Commercial Street ,Gilgit','reqiured'=>'');
										echo form_input($data);
							  ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							  <?php echo form_label('Company Phone:'); ?>
								<?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contatc1','placeholder'=>'e.g 00659855487','reqiured'=>'');
										echo form_input($data);
							   ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							   <div class="form-group">
							     <?php echo form_label('Company Mobile :'); ?>
				                   <?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contact_two','placeholder'=>'e.g 00659855487','reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			            </div>
			        </div>
			        <div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              			  <label class="box-label"><b>Company Logo</b></label>
	              			</h4>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
				                <label>Upload Company Logo (Optional)</label>
									 <div class="input-group">
				                
				          		<input type="file" name="customer_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
				                </div>
				              </div>
			              </div>
			            </div>
			        </div>			        
			        <div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<label class="box-label"><b>Company optional details</b></label>
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
							$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Company');
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