<section class="content">
    <div class="row" id="print-section">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?> From <?php echo $date1; ?> - to - <?php echo $date2; ?>
                    </h3>
                </div>
                <div class="box-body" >
                    <?php
                        $attributes = array('id'=>'Sales_form','method'=>'post','class'=>'form-horizontal');
                    ?>
                    <?php echo form_open('sales_report/return_item_report',$attributes); ?>
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
                             <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg  pull-right "><i class="fa fa-print pull-left"></i> Print Report</button>

                            <?php
                                $data = array('class'=>'btn btn-info  btn-flat btn-lg pull-right','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search returns');
                                echo form_button($data);
                            ?>
                        </div>
                    </div>
                 <?php echo form_close(); ?> 
                    <div class="col-md-12 table-responsive">
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
                                $total_return = 0;
                                $total_dis = 0;
                                $total_return_paid = 0;
                                if($return_data != NULL)
                                {
                					foreach ($return_data as $single_item)
                                    {      

                                        $total_return = $total_return+$single_item->total_bill;

                                        $total_dis = $total_dis+$single_item->discount_given;

                                        $total_return_paid = $total_return_paid+$single_item->total_paid;
        				    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->invoice_id; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->date; ?>
                                        </td>                                
                                        <td>
                                            <?php echo $single_item->customer_name; ?>
                                        </td>          
                                        <td>
                                            <?php echo $single_item->agent; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->total_bill; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->discount_given; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->total_paid; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format((($single_item->total_bill-$single_item->discount_given)-$single_item->total_paid),'3','.',''); ?>
                                        </td>
                                        <td>
                                            <div class="btn-group no-print pull pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Action</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu " role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('return_items/return_single_invoice/'.$single_item->id); ?>">
                                                            <i class="fa fa-eye"></i> 
                                                            View details
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                        <?php
                        $sno++;
                    			 }
                    		  }
        				?>
                        <?php 
                            $currency = $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
                         ?>
                        <tr >
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo $currency.' '.$total_return; ?> </th>
                            <th  ><?php echo $currency.' '.$total_dis; ?></th>
                            <th  ><?php echo $currency.' '.$total_return_paid; ?></th>
                            <th><?php echo $currency.' '.(($total_return-$total_dis)-$total_return_paid); ?></th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>