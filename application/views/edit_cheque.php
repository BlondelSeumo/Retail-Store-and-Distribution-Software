<?php 
if($trans_data != NULL)
{
?>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body">
          <div class="row">
              <ol class="breadcrumb pull-left">
                  <li>
                      <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url('bank/written_cheque'); ?>"> Cheques</a>
                  </li>
                  <li class="active">Edit cheque</li>
              </ol>
          </div> 
            <?php
                $attributes = array('id'=>'open_balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('bank/update_cheque',$attributes); ?>
                <div class="row no-print invoice" >
                    <h4  class="purchase-heading" > <i class="fa fa-pencil"></i>  View Cheque <span class="pull-right"> <i class="fa fa-calendar"></i> Cheque Date : <?php
                      $data = array('class'=>' cheque-fields','type'=>'date','name'=>'deposit_date','reqiured'=>'','value'=>$trans_data[0]->date);
                      echo form_input($data);
                    ?></span>
                        <small>Use to view or edit cheque</small>
                    </h4>
                    <div class="col-md-12 cheque-area-border" >
                      <span class="pull-right bank-balance" >Available Balance:  <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>  <span id="available_balance"><?php echo $available_balance; ?></span> </span> 
                      
                      <div class="form-group cheque-setting-top">
                           <label><i class="fa fa-check-circle"></i> Bank</label>
                              <select onchange="find_available(this.value)" name="bank_id" class="form-control select2 cheque-fields">
                                    <?php
                                      foreach ($bank_list as $single_bank) 
                                      {

                                    ?>
                                         <option <?php echo ($trans_data[0]->bank_id == $single_bank->id ? 'selected' : '' ); ?> value="<?php echo $single_bank->id ?>">
                                          <?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->branchcode.' | '.$single_bank->title.' | '.$single_bank->accountno;  ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>
                        <div class="form-group ">
                            <?php echo form_label(''); ?>
                            <label><i class="fa fa-check-circle"></i> Cheque No</label>
                             <?php
                                $data = array('class'=>'form-control cheque-fields','type'=>'text','name'=>'cheque_id','reqiured'=>'','value'=>$trans_data[0]->ref_no);
                              echo form_input($data);
                            ?>
                        </div>                       
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Payee Name</label>
                            <select name="payee_id" class="form-control select2 cheque-fields">
                                  <?php 
                                    foreach ($customer_list as $customer) 
                                    {
                                  ?>
                                       <option <?php echo ($trans_data[0]->payee_id == $customer->id ? 'selected' : '' ); ?>  value="<?php echo $customer->id ?>">
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
                                         <option <?php echo ($trans_data[0]->accounthead == $head->id ? 'selected' : '' ); ?>  value="<?php echo $head->id ?>">
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
                                $data = array('class'=>'form-control cheque-fields ','type'=>'number','name'=>'amount','step'=>'any','placeholder'=>'e.g 4000','value'=>$trans_data[0]->total_paid);
                                echo form_input($data);
                            ?>
                        </div>                                         
                        <div class="form-group">
                            <label><i class="fa fa-check-circle"></i> Narration</label>
                             <?php
                                $data = array('class'=>'form-control cheque-fields ','type'=>'text','name'=>'description','reqiured'=>'','value'=> $trans_data[0]->naration);
                                echo form_input($data);
                            ?>
                            <?php
                                $data = array('class'=>'','type'=>'hidden','id'=>'transaction_id','name'=>'transaction_id','value'=>$trans_data[0]->transaction_id);
                                echo form_input($data); 

                                $data = array('class'=>'','type'=>'hidden','id'=>'che_pri_id','name'=>'che_pri_id','value'=>$trans_data[0]->id);
                                echo form_input($data); 
                            ?>
                        </div>  
                        <div class="form-group">
                          <?php 
                            $data = array('class'=>'input-lg form-control ','type'=>'file','name'=>'attachment','reqiured'=>'');
                            echo form_input($data); 
                          ?>
                        </div>                  
                    </div>  
                    <div class="col-md-6">
                        <span class="pull-left">
                          <img  class="img-setting" src="<?php echo base_url('uploads/cheque/').$trans_data[0]->attachment;?>" >
                        </span>
                    </div> 
                    <div class="form-group ">
                      <?php
                          $data = array('class'=>'btn btn-info btn-submit-cheque btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_balance','value'=>'true','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                              Update Cheque ');
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
                $('#currrent_amount').val(response);
            }
        });
  }
</script>
<?php 
}
?>