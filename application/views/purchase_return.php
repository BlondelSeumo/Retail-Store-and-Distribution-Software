<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <a class="btn btn-info btn-flat btn-lg" href="<?php echo base_url('purchase/create_purchase');?>" ><i class="fa fa-plus-square" aria-hidden="true"></i> 
                    Create Purchase
                </a>
                <a class="btn btn-success btn-flat btn-lg" href="<?php echo base_url('purchase/return_purchase');?>" ><i class="fa fa-arrow-left" aria-hidden="true"></i> 
                    Purchase Return
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-lg btn-flat   pull-right "><i class="fa fa-print  pull-left"></i>    
                    Print Report
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                     <br>
                    <small>By default it will fetch the return purchases of current month.  </small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php
                            $attributes = array('id'=>'return_purchase_form','method'=>'post',);
                        ?>
                        <?php echo form_open('purchase/return_list',$attributes); ?>
                        <div class="col-md-12  ">
                            <div class="form-group margin ">
                                <?php echo form_label('Date From:'); ?>
                                <div class="input-group date ">
                                    <div class="input-group-addon   ">
                                        <i class="fa fa-calendar "></i>
                                    </div>
                                    <?php
                                        $data = array('class'=>'form-control  input-lg','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                        echo form_input($data);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group margin">
                                <?php echo form_label('Date To:'); ?>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php
                                            $data = array('class'=>'form-control  input-lg' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                            echo form_input($data);
                                        ?>
                                    </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                                <?php
                                    $data = array('class'=>'btn btn-info btn-lg btn-flat margin  pull-right','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search P.Returns');
                                    echo form_button($data);
                                 ?>
                            </div>
                            <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
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
                                $total_bill = 0;
                                $total_pur = 0;
                                $total_bal = 0;

                            if($purchase_list != NULL)
                            {

                                foreach ($purchase_list as $single_purchase)
                                {
                                    $total_bill = $total_bill+$single_purchase->total_bill;
                                    $total_pur = $total_pur + $single_purchase->total_paid;
                                    $total_bal = $total_bal + $single_purchase->total_bill-$single_purchase->total_paid;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $single_purchase->id; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->invoice_id; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->total_bill; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->total_paid; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_purchase->total_bill-$single_purchase->total_paid; ?>
                                    </td>                                   
                                    <td>
                                        <?php echo $single_purchase->payment_type_id; ?>
                                    </td>                                     
                                    <td>
                                        <?php echo $single_purchase->payment_date; ?>
                                    </td>
                                    <td>
                                      <?php 
                                            if($single_purchase->status == 0)
                                            {  
                                                echo "Purchased";
                                            }
                                            else
                                            {
                                                echo "P.Return";
                                            }
                                       ?>
                                    </td>
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="btn btn-info btn-flat">Action</button>
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li onclick="show_modal_page('<?php echo base_url().'purchase/popup/view_purchase_detail/'.$single_purchase->id; ?>')" >
                                                    <a href="#"><i class="fa fa-pencil"></i> View details</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url().'prints/purchase_return/'.$single_purchase->id; ?>" > <i class="fa fa-image"></i> Preview </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                 ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-setting-product">
            <div class="col-md-12">
                <b>P.Return Bill : </b>  <?php echo number_format($total_bill,'3','.',''); ?>/-
                <b>P.Return Recieved : </b>    <?php echo number_format($total_pur,'3','.',''); ?>/-
                <b>P.Return Receivable  : </b>   <?php echo number_format($total_bal,'3','.',''); ?>/-
            </div>
        </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 