<div class="col-md-6 set-no-padding">
 <table class="table table-striped table-bordered table_height_set">
    <thead>
        <tr> 
            <th>Item</th>
            <th>Weight</th>
            <th>W-Sale</th>
            <th>Packs</th>
            <th>Qty</th>
            <th>Discount(%)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
 <?php    
    $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency']; 
    $total_tax = 0;  
    $total_gross = 0;
    $single_tax = 0; 
    $total_discount = 0; 
   
if($temp_data != NULL)
{
    foreach ($temp_data as $single_val) 
    {
        $total_discount = $total_discount + ((($single_val->price * $single_val->pack) / 100) * $single_val->discount);
        
        $sub_total_tax = $single_val->qty * $single_val->tax;
        $total_tax = number_format($total_tax + $sub_total_tax,3,'.','');
        $total_gross = number_format($total_gross+($single_val->price*$single_val->pack),3,'.','');
 ?>
    <tr > 
        <td><?php echo $single_val->product_name; ?></td>
        <td><?php echo $single_val->mg.' '.$single_val->unit_type; ?></td>
         <td>
            <input type="number" onkeyup="amend_amount(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" step="any" value="<?php echo $single_val->price; ?>" name="supply_amount" id="supply_amount">
        </td>   
         <td>
            <input type="number" onkeyup="amend_qty(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" value="<?php echo $single_val->pack; ?>" name="supply_qty" id="supply_qty" />
        </td>         
        <td>
            <?php echo $single_val->qty; ?>
        </td>
        <td>
            <input type="number" step="any"  class="supply_fields" value="<?php echo $single_val->discount; ?>" name="discount_offered" onkeyup="amend_discount(this.value,'<?php echo $single_val->id; ?>')" id="discount_offered">
        </td>
        <td >
            <a onclick="delete_item('<?php echo $single_val->id; ?>')" ><i class="fa fa-trash margin" aria-hidden='true'></i>
            </a>  
        </td>
    </tr>
     <?php 
       } 
    } 
      ?> 
    </tbody>
 </table>  
</div>
<div class="col-md-6">
        <div class="row total-grid-values">
            <div class="col-md-4 col-sm-12 col-xs-12">
                Gross Total (<?php echo $currency; ?>) :
                <input type="number" name="total_gross_amt" id="total_gross_amt" disabled="disabled" class=" amount-box  text-center outline-cls" value="<?php echo $total_gross; ?>" />
            </div>    
            <div class="col-md-4 col-sm-12 col-xs-12">
                Tax Total (<?php echo $currency; ?>): 
                <input type="number" class=" amount-box text-right outline-cls" name="total_tax_amt" id="total_tax_amt" disabled="disabled" value="<?php echo $total_tax; ?>" />
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                Total Bill (<?php echo $currency; ?>):
                <input disabled="disabled" type="number" name="gross_total_bill" id="gross_total_bill" class=" amount-box  text-center" value="<?php echo number_format($total_tax+$total_gross,'3','.',''); ?>" />
               
            </div>
        </div> 
        <div class="row total-grid-values">            
            <div class="col-md-4 col-sm-12 col-xs-12">
                Discount (<?php echo $currency; ?>) :
                <input type="number"  name="discountfield" id="discountfield" step="any" class=" amount-box text-right" value="<?php echo number_format($total_discount,'3','.',''); ?>" />
            </div>  
            <div class="col-md-4 col-sm-12 col-xs-12">
                Total (after dis)  (<?php echo $currency; ?>):
               <h4 class="" id="net_amount"> <?php echo number_format(($total_tax+$total_gross)-$total_discount,'3','.',''); ?>
               </h4>
                <input type="hidden" id="net_total_amount_input" name="total_bill" step="any" value="<?php echo number_format(($total_tax+$total_gross)-$total_discount,'3','.',''); ?>" />
                  
            </div>
        </div>        
         <div class="row row-buttons text-center ">
                <button  type="button" onclick="clear_invoice()" class="btn btn-primary btn-lg btn-flat btn-left-side-invoice"> 
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>  NEW ORDER
                </button>                    
                 <button  type="submit" id="submit_btn" class="btn btn-danger btn-lg btn-flat btn-left-side-invoice"> 
                   <i class="fa fa-floppy-o" aria-hidden="true"></i>  SAVE ORDER
                </button> 
         </div>
    </div>
</div>
<?php $this->load->view('ajax/order_item_script_ajax.php'); ?>

<script type="text/javascript">
    $('#payment_id').change(function(){
    var method = $('#payment_id').val();
    if(method == 1)
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