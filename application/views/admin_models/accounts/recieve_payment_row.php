<div class="col-md-12 table-responsive">
<h3>Outstanding Transactions</h3>
   <table class="table table-striped table-hover  ">
       <thead class="purchase-heading">
        <tr>
           <td class="col-md-4 ">Description</td>
           <td class="col-md-2 ">Due date</td>
           <td class="col-md-2 ">Total</td>
           <td class="col-md-2 ">Amount due</td>
           <td class="col-md-2 ">Payment</td>
       </tr>
       </thead>
       <tbody   >
          <?php 
            foreach ($invoice_list as $single_invoice) 
            {
          ?>
          <tr>
             <td>
                <a href="javascript:void(0)">  Invoice # <?php echo $single_invoice->id.' ('.$single_invoice->date.')'; ?> </a>
             </td>                                     
              <td>
                 <?php echo $single_invoice->due_date; ?>
             </td>
             <td>
                  <?php echo $single_invoice->total_bill-$single_invoice->total_paid; ?>
             </td>     
             <td>
                  <?php echo $single_invoice->total_bill; ?>
             </td>      
             <td>
                <input type="number" value="0" class="form-control  total_payment_received" name="payments[]" step="any" /> 

                <input type="hidden" value="<?php echo $single_invoice->id; ?>" name="invoice_id[]"  />
             </td>   
          </tr>
          <?php
            } 
          ?>
       </tbody>
       <tfoot>                    
          <tr>
               <td colspan="5">
                  <button type="button" onclick="clearalllines()" class="btn btn-primary btn-add-setting pull-right" name="addline" onclick="add_new_row('<?php echo base_url().'expense/popup/new_bill_row';?>')"> <i class="fa fa-trash"></i>    Clear payment 
                  </button>
               </td>
           </tr>                   
         </tfoot>
   </table>
</div>