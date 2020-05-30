<section class="content">
    <div class="box" id="print-section">
        <div class="box-body">
            <?php
                $attributes = array('id'=>'open_balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open('bank/add_payment_transaction',$attributes); ?>
                <div class="row no-print invoice" >
                    <h4  class="purchase-heading" > <i class="fa fa-check-circle"></i>  Create Payment <span class="pull-right"> <i class="fa fa-calendar"></i> Date : <?php
                      $data = array('class'=>' cheque-fields','type'=>'date','name'=>'deposit_date','reqiured'=>'');
                      echo form_input($data);
                    ?></span>
                        <small>Use to create payment collections through bank or bank profit e.g interest</small>
                    </h4>
                    <div class="col-md-12 cheque-area-border" >
                      <div class="form-group cheque-setting-top">
                           <label><i class="fa fa-check-circle"></i> Bank</label>
                              <select name="bank_id" class="form-control select2 cheque-fields">
                                    <?php 
                                      foreach ($bank_list as $single_bank) 
                                      {

                                    ?>
                                         <option value="<?php echo $single_bank->id ?>">
                                          <?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->branchcode.' | '.$single_bank->title.' | '.$single_bank->accountno;  ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>                       
                        <div class="form-group">
                              <label><i class="fa fa-check-circle"></i> Payee Name <small>(Please select only bank)</small></label>
                              <select name="payee_id" class="form-control select2 cheque-fields">
                                    <?php 
                                      foreach ($customer_list as $customer) 
                                      {
                                    ?>
                                         <option value="<?php echo $customer->id ?>">
                                          <?php echo 'Name '.$customer->customer_name.' | Email '.$customer->cus_email.' | Contact '.$customer->cus_contact_1; ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>   
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Account</label>
                              <select name="account_head" class="form-control select2 cheque-fields">
                                    <?php 
                                      foreach ($head_list as $head) 
                                      {
                                    ?>
                                         <option value="<?php echo $head->id ?>">
                                          <?php echo 'Name : '.$head->name.' | Nature : '.$head->nature.' | Type : '.$head->type; ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>                         
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Amount</label>
                            <?php
                                $data = array('class'=>'form-control cheque-fields ','type'=>'number','name'=>'amount','onkeyup'=>'check_amount(this.value)','step'=>'any','value'=>'0');
                                echo form_input($data);
                            ?>
                        </div>                                         
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Narration</label>
                             <?php
                                $data = array('class'=>'form-control cheque-fields ','type'=>'text','name'=>'description','reqiured'=>'','placeholder'=>'e.g Earned interest received from bank .');
                                echo form_input($data);
                            ?>
                            <?php
                                $data = array('class'=>'','type'=>'hidden','id'=>'currrent_amount','name'=>'currrent_amount','value'=>'');
                                echo form_input($data);
                            ?>
                        </div>                    
                    </div>  
                    <div class="form-group ">
                      <?php
                          $data = array('class'=>'btn btn-info btn-submit-cheque btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_balance','value'=>'true','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                              Save Payment ');
                          echo form_button($data);
                       ?>  
                    </div>
                </div>  
                <?php form_close(); ?>
        </div>
    </div>
</section>