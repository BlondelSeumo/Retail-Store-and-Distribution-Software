<div class="row">
    <div class="col-md-12 ">
        <h4 class="text-left" style="margin-left:2%;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> View invoices</h4>
    </div>
</div>
    <?php
    	for($i = 0; $i < count($Sales_Record); $i++)
        {
    ?>
    <section class="invoice" id="<?php echo $Sales_Record[$i][0]->id; ?>">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
            <i class="fa fa-globe"></i> <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
            <small class="pull-right">Date: <?php echo $invoices_record[$i]->date; ?></small>
          </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h4>
                    <small class="pull-right">Status: 
            			<?php 
            				if($invoices_record[$i]->status  == 4)
                            {
            					echo "invoice Expired";
            				} 
            				else
                            {
            					echo "Error";

            				}
            				?>
                        </small>
                  </h4>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <b>Agent# <?php echo $invoices_record[$i]->agentname; ?></b>
                <br>
                <b>Temp invoice # <?php echo $invoices_record[$i]->id; ?></b>
                <br> From
                <div class="row">
                    <div class="col-md-12">
                        <address>
                            <strong><?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?></strong><br>
                            Address:<?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['address'] ;?><br>
                            Phone: <?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['phone_number'] ;?><br>
                            Email: <?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['email'] ;?>
                      </address>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Mg</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            			$counter = 0;
            			$total = 0;
            			while( $counter < count($Sales_Record[$i]))
                        {
            				$subtotal = 0;
            				$subtotal = $Sales_Record[$i][$counter]->price*$Sales_Record[$i][$counter]->qty;
            				$total = $total+$subtotal;
            			?>
                            <tr>
                                <td>
                                    <?php echo $counter+1; ?>
                                </td>
                                <td>
                                    <?php echo $Sales_Record[$i][$counter]->product_name; ?>
                                </td>
                                <td>
                                    <?php echo $Sales_Record[$i][$counter]->product_category; ?>
                                </td>
                                <td>
                                    <?php echo $Sales_Record[$i][$counter]->mg; ?>
                                </td>
                                <td>
                                    <?php echo $Sales_Record[$i][$counter]->price; ?>
                                </td>
                                <td>
                                    <?php echo $Sales_Record[$i][$counter]->qty; ?>
                                </td>
                                <td>
                                    <?php echo $subtotal;?>
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
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal (
                                <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>):</th>
                            <td class="text-right">
                                <?php echo $total; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:50%">Discount(%):</th>
                            <td class="text-right">
                                <?php echo $invoices_record[$i]->discount; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:50%">Shipping Charges(
                                <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>):</th>
                            <td class="text-right">
                                <?php echo $invoices_record[$i]->shippingcharges; ?>
                            </td>
                        </tr>
                        <?php
            			      $totalam = ($total/100)*$invoices_record[$i]->discount;
            				  $new_amount = $total-$totalam ;
            			  ?>
                            <tr>
                                <th>Total (
                                    <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>):</th>
                                <td class="text-right">
                                    <?php echo $new_amount+$invoices_record[$i]->shippingcharges; ?>
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row no-print">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <button type="button" class="btn btn-default btn-flat  pull-right margin  " onclick="#"> <i class="fa fa-user" aria-hidden="true"></i> Customer Profile </button>
                <button onclick="show_modal_page('<?php echo base_url().'orders/popup/prescription_image_model_temp/'.$invoices_record[$i]->id ?>')" name="print_button" class="btn btn-success btn-flat   pull-right margin "><i class="fa fa-eye "></i> View prescription </button>
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
