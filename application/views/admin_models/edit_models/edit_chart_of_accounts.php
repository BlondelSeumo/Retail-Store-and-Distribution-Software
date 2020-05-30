<!-- Select2 -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Head
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'expense_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open('accounts/edit_charts',$attributes); ?>			
					<div class="form-group">
						<?php echo form_label('Account Name:'); ?>
						<?php			
								$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'name','value'=>$head_data[0]->name,'reqiured'=>'');
								echo form_input($data);			
						?>
					</div>
					<div class="form-group">
						<?php 
								$data = array('class'=>'form-control','type'=>'hidden','name'=>'head_id','value'=>$head_data[0]->id);
										echo form_input($data);
						 ?>
						<label>Nature:</label>				
							<?php
								
                                $head_options = array(
                                    'Assets'  => 'Assets',
                                    'Libility'  => 'Libility',
                                    'Equity'  => 'Equity',
                                    'Expense'  => 'Expense',
                                    'Revenue'  => 'Revenue'
                                 );
	                           
	                         	$extra = array(
	                                      'id'       => 'nature_id',
	                                      'onChange' => '',
	                                      'class'=>'form-control input-lg '

	                                    );
	                          	echo form_dropdown('edit_nature', $head_options, array($head_data[0]->nature),$extra);
							?>	
					</div>
					<div class="form-group">
						<label>Type: </label>				
							<?php
								
                                $type_options = array(
                                    'Current'  => 'Current',
                                    'Non-Current'  => 'Non-Current'
                                 );
	                           
	                         	$extra = array(
	                                      'id'       => '',
	                                      'onChange' => '',
	                                      'class'=>'form-control input-lg'
	                                    );
	                          	echo form_dropdown('edit_type', $type_options, array($head_data[0]->type),$extra);
							?>	
					</div>
					<div class="form-group" style="display: <?php echo ($head_data[0]->nature == "Expense" ? "block" : "none"); ?> "  id="expense-type-id">
						<label>Expense Type: </label>				
							<?php
                                $type_expense = array(
                                    'Cash Expense' 		=> 'Cash Expense',
                                    'Non-Cash Expense'  => 'Non-Cash Expense',
                                    'Goods Expense'  	=> 'Goods Expense'
                                 );
	                         	$extra = array(
	                                      'id'       => '',
	                                      'onChange' => '',
	                                      'class'=>'form-control input-lg'
	                                    );
	                          	echo form_dropdown('expense_type', $type_expense, array($head_data[0]->expense_type),$extra);
							?>	
					</div>
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-pencil" aria-hidden="true"></i> Update Head');
							echo form_button($data);
						?>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#nature_id").on("change", function() 
	{
		var value = $('#nature_id').val();
		if(value == 'Expense')
		{
			$('#expense-type-id').css('display','block');
		}
		else
		{
			$('#expense-type-id').css('display','none');
		}
	});
</script>