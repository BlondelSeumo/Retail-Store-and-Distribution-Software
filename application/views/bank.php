<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
                 <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Bank</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>bank/popup/add_bank_model')" class="btn btn-info btn-flat" ><i class="fa fa-plus-square" aria-hidden="true"></i>
                    Add bank
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat   pull-right "><i class="fa fa-print pull-left"></i> Print / Pdf</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
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
                                    if($bank_list != NULL)
                                    {
                                        foreach ($bank_list as $bank)
                                        {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $bank->bankname; ?>
                                        </td>
                                        <td>
                                            <?php echo $bank->branch; ?>
                                        </td>
                                        <td>
                                            <?php echo $bank->branchcode; ?>
                                        </td>
                                        <td>
                                            <?php echo $bank->title; ?>
                                        </td>       
                                        <td>
                                            <?php echo $bank->accountno; ?>
                                        </td>       
                                        <td>
                                            <?php 
                                            if($bank->status == 0)
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
                                            <div class="btn-group no-print pull pull-right">
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li  onclick="show_modal_page('<?php echo base_url().'bank/popup/edit_bank_model/'.$bank->id ?>')"><a href="#"><i class="fa fa-pencil"></i> View details</a>
                                                    </li>
                                                    <li>
                                                        <?php
                                                         if($bank->status == 0)
                                                         {
                                                        ?>
                                                            <a onclick="confirmation_alert('make this in active','<?php echo base_url(); ?>bank/change_status/<?php echo $bank->id; ?>/1')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> 
                                                            In active</a>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                         ?>
                                                            <a onclick="confirmation_alert('make this active ','<?php echo base_url(); ?>bank/change_status/<?php echo $bank->id; ?>/0')" ><i class="fa fa-plus"></i>
                                                                Active
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