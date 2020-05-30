<section class="content">
    <div class="row">
        <div style="margin-bottom:25px;" class="col-xs-12 no-print">
            <div class="col-md-12">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg  pull-right "><i class="fa fa-print pull-left"></i> Print Report</button>
            </div>
        </div>
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
                    				if($product_record_list != NULL)
                                    {
                    					$sno = 1;
                    					foreach ($product_record_list as $obj_product_List)
                                        {
                				?>
                                    <tr>
                                        <td>
                                            <?php echo $sno; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_List->product_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_List->mg; ?>
                                        </td>
                                        <td>
                                            <b style="color: #c00;"><?php echo $obj_product_List->quantity; ?></b>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_List->min_stock; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_List->retail; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $result = fetch_single_pending_item($obj_product_List->id);
                                            if($result != 0)
                                            {
                                                echo $result;
                                             ?>
                                                (<a href="<?php echo base_url('product/pending_stock'); ?>">Move to stock</a>)
                                             <?php   
                                            }
                                            else
                                            {
                                                echo $result;
                                            }
                                            ?>
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
