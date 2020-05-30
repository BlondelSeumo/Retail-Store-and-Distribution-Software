<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> 
		Add New Head
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'chart_of_accounts_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open($link,$attributes); ?>		
					<div class="form-group">
						<?php echo form_label('Account Name:'); ?>
						<?php			
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'name','placeholder'=>'e.g Cash','reqiured'=>'');
								echo form_input($data);			
						?>
					</div>			
					<div class="form-group">
						<label>Nature:</label>				
						<select class="form-control select2 input-lg" onchange="visible_expense(this.value)" name="nature" id="nature"  style="width: 100%;">
								<option value="Assets" >Assets</option>
								<option value="Libility" >Libility</option>
								<option value="Equity" >Equity</option>
								<option value="Expense" >Expense</option>
								<option value="Revenue" >Revenue</option>
						</select>
					</div>					
					<div class="form-group">
						<label>Type :</label>				
						<select class="form-control select2 input-lg" name="type" id="type"  style="width: 100%;">
								<option value="Current" >Current</option>
								<option value="Non-Current" >Non-Current</option>
						</select>
					</div>
					<div class="form-group" id="expense-type-id">
						<label>Expense Type :</label>		
						<select class="form-control select2 input-lg" name="expense_type" id="expense_type" >
							<option value="Cash Expense" >Cash Expense</option>
							<option value="Non-Cash Expense" >Non-Cash Expense</option>
							<option value="Goods Expense" >Goods Expense</option>
							<option value="Bank Expense" >Bank Expense</option>
						</select>
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Head ');
							
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
<script type="text/javascript">
	//USED TO VISIBLE EXPENSE TYPE 
	function visible_expense(value)
	{
		if(value == 'Expense')
		{
			$('#expense-type-id').css('display','block');
		}
		else
		{
			$('#expense-type-id').css('display','none');
		}
		
	}
</script>