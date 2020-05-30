<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <a type="button" class="btn btn-info btn-flat" href="<?php echo base_url('bank/create_collection'); ?>" ><i class="fa fa-plus-square" aria-hidden="true"></i>        Create payment
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report
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
                                if($collect_list != NULL)
                                {
                                    foreach ($collect_list as $collect)
                                    {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $collect->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $collect->bankname; ?>
                                    </td> 
                                    <td>
                                        <?php echo $collect->headname; ?>
                                    </td>  
                                    <td>
                                        <?php echo $collect->amount; ?>
                                    </td>
                                    <td>
                                        <?php echo $collect->naration; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                 <li>
                                                     <a href="<?php echo base_url('bank/edit_collection/'.$collect->main_trans_id); ?>" >
                                                        <i class="fa fa-pencil"></i> 
                                                        Edit
                                                    </a> 
                                                 </li>  
                                                 <li ><a href="<?php echo base_url('prints/bank_collection/'.$collect->main_trans_id); ?>"><i class="fa fa-link"></i> Preview</a>
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