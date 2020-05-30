<style>
p{
    margin:0px;
}
</style>
<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-md btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header no-print">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                        <?php  echo $table_name; ?>
                    </h3>
                    <p>
                        <small>Used to generate the list of goods supplied to salesman</small>
                    </p>
                </div>
                <div class="box-body">
                    <?php
                    if($order_details != NULL)
                    {
                    ?>
                    <div class="col-md-12">
                        <h3 class="text-center">
                            <?php 
                                echo $company_info[0]->companyname; 
                            ?>
                            (Order List)
                        </h3>
                        
                    </div>                 
                    <div class="col-md-12">
                        <div class="col-md-6 text-left">Salesman : <?php echo $order_details[0]->salesman_name; ?></div>
                        <div class="col-md-6 text-right">Date : <?php echo $order_details[0]->date; ?></div>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table id="" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Sno</td>
                                    <td>Name</td>
                                    <td>Company</td>
                                    <td>Opening Stock(Packs)</td>
                                    <td>Stock Out(Packs)</td>
                                    <td>Stock Return</td>
                                    <td>Stock Sale</td>
                                    <td>Qty</td>
                                    <td>Rate (<?php echo $company_info[0]->currency; ?>)</td>
                                    <td>Total (<?php echo $company_info[0]->currency; ?>)</td>
                                    <td>Closing Stock</td>
                                    <td>Lose items</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                    
                            $counter = 1;
                            $total = 0;
                            if($sub_order != NULL)
                            {
                                
                                foreach ($sub_order as $single_list)
                                {
                                    $discount =  (($single_list->price * $single_list->pack) / 100) * $single_list->discount;
                                    
                                    $total = $total + (($single_list->price * $single_list->pack) - $discount);
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $counter++; ?>
                                        </td>
                                        <td>
                                           <small> <?php echo $single_list->product_name; ?></small>
                                        </td>
                                        <td>
                                           <small> <?php echo $single_list->customer_name; ?></small>
                                        </td>
                                        <td>
                                            <?php echo $single_list->opening_stock; ?>
                                        </td>
                                        <td>
                                        <?php echo $single_list->pack; ?>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                           
                                        </td>
                                        <td>
                                            <?php echo $single_list->price;  ?>
                                        </td>
                                        <td>
                                            <?php echo ($single_list->price * $single_list->pack) - $discount; ?>
                                            <small style="float:right;"> (<?php echo $single_list->discount.'%'; ?>)</small>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <table class="table table-hover table-bordered table-striped">
                        <?php
                            $attributes = array('id'=>'order_summary','method'=>'post',);
                        ?>
                        <?php echo form_open('order_list/update_summary',$attributes); ?>
                            <tr>
                                <th colspan="2">Order Summary (Note all amounts are in <?php echo $company_info[0]->currency; ?>)</th>
                            </tr>
                            <tr>
                              <td>Total amount</td>
                              <th> <?php echo $order_details[0]->total_amount; ?></th>
                            </tr> 
                            <tr>
                              <td>Cash</td>
                              <th><input type="number" step="any" name="cash_amount" value="<?php echo $order_details[0]->cash; ?>" class="order-summary-box form-control" /></th>
                            </tr>  
                            <tr>
                              <td>Credit Amount </td>
                              <th><input type="number" step="any" name="credit_amount" value="<?php echo $order_details[0]->credit_amount; ?>" class="order-summary-box form-control" /></th>
                            </tr>  
                            <tr>
                              <td>Cheque Amount</td>
                              <th><input type="number" step="any" name="cheque_amount" value="<?php echo $order_details[0]->cheque_amount; ?>" class="order-summary-box form-control" /></th>
                            </tr>  
                            <tr>
                              <td>Schemes</td>
                              <th><input type="number" step="any" name="schemes" value="<?php echo $order_details[0]->schemes; ?>" class="order-summary-box form-control" /></th>
                            </tr>  
                            <tr>
                              <td>Bank Deposit</td>
                              <th><input type="number" step="any" name="bank_deposits" value="<?php echo $order_details[0]->bank_deposit; ?>" class="order-summary-box form-control" /></th>
                            </tr>  
                            <tr>
                              <td>Return Stock Value</td>
                              <th><input type="number" step="any" name="stock_return" value="<?php echo $order_details[0]->return_stock_val; ?>" class="order-summary-box form-control" /></th>
                            </tr> 
                            <tr>
                              <th>Net Total</th>
                              <th > <?php echo $order_details[0]->total_amount; ?></th>
                            </tr> 
                            <tr class="no-print">
                              <th></th>
                              <th >
                              <input type="hidden" step="any" name="order_id" value="<?php echo $order_details[0]->main_order_id; ?>" />
                                <?php
                                    $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-save" aria-hidden="true"></i> Update');
                                    echo form_button($data);
                                ?>
                              </th>
                            </tr>     
                         </table>  
                            
                            <?php echo form_close(); ?>         
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