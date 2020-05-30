<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?> From <?php echo $date1; ?> - to - <?php echo $date2; ?> </h3>
                </div>
                <div class="box-body ">
                <?php
                    $attributes = array('id'=>'top_customers_form','method'=>'post','class'=>'form-horizontal');
                ?>
                <?php echo form_open('sales_report/top_salesman',$attributes); ?>
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
                             <button type="button" onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg  pull-right "><i class="fa fa-print pull-left"></i> Print Report</button>
                            <?php
                                $data = array('class'=>'btn btn-info  btn-flat btn-lg pull-right','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search Report');
                                echo form_button($data);
                            ?>
                        </div>
                    </div>
                 <?php echo form_close(); ?>
                
                <div >
                <div class="col-md-12 table-responsive">
                    <br>
                    <table class="table table-bordered table-striped">
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
    			            
        					foreach ($sales_record as $single_sale) 
                            {
        				    ?>
                                <tr>
                                    <td>
                                        <?php echo $sno; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_sale['name']; ?>
                                    </td>
                                    <td>
                                       <?php echo $single_sale['contact']; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_sale['address']; ?>
                                    </td>
                                     <td>
                                        <?php echo $single_sale['total_sold']; ?>
                                    </td>
                                </tr>
                                <?php
                                     $sno++;
                    				}		
                    			?>
                            </tbody>
                        </table>
                    </div>
                </div>
        <!-- /.box-body -->
            </div>
    <!-- /.box -->
        </div>
    </div>
</div>
<!-- /.col -->