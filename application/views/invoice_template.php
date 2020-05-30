<div class="col-md-6 set-no-padding">
 <table class="table table-striped table-bordered table_height_set">
    <thead>
        <tr> 
            <th>Item</th>
            <th>Weight</th>
            <th>Price</th>
            <th >Qty</th>
            <th>Discount(%)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
 <?php   
    $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
    $total_tax   = 0;  
    $total_gross = 0;
    $single_tax  = 0; 
    $total_discount = 0;
    $total_cost = 0;

if($temp_data != NULL)
{

    foreach ($temp_data as $single_val) 
    {
       
        $total_cost = $total_cost +  ($single_val->purchase * $single_val->qty); 
        
        $total_discount = $total_discount + ((($single_val->price * $single_val->qty) / 100) * $single_val->discount);

        $sub_total_tax = $single_val->qty * $single_val->tax;

        $total_tax = number_format($total_tax + $sub_total_tax,3,'.','');

        $total_gross = number_format($total_gross+($single_val->price*$single_val->qty),3,'.','');
 ?>
    <tr > 
        <td><?php echo $single_val->product_name; ?></td>
        <td><?php echo $single_val->mg.' '.$single_val->unit_type; ?></td>
        <td><?php echo $single_val->price; ?></td>
         <td>
            <input type="number"  onkeyup="amend_qty(this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" value="<?php echo $single_val->qty; ?>" name="supply_qty" id="supply_qty">
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
                Discount (<?php echo $currency; ?>) :
               <input type="number" readonly name="discountfield" id="discountfield" step="any" class=" amount-box text-right" value="<?php echo number_format($total_discount,'3','.',''); ?>" />
            </div>  
        </div> 
        <div class="row total-grid-values">
            <div class="col-md-4 total_amount_area">
                <div class="">
                    <p > Total Amount (<?php echo $currency; ?>) </p>
                    <h4  id="net_total_amount"> <?php echo number_format(($total_tax+$total_gross)-$total_discount,'3','.',''); ?>
                    </h4>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                Bill Paid (<?php echo $currency; ?>):
                <input type="number" name="bill_paid" id="bill_paid" class="text-center pos_box" step="any" value="<?php echo ($total_tax+$total_gross)-$total_discount; ?>" />
                <input type="hidden" name="total_bill" id="total_bill"  value="<?php echo $total_tax+$total_gross; ?>" />
                <input type="hidden" name="bill_cost" id="bill_cost" class=" text-center" value="<?php echo number_format($total_cost,'3','.',''); ?>" />
            </div> 
        </div>        
         <div class="row total_amount_area_row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                   Cash Recieved :
                    <input type="number" onkeyup="amount_refund(this.value)" name="amount_recieved" id="amount_recieved" class=" text-center pos_box" value="0" />
                </div>            
                <div class="col-md-4 col-sm-12 col-xs-12  ">
                    Cash Refund : 
                    <span id="cash_given_to_customer">0</span> 
                </div> 
         </div>
         <div class="row row-buttons text-center">
                <button  type="button" onclick="clear_invoice()" class="btn btn-primary btn-lg btn-flat btn-left-side-invoice"> 
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>  NEW INVOICE
                </button>                    
                <a href="<?php echo base_url('return_items');?>"  class="btn btn-warning btn-lg btn-flat btn-left-side-invoice" > 
                  <i class="fa fa-arrow-left" aria-hidden="true"></i>  RETURN ITEMS
                </a>
                 <button type="submit"  id="submit_btn" class="btn btn-danger btn-lg btn-flat btn-left-side-invoice"> 
                   <i class="fa fa-floppy-o" aria-hidden="true"></i>  SAVE AND PRINT
                </button> 
         </div>
    </div>
</div>
<script type="text/javascript">
    //USED TO DELETE AN ITEM FROM DATABASE TEMP TABLE
    function delete_item(item_id)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url:'<?php echo base_url('invoice/delete_item_temporary/'); ?>'+item_id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');

            }
        });

        $('#barcode_scan_area').focus();
    }

    var discounttimmer;
    //USED TO CALCUATE DISCOUNT AMOUT
    function checkDiscount(dis_amt)
    {

          clearTimeout(discounttimmer);
          discounttimmer = setTimeout(function callback(){
           var total_gross_amt =  $('#total_gross_amt').val();
           var total_tax_amt   =  $('#total_tax_amt').val();
            if(dis_amt > 0)
            {
               var newamt = parseFloat(total_gross_amt-dis_amt)+parseFloat(total_tax_amt); 
               $('#net_total_amount').html(newamt.toFixed(3));
               $('#bill_paid').val(newamt.toFixed(3));
               $('#total_bill').val(newamt.toFixed(3));
            }
            else
            {   
                var pre_val =  parseFloat(total_gross_amt)+parseFloat(total_tax_amt);
                 $('#net_total_amount').html(pre_val.toFixed(3));
                 $('#bill_paid').val(pre_val.toFixed(3));
                 $('#total_bill').val(pre_val.toFixed(3));
            }
          },500)
    }

    //USED TO CALCULATE HOW MUCH AMOUNT SHOULD RETURN TO CUSTOMER
    function amount_refund(amt)
    {
        var netamt =  $('#net_total_amount').html();

        var cash_given = amt-parseFloat(netamt);
        $('#cash_given_to_customer').html(cash_given.toFixed(3));
    }

    //USED TO OPEN CUSTOMER PAYMENT MODEL 
    function open_payment_model()
    {
        var cus_id = $('#customer_id').val();
        show_modal_page('<?php echo base_url('invoice/popup/add_customer_payment_pos_model/');?>'+cus_id)
    }
</script>