<section class="content">
    <div class="row">
      <ol class="breadcrumb pull-left">
          <li>
              <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url('vouchers/journal_list'); ?>"> Vouchers</a>
          </li>
          <li class="active">Edit vouchers</li>
      </ol>
    </div> 
    <div class="box" id="print-section">
        <div class="box-body ">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'payment_voucher','method'=>'post','class'=>'');
            ?>
            <?php echo form_open('vouchers/update_journal_voucher',$attributes); ?>
            <div class="container">
                <div class="row no-print invoice">
                    <h4  class="purchase-heading" > <i class="fa fa-check-circle"></i> 
                      Update journal voucher
                      <small>
                        Note: All balances are in <?php  echo $default[0]->currency; ?>
                      </small> 
                    </h4>
                    <div class="col-md-12 ">
                        <br>
                        <div class="form-group">
                            <?php echo form_label('Description'); ?>
                             <?php
                                $data = array('type'=>'hidden','name'=>'transaction_id','reqiured'=>'','value'=>$voucher_list[0]->transaction_id);
                                echo form_input($data);

                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','reqiured'=>'','value'=>$voucher_list[0]->memo);
                                echo form_input($data);
                            ?>
                        </div>                    
                        <div class="form-group">
                            <?php echo form_label('Date'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','reqiured'=>'','value'=>$voucher_list[0]->receipt_date);
                                echo form_input($data);
                            ?>
                        </div>
                        <div class="form-group">
                              <label> Holder Name</label>
                              <select name="payee_id" class="form-control select2 cheque-fields">
                                    <?php 
                                      foreach ($customer_list as $customer) 
                                      {
                                    ?>
                                         <option <?php echo ($customer->id == $voucher_list[0]->payee_id ? 'selected' : '' ); ?> value="<?php echo $customer->id ?>">
                                          <?php echo 'Name '.$customer->customer_name.' | Email '.$customer->cus_email.' | Contact '.$customer->cus_contact_1; ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>
                    </div>                         
            </div>
            <div class="row invoice">
              <div class="col-md-12 table-responsive">
                 <table class="table table-striped table-hover  ">
                     <thead>
                       <tr>
                           <th class="col-md-5 ">Account</th>
                           <th class="col-md-3"></th>
                           <th class="col-md-2">Debit</th>
                           <th class="col-md-2">Credit</th>
                       </tr>
                     </thead>
                     <tbody  id="transaction_table_body" >
                        <?php 
                          $debit_total = 0;
                          $credit_total = 0;
                          if($trans_data != NULL )
                          {
                            foreach ($trans_data as $single_trans) 
                            {
                              //$total = $total + $single_trans->amount;
                        ?>
                        <tr>
                           <td >
                                <select name="account_head[]" class="form-control select2 input-lg">
                                   <?php 
                                    if($accounts_records != NULL )
                                    {
                                      foreach ($accounts_records as $single_head) 
                                      {
                                        ?>
                                        <option <?php echo ($single_trans->accounthead == $single_head->id ? 'selected' : '' ); ?> value="<?php echo $single_head->id; ?>"><?php echo $single_head->name; ?></option>
                                        <?php
                                      }
                                    }
                                   ?>
                                </select>
                           </td>
                           <td>
                                
                           </td> 
                           <td>
                            <?php

                              if($single_trans->type == 0)
                              {
                                   $debit_total = $debit_total + $single_trans->amount;
                              }
                             

                              $data = array('class'=>'form-control input-lg','step'=>'any','type'=>'number','name'=>'debitamount[]','value'=>($single_trans->type == 0 ? $single_trans->amount : '0'),'reqiured'=>'','onkeyup'=>'count_debits()');

                                echo form_input($data);
                            
                            ?>
                           </td> 
                           <td>
                            <?php

                              if($single_trans->type == 1)
                              {
                                 $credit_total = $credit_total + $single_trans->amount;
                              }


                              $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'creditamount[]','step'=>'any','value'=>($single_trans->type == 1 ? $single_trans->amount : '0'),'reqiured'=>'','onkeyup'=>'count_credits()');
                                echo form_input($data);
                            ?>
                           </td>
                       </tr>
                      <?php 
                          }
                        }
                      ?>
                     </tbody>
                     <tfoot>
                       <tr>
                           <td colspan="3">
                              <button type="button" class="btn btn-primary" name="addline" onclick="add_new_row('<?php echo base_url().'vouchers/popup/new_row';?>')"> <i class="fa fa-plus-circle"></i> Add a line </button>
                              <button type="button" onclick="clearalllines()" class="btn btn-danger btn-add-setting" name="addline"> <i class="fa fa-trash"></i>    Clear all lines 
                              </button>
                           </td>
                           <td id="row_loading_status"></td>
                       </tr>                   
                       <tr>
                           <th ></th>
                           <th >Totals: </th>
                           <th >
                               <?php 
                                 $data = array('type'=>'number','name'=>'total_debit_amount','step'=>'any','value'=>$debit_total,'readonly'=>'readonly','class'=>'accounts_total_amount','reqiured'=>'');
                                    echo form_input($data);
                                ?>
                           </th>
                           <th>
                               <?php 
                                 $data = array('type'=>'number','name'=>'total_credit_amount','step'=>'any','value'=>$credit_total,'readonly'=>'readonly','class'=>'accounts_total_amount','reqiured'=>'');
                                    echo form_input($data);
                                ?>
                           </th>
                       </tr>
                       <tr>
                           <td colspan="4" class="transaction_validity" id="transaction_validity">
                              
                           </td >
                       </tr>  
                     </tfoot>
                 </table>
                </div>
                <div class="col-md-12 ">
                    <div class="form-group">
                        <?php
                            $data = array('class'=>'btn btn-info  margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                Update ');
                            echo form_button($data);
                         ?>  
                    </div>
                </div>
                </div>
            </div>
            <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var timmer;
    function count_debits() 
    {
        clearTimeout(timmer);
        
         timmer = setTimeout(function callback()
        { 
            var total_debit = 0;
             $('input[name="debitamount[]"]').each(function() 
             {  
                 if($(this).val() != '')
                 {
                     total_debit = total_debit + parseFloat($(this).val());
                 }
              });

             $('input[name="total_debit_amount"]').val(total_debit);

            //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
             check_validity()

        }, 800); 
    }  

    function count_credits() 
    {
        clearTimeout(timmer);
        
         timmer = setTimeout(function callback()
        { 
            var total_credits = 0;
             $('input[name="creditamount[]"]').each(function() 
             {  
                if($(this).val() != '')
                {
                    total_credits = total_credits + parseFloat($(this).val());
                }  
             });

             $('input[name="total_credit_amount"]').val(total_credits);

             //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
             check_validity();

        }, 800); 
    } 

   function clearalllines()
   {
      $('#transaction_table_body').html('');

      calculateSubTotal();
   }         
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 