    <script type="text/javascript">
    //USED TO DELETE AN ITEM FROM DATABASE TEMP TABLE
    function delete_item(item_id)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url:'<?php echo base_url('supply/delete_item_temporary/'); ?>'+item_id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
            }
        });

        $('#barcode_scan_area').focus();
    }

    function calculate_func(val)
    {
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          { 
             var net_total = $('#net_total_amount_input').val();      
             var balance =  net_total-val;
             $('#balance_field').val(balance.toFixed(3));      

          }, 100);
    }
   
    var discounttimmer ;
    //USED TO CALCUATE DISCOUNT AMOUT
    function checkDiscount(dis_amt)
    {
          clearTimeout(discounttimmer);
          discounttimmer = setTimeout(function callback(){
          var total_gross_amt =  $('#total_gross_amt').val();
          var total_tax_amt   =  $('#total_tax_amt').val();

            if(dis_amt > 0)
            {
               var newamt = parseFloat(total_gross_amt-dis_amt)+parseFloat(total_tax_amt); 
               $('#net_amount').html(newamt.toFixed(3));
               $('#net_total_amount_input').val(newamt.toFixed(3));
               $('#cash_recieved').val(newamt.toFixed(3));
            }
            else
            {   
                var pre_val =  parseFloat(total_gross_amt)+parseFloat(total_tax_amt);
                 $('#net_amount').html(pre_val.toFixed(3));
                 $('#net_total_amount_input').val(pre_val.toFixed(3));
                 $('#cash_recieved').val(pre_val.toFixed(3));
            }

          },100)
    }

    //USED TO CALCULATE HOW MUCH AMOUNT SHOULD RETURN TO CUSTOMER
    function amount_refund(amt)
    {
        var netamt =  $('#net_total_amount_input').val();

        var cash_given = amt-parseFloat(netamt);
        $('#cash_given_to_customer').html(cash_given.toFixed(3));
    }

    //USED TO OPEN CUSTOMER PAYMENT MODEL 
    function open_payment_model()
    {
        var cus_id = $('#customer_id').val();
        show_modal_page('<?php echo base_url('invoice/popup/add_customer_payment_pos_model/');?>'+cus_id)
    }
</script>