<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <a type="button" class="btn btn-danger btn-flat btn-sm" href="<?php echo base_url('purchase');?>" ><i class="fa fa-times" aria-hidden="true"></i> Cancel Purchase
                </a>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Create Purchase Return :
            </h3>
        </div>
        <div class="box-body">
                <?php
                    $attributes = array('id'=>'return_purchase_form','method'=>'post','class'=>'');
                ?>
                <?php echo form_open_multipart('purchase/add_purchase',$attributes); ?>
                <div class="row">
                    <div class="col-md-12 ">
                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  General Detail :</h4>
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <?php echo form_label('Account Holders'); ?>
                                    <select name="pur_supplier" class="form-control select2 input-lg">
                                        <?php 
                                        foreach ($supplier_list as $single_supplier) 
                                        {
                                        ?>
                                            <option value="<?php echo $single_supplier->id; ?>">
                                                <?php echo $single_supplier->customer_name; ?>     
                                            </option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                            </div>
                             <small> who is the provider of puchasing items</small>
                        </div>                
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <?php echo form_label('Store'); ?>
                                <select name="pur_store" class="form-control input-lg">
                                   <?php 
                                        if($store_list != NULL)
                                        {
                                            foreach ($store_list as $single_store) 
                                            {
                                    ?>
                                                <option value="<?php echo $single_store->id; ?>"><?php echo $single_store->name; ?> 
                                                </option>
                                    <?php
                                            }
                                        }

                                     ?>
                                </select>
                            </div>
                            <small>for which store you are purchasing </small>
                        </div>                
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <?php echo form_label('Bill No'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'pur_invoice','placeholder'=>'e.g 255','reqiured'=>'');
                                    echo form_input($data);
                                ?>
                            </div>
                            <small>mention the bill no provided by supplier </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Create purchase return :
                        <small >Create a purchase return for returning purpose.</small>   
                        </h4>  

                    </div>
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label ><i class="fa fa-search"  aria-hidden="true"></i> <b>SEARCH ITEMS :</b></label>
                            <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                            <div id="search_id_result_manual"></div>
                            <small>Search through product name (e.g aquafina). </small>
                        </div>                   
                    </div>        
                </div>
                <div class="row">
                    <div class="col-md-12 ">      
                        <div  id="inner_invoice_area">
                            <?php $this->load->view($temp_view,$temp_data); ?> 
                        </div>    
                    </div>
                </div>
                
        </div>
    </div>
</section>
<script type="text/javascript">
    var timmer;
    function calculate_func(val)
    {
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          { 
             var grand_total = $('#grand_total').val();         
             var balance =  grand_total-val;
             $('#balance_field').val(balance);      

          }, 800);
    }

    $('#payment_id').change(function(){
        
    var method = $('#payment_id').val();
   
    if(method == 'Cheque')
    {
        $('.bank-section-details').css('display','block');
    }
    else
    {
        $('.bank-section-details').css('display','none');
    }
});

$('#bank_id').change(function(){
    var bank_id = $('#bank_id').val();


    if(bank_id != 0)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('bank/check_available_balance/'); ?>'+bank_id,
            success: function(response)
            {
                $('#available_balance').html(response);
                $('#save_available_balance').val(response);
            }
        });

        $('#bank-cheque-no').css('display','block');
    }
});
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 


<!-- Bootstrap model  ends--> 
<?php $this->load->view('ajax/pr_bill_script.php'); ?>