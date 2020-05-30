    <script type="text/javascript">
    //USED TO DELETE AN ITEM FROM DATABASE TEMP TABLE
    function delete_item(item_id)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url:'<?php echo base_url('purchase/delete_item_temporary_pr/'); ?>'+item_id,
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
          discounttimmer = setTimeout(function callback()
          {
            var before_total =  $('#before_total').val();
            var offered_discount   =  $('#offered_discount').val();

            if(offered_discount > 0)
            {
              var dis_amt = (before_total/100)*offered_discount;

               var newamt = parseFloat(before_total-dis_amt); 

               
               $('#grand_total').val(newamt.toFixed(3));
            }

          },1000)
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