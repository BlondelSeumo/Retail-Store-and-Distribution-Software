<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" class="btn btn-info btn-flat btn-lg"  onclick="show_modal_page('<?php echo base_url().'customers/popup/add_customer_model/'; ?>')" ><i class="fa fa-plus-square" aria-hidden="true"></i> Add Customer
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-lg btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3> <br/>
                    <small>By default it will fetch the current months data.</small>
                </div>
                <div class="box-body">
                <?php
                    $attributes = array('id'=>'customer_ledger','method'=>'post','class'=>'');
                ?>
                <?php echo form_open_multipart('customers/create_ledger',$attributes); ?>
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo form_label('Date From:'); ?>
                                <?php $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date1');
                                echo form_input($data); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Date To:'); ?>
                                <?php $data1 = array('class'=>'form-control input-lg','type'=>'date','name'=>'date2');
                                echo form_input($data1); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Select customer to genetate ledger.'); ?>
                                <select name="customer_id" class="form-control select2 input-lg">
                                    <?php 
                                    foreach ($customer_list as $single_customer) 
                                    {
                                    ?>
                                        <option value="<?php echo $single_customer->id; ?>">
                                            <?php echo $single_customer->customer_name; ?>     
                                        </option>
                                    <?php 
                                     }
                                    ?>
                                </select>
                        </div> 
                        <div class="form-group">
                            <?php
                                $data = array('class'=>'btn btn-primary btn-flat margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Build ledger  ');
                                
                                echo form_button($data);
                             ?>  
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
                <?php 
                 
                 $currency = $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];

                if($ledger != NULL)
                {
                  ?>
                <h2 class="text-center">
                    <?php echo $heading; ?> 
                </h2>
                <h4 class="text-center">
                    <?php echo $email_phone; ?> 
                </h4>
                <h4  class="purchase-heading"> <i class="fa fa-check-circle"></i> 
                    Purchased Items 
                    <small>List of bills piad by customer against purchases. </small>
                </h4>
                <div class="table-responsive  ">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <?php
                                    foreach ($table_heading_names_of_coloums as $table_head)
                                    {
                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>

                                    <?php
                                    }
                                    ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($ledger != NULL)
                                {
                                    $total = 0;
                                    $paid = 0;
                                    $balance = 0;
                                    $discount = 0;

                                    foreach ($ledger as $single_ledger)
                                    {
                                        $discount = $discount + $single_ledger->discount;
                                        $total = $total + $single_ledger->total_bill;
                                        $paid = $paid + $single_ledger->bill_paid;
                                        $balance = $balance + ($single_ledger->total_bill-$single_ledger->bill_paid);
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $single_ledger->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_ledger->total_bill; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_ledger->discount; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_ledger->bill_paid; ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($single_ledger->total_bill-$single_ledger->bill_paid,'3','.',''); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('invoice/single_invoice/').$single_ledger->id; ?>"><?php echo $single_ledger->id; ?></a>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                 ?>
                                 <tr>
                                    <th>Total</th>
                                    <th><?php echo $currency.' '.number_format($total,'3','.',''); ?></th>
                                    <th><?php echo $currency.' '.number_format($discount,'3','.',''); ?></th>
                                    <th><?php echo $currency.' '.number_format($paid,'3','.',''); ?></th>
                                    <th><?php echo $currency.' '.number_format($balance,'3','.',''); ?></th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php 
                }
                 ?>
                <?php 
                if($return_data != NULL)
                {
                    $total = 0;
                    $discount = 0;
                    $paid = 0;
                    $balance = 0;
                ?>
                <h4  class="purchase-heading"><i class="fa fa-check-circle"></i>
                 Purchased return
                 <small>List of amounts paid for customer returns. </small>
                </h4>
                <div class="table-responsive  ">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <?php
                                    foreach ($table_heading_names_of_coloums_retun as $table_head)
                                    {
                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($return_data as $single_return)
                            {
                                $total = $total + $single_return->total_bill;
                                $discount = $discount + $single_return->discount_given;
                                $paid = $paid + $single_return->return_amount;
                                $balance = $balance + ($single_return->total_bill-$single_return->discount_given)-$single_return->return_amount;
                        ?>
                            <tr>
                                <td>
                                    <?php echo $single_return->date; ?>
                                </td>
                                <td>
                                    <?php echo $single_return->total_bill; ?>
                                </td>
                                <td>
                                    <?php echo $single_return->discount_given; ?>
                                </td>
                                <td>
                                    <?php echo $single_return->return_amount; ?>
                                </td>
                                <td>
                                    <?php echo number_format(($single_return->total_bill-$single_return->discount_given)-$single_return->return_amount,'3','.',''); ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('return_items/return_single_invoice/'.$single_return->id); ?>"><?php echo $single_return->invoice_id; ?></a>
                                </td>
                            </tr>
                                <?php
                                 }
                                 ?>
                            <tr>
                                <th>Total</th>
                                
                                <th><?php echo $currency.' '.number_format($total,'3','.',''); ?></th>
                                <th><?php echo $currency.' '.number_format($discount,'3','.',''); ?></th>
                                <th><?php echo $currency.' '.number_format($paid,'3','.',''); ?></th>
                                <th><?php echo $currency.' '.number_format($balance,'3','.',''); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php 
                }
                ?>
                <?php 
                if($recieved_payments != NULL)
                {
                    $total = 0;
                    $paid = 0;
                    $balance = 0;
                ?>
                <h4  class="purchase-heading"><i class="fa fa-check-circle"></i> 
                    Customer paid amount
                    <small>List of amounts piad by customer against balances. </small>
                </h4>
                <div class="table-responsive  ">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <?php
                            foreach ($table_heading_names_of_coloums_recieved as $table_head)
                            {
                            ?>
                                <th>
                                    <?php echo $table_head; ?>
                                </th>
                            <?php
                            }
                            ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($recieved_payments as $single_recieved)
                                {
                                    $total = $total + $single_recieved->amount;    
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $single_recieved->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_recieved->method; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_recieved->agentname; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_recieved->amount; ?>
                                    </td>
                                    <td >
                                        <?php echo $single_recieved->description; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                              <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th colspan="2"><?php echo $currency.' '.number_format($total,'3','.',''); ?></th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php 
                        }
                        if($expense_transactions != NULL)
                        {
                            $total = 0;
                            $paid = 0;
                    ?>
                    <h4  class="purchase-heading"><i class="fa fa-check-circle"></i> 
                    Expenses piad to customer
                    <small>List of expense amounts piad to customer. </small>
                    </h4>
                    <div class="table-responsive  ">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <?php
                                foreach ($table_heading_names_of_coloums_expense as $table_head)
                                {
                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>
                                <?php
                                }
                                ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($expense_transactions as $single_single)
                                    {
                                        $total = $total + $single_single->total_bill;    
                                        $paid = $paid + $single_single->total_paid;    
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_single->date; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_single->method; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_single->customer_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_single->user; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_single->total_bill; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_single->total_paid; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_single->total_paid-$single_single->total_paid; ?>
                                        </td>
                                        <td >
                                            <?php echo $single_single->description; ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                              <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th >
                                    <?php echo $currency.' '.number_format($total,'3','.',''); 
                                    ?> 
                                </th>
                                <th >
                                    <?php echo $currency.' '.number_format($paid,'3','.','');?>
                                </th>                                
                                <th >
                                    <?php echo $currency.' '.number_format($total-$paid,'3','.','');?>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php    
                    }    

                        $received_total = 0;
                        $paid_total = 0;
                        if($bank_transactions != NULL)
                        {  
                    ?>
                        <h4  class="purchase-heading"><i class="fa fa-check-circle"></i> 
                            Transactions occured via banks
                            <small>List of cheques piad or recieved from customer. </small>
                        </h4>
                        <div class="table-responsive  ">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <?php
                                    foreach ($table_heading_names_of_coloums_transaction as $table_head)
                                    {
                                    ?>
                                        <th>
                                            <?php echo $table_head; ?>
                                        </th>
                                    <?php
                                    }
                                    ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($bank_transactions as $single_trans)
                                        {
                                            //FOR CALCULATING PAID
                                            if($single_trans->transaction_status == 0 AND $single_trans->transaction_type == 'paid')
                                            {
                                                $paid_total = $paid_total + $single_trans->total_paid;
                                            }
                                            
                                            //FOR CALCULATING RECEIVED
                                            if($single_trans->transaction_status == 0 AND $single_trans->transaction_type == 'recieved')
                                            {
                                                $received_total = $received_total + $single_trans->total_paid;
                                            }   
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $single_trans->date; ?>
                                            </td>
                                            <td>
                                                <?php echo $single_trans->bankname; ?>
                                            </td>
                                            <td>
                                                <?php echo $single_trans->customer_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $single_trans->total_paid; ?>
                                            </td>
                                            <td >
                                                <?php echo $single_trans->ref_no; ?>
                                            </td> 
                                            <td >
                                               <?php 
                                                    if($single_trans->transaction_status == 0 AND $single_trans->transaction_type == 'paid')
                                                    {
                                                        echo 'Cleared';
                                                    }
                                                    else if($single_trans->transaction_status == 1 AND $single_trans->transaction_type == 'paid')
                                                    {
                                                        echo 'Outstanding';
                                                    }
                                                    else if($single_trans->transaction_status == 0 AND $single_trans->transaction_type == 'recieved')
                                                    {
                                                        echo 'Deposited';
                                                    }
                                                    else if($single_trans->transaction_status == 1 AND $single_trans->transaction_type == 'recieved')
                                                    {
                                                        echo 'Not Deposited';
                                                    }
                                                ?>
                                            </td>
                                            <td >
                                                <?php 
                                                    if($single_trans->transaction_type == 'paid')
                                                    {
                                                        echo "Paid";
                                                    }
                                                    else
                                                    {
                                                        echo "Recieved";      
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    <tr>
                                        <th>Total Received</th>
                                        <th> <?php echo $currency.' '.$received_total; ?> /- </th>
                                    </tr>
                                    <tr>
                                        <th>Total Paid</th>
                                        <th> <?php echo $currency.' '.$paid_total; ?> /- </th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                                }
                             ?>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 