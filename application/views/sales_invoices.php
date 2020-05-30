<div class="row">
    <div class="col-md-12 ">
        <?php
            $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];

            $attributes = array('id'=>'invoice_form','method'=>'post',);
        ?>
        <?php echo form_open('invoice/manage',$attributes); ?>
            <div class="col-md-12  ">
                <div class="form-group margin ">
                    <?php echo form_label('Date From:'); ?>
                        <div class="input-group date ">
                            <div class="input-group-addon   ">
                                <i class="fa fa-calendar "></i>
                            </div>
                            <?php
                                $data = array('class'=>'form-control  input-lg','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group margin">
                    <?php echo form_label('Date To:'); ?>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php
                                $data = array('class'=>'form-control  input-lg' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
                                echo form_input($data);
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group margin ">
                    <?php echo form_label('OR Enter receipt no:'); ?>
                        <?php
                            $data = array('class'=>'form-control input-lg' ,'type'=>'number','name'=>'invoice_no','reqiured'=>'');
                            echo form_input($data);
                        ?>
                </div>
            </div>
            <div class="col-md-12">
                <?php
                    $data = array('class'=>'btn btn-info btn-lg btn-flat margin  pull-right','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search receipts');
                    echo form_button($data);
                 ?>
            </div>
            <?php echo form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 ">
        <h4  class="purchase-heading" >  
            <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
            View receipts
            <small>Receipt  generated from POS and create supply.</small>
        </h4>
    </div>
</div>
<?php
    for($i = 0; $i < count($Sales_Record); $i++)
    {
?>
    <section class="invoice" id="<?php echo $Sales_Record[$i][0]->id; ?>">
        <div class="row no-print">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                  <!-- <button class="btn btn-primary  btn-flat  pull-right"  onclick="show_modal_page('<?php echo base_url().'invoice/popup/edit_invoice_model/'.$invoices_Record[$i]->id ?>')"><i class="fa fa-pencil pull-left"></i> 
                  Edit</button>  -->
                  <button class="btn btn-default  btn-flat  pull-right"  onclick="printDiv(<?php echo $Sales_Record[$i][0]->id; ?>)" ><i class="fa fa-print pull-left"></i> 
                  Print 
                  </button>
            </div>
        </div>
        <div class="row">
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <b>
            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
            </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Phone : </b><?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['contact'] ;?>
               </b>
            </div>
         <?php
            if($invoices_Record[$i]->cus_id != 0)
            {
               $customer_arr =  $this->db->get_where('mp_payee', array('id' => $invoices_Record[$i]->cus_id))->result_array();
               if($customer_arr != NULL)
               {   
        ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Bill To : <?php echo $customer_arr[0]['customer_name'];  ?></b>
            </div>            
        <?php        
                }
             }
        ?>         
            <div class="col-md-12 col-sm-12 col-xs-12">
                <b> Bill no # <?php echo $invoices_Record[$i]->id; ?> </b>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b> Bill Date : </b> <?php echo $invoices_Record[$i]->date; ?>
            </div>
            <?php
            if($invoices_Record[$i]->sales_man_id != 0)
            {
               $result =  $this->db->get_where('mp_salesman', array('id' => $invoices_Record[$i]->sales_man_id))->result_array();
               if($result != NULL)
               {   
        ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Salesman : <?php echo $result[0]['name'];  ?></b>
            </div>            
        <?php        
                }
             }
        ?>
             <div class="col-md-12 col-sm-12 col-xs-12">
                 <b >
                    <?php
                       if($invoices_Record[$i]->status == 1)
                       {
                    ?>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <?php
                        echo "Editted";
                      } 
                      ?>
                </b>    
            </div>
        </div>
         <div class="col-md-3 col-sm-12 col-xs-12  ">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <b> Agent : </b><?php echo $invoices_Record[$i]->agentname; ?>
                </div>
                <?php
                    if($invoices_Record[$i]->driver_id != 0)
                    {
                        $result =  $this->db->get_where('mp_drivers', array('id' => $invoices_Record[$i]->driver_id))->result_array();
                        if($result != NULL)
                        {   
                ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <b>  Driver : <?php echo $result[0]['name'];  ?></b>
                    </div>            
                <?php        
                        }
                    }
                ?> 
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <b> Mode : <?php echo ($invoices_Record[$i]->source == 0 ? 'POS': 'Whole Sale');  ?></b>
                </div>                 
        <?php
            if($invoices_Record[$i]->vehicle_id != 0)
            {
               $result =  $this->db->get_where('mp_vehicle', array('id' => $invoices_Record[$i]->vehicle_id))->result_array();
               if($result != NULL)
               {   
        ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Vehicle : <?php echo $result[0]['name'];  ?></b>
            </div>            
        <?php        
                }
             }
        ?>        
        <?php
            if($invoices_Record[$i]->region_id != 0)
            {
               $result =  $this->db->get_where('mp_town', array('id' => $invoices_Record[$i]->region_id))->result_array();
               if($result != NULL)
               {   
        ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Region : <?php echo $result[0]['region'].' / '.$result[0]['name'];  ?></b>
            </div>            
        <?php        
                }
             }
        ?>
         <?php
            if($invoices_Record[$i]->store_id != 0)
            {
               $result =  $this->db->get_where('mp_stores', array('id' => $invoices_Record[$i]->store_id))->result_array();
               if($result != NULL)
               {   
        ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <b>  Store : <?php echo $result[0]['name'];  ?></b>
            </div>            
        <?php        
                }
             }
        ?>
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
                        <th><?php echo ($invoices_Record[$i]->source == 0 ? 'Qty': 'Packs');  ?></th>
                        <th>Discount(%)</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    $total = 0;
                    $total_tax = 0; 
                    while( $counter < count($Sales_Record[$i]))
                    {


                        $total_discount = 0;
                        $subtotal = 0;
                        $subtotal = $Sales_Record[$i][$counter]->price*$Sales_Record[$i][$counter]->qty;
                        $total = $total+$subtotal;
                        $total_tax += $Sales_Record[$i][$counter]->tax*$Sales_Record[$i][$counter]->qty;

                        $total_discount = $total_discount + ((($Sales_Record[$i][$counter]->price * $Sales_Record[$i][$counter]->qty) / 100) * $Sales_Record[$i][$counter]->discount);

                    ?>
                        <tr style="border-bottom:2px solid #ccc;">
                            <td>
                                <?php echo $counter+1; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->product_no; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->product_name; ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->mg.' '.$Sales_Record[$i][$counter]->unit_type; ?>
                            </td>
                            <td>
                                <?php echo number_format($Sales_Record[$i][$counter]->price,'3','.',''); ?>
                            </td>
                            <td>
                                <?php
                                    if($invoices_Record[$i]->source == 1)
                                    {
                                        echo $Sales_Record[$i][$counter]->qty; 
                                    }
                                    else
                                    {
                                        echo $Sales_Record[$i][$counter]->qty; 
                                    }  
                                ?>
                            </td>
                            <td>
                                <?php echo $Sales_Record[$i][$counter]->discount; ?>
                            </td>
                            <td>
                                <?php echo number_format($subtotal-$total_discount,'3','.','');?>
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
                            <th  style="width:80%">Subtotal (<?php echo $currency;?>):</th>
                            <td class="text-center">
                                <?php echo number_format($total,'3','.',''); ?>
                            </td>
                        </tr>
                         <tr  style="border-bottom: 2px dotted #eee;">
                            <th style="width:80%">Total Discount (<?php echo $currency;?>):</th>
                            <td class="text-center">
                              <?php echo number_format($invoices_Record[$i]->discount,'3','.',''); ?>
                            </td>
                        </tr>
                        <?php 
                          $total_after_dis = $total-$invoices_Record[$i]->discount;
                        ?>  
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th  style="width:80%">After Discount(
                            <?php echo $currency;?> ):</th>
                        <td class="text-center">
                            <?php echo number_format($total_after_dis,3,'.',''); ?>
                        </td>
                    </tr>
                     <tr  style="border-bottom: 2px dotted #eee;">
                        <th style="width:80%">Tax (
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
                    <?php
                    if($invoices_Record[$i]->status == 1 OR $invoices_Record[$i]->source == 1)
                    {
                    ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <td colspan="7" >
                            <b>Description : </b> <?php echo $invoices_Record[$i]->description; ?>
                        </td>
                    </tr>
                    <?php 
                        }
                     ?>
                    <tr  style="border-bottom: 2px dotted #eee;">
                        <td colspan="7"  >[
                        <b>  Payment Method: </b>
                            <?php  
                            if($invoices_Record[$i]->payment_method == 0)
                            {
                                echo "Cash";
                            }
                            elseif($invoices_Record[$i]->payment_method == 1)
                            {
                                echo "Cheque";
                            }
                            else if($invoices_Record[$i]->payment_method == 2)
                            {
                                echo "Credit";
                            }
                          
                             ?> 
                             ] [ 
                             <b> Cash recieved:</b> <?php echo $invoices_Record[$i]->total_paid; ?> /- ] [ <b>  Cash balance:</b> <?php echo $invoices_Record[$i]->total_bill - $invoices_Record[$i]->total_paid; ?> /- ]
                        </td>
                    </tr> 
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
        <?php
            }
        ?>
 <!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 