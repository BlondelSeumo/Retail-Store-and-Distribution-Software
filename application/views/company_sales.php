<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?> From <?php echo $date1; ?> - to - <?php echo $date2; ?></h3>
                </div>
                <div class="box-body ">
                    <?php
						$attributes = array('id'=>'company_wise_Sales_form','method'=>'post','class'=>'form-horizontal');
					?>
                        <?php echo form_open('sales_report/company_wise',$attributes); ?>
                            <div class="col-md-12 no-print">
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
                                    <?php echo form_label('Select Company:'); ?>
                                    <select name="comapany_id" class="form-control input-lg select2" >
                                        <?php 
                                        if($company_record != NULL)
                                        {
                                            foreach ($company_record as $single_company) 
                                            {
                                        ?>
                                            <option value="<?php echo $single_company->id; ?>">
                                                <?php echo $single_company->customer_name; ?>     
                                            </option>
                                        <?php 
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg  pull-right "><i class="fa fa-print pull-left"></i> Print Report</button>

                                    <?php
										$data = array('class'=>'btn btn-info  btn-flat btn-lg pull-right','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search sales');
										echo form_button($data);
									?>
                                </div>
                            </div>
                    <?php echo form_close(); ?> 
                </div>
                <div>
                    <?php
                     if($invoices_record != NULL)
                     {
                    ?>
                   
                <div class="col-md-12 table-responsive">
                    <h4><i class="fa fa-building"></i> Company : <?php  echo $invoices_record[0]->customer_name; ?></h4>  
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
    			            $sno = 1;
    			            $total_revenue =0;
                            $discount_offered = 0;
                            $total_expense = 0;
                            $total_items_sold = 0;
    			            $totalprofit = 0;

                            foreach ($invoices_record as $single_invoice) 
                            {
                            
    							$total = 0;
    				            $subtotal = 0;
    							 $subtotal = $single_invoice->price*$single_invoice->qty;
                                $total_expense = $total_expense + ($single_invoice->purchase*$single_invoice->qty); 
                                $total = $total+$subtotal;  
                                $new_amount = $single_invoice->discount;     
                                $total_revenue = $total_revenue+$total;    
                                $discount_offered  = $discount_offered+($total-$new_amount);      
                                $totalprofit = $total_revenue-$total_expense;
    				        ?>
                        <tr>
                            <td>
                                <?php echo $sno; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->id; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->date; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->product_name; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->mg.' '.$single_invoice->unit_type; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->price; ?>
                            </td>
                            <td>
                                <?php echo $single_invoice->qty; ?>
                            </td>
                            <td>
                                <?php echo $subtotal; ?>
                            </td>
                        </tr>
                    <?php
                            $total_items_sold += $single_invoice->qty;
        		        }
		          ?>
            </tbody>
        </table>
    </div>
        <section class="content" style="background-color:#fff;">
            <div class="row">
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th><i class="fa fa-arrow-circle-right"></i> Company sales report</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>No of item sold </td>
                        <td class="text-right">
                                <?php echo $total_items_sold; ?>
                        </td>
                    </tr>                    
                    <tr>
                        <td>Total Amount Sold (Without discount)</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $total_revenue; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Total Expense</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $total_expense; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Profit/Lost</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $totalprofit; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Total Discount Offered</td>
                        <td class="text-right">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $discount_offered; ?> /- </td>
                    </tr>
                    <tr>
                        <td>Net Profit/Lost</td>
                        <td class="text-right ">
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>
                                <?php echo $totalprofit-$discount_offered; ?> /- </td>
                    </tr>
                </table>
            </div>
        </section>
        <?php 
         }
         else
         {
            echo '<b class="text-center">'."Sorry no record found".'</b>';
         }
        ?>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->