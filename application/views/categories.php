<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>category/popup/add_category_model')" class="btn btn-info btn-lg btn-flat " >
                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                    <?php echo $page_add_button_name; ?>
                </button>           
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>category/popup/add_csv_model')" class="btn btn-success btn-lg btn-flat ">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    Upload CSV
                </button>
                <a href="<?php echo base_url('category/export'); ?>" class="btn btn-primary btn-lg btn-flat ">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export CSV
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg   pull-right ">
                    <i class="fa fa-print pull-left "></i> Print Report
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
                    <h3 class="box-title">
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                             <?php echo $table_name; ?>
                    </h3>
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
                                    if($catagory_records != NULL)
                                    {
                                        foreach($catagory_records as $fetch_records)
                                        {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $fetch_records->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $fetch_records->category_name; ?>
                                        </td>
                                        <td >
                                            <?php echo $fetch_records->description; ?>
                                        </td>
                                        <td>
                                            <?php echo $fetch_records->register_date; ?>
                                        </td>
                                        <td>
                                            <?php echo $fetch_records->added_by; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($fetch_records->status == 0)
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
                                                <button type="button" class="btn btn-info btn-flat">Action
                                                </button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"> </span>
                                                    <span class="sr-only">Toggle Dropdown </span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li onclick="show_modal_page('<?php echo base_url().'category/popup/edit_category_model/'.$fetch_records->id; ?>')">
                                                        <a href="#"> <i class="fa fa-pencil"> </i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a  onclick="confirmation_alert('delete this  ','<?php echo base_url();?>category/delete/<?php echo $fetch_records->id; ?>')"  href="javascript:void(0)"> <i class="fa fa-trash-o"> </i> Delete </a>
                                                    </li>
                                                    <li>
                                                        <?php
                                                        if($fetch_records->status == 0)
                                                        {
                                                        ?>
                                                           
                                                            <a onclick="confirmation_alert('in active this  ','<?php echo base_url(); ?>category/change_status/<?php echo $fetch_records->id; ?>/1')"  href="javascript:void(0)" > <i class="fa fa-minus"></i> In active</a>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?> 
                                                            <a onclick="confirmation_alert('in active this  ','<?php echo base_url(); ?>category/change_status/<?php echo $fetch_records->id; ?>/0')"  href="javascript:void(0)" ><i class="fa fa-plus"> </i>       Active
                                                            </a>
                                                        <?php
                                                        }
                                                        ?>
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
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 
