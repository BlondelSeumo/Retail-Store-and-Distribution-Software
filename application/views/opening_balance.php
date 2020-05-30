<section class="content-header">
  <div class="row">
    <ol class="breadcrumb pull-left">
        <li>
            <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        <li class="active">Opening balances</li>
    </ol>
  </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'open_balance_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open('vouchers/add_new_balance',$attributes); ?>
            <div class="container">
                <div class="row no-print invoice">
                    <div class="col-md-12 ">
                        <h4  class="purchase-heading" > <i class="fa fa-check-circle"></i>   Opening Balances 
                            <small>Use when importing account heads</small>
                        </h4> <br>
                        <div class="form-group">
                            <?php echo form_label('Account'); ?>
                              <select name="account_head" class="form-control select2 input-lg">
                                    <?php 
                                      foreach ($heads_record as $single_head) 
                                      {
                                    ?>
                                         <option value="<?php echo $single_head->id ?>">
                                          <?php echo $single_head->name ?>
                                          </option>
                                    <?php   
                                      }
                                    ?>   
                              </select>
                        </div>                        
                        <div class="form-group">
                            <?php echo form_label('Account'); ?>
                              <select name="account_nature" class="form-control input-lg">
                                  <option value="0"> Debit </option> 
                                  <option value="1"> Credit </option> 
                              </select>
                        </div>    
                        <div class="form-group">
                            <?php echo form_label('Amount'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'amount','reqiured'=>'','step'=>'any');
                                echo form_input($data);
                            ?>
                        </div>                      
                        <div class="form-group">
                            <?php echo form_label('Date'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','reqiured'=>'','value'=>Date('d/m/Y'));
                                echo form_input($data);
                            ?>
                            <small>By default it will set today's date.</small>
                        </div>                    
                        <div class="form-group">
                            <?php echo form_label('Description'); ?>
                             <?php
                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>                    
                    </div>
                        <div class="form-group">
                          <?php
                              $data = array('class'=>'btn btn-info  margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_balance','value'=>'true','id'=>'btn_save_transaction','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> 
                                  Save ');
                              echo form_button($data);
                           ?>  
                        </div>    
                  </div>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</section>