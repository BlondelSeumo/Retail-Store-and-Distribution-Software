<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button class="btn btn-info btn-flat btn-lg" onclick="show_modal_page('<?php echo base_url().'printer_settings/popup/add_new_printer_model/'; ?>')" ><i class="fa fa-plus-square" aria-hidden="true"></i> Create Printer
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
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Thermal printers :</h3>
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
                                if($print_record != NULL)
                                {
                                    foreach ($print_record as $single_printer)
                                    {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_printer->printer_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_printer->fontsize; ?>
                                        </td>
                                        <td>
                                            <?php echo ($single_printer->set_default == 0 ? 'No' : 'Yes'); ?>
                                        </td>
                                        <td>
                                            <div class="btn-group pull no-print pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Action</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li onclick="show_modal_page('<?php echo base_url().'printer_settings/popup/edit_printer_model/'.$single_printer->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> 
                                                        View details</a>
                                                    </li>
                                                    <li>
                                                        <a onclick="confirmation_alert('delete this  ','<?php echo base_url().'Printer_settings/delete/'.$single_printer->id; ?>')" href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Delete</a>
                                                    </li>                                                    
                                                    <li>
                                                        <a onclick="confirmation_alert('make this default  ','<?php echo base_url().'Printer_settings/change_status/'.$single_printer->id.'/1'; ?>')" href="javascript:void(0)" ><i class="fa fa-print"></i> Make default</a>
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