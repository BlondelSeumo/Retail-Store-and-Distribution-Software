<div class="invoice">
  <section>
      <div class="row">
        <h4 class="purchase-heading">
          <i class="fa fa-plus-circle"></i> Puchase Order
          <small>Create PO for your vendor</small>
        </h4>
      </div>
  </section>
  <section class="content">
        <div class="box" id="print-section">
          <div class="box-body ">
            <?php
                $attributes = array('id'=>'add_invoice','method'=>'post','class'=>'');
            ?>
            <?php echo form_open('purchase_order/add_estimate',$attributes); ?>
            <div class="row">
               <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <label>Account : </label>               
                      <select class="form-control select2 " name="payee_id" id="payee_id">
                          <?php
                          //category_names from mp_category table;
                          if($payee_list != NULL)
                          {       
                              foreach ($payee_list as $single_payee)
                              {
                          ?>
                                  <option value="<?php echo $single_payee->id; ?>" ><?php echo $single_payee->customer_name.' | '.$single_payee->cus_email; ?> 
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
               </div>                                                     
               <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <label>Billing address : </label>               
                      <?php               
                          $data = array('class'=>'form-control input-lg ','type'=>'text','name'=>'billing_address','reqiured'=>'');
                          echo form_input($data);             
                      ?>
                  </div>
               </div>
               <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <?php echo form_label('PO date :'); ?>
                      <?php               
                          $data = array('class'=>'form-control input-lg ','type'=>'date','name'=>'date','reqiured'=>'');
                          echo form_input($data);             
                      ?>
                  </div>
                </div>    
                <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                      <?php echo form_label('Delivery  date :'); ?>
                      <?php               
                          $data = array('class'=>'form-control input-lg ','type'=>'date','name'=>'expire_date','reqiured'=>'');
                          echo form_input($data);             
                      ?>
                  </div>
                </div> 
                <div class="col-md-4 col-sm-12">
                  <div class="form-group">
                    <label class="check-to-email"> Mail PO :  
                      <?php               
                          $data = array('type'=>'checkbox','name'=>'send_mail','reqiured'=>'','value' => '');
                          echo form_input($data);             
                      ?>
                    </label>
                  </div>
                </div>                   
              </div>        
              <div class="row">
                  <div class="col-md-12 table-responsive">
                       <table class="table table-striped table-hover  ">
                           <thead class="purchase-heading">
                            <tr>
                               <td class="col-md-3 ">Product/Service</td>
                               <td class="col-md-3 ">Description</td>
                               <td class="col-md-1 ">Quantity</td>
                               <td class="col-md-1 ">Price</td>
                               <td class="col-md-1 ">Amount</td>
                               <td class="col-md-1">Action</td>
                           </tr>
                           </thead>
                           <tbody  id="transaction_table_body" >
                              <tr>
                                <td>
                                    <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product[]','reqiured'=>'','id'=>'des_id');
                                        echo form_input($data);
                                    ?>
                                 </td>                               
                                  <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'descriptionarr[]','reqiured'=>'','id'=>'des_id');
                                          echo form_input($data);
                                      ?>
                                 </td>    
                                 <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg qty','type'=>'number','name'=>'qty[]','id'=>'quantity_item','step'=>'any','reqiured'=>'','value'=>'0');
                                          echo form_input($data);
                                      ?>
                                 </td>    
                                 <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg price','type'=>'number','name'=>'price[]','id'=>'price','step'=>'any','reqiured'=>'','value'=>'0');
                                          echo form_input($data);
                                      ?>
                                 </td>    
                                 <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg item_Subtotal','type'=>'number','name'=>'subtotal[]','id'=>'amount','step'=>'any','reqiured'=>'','value'=>'0');
                                          echo form_input($data);
                                      ?>
                                 </td>                           
                                 <td>
                                      <a  onclick="deleteParentElement(this)" href="javascript:void(0)">
                                          <i class="fa fa-trash bill-times-icon" aria-hidden="true"></i>
                                      </a>
                                 </td>
                              </tr>
                           </tbody>
                           <tfoot>                    
                              <tr>
                                   <td colspan="5">
                                      <button type="button" class="btn btn-primary btn-add-setting" name="addline" onclick="add_new_row('<?php echo base_url('invoice/popup/new_row_po');?>')"> <i class="fa fa-plus-circle"></i>    Add a line 
                                      </button> 
                                      <button type="button" onclick="clearalllines()" class="btn btn-danger btn-add-setting" name="addline" onclick="add_new_row('<?php echo base_url().'expense/popup/new_bill_row';?>')"> <i class="fa fa-trash"></i>    Clear all lines 
                                      </button>
                                   </td>
                                   <td id="row_loading_status"></td>
                               </tr>                   
                              <tr>
                                 <td colspan="4"></td>
                                 <td class=" expense-total-settings">Sub total</td>
                                 <td>
                                     <?php 
                                       $data = array('type'=>'number','name'=>'sub_total','step'=>'any','value'=>'0.00','readonly'=>'readonly','class'=>'subtotal_amount bill-total-settings','reqiured'=>'');
                                          echo form_input($data);
                                      ?>
                                 </td>
                              </tr>                                                             
                              <tr>
                                 <td colspan="4"></td>
                                 <td class=" expense-total-settings"> Total </td>
                                 <td>
                                     <?php 
                                       $data = array('type'=>'number','name'=>'total_bill','step'=>'any','value'=>'0.00','readonly'=>'readonly','class'=>'total_bill bill-total-settings','reqiured'=>'');
                                          echo form_input($data);
                                      ?>
                                 </td>
                              </tr>                              
                            </tfoot>
                       </table>
                      </div>
                      <div class="col-md-5 ">
                        <div class="form-group">
                            <?php echo form_label('Message displayed on purchase order :'); ?>
                            <?php               
                                $data = array('class'=>'form-control input-lg ','type'=>'text','name'=>'invoicemessage','reqiured'=>'');
                                echo form_input($data);             
                            ?>
                        </div>                        
                        <div class="form-group">
                            <?php echo form_label('Message displayed on statement:'); ?>
                            <?php               
                                $data = array('class'=>'form-control input-lg ','type'=>'text','name'=>'memo','reqiured'=>'');
                                echo form_input($data);             
                            ?>
                        </div>
                      </div>                    
                      <div class="col-md-12 ">
                        <div class="form-group">
                          <label> <i class="fa fa-paperclip" aria-hidden="true" ></i> Attachments  Maximum size: 25MB</label>
                            <?php               
                                $data = array('class'=>'input-lg ','type'=>'file','name'=>'attachment','reqiured'=>'');
                                echo form_input($data);             
                            ?>
                        </div>
                      </div>
                      <div class="col-md-12 ">
                          <div class="form-group">
                              <center>
                              <?php
                                  $data = array('class'=>'btn btn-info  margin btn-lg  ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                      Save PO');
                                  echo form_button($data);
                               ?>  
                               </center>
                          </div>
                      </div>
                      <?php echo form_close(); ?>
                    </div>
                </div>
          </div>
      </div>
  </section>
</div>  
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>

<!-- Bootstrap model  ends--> 
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });

  function deleteParentElement(n) 
  {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    calculateSubTotal();
  }

    //CALCAULATE AND ASSIGN WHEN PRODUCT NAME IS SELECTED AND SET ITS VALUE TO TEXT BOX
   $('body').delegate('#product_name', 'change', function(n) {

    // var tableRow = $(this).parent().parent();
    var price = $(this).find(':selected').data('price');

    var tax = $(this).find(':selected').data('tax');

    var description = $(this).find(':selected').data('description');

    var tableRow = $(this).parent().parent();

    tableRow.find('#price').val(price);

    tableRow.find('#des_id').val(description);

    tableRow.find('#quantity_item').val(1);

    tableRow.find('#amount').val(1*price);

    var  taxamount = CalculatedAmountTax(1*price,tax);

    tableRow.find('.sales_tax').val(taxamount.toFixed(3));

    tableRow.find('.single_tax').val(taxamount.toFixed(3));

    calculateSubTotal();
   
   });   

   //CALCAULATE AND ASSIGN WHEN QUANTITY NAME IS SELECTED AND SET ITS VALUE TO TEXT BOX
   $('body').delegate('#quantity_item, #price', 'keyup', function(n) {

    var tableRow = $(this).parent().parent();

    var tax = tableRow.find('.single_tax').val();

    var quantity_item = tableRow.find('#quantity_item').val();

    var price = tableRow.find('#price').val();

    var  taxamount = quantity_item*tax;

    tableRow.find('.sales_tax').val(taxamount.toFixed(3));

    tableRow.find('#amount').val(quantity_item*price);

    calculateSubTotal();
   
   });   

   function calculateSubTotal()
   {
        var totalGrossAmount = 0;
        var totalTaxAmount = 0;
        $('.item_Subtotal').each(function(i, e) {
            var subAmount = $(this).val() - 0;
            totalGrossAmount += subAmount;
        });

        $('.sales_tax').each(function(i, e) 
        {
            var tax_Amount = $(this).val() - 0;
            totalTaxAmount += tax_Amount;
        });

        $('.subtotal_amount').val(totalGrossAmount.toFixed(3));
        $('#taxfield').val(totalTaxAmount.toFixed(3));
        $('.total_bill').val((totalGrossAmount+totalTaxAmount).toFixed(3));
        $('.balance_due').val((totalGrossAmount+totalTaxAmount).toFixed(3));
   }

    function CalculatedAmountTax(retail,tax)
    {
       return (retail / 100) * tax;  
    }

   function clearalllines()
   {
      $('#transaction_table_body').html('');

      calculateSubTotal();
   }
</script>