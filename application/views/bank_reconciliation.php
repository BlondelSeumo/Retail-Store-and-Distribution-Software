<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
               <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Bank reconciliation</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print / Pdf</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-header no-print">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Bank Reconcile</h3>
        </div>
        <div class="box-body ">
            <?php
                $attributes = array('id'=>'general_journal','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements/bank_reconciliation',$attributes); ?>
            <div class="row no-print ">
                <div  class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group ">
                        <select name="bank_id" class="form-control">
                            <?php 
                            if ($bank_list != null) 
                            {
                                foreach ($bank_list as $single_bank) 
                                {
                                    ?>
                                <option value="<?php echo $single_bank->id ?>">
                                <?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->branchcode.' | '.$single_bank->title.' | '.$single_bank->accountno; ?>
                                </option>
                            <?php
                                }
                            }
                            ?>   
                            </select>
                        </div>
                    </div>
                <div  class="col-md-2"></div>
                <div  class="col-md-12">
                    <div  class="col-md-1"></div>
                        <div  class="col-md-8">
                            <div class="col-md-10 col-sm-4 ">
                                <div class="form-group">
                                    <label for="date_from" class="col-sm-4 control-label text-right">
                                       
                                    </label>
                                    <?php 
                                        $current_month = date('m');
                                    ?>
                                    <div class="col-sm-8">
                                        <select name="month" class="form-control">
                                             <option <?php echo $current_month == 1 ? 'selected': ''; ?> value="1">January</option>  
                                             <option <?php echo $current_month == 2 ? 'selected': ''; ?> value="2">Feburary</option>  
                                             <option <?php echo $current_month == 3 ? 'selected': ''; ?> value="3">March</option>  
                                             <option <?php echo $current_month == 4 ? 'selected': ''; ?> value="4">April</option>  
                                             <option <?php echo $current_month == 5 ? 'selected': ''; ?> value="5">May</option>  
                                             <option <?php echo $current_month == 6 ? 'selected': ''; ?> value="6">June</option>  
                                             <option <?php echo $current_month == 7 ? 'selected': ''; ?> value="7">July</option>  
                                             <option  <?php echo $current_month == 8 ? 'selected': ''; ?> value="8">August</option>  
                                             <option <?php echo $current_month == 9 ? 'selected': ''; ?> value="9">September</option>  
                                             <option <?php echo $current_month == 10 ? 'selected': ''; ?> value="10">October</option>  
                                             <option <?php echo $current_month == 11 ? 'selected': ''; ?> value="11">November</option>  
                                             <option <?php echo $current_month == 12 ? 'selected': ''; ?> value="12">December</option>  
                                        </select>
                                    </div>   
                                </div>
                            </div> 
                            <div class="col-md-2 col-sm-4">
                                <div class="form-group">
                                    <?php
                                        $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Create statement');
                                        echo form_button($data);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-1"></div>
                </div>
                <?php form_close(); ?>
            <div class="make-container-center">

        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                   <h2 style="text-align:center">Bank Reconcile </h2>
                   <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3> 
                    <h4 style="text-align:center">
                        <?php 
                            if( $bank_detail[0] != NULL)
                            {
                        ?>
                                <u> <?php echo $bank_detail[0]->bankname; ?></u>
                        <?php         
                            }
                        ?>  
                    </h4>
                   <h4 style="text-align:center"><b>Month</b> <?php echo $period; ?> 
                   </h4>
                   <h4 style="text-align:center">Created <?php echo Date('Y-m-d'); ?> 
                   </h4>
                </div>
            <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <table class="table table-hover table-responsive" id="dataTable">
                <tbody>   
                    <tr class="clickable-row" data-href="">
                        <td class=""><i class="fa fa-plus-circle" aria-hidden="true"></i> Add (Deposits that not recorded)</td>
                        <td></td>        
                        <td></td>  
                        <td></td>        
                        <td></td>        
                        <td></td>        
                    </tr>
                    <tr class="clickable-row ledger_head">
                        <td >Date</td>
                        <td>Type</td>        
                        <td>No</td>
                        <td>Name</td>        
                        <td>Amount</td>          
                        <td></td>          
                    </tr>
                    <?php 
                        $total_deposit = 0;
                        if($not_deposits != NULL)
                        {

                            foreach ($not_deposits as $single_despoit) 
                            {
                                $total_deposit = $total_deposit + $single_despoit->total_bill;
                    ?>
                                <tr class="clickable-row" >
                                    <td ><?php echo $single_despoit->cleared_date; ?></td>
                                    <td><?php echo $single_despoit->method; ?></td>        
                                    <td><?php echo $single_despoit->ref_no; ?></td>
                                    <td><?php echo $single_despoit->customer_name; ?></td>        
                                    <td><?php echo $single_despoit->total_bill; ?></td>          
                                    <td></td>          
                                </tr> 
                    <?php
                            }
                        }
                    ?>  
                      <tr class="clickable-row" >
                            <td></td>
                            <td></td>        
                            <td></td>
                            <td></td>        
                            <td></td>          
                            <td><b><?php echo number_format($total_deposit,3,'.',''); ?></b></td>          
                     </tr> 
                     <tr class="clickable-row " data-href="">
                        <td colspan="6" class=""><i class="fa fa-minus-circle" aria-hidden="true"></i> 
                            Deduct (Outstanding checks)
                        </td>        
                    </tr>
                    <tr class="clickable-row ledger_head" data-href="">
                        <td>Date</td>
                        <td>Type</td>        
                        <td>No</td>
                        <td>Name</td>        
                        <td>Amount</td>          
                        <td></td>          
                    </tr>
                    <?php 
                        $total_out = 0;
                        if($out_standing != NULL)
                        {
                            foreach ($out_standing as $single_cheque) 
                            {
                                $total_out = $total_out + $single_cheque->total_paid;
                    ?>
                                <tr class="clickable-row" >
                                    <td ><?php echo $single_cheque->cleared_date; ?></td>
                                    <td><?php echo $single_cheque->method; ?></td>        
                                    <td><?php echo $single_cheque->ref_no; ?></td>
                                    <td><?php echo $single_cheque->customer_name; ?></td>        
                                    <td><?php echo $single_cheque->total_paid; ?></td>          
                                    <td></td>          
                                </tr> 
                    <?php
                            }
                        }
                    ?>  
                    <tr class="clickable-row" >
                            <td></td>
                            <td></td>        
                            <td></td>
                            <td></td>        
                            <td></td>          
                            <td><b><?php echo number_format($total_out,3,'.',''); ?></b></td>          
                     </tr> 
                   
                    <tr class="clickable-row " data-href="">
                        <td colspan="6" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</td>
                    </tr> 
                    <tr class="clickable-row" data-href="">
                        <?php
                        $total_collection = 0; 
                        if($bank_profit != NULL)
                        {
                            foreach ($bank_profit as $single_profit) 
                            {
                                $total_collection = $total_collection + $single_profit->amount;
                        ?>
                                 <tr class="clickable-row" >
                                    <td class=""><?php echo $single_profit->name; ?> </td>
                                    <td></td>
                                    <td></td>        
                                    <td></td>
                                    <td><?php echo $single_profit->amount; ?> </td>        
                                    <td> </td>        
                                              
                                </tr>
                        <?php

                            }
                        }   
                     ?>         
                    </tr>
                     <tr class="clickable-row" >
                            <td></td>
                            <td></td>        
                            <td></td>
                            <td></td>        
                            <td></td>          
                            <td><b><?php echo number_format($total_collection,3,'.',''); ?></b></td>          
                     </tr> 
                    <tr class="clickable-row " data-href="">
                        <td colspan="5" ><i class="fa fa-minus-circle" aria-hidden="true"></i> Deduct</td>    
                    </tr> 
                    <?php 
                    $total_deduction = 0;
                    if($bank_expense != NULL)
                    {
                        foreach ($bank_expense as $single_expense) 
                        {
                            $total_deduction = $total_deduction + $single_expense->price;  
                    ?>
                             <tr class="clickable-row" data-href="">
                                <td class=""><?php echo $single_expense->name; ?> </td>
                                <td></td>
                                <td></td>        
                                <td></td>
                                <td><?php echo $single_expense->price; ?> </td>        
                                <td> </td>        
                                          
                            </tr>
                    <?php
                        }
                    }   
                     ?>
                     <tr class="clickable-row" >
                            <td></td>
                            <td></td>        
                            <td></td>
                            <td></td>        
                            <td></td>          
                            <td><b><?php echo number_format($total_deduction,3,'.',''); ?></b></td>          
                     </tr> 
                      <tr class="clickable-row " data-href="">
                        <td class="">Balance Per depositor's records <?php echo $period; ?> </td>
                        <td></td>        
                        <td></td> 
                        <td></td>        
                        <td></td>         
                        <td><b><?php echo $bank_total; ?></b></td>         
                    </tr> 
                </tbody>
            </table>
        </div>
    </div>
</section>