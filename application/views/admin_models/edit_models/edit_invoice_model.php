<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
   Edit invoice
</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="box box-primary">
           <div class="box-body">
                <div class="col-md-12">
        		<?php
                    $attributes = array('id'=>'invoice_form','method'=>'post','class'=>'form-horizontal');
                ?>
            <?php echo form_open('invoice/edit_invoice',$attributes); ?>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <b>
            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
            </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Phone : </b><?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['phone_number'] ;?>
               </b>
            </div>
             <?php
            if($invoice_data[0]->cus_id != 0)
            {
               $customer_arr =  $this->db->get_where('mp_payee', array('id' => $invoice_data[0]->cus_id))->result_array();
               if($customer_arr != NULL)
               {   
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Bill To : <?php echo $customer_arr[0]['customer_name'];  ?></b>
            </div>            
            <?php        
                }
             }
             ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> Invoice # <?php echo $invoice_data[0]->order_id; ?> </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <b>  Agent : </b><?php echo $invoice_data[0]->agentname; ?>
            </div> 
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Invoice Date : </b> <?php echo $invoice_data[0]->date; ?>
            </div>
             <div class="col-md-12 col-sm-12 col-xs-12">
                 <b >
                    <?php

                       if($invoice_data[0]->status == 1){

                           ?>
                           <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                           <?php
                          echo "Editted";
                      } 
                      ?>
                </b>    
            </div>
            </div>
            <div style="margin-top: 6%;" class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Sku</th>
                                <th>Item</th>
                                <th>Weight</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Discount(%)</th>
                               
                            </tr>
                        </thead>
                      <tbody>
                    <?php
                    $counter = 0;
                    $total = 0;
                    $total_tax = 0; 
                    $total_discount = 0; 
       
                    while( $counter < count($invoice_data))
                    {
                        $total_discount = $total_discount + $invoice_data[$counter]->discount;

                        $subtotal = 0;
                        $subtotal = $invoice_data[$counter]->price*$invoice_data[$counter]->qty;
                        $total = $total+$subtotal;
                        $total_tax += ($subtotal/100)*$invoice_data[$counter]->tax;


                    ?>
                        <tr style="border-bottom:2px solid #ccc;">
                            <input type="hidden"  class="form-control no-border  " value="<?php echo $invoice_data[$counter]->id; ?>" name="edit_sales_id[]" />
                            <input type="hidden"  class="form-control no-border  " value="<?php echo $invoice_data[$counter]->product_id; ?>" name="edit_product_id[]" />
                            <td>
                                <?php echo $counter+1; ?>
                            </td>
                            <td>
                                <?php echo $invoice_data[$counter]->product_no; ?>
                            </td>
                            <td>
                                <?php echo $invoice_data[$counter]->product_name; ?>
                            </td>
                            <td>
                                <?php echo $invoice_data[$counter]->mg; ?>
                            </td>
                            <td>
                                 <input type="number" readonly class="form-control no-border edit_product_price set-input-width" value="<?php echo number_format($invoice_data[$counter]->price,'3','.',''); ?>"  name="product_price[]" />
                            </td>
                             
                            <td>
                                <input type="number" class="form-control  edit_product_quantity set-input-width" value="<?php echo $invoice_data[$counter]->qty; ?>" id="<?php echo 'quantity'.$invoice_data[$counter]->id; ?>" onkeyup="checkquantity(<?php echo $invoice_data[$counter]->id; ?>,<?php echo $invoice_data[$counter]->qty; ?>,this.value)" name="product_quantity[]">
                            </td> 
                            <td>
                                 <input type="number" class="form-control no-border edit_product_discount set-input-width"  onkeyup="calculatediscount(<?php echo $invoice_data[$counter]->id; ?>,<?php echo $invoice_data[$counter]->discount; ?>,this.value)" value="<?php echo number_format($invoice_data[$counter]->discount,'3','.',''); ?>"  name="edit_product_discount[]" />
                            </td>
                            
                        </tr>
                        <?php
                            $counter++; 
                            }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table">
                            <?php 
                              $currency = $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
                            ?>
                        
                           <tr>
                                <th colspan="3">Amount Paid (<?php echo $currency; ?>)</th>  
                                <td><input type="number" step="any" style="width:100px; float:right; " class="form-control amountpaid " value="<?php echo $invoice_data[0]->bill_paid; ?>" name="amountpaid"/></td>
                            </tr>
                            <tr>
                                <td colspan="5"><b>Description(opt)</b><input type="text"  class="form-control edit_description input-lg" placeholder="Plz Provide the reason of edit" value="<?php echo $invoice_data[0]->description; ?>" name="edit_description"/>
                                </td>
                            </tr>
                            <input type="hidden"  name="edit_invoice_id"  class="form-control " value="<?php echo $invoice_data[0]->order_id;  ?>"  />
                        </table>
                    </div>
                </div>
            </div>
            <div class="row no-print">
                <div class="col-xs-12">
                    <?php
                         $data = array('class'=>'btn btn-info btn-flat pull-right btn-lg','id'=>'update_button_data_invoice','type' => 'submit','name'=>'btn_submit_product','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update invoice');
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
<script>

function calculatediscount()
{
    //alert('sdasd');
}

function checkdiscount(value) 
{
    if (parseInt(value) > 100 || parseInt(value) < 0) 
    {
        $('#update_button_data_invoice').attr('disabled','disabled');
        $("#discountfield").css("border-color", "#c00");
    } 
    else 
    {
        $("#discountfield").css("border-color", "#ccc");
        $('#update_button_data_invoice').removeAttr('disabled');
    }
} 

function checkquantity(id, qty, value) 
{
    if (qty < value) 
    {
        $('#update_button_data_invoice').attr('disabled','disabled');
        $("#quantity"+id).css("border-color","#c00");
    } 
    else 
    {
        $('#update_button_data_invoice').removeAttr('disabled');
        $("#quantity" + id).css("border-color", "#ccc");
    }
}

$('body').delegate('.edit_product_quantity,.edit_discount_box', 'keyup', function()
{
    var tableRow = $(this).parent().parent();
    var product_quantity = tableRow.find('.edit_product_quantity').val();
    var product_price = tableRow.find('.edit_product_price').val();
    var discountbox = tableRow.find('.edit_discount_box').val();
    checkdiscount(discountbox);
    var CalculatedAmount = (product_quantity * product_price);
    tableRow.find('.edit_product_subtotal').val(CalculatedAmount);
    AddSubtotals(discountbox);
});

function AddSubtotals(discountbox) 
{
    var totalGrossAmount = 0;
    $('.edit_product_subtotal').each(function(i, e) 
    {
        var subAmount = $(this).val() - 0;
        totalGrossAmount += subAmount;
    });

    var tempgross = totalGrossAmount;

    if (typeof discountbox == 'undefined') 
    {
        discountbox = 0;
    }

    if (discountbox != 0) 
    {

        //var CalculatedAmountWithDis = (totalGrossAmount / 100) * discountbox;
         tempgross = totalGrossAmount - discountbox;
    }

    $('.Edit_subtotal_amount').val(totalGrossAmount);
    $('.Edit_total_amount').val(tempgross);
    $('.amountpaid').val(tempgross);
}

   </script> 