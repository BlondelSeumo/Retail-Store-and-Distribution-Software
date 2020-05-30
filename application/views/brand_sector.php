<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button class="btn btn-info btn-flat btn-lg" onclick="show_modal_page('<?php echo base_url().'initilization/popup/add_brand_sector/'; ?>')" ><i class="fa fa-plus-square" aria-hidden="true"></i> Create Brand sector
                </button>
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>initilization/popup/add_csv_model/brand_sector')" class="btn btn-success btn-lg btn-flat ">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    Upload CSV
                </button>
                <a href="<?php echo base_url('initilization/export/brand_sector'); ?>" class="btn btn-primary btn-lg btn-flat ">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export CSV
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-lg btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report
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
                </div>
                <div class="box-body">
                <div class="table-responsive col-md-12">
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
                            if($brand_list != NULL)
                            {
                                foreach ($brand_list as $single_brand)
                                {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $single_brand->sector; ?>
                                    </td> 
                                    <td>
                                        <?php echo $single_brand->created; ?>
                                    </td> 
                                    <td>
                                        <?php echo $single_brand->updated; ?>
                                    </td>    
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="btn btn-info btn-flat">Action</button>
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li onclick="show_modal_page('<?php echo base_url().'initilization/popup/edit_brand_sector/'.$single_brand->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> 
                                                View details</a>
                                                </li>
                                                <li><a onclick="confirmation_alert('delete this  ','<?php echo base_url().'initilization/delete/brand_sector/'.$single_brand->id; ?>')" href="javascript:void(0)" > <i class="fa fa-trash-o"></i> Delete</a>
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