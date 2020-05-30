<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> 
    	Edit company
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
				<?php echo form_open_multipart('company/edit',$attributes); ?>
				<?php 
				  $data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_company_id','value'=>$single_company[0]->id);
				  echo form_input($data);
				 ?>
	              	<div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<h4>
	              				<label class="box-label"><b>Company basic info</b></label>
	              			</h4>
			              	<div class="col-md-5 field-agjust">	
				              <div class="form-group">	
								 <?php echo form_label('Company Name:'); ?>
								 <?php
									$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_name','value'=>$single_company[0]->customer_name,'reqiured'=>'');
									echo form_input($data);
								?>
				              </div>
				            </div>
				            <div class="col-md-5 field-agjust">	
							   <div class="form-group">
								<?php echo form_label('Company Email:'); ?>
				                <?php
									$data = array('class'=>'form-control input-lg','type'=>'email','name'=>'customer_email','value'=>$single_company[0]->cus_email,'reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              	</div>
			              	<div class="col-md-5 field-agjust" >	
							   <div class="form-group">
							     <?php echo form_label('NTN No:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_cnic','value'=>$single_company[0]->customer_nationalid,'reqiured'=>'');
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
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_address','value'=>$single_company[0]->cus_address,'reqiured'=>'');
										echo form_input($data);
							  ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							  <?php echo form_label('Company Phone:'); ?>
								<?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contatc1','value'=>$single_company[0]->cus_contact_1,'reqiured'=>'');
										echo form_input($data);
							   ?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							   <div class="form-group">
							     <?php echo form_label('Company Mobile :'); ?>
				                   <?php
										$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'customer_contact_two','value'=>$single_company[0]->cus_contact_2,'reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							   <div class="form-group">
							     <?php echo form_label('Supplier:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_company','value'=>$single_company[0]->cus_company,'reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>
			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							     <?php echo form_label('Region:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_region','value'=>$single_company[0]->cus_region,'reqiured'=>'');
										echo form_input($data);
									?>
				              </div>
			              </div>

			              <div class="col-md-5 field-agjust">	
							  <div class="form-group">
							     <?php echo form_label('Town:'); ?>
								  <?php
										$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_town','value'=>$single_company[0]->cus_town,'reqiured'=>'');
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
			               <div class="col-md-4 field-agjust ">	
							  <div class="form-group margin">
							  	<img src="<?php echo base_url('uploads/supplier/'.$single_company[0]->cus_picture); ?>" class="img-circle" width="70" height="70" name="" />
				              </div>
			              </div>
			            </div>
			        </div>			        
			        <div class="row box box-default">
	              		<div class="col-md-12 margin">
	              			<label class="box-label"><b>Company Optional Details</b></label>
			              <div class="col-md-12 field-agjust">	
							   <div class="form-group">
							   <?php echo form_label('Any Description:'); ?>
				               <?php
									$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'customer_description','value'=>$single_company[0]->cus_description,'reqiured'=>'');
									echo form_input($data);
								?>
				              </div>
			              </div>
			            </div>
			        </div>
		              <div class="col-md-5">	
						  <div class="form-group">  				
							<?php
								$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Company');
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