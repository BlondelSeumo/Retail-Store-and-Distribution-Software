<section class="content">
    <div class="row">
      <ol class="breadcrumb pull-left">
          <li>
              <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url('payee'); ?>"> Payee</a>
          </li>
          <li class="active">Account statement</li>
      </ol>
    </div> 
    <div class="container-fluid">
        <div class="box" id="print-section">
            <div class="box-header no-print">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-sm btn-flat pull-right "><i class="fa fa-print pull-left"></i> Print / Pdf</button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i>Statement of Account</i></h4>
                        <small><i>Period: <?php echo $date1;  ?> - <?php echo $date2;  ?></i></small>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <h4><?php echo $default_data[0]->companyname; ?></h4>
                            <small>
                               <?php echo $default_data[0]->address; ?>
                            </small>
                        </div>
                    </div>
                </div>    
                <br>
                <?php
                    $attributes = array('id'=>'account_statement','method'=>'post','class'=>'');
                ?>
                <?php echo form_open('payee/ledger/'.$account_id,$attributes); ?>
                <div class="row no-print">
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label for="date_from" class="col-sm-5 control-label">
                                Date From
                            </label>
                            <div class="col-sm-7">
                                <?php 
                                    $data = array('class'=>'form-control','id'=>'date_from','type'=>'date','name'=>'date1');
                                    echo form_input($data); 
                                ?>
                            </div>   
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from" class="col-sm-4 control-label">
                                Date To
                            </label>
                            <div class="col-sm-8">
                                <?php 
                                     $data1 = array('class'=>'form-control','type'=>'date','name'=>'date2');
                                    echo form_input($data1);
                                ?>
                            </div>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php
                                $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Create statement');
                                echo form_button($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" onchange="search_transaction(this.value,'<?php echo $account_id; ?>')" name="timeperiod">
                                <option value="Filter">Filter </option>
                                <option value="month">This Month </option>
                                <option value="three">Last 3 Months </option>
                                <option value="year"> This Year </option>
                                <option value="all">  All </option>
                            </select>
                        </div>
                    </div>
                </div>
             <?php echo form_close(); ?> 
            
                <div class="row">
                    <div class="col-md-12">
                        <h5><i class="fa fa-star"></i> Account Holder </h5>
                        <h5><b><?php echo $payee_details[0]->customer_name; ?><i> (<?php echo $payee_details[0]->cus_contact_1; ?>)</i></b></h5>
                        <small>
                           <?php echo $payee_details[0]->cus_address; ?>
                        
                         <span class="pull-right" >
                           <i class="fa fa-print" aria-hidden="true"></i> Printed Date : <?php echo date('Y-m-d'); ?>
                        </span>
                        </small>
                    </div>                   
                </div> 
                <br/>
                <div class="row">
                    <div class="col-md-12  table-responsive">
                         <table class="table table-striped table-hover table-bordered ">
                             <tr>
                                 <th>Sno</th>
                                 <th>Date</th>
                                 <th>Transaction ID</th>
                                 <th>Source</th>
                                 <th>Description </th>
                                 <th>Amount</th>
                                 <th>Payment</th>
                                 <th>Balance</th>
                             </tr>
                            <?php

                            $balance = 0;
                            $charges = 0;
                            $payment = 0; 
                            $counter = 0;

                            if($transactions != NULL)
                            {
                                
                                foreach ($transactions as $single_trans) 
                                {
                                  //  $balance = $balance + ($single_trans->total_bill - $single_trans->total_paid);
                                    $calculate_balance = balance_identifier($single_trans->generated_source,$balance,$single_trans->total_bill , $single_trans->total_paid);

                                    $balance = $calculate_balance;

                                    $charges = $charges + $single_trans->total_bill;

                                    $payment = $payment + $single_trans->total_paid;

                                    $counter++;
                            ?>
                                    <tr>
                                        <td><?php echo $counter;  ?> </td>
                                        <td><?php echo $single_trans->date;  ?> </td>
                                        <td> 
                                            <a href="<?php echo base_url('prints/transaction/'.$single_trans->transaction_id); ?>" >
                                                <?php echo  $single_trans->transaction_id; ?>
                                            </a>
                                        </td>
                                        <td><?php echo str_replace('_', ' ',ucfirst($single_trans->generated_source));  ?></td>
                                        <td><?php echo $single_trans->naration;  ?></td>
                                        <td><?php echo $single_trans->total_bill;  ?></td>
                                        <td>
                                        <?php 
                                            $source = source_identifier($single_trans->generated_source);
                                            if($source == 'yes')
                                            {
                                                echo '( '.$single_trans->total_paid.' )';   
                                            }
                                            else
                                            {   
                                                echo $single_trans->total_paid;
                                            }
                                        ?>                                              
                                        </td>
                                        <td>
                                            <?php 
                                               if($balance >= 0)
                                               {
                                                  echo $balance;   
                                               }
                                               else if($balance < 0)
                                               {
                                                    echo '( '. -($balance).' )';
                                               }  
                                            ?>        
                                        </td>
                                     </tr>
                            <?php 
                                }
                            }
                            ?>    
                         </table>
                    </div>
                </div> 
        </div>
    </div>
</section>
<script type="text/javascript">
    function search_transaction(period,account_id)
    {
       window.location = '<?php echo base_url('payee/ledger/')?>'+account_id+'/'+period;
    }
</script>