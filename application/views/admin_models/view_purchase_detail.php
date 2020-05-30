<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-money" aria-hidden="true"></i>
	 	Purchase details 
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger" id="print-section-1">
        	<div class="box-body">
        		 <div class="col-md-12">
		            <div class="pull pull-right margin">
		                <button onclick="printDiv('print-section-1')" class="btn btn-default btn-sm btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report</button>
		            </div>
		        </div>
	         	<div class="col-md-12">
	         		<table class="table table-bordered table-striped">
	         			<tr>
	         				<td>Invoice No</td>
	         				<td><?php echo $single_purchase[0]->invoice_id; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Date</td>
	         				<td><?php echo $single_purchase[0]->date; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Supplier</td>
	         				<td>
	         				<?php 
	         					echo $this->db->get_where('mp_payee', array('id' =>$single_purchase[0]->supplier_id))->result_array()[0]['customer_name'] ; 
	         				?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Total</td>
	         				<td><?php echo $single_purchase[0]->total_bill; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Amount</td>
	         				<td><?php echo $single_purchase[0]->total_paid; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Balance</td>
	         				<td><?php echo $single_purchase[0]->total_bill - $single_purchase[0]->total_paid; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Method</td>
	         				<td><?php echo $single_purchase[0]->payment_type_id; ?></td>
	         			</tr>	
	         			<tr>
	         				<td>Payment date</td>
	         				<td><?php echo $single_purchase[0]->payment_date; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Status</td>
	         				<td>
	         					<?php 
	         						if($single_purchase[0]->status == 0)
         							{
         								echo "Purchased";
         							}
         							else
         							{
         							 	echo "Purchased Return";	
         							} 
	         					?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Store</td>
	         				<td>
	         				<?php 
	         					echo $this->db->get_where('mp_stores', array('id' =>$single_purchase[0]->store))->result_array()[0]['name'] ; 
	         				?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Description</td>
	         				<td><?php echo $single_purchase[0]->description; ?></td>
	         			</tr>
	         		</table>			    		
	        	</div>
				<div class="col-md-12">
					<table class="table table-bordered table-striped">
						<tr>
							<th>Name</th>
							<th>Weight</th>
							<th>Packs</th>
							<th>Cost</th>
							<th>Retail</th>
							<th>Pack Cost</th>
							<th>Pack Retail</th>		 
						</tr>	
						<tr>
						<?php
							if($purchase_list != NULL)
							{
								foreach($purchase_list as $single_purchase)
								{
						?>	
									<tr>
										<td><?php echo $single_purchase->product_name; ?></td>
										<td><?php echo $single_purchase->mg.' '.$single_purchase->unit_type; ?></td>
										<td><?php echo $single_purchase->qty; ?></td>
										<td><?php echo $single_purchase->cost; ?></td>
										<td><?php echo $single_purchase->retail; ?></td>
										<td><?php echo $single_purchase->pack_cost; ?></td>
										<td><?php echo $single_purchase->pack_retail; ?></td>	 
									</tr>		
						<?php			
								}		
							}
						?>
						</tr>		 
					</table>				 
				</div>	
     		</div>				  
		</div>
	</div>
</div>
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>