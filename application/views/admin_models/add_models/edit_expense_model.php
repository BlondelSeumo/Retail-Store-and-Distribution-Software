<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Expense
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'add_expense_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('expense/edit_expense',$attributes); ?>				
					<div class="form-group">
						<label>Select Expense: </label>				
						<select class="form-control select2" name="head_id" id="head_id"  style="width: 100%;">
							<?php
							//category_names from mp_category table;
							if($head_list != NULL)
							{		
								foreach ($head_list as $single_head_list)
								{
							?>
									<option <?php echo ($head_list[0]->id == $single_head_list->id ? 'selected' : ''); ?> value="<?php echo $single_head_list->id; ?>" ><?php echo $single_head_list->name; ?> 
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
						<label>Select Payee: </label>				
						<select class="form-control select2" name="payee_id" id="payee_id"  style="width: 100%;">
							<?php
							//category_names from mp_category table;
							if($payee_list != NULL)
							{		
								foreach ($payee_list as $single_payee)
								{
							?>
									<option <?php echo ($payee_list[0]->id == $single_payee->id ? 'selected' : ''); ?> value="<?php echo $single_payee->id; ?>" ><?php echo $single_payee->customer_name; ?> 
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
						<label>Payment Method: </label>	
							<select class="form-control input-lg " name="payment_id" id="payment_id"  style="width: 100%;">
								<option <?php echo ($single_expense[0]->method == 'Cash' ? 'selected' : ''); ?> value="Cash" > Cash </option>
								<option <?php echo ($single_expense[0]->method == 'Cheque' ? 'selected' : ''); ?> value="Cheque" > Cheque </option>
							</select>
					</div>
					<div class="bank-section-details">
						<div class="form-group ">
							<label>Bank account: </label>				
							<select class="form-control select2" name="bank_id" id="bank_id"  style="width: 100%;">
								<option value="0"> Bank account</option>
								<?php
								//category_names from mp_category table;
								if($bank_list != NULL)
								{		
									foreach ($bank_list as $single_bank)
									{
								?>
									<option <?php echo ($single_expense[0]->method == $single_bank->id ? 'selected' : ''); ?> value="<?php echo $single_bank->id; ?>" ><?php echo $single_bank->bankname.' | TITLE '.$single_bank->title.' | Account '.$single_bank->accountno.' | Branch '.$single_bank->branch.' | Code '.$single_bank->branchcode; ?> 
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
							<h5>Available balance PKR <b id="available_balance"> 0 </b></h5>
						</div>
						<div class="form-group " id="bank-cheque-no">
							<?php echo form_label('Cheque No:'); ?>
							<?php				
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'ref_no','value'=>$single_expense[0]->method);
								echo form_input($data);				
							?>
							<?php				
								$data = array('type'=>'hidden','id'=>'save_available_balance','name'=>'save_available_balance','value'=>'0','reqiured'=>'');
								echo form_input($data);				
							?>
						</div>
					</div>
					<div class="form-group">
						<?php echo form_label('Bill Total:'); ?>(<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>)
						<?php			
							$data = array('class'=>'form-control input-lg','type'=>'text','step'=>'any','name'=>'bill_total','value'=>$single_expense[0]->total_bill,'reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Bill Paid:'); ?>(<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>)
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'number','id'=>'bill_paid','name'=>'bill_paid','step'=>'any','value'=>$single_expense[0]->total_paid,'reqiured'=>'');
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Payment Date:'); ?>
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','value'=>$single_expense[0]->date);
							echo form_input($data);				
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Description:'); ?>
						<?php				
							$data = array('class'=>'form-control input-lg','type'=>'text','id'=>'description','name'=>'description','placeholder'=>'e.g Any description','value'=>$single_expense[0]->description);
							echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Expense');
							
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

$('#payment_id').change(function(){
	var method = $('#payment_id').val();
	if(method == 'Cheque')
	{
		$('.bank-section-details').css('display','block');
	}
	else
	{
		$('.bank-section-details').css('display','none');
	}
});

$('#bank_id').change(function(){
	var bank_id = $('#bank_id').val();


	if(bank_id != 0)
	{
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('bank/check_available_balance/'); ?>'+bank_id,
            success: function(response)
            {
                $('#available_balance').html(response);
                $('#save_available_balance').val(response);
            }
        });

		$('#bank-cheque-no').css('display','block');
	}
});
</script>