<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Bank</h4>
</div>
<div class="modal-body">
   <div class="row">
	  	<div class="box box-danger">
		    <div class="box-body">
		     	<div class="col-md-12">
			 	<?php
					$Edit_attributes = array('id'=>'bank_form','method'=>'post','class'=>'form-horizontal');
				?>
				<?php echo form_open('bank/edit/',$Edit_attributes); ?>	  
			      <div class="form-group">    
					<?php
							echo form_label('Bank Name:');
							$data = array('class'=>'form-control ','type'=>'hidden','name'=>'bank_id','value'=>$bank_list[0]->id);
							echo form_input($data);	
							$data = array('class'=>'form-control input-lg','type'=>'text','value'=>$bank_list[0]->bankname,'name'=>'bankname');
							echo form_input($data);									
					?>          
			      </div>	
			      <div class="form-group">    
					<?php
							echo form_label('Branch Name:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'branch','value'=>$bank_list[0]->branch);
							echo form_input($data);						
					?>           
			      </div>			      
			      <div class="form-group">    
					<?php
							echo form_label('Branch Code:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'branchcode','value'=>$bank_list[0]->branchcode);
							echo form_input($data);						
					?>           
			      </div>			      
			      <div class="form-group">    
					<?php
							echo form_label('Account Title:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'title','value'=>$bank_list[0]->title);
							echo form_input($data);						
					?>           
			      </div>			      
			      <div class="form-group">    
					<?php
							echo form_label('Account Number:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'accountno','value'=>$bank_list[0]->accountno);
							echo form_input($data);						
					?>           
			      </div>
				  <div class="form-group">  				
			         <?php
						$data = array('class'=>'btn btn-info btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Bank ');
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