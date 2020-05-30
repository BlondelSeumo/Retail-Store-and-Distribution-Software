<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>product/popup/add_stock_model')" class="btn btn-primary btn-flat btn-lg" ><i class="fa fa-plus-square" aria-hidden="true"></i>
                    <?php echo $page_stock_button_name; ?>
                </button>
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
                    				if($stock_list != NULL)
                                    {
                                        $sno = 1;
                    					foreach ($stock_list as $single_list)
                                        {
                    				?>
                                    <tr>
                                        <td>
                                            <?php echo $sno; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->product_name; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_list->mg.' '.$single_list->unit_type; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->manufacturing  ; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->expiry; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->qty; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->purchase; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->selling; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->pack_retail_price; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->pack_purchase_price; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->date; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list->added; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group no-print pull pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Action</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu " role="menu">
                                                    <li>
                                                        <a onclick="confirmation_alert('update this to stock  ','<?php echo base_url().'product/update_to_stock/'.$single_list->id; ?>')"  href="javascript:void(0)"><i class="fa  fa-arrow-circle-o-right"></i> Update to stock
                                                        </a>
                                                    </li> 
                                                    <li onclick="show_modal_page('<?php echo base_url().'product/popup/edit_stock_model/'.$single_list->id; ?>')  " >        
                                                        <a href="#"><i class="fa fa-pencil"></i> Edit</a>
                                                    </li>
                                                    <!-- <li  >      
                                                        <a onclick="confirmation_alert('delete this ','//echo base_url().'product/delete_stock/'.$single_list->id; ?>')"  href="javascript:void(0)" >       <i class="fa fa-trash"></i>   Delete
                                                        </a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                         $sno++;
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
