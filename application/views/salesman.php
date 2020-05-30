<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button class="btn btn-info btn-flat btn-lg" onclick="show_modal_page('<?php echo base_url().'supply/popup/add_Saleman/'; ?>')" ><i class="fa fa-plus-square" aria-hidden="true"></i> Create Salesman
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
                                if($salesman_list != NULL)
                                {
                                    foreach ($salesman_list as $single_salesman)
                                    {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_salesman->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_salesman->contact; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_salesman->address; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_salesman->description; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_salesman->ref; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_salesman->date; ?>
                                        </td>                                   
                                        <td>
                                            <?php echo img(array('width'=>'40','height'=>'40','class'=>'img-circle','src'=>'uploads/salesman/'.$single_salesman->cus_picture)); ?>
                                        </td>                                   
                                        <td>
                                            <?php 
                                                if($single_salesman->status == 0)
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
                                                    <li onclick="show_modal_page('<?php echo base_url().'supply/popup/edit_salesman/'.$single_salesman->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> View details</a>
                                                    </li>
                                                    <li><a onclick="confirmation_alert('delete this','<?php echo base_url().'supply/delete/salesman/'.$single_salesman->id; ?>')"  href="javascript:void(0)"  href="#"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </li>
                                                    <?php
                                                        if($single_salesman->status != 0)
                                                        {                                   
                                                    ?>
                                                        <li>
                                                            <a onclick="confirmation_alert('this active','<?php echo base_url(); ?>supply/change_status/salesman/<?php echo $single_salesman->id; ?>/0')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> Active</a>
                                                        </li>
                                                        <?php
                                                            }

                                                             if($single_salesman->status != 1)
                                                            {       
                                                        ?>
                                                            <li>
                                                                <a onclick="confirmation_alert('this in active','<?php echo base_url(); ?>supply/change_status/salesman/<?php echo $single_salesman->id; ?>/1')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> In active</a>
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