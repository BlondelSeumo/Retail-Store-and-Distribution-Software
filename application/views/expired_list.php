<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg pull-right "><i class="fa fa-print pull-left"></i> Print Report</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box " id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body ">
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
                    				if($expire_result != NULL)
                                    {
                    					foreach ($expire_result as $single_item)
                                        {
                    				?>
                                    <tr>
                                        <td>
                                            <?php echo $single_item->product_name; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->mg.' '.$single_item->unit_type; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->manufacturing  ; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->expire; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->quantity; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->purchase; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->retail; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->quantity*$single_item->retail; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->location; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group no-print pull pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Action</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu " role="menu">
                                                    <li>  <a onclick="confirmation_alert('move this  ','<?php echo base_url().'product/change_status/'.$single_item->id.'/2'; ?>')"  href="javascript:void(0)" ><i class="fa  fa-arrow-circle-o-right"></i> Move to expired</a>
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
