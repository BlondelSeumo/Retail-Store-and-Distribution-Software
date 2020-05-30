<div class="row">
  <div class="col-md-12">
        <ol class="breadcrumb pull-left">
            <li>
                <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
              <a href="<?php echo base_url('expense'); ?>"> Expense</a>
            </li>
            <li class="active">Add expense</li>
        </ol>
  </div> 
</div>
<div class="invoice">
  <section>
      <div class="row">
        <h4 class="purchase-heading">
          <i class="fa fa-plus-circle"></i> Add Expense 
            <small>
               <i>Saves this expense, and automatically updates your accounting.</i>
               <span class="pull-right bank-section-details">
                  Available balance :  
                    PKR <span id="available_balance">0</span>
                </span>
            </small>
        </h4>
      </div>
  </section>
  <section class="content">
        <div class="box" id="print-section">
            <div class="box-body ">
              <?php
                  $attributes = array('id'=>'expense_area','method'=>'post','class'=>'');
              ?>
              <?php echo form_open_multipart('expense/add_expense',$attributes); ?>
              <div class="row">
                 <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <?php       
                          $data = array('type'=>'hidden','id'=>'save_available_balance','name'=>'save_available_balance','value'=>'0','reqiured'=>'');
                          echo form_input($data);       
                        ?>
                        <label>Payee : </label>               
                        <select class="form-control select2 " name="payee_id" id="payee_id">
                            <?php
                            //category_names from mp_category table;
                            if($payee_list != NULL)
                            {       
                                foreach ($payee_list as $single_payee)
                                {
                            ?>
                                    <option value="<?php echo $single_payee->id; ?>" ><?php echo $single_payee->customer_name.' | '.$single_payee->type; ?> 
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
                        <label>Payment Method : </label>               
                        <select class="form-control input-lg " name="payment_method" id="payment_method">
                          <option value="Cash" > Cash </option>
                          <option value="Cheque" > Cheque </option>
                        </select>
                    </div>
                 </div>
                 <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <?php echo form_label('Date'); ?>
                        <?php               
                            $data = array('class'=>'form-control input-lg ','type'=>'date','name'=>'date','reqiured'=>'');
                            echo form_input($data);             
                        ?>
                    </div>
                  </div> 
                </div> 
              <div class="row ">
                 <div class="col-md-4 col-sm-12">
                     <div class="form-group">
                        <?php echo form_label('Ref no.'); ?>
                        <?php               
                            $data = array('class'=>'form-control bill-text-fields-settings input-lg','type'=>'text','name'=>'ref_no','reqiured'=>'');
                            echo form_input($data);             
                        ?>
                    </div>
                 </div>           
                  <div class="col-md-4 col-sm-12 bank-section-details">
                    <div class="form-group">
                        <label>Bank : </label>               
                        <select class="form-control select2 " name="bank_id" id="bank_id">
                          <option value="0"> Select bank </option>
                          <?php
                            //category_names from mp_category table;
                            if($bank_list != NULL)
                            {       
                                foreach ($bank_list as $single_bank)
                                {
                          ?>
                                    <option value="<?php echo $single_bank->id; ?>" ><?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->title; ?> 
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
              </div>          
              <div class="row">
                  <div class="col-md-12 table-responsive">
                       <table class="table table-striped table-hover  ">
                           <thead class="purchase-heading">
                             <tr style="">
                                 <th class="col-md-3 ">ACCOUNT</th>
                                 <th class="col-md-6 ">DESCRIPTION</th>
                                 <th class="col-md-2 ">AMOUNT</th>
                                 <th class="col-md-1">ACTION</th>
                             </tr>
                           </thead>
                           <tbody  id="transaction_table_body" >
                              <tr>
                                 <td>
                                      <select class="form-control select2 "  name="account_head[]" id="account_head">
                                          <option value="0" >Choose</option>
                                          <?php
                                          //category_names from mp_category table;
                                          if($head_list != NULL)
                                          {       
                                              foreach ($head_list as $single_head)
                                              {
                                          ?>
                                                <option value="<?php echo $single_head->id; ?>" ><?php echo $single_head->name; ?> 
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
                                 </td>                                     
                                  <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg','type'=>'text','placeholder'=>'Any description','name'=>'descriptionarr[]','reqiured'=>'');
                                          echo form_input($data);
                                      ?>
                                 </td>    
                                 <td>
                                      <?php
                                          $data = array('class'=>'form-control input-lg amount','type'=>'number','name'=>'amount[]','id'=>'amount','step'=>'any','reqiured'=>'','value'=>'0');
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
                                   <td colspan="4">
                                      <button type="button" class="btn btn-primary btn-add-setting" name="addline" onclick="add_new_row('<?php echo base_url().'expense/popup/new_bill_row';?>')"> <i class="fa fa-plus-circle"></i>    Add a line 
                                      </button> 
                                      <button type="button" onclick="clearalllines()" class="btn btn-danger btn-add-setting" name="addline" onclick="add_new_row('<?php echo base_url().'expense/popup/new_bill_row';?>')"> <i class="fa fa-trash"></i>    Clear all lines 
                                      </button>
                                   </td>
                                   <td id="row_loading_status"></td>
                               </tr>                   
                              <tr>
                                 <td colspan="2"></td>
                                 <td class=" expense-total-settings">Total</td>
                                 <td>
                                     <?php 
                                       $data = array('type'=>'number','name'=>'total_bill','step'=>'any','value'=>'0.00','readonly'=>'readonly','class'=>'total_bill bill-total-settings','reqiured'=>'');
                                          echo form_input($data);
                                      ?>
                                 </td>
                              </tr> 
                              <tr>
                                 <td colspan="2"></td>
                                 <td class=" expense-total-settings">Paid</td>
                                 <td>
                                     <?php 
                                       $data = array('type'=>'number','name'=>'total_paid','step'=>'any','value'=>'0.00','class'=>'total_paid bill-total-settings','reqiured'=>'');
                                          echo form_input($data);
                                      ?>
                                 </td>
                              </tr> 
                            </tfoot>
                       </table>
                      </div>
                      <div class="row">
                        <div class="col-md-5 ">
                          <div class="form-group">
                              <?php echo form_label('Memo'); ?>
                              <?php               
                                  $data = array('class'=>'form-control input-lg ','type'=>'text','name'=>'memo','reqiured'=>'');
                                  echo form_input($data);             
                              ?>
                          </div>
                        </div> 
                      </div>  
                      <div class="row">                 
                        <div class="col-md-5 ">
                          <div class="form-group">
                            <label> <i class="fa fa-paperclip" aria-hidden="true" ></i> Attachments  Maximum size: 25MB</label>
                              <?php               
                                  $data = array('class'=>'input-lg ','type'=>'file','name'=>'attachment','reqiured'=>'');
                                  echo form_input($data);             
                              ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 ">
                          <div class="form-group">
                              <center>
                              <?php
                                  $data = array('class'=>'btn btn-info  margin btn-lg  ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                      Save expense');
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

  $('#payment_method').change(function(){
  var method = $('#payment_method').val();
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

  $(function () {
  //Initialize Select2 Elements
  $(".select2").select2();
});

function deleteParentElement(n) 
{
  n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
  calculateSubTotal();
}

 //CALCAULATE AND ASSIGN WHEN QUANTITY NAME IS SELECTED AND SET ITS VALUE TO TEXT BOX
 $('body').delegate('.amount', 'keyup', function(n) {
      calculateSubTotal();
 });

function calculateSubTotal()
 {
    var totalAmount = 0;
    $('.amount').each(function(i, e) {
        totalAmount +=  $(this).val() - 0;
    });

    $('.total_bill').val((totalAmount).toFixed(3));
    $('.total_paid').val((totalAmount).toFixed(3));
 }  

 function clearalllines()
 {
    $('#transaction_table_body').html('');

    calculateSubTotal();
 }
</script>