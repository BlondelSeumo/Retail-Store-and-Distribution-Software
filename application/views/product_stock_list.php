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
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Available Stock List</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    $total_stock = 0;
                                    $total_worth = 0;
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
                    				if($product != NULL)
                                    {
                                       $sno = 1;
                    					foreach ($product as $single_item)
                                        {
                                            $total_stock =  $total_stock+$single_item->quantity;
                                            $total_worth = $total_worth+($single_item->quantity*$single_item->purchase);
                    				?>
                                    <tr>
                                        <td>
                                            <?php echo $sno++; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->product_name; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->sku; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->mg.' '.$single_item->unit_type; ?>
                                        </td> 
                                        <td>
                                           <?php 
                                                $result = fetch_single_qty_item($single_item->id);
                                                echo ($result != NULL ? $result  : '0');
                                              ?>
                                        </td> 
                                        <td>
                                            <?php 
                                                $result = fetch_single_return_item($single_item->id);
                                                echo ($result != NULL ? $result  : '0');
                                              ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->quantity  ; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->purchase  ; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->retail; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->quantity*$single_item->purchase; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->whole_sale; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->pack_cost; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->whole_sale-$single_item->pack_cost; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_item->tax; ?>
                                        </td> 
                                        <td>
                                            <?php echo $single_item->location; ?>
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
    <div class="row bg-setting-product">
        <div class="col-md-12">
            <p><b> Total no of items in stock(<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>)</b>  <?php echo $total_stock; ?> which
               <b> net worth of (<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>): </b> <?php echo $total_worth; ?> /-

            </p>
        </div>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->        