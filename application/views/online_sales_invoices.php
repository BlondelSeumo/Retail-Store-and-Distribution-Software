<div class="row">
    <div class="col-md-12 ">
        <?php $attributes=array( 'id'=>'online_invoice_form','method'=>'post',); ?>
        <?php echo form_open($Path,$attributes); ?>
        <div class="col-md-12  ">
            <div class="form-group margin ">
                <?php echo form_label( 'Date From:'); ?>
                <div class="input-group date ">
                    <div class="input-group-addon   ">
                        <i class="fa fa-calendar "></i>
                    </div>
                    <?php $data=array( 'class'=>'form-control pull-right ','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>''); echo form_input($data); 
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group margin">
                <?php echo form_label( 'Date To:'); ?>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php $data=array( 'class'=>'form-control pull-right ' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>''); echo form_input($data); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?php $data=array( 'class'=>'btn btn-info btn-flat btn-lg pull-right','name'=>'searchecord','value'=>'Search invoices'); echo form_submit($data); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 ">
        <h4 class="text-left" style="margin-left:2%;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> View invoices</h4>
    </div>

</div>
<?php for($i=0 ; $i < count($Sales_Record); $i++){ ?>
<section style="border-bottom: 2px solid #00c0ef;" class="invoice" id="<?php echo $invoices_record[$i]->id; ?>">

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
                        if($invoices_record[$i]->status == 1)
                        {
                            echo "Verified";
                        }
                        else if($invoices_record[$i]->status  == 2)
                        {
                            echo "Paid";
                        }
                        else if($invoices_record[$i]->status  == 0)
                        {
                            echo "Un Verified";
                        }
                        else if($invoices_record[$i]->status  == 3)
                        {
                            echo "Delivered To Customer";
                        } 
                        else if($invoices_record[$i]->status  == 4)
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
            <br> 
            <div class="row">
                <div class="col-md-12">
                    <address> 
                            Address: <?php echo $this->db->get_where('mp_contactabout', array('id' => 1))->result_array()[0]['address'] ;?><br>
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
                        <th>Mg</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $counter=0; 
                        $total=0; 
                        $tax=0; 
                        while( $counter < count($Sales_Record[$i]))
                            { 
                                $subtotal=0 ; 
                                $subtotal=$Sales_Record[$i][$counter]->price*$Sales_Record[$i][$counter]->qty; 
                                $total = $total+$subtotal;
                                $tax =  $tax + $Sales_Record[$i][$counter]->tax;
                    ?>
                    <tr>
                        <td>
                            <?php echo $counter+1; ?>
                        </td>
                        <td>
                            <?php echo $Sales_Record[$i][$counter]->product_name; ?>
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
                    <?php $counter++; } ?>
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
                        <th style="width:50%">Tax(<?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>):</th>
                        <td class="text-right">
                            <?php echo $tax ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="width:50%">Shipping Charges(
                            <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'] ;?>):</th>
                        <td class="text-right">
                            <?php echo $invoices_record[$i]->shippingcharges; ?>
                        </td>
                    </tr>
                    <?php $totalam=( $total/100)*$invoices_record[$i]->discount; 
                    $new_amount = ($total-$totalam)+$tax; ?>
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
        <div class="col-md-12">
            <?php if($invoices_record[$i]->status == 2)
            { 
            ?>
            <button type="button"  class="btn btn-primary btn-flat  pull-right btn-lg  " onclick="show_modal_page('<?php echo base_url().'orders/popup/add_delivery_model/'.$invoices_record[$i]->id ?>')" > <i class="fa fa-truck" aria-hidden="true"></i>     Deliver to customer
            </button>
            <button type="button" onclick="show_modal_page('<?php echo base_url().'orders/popup/customer_profile_model/'.$invoices_record[$i]->cus_id ?>')" class="btn btn-default btn-flat  pull-right btn-lg  "> <i class="fa fa-user" aria-hidden="true"></i> Customer profile 
            </button>
            <button onclick="show_modal_page('<?php echo base_url().'orders/popup/prescription_image_model/'.$invoices_record[$i]->prescription_id ?>')"  name="print_button" class="btn btn-success btn-flat   pull-right btn-lg "><i class="fa fa-eye "></i> View prescription 
            </button>
            <button onclick="printDiv(<?php echo $invoices_record[$i]->id; ?>)" name="print_button" class="btn btn-info btn-flat   pull-right btn-lg "><i class="fa fa-print pull-left"></i> Print invoice 
            </button>
            <?php 
            } 
            else 
            { 
            ?>
            <button type="button" onclick="show_modal_page('<?php echo base_url().'orders/popup/customer_profile_model/'.$invoices_record[$i]->cus_id ?>')" class="btn btn-default btn-flat   pull-right btn-lg  "> <i class="fa fa-user" aria-hidden="true"></i> Customer profile 
            </button>
            <button onclick="show_modal_page('<?php echo base_url().'orders/popup/prescription_image_model/'.$invoices_record[$i]->prescription_id ?>')"  name="print_button" class="btn btn-success btn-flat   pull-right btn-lg "><i class="fa fa-eye "></i> View prescription 
            </button>
            <button onclick="printDiv(<?php echo $invoices_record[$i]->id; ?>)" name="print_button" class="btn btn-info btn-flat   pull-right btn-lg "><i class="fa fa-print pull-left"></i> Print invoice 
            </button>
            <?php } ?>
        </div>
    </div>
    <?php if($invoices_record[$i]->status == 3){ ?>
    <div class="row ">
        <span><u> Delivered To </u>  :<i><?php echo $invoices_record[$i]->delivered_to; ?></i></span>,
        <span><u> Delivered By </u> : <i><?php echo $invoices_record[$i]->delivered_by; ?></i></span>,
        <span><u> Delivered Date </u>  : <i><?php echo $invoices_record[$i]->delivered_date; ?></i></span>
        <p>
            <br />
            <span><u> Delivered description </u>  :</span>
            <i><?php echo $invoices_record[$i]->delivered_description; ?></i>
        </p>
    </div>
    <?php } ?>
</section>
<div class="clearfix"></div>
<?php } ?>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends-->
<script type="text/javascript">
    function edit_invoice_status(id) 
    {
        //Assign JSON data to textbox to edit
        $('[name="edit_invoice_Id"]').val(id);
        // show bootstrap modal when complete loaded            
        $('#Add_Model').modal('show');
    }
</script>