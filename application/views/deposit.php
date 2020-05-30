<section class="content">
  <div class="row">
      <ol class="breadcrumb pull-left">
          <li>
              <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url('bank/deposit_list'); ?>"> Deposit </a>
          </li>
          <li class="active">Create deposit</li>
      </ol>
    </div> 
    <div class="box" id="print-section">
        <div class="box-body">
            <?php
                $attributes = array('id'=>'open_balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('bank/add_deposit',$attributes); ?>
                <div class="row no-print invoice" >
                    <h4  class="purchase-heading" > <i class="fa fa-check-circle"></i>  Create Bank Deposit <span class="pull-right"> <i class="fa fa-calendar"></i> Deposit Date : <?php
                                $data = array('class'=>' cheque-fields','type'=>'date','name'=>'deposit_date','reqiured'=>'');
                                echo form_input($data);
                          ?> </span>
                        <small>Use to create a Bank deposit</small>
                    </h4>
                    <div class="col-md-12 cheque-area-border" >
                        <span class="pull-right bank-balance" >Available Balance:  <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>  <span id="available_balance">0</span> </span> 
                      
                      <div class="form-group cheque-setting-top">
                           <label><i class="fa fa-check-circle"></i> Bank</label>
                              <select onchange="find_available(this.value)" name="bank_id" class="form-control select2 cheque-fields">
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
                              <label><i class="fa fa-check-circle"></i> Received From</label>
                              <select name="customer_id" class="form-control select2 cheque-fields">
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
                                $data = array('class'=>'form-control cheque-fields ','type'=>'number','name'=>'amount','reqiured'=>'','step'=>'any','value'=>'0');
                                echo form_input($data);
                            ?>
                        </div> 
                         <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Method </label>
                            <select name="method" class="form-control cheque-fields">
                               <option value="Cash">Cash</option>   
                               <option value="Cheque">Cheque</option>   
                            </select>
                        </div>  
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Ref No</label>
                             <?php
                                $data = array('class'=>'form-control cheque-fields ','type'=>'text','name'=>'refno','reqiured'=>'','placeholder'=>'e.g deposit slip no.');
                                echo form_input($data);
                            ?>
                        </div>                                        
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Memo</label>
                             <?php
                                $data = array('class'=>'form-control cheque-fields ','type'=>'text','name'=>'memo','reqiured'=>'','placeholder'=>'e.g Recieved from Customer medix for his recievables.');
                                echo form_input($data);
                            ?>
                        </div> 
                        <div class="form-group">
                          <div class="border-setting">
                              <label> <i class="fa fa-paperclip" aria-hidden="true" ></i> 
                                Attachments  Maximum size: 25MB
                              </label>
                                <?php               
                                    $data = array('class'=>'input-lg ','type'=>'file','name'=>'attachment','reqiured'=>'');
                                    echo form_input($data);             
                                ?>
                            </div>    
                        </div>                    
                    </div>  
                    <div class="form-group ">
                      <?php
                          $data = array('class'=>'btn btn-info btn-submit-cheque btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_balance','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                              Save Deposit ');
                          echo form_button($data);
                       ?>  
                    </div>
                </div>  
                <?php form_close(); ?>
        </div>
    </div>
</section>
<script type="text/javascript">
  function find_available(bank_id)
  {

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('bank/check_available_balance/'); ?>'+bank_id,
            success: function(response)
            {
                $('#available_balance').html(response);
              
            }
        });
  }
</script>