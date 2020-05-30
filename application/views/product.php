<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>product/popup/add_stock_model')" class="btn btn-primary btn-flat btn-lg" ><i class="fa fa-plus-square" aria-hidden="true"></i>
                    <?php echo $page_stock_button_name; ?>
                </button>
                <a href="<?php echo base_url('product/add_new_product'); ?>"  class="btn btn-info btn-flat btn-lg"><i class="fa fa-plus-square" aria-hidden="true"></i>
                    <?php echo $page_add_button_name; ?>
                </a>
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>product/popup/add_csv_model')" class="btn btn-success btn-lg btn-flat ">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    Upload CSV
                </button>
                <a href="<?php echo base_url('product/export'); ?>" class="btn btn-primary btn-lg btn-flat ">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export CSV
                </a>
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
                                        <td>
                                            <?php echo $table_head; ?>
                                        </td>
                                    <?php
                                        }
                                     ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total_stock = 0;
                                    $total_worth = 0;
                                    $sno = 1;
                                    if($product_record_list != NULL)
                                    {
                                        foreach ($product_record_list as $obj_product_record_list)
                                        {
                                            $total_stock = $total_stock +
                                            $obj_product_record_list->quantity; 
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->product_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->mg.' '.$obj_product_record_list->unit_type; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->category_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->name; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $result = fetch_single_qty_item($obj_product_record_list->id);
                                                echo ($result != NULL ? $result  : '0');
                                              ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->quantity; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->purchase; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->retail; ?>
                                        </td>
                                        <td>
                                            <?php
                                                 echo $obj_product_record_list->purchase*
                                                  $obj_product_record_list->quantity;

                                                  $total_worth = $total_worth + (
                                                  $obj_product_record_list->purchase* $obj_product_record_list->quantity);
                                             ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->pack_cost; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->whole_sale; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->whole_sale - $obj_product_record_list->pack_cost; ?>
                                        </td>
                                        <td>
                                            <?php echo $obj_product_record_list->tax; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($obj_product_record_list->status == 0)
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
                                                <button type="button" class="btn btn-info btn-flat">Action</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu " role="menu">
                                                    <li>
                                                        <a href="<?php echo base_url('product/product_details/'.$obj_product_record_list->id); ?>">
                                                            <i class="fa fa-pencil"></i> View details
                                                        </a>
                                                    </li>
                                                    <li><a onclick="confirmation_alert('delete this ','<?php echo base_url().'product/Delete/'.$obj_product_record_list->id; ?>')" href="javascript:void(0)"> <i class="fa fa-trash-o"></i> Delete</a></li>
                                                    <li>
                                                        <?php

                                                            if($obj_product_record_list->status == 0)
                                                            {
                                                        ?>
                                                            <a onclick="confirmation_alert('in active this','<?php echo base_url(); ?>product/change_status/<?php echo $obj_product_record_list->id; ?>/1')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> In active</a>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                                <a onclick="confirmation_alert('active this  ','<?php echo base_url(); ?>product/change_status/<?php echo $obj_product_record_list->id; ?>/0')"  href="javascript:void(0)" ><i class="fa fa-plus"></i> Active</a>
                                                            <?php
                                                            }
                                                            ?>
                                                    </li>
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
    <div class="row bg-setting-product">
        <div class="col-md-12">
            <p><b> Total items in stock(<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>)</b> is <?php echo $total_stock; ?> which
               <b> net worth of (<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>): </b> <?php echo $total_worth; ?> /-
            </p>
        </div>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->        
