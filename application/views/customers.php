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
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
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
                                if($customer_list != NULL)
                                {
                                    foreach ($customer_list as $obj_customer_list)
                                    {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $obj_customer_list->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $obj_customer_list->cus_email; ?>
                                    </td>
                                    <td>
                                        <?php echo $obj_customer_list->cus_contact_1; ?>
                                    </td>
                                    <td>
                                        <?php echo $obj_customer_list->cus_town; ?>
                                    </td>

                                    <td>
                                        <?php echo img(array('width'=>'40','height'=>'40','class'=>'img-circle','src'=>'uploads/customers/'.$obj_customer_list->cus_picture)); ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if($obj_customer_list->cus_status == 0)
                                        {
                                         echo "Active";
                                        }
                                        else
                                        {
                                            echo "In active";
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

                                                <li onclick="show_modal_page('<?php echo base_url().'customers/popup/edit_customer_model/'.$obj_customer_list->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> View details</a></li>
                                                <li>
                                                    <a onclick="confirmation_alert('delete this  ','<?php echo base_url().'customers/delete/'.$obj_customer_list->id; ?>')"  href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                </li>  
                                                <?php
                                                if($obj_customer_list->cus_status != 0)
                                                {                                   
                                                ?>
                                                    <li>
                                                        <a onclick="confirmation_alert('make this active','<?php echo base_url(); ?>customers/change_status/<?php echo $obj_customer_list->id; ?>/0')"  href="javascript:void(0)"  ><i class="fa fa-minus"></i> Active</a>
                                                    </li>
                                                    <?php
                                                    }
                                                     if($obj_customer_list->cus_status != 1)
                                                    {       
                                                    ?>
                                                        <li>
                                                            <a onclick="confirmation_alert('make this in active','<?php echo base_url(); ?>customers/change_status/<?php echo $obj_customer_list->id; ?>/1')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> In active</a>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>  
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
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 