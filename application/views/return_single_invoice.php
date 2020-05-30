<div class="row">
    <div class="col-md-12 ">
        <h4  class="purchase-heading" >  
            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
            View return receipt
            <small>Receipt generated from return items.</small>
        </h4>
    </div>
</div>
    <section class="invoice" id="<?php echo $return_data[0]->id; ?>">
        <div class="row">
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <b>
            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];
            ?>
            </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Phone : </b><?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['phone_number'] ;?>
               </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Bill To : <?php echo $return_data[0]->customer_name;  ?></b>
            </div>                    
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> Bill no # <?php echo $return_data[0]->return_trans_id; ?> </b>
            </div>            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> Against invoice # <?php echo $return_data[0]->invoice_id; ?> </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Bill Date : </b> <?php echo $return_data[0]->date; ?>
            </div>
        </div>
         <div class="col-md-3 col-sm-3 col-xs-12  ">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <b> Agent : </b><?php echo $return_data[0]->agent; ?>
            </div> 
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <b> Mode : </b><?php echo ($return_data[0]->mode == 'single' ? 'Pos' : 'WholeSale'); ?>
            </div>        
         </div>
     </div>
    <div class="row table-responsive">
        <div class="col-xs-12 ">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sku</th>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    $total = 0;
                    $total_tax = 0; 
                    foreach ($return_data as $single_item) 
                    {
                        $subtotal = 0;
                        $subtotal = $single_item->price*$single_item->qty;
                        $total = $total+$subtotal;
                        $total_tax += $single_item->tax*$single_item->qty;
                    ?>
                        <tr style="border-bottom:2px solid #ccc;">
                            <td>
                                <?php echo $counter+1; ?>
                            </td>
                            <td>
                                <?php echo $single_item->product_no; ?>
                            </td>
                            <td>
                                <?php echo $single_item->product_name; ?>
                            </td>
                            <td>
                                <?php echo $single_item->mg.' '.$single_item->unit_type; ?>
                            </td>
                            <td>
                                <?php echo number_format($single_item->price,'3','.',''); ?>
                            </td>
                            <td>
                                <?php echo $single_item->qty; ?>
                            </td>
                            <td>
                                <?php echo number_format($subtotal,'3','.','');?>
                            </td>
                        </tr>
                    <?php
                        $counter++; 
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table">
                        <tr class="text-left" style="border-bottom: 2px dotted #eee;">
                            <th  style="width:50%">Subtotal (<?php echo $currency;?>):</th>
                            <td class="text-center">
                                <?php echo number_format($total,'3','.',''); ?>
                            </td>
                        </tr>
                         <tr  style="border-bottom: 2px dotted #eee;">
                            <th style="width:50%"> Discount (<?php echo $currency;?>):</th>
                            <td class="text-center">
                              <?php echo number_format($return_data[0]->discount_given,'3','.',''); ?>
                            </td>
                        </tr>
                        <?php 
                          $total_after_dis = $total-$return_data[0]->discount_given;

                          $total_after_dis = number_format($total_after_dis,3,'.','');
                      ?>  
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th  style="width:50%">After Discount(
                            <?php echo $currency;?> ):</th>
                        <td class="text-center">
                            <?php echo $total_after_dis; ?>
                        </td>
                    </tr>
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th style="width:50%">Tax (
                            <?php echo $currency ;?>):</th>
                        <td class="text-center">
                            <?php echo number_format($total_tax,'3','.',''); ?>
                        </td>
                    </tr>    
                        <?php
                              $new_amount = $total_after_dis+$total_tax;
                          ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <th>Total (
                            <?php echo $currency ;?>):</th>
                        <td class="text-center">
                            <?php echo number_format($new_amount,'3','.',''); ?>
                        </td>
                    </tr>
                                
                                <tr  style="border-bottom: 2px dotted #eee;">
                                    <td colspan="7"  >
                                         <b>[ Total bill : <?php echo $total_after_dis; ?> </b> /- ] [ <b>
                                         <b> Cash return :</b> <?php echo $return_data[0]->total_paid; ?> /- ] [ <b>  Cash balance:</b> <?php echo number_format($total_after_dis-$return_data[0]->total_paid,'3','.',''); ?> /- ]
                                    </td>
                                </tr>
                              
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div> 