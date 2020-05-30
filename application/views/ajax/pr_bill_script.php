<script type="text/javascript">    

var timmer;
//USE TO CHANGE THE AMOUNT
function amend_amount(val,item_id)
{       
       clearTimeout(timmer);
        timmer = setTimeout(function callback(){
        //get_search_result(search_item);
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('supply/update_price/'); ?>'+val+'/'+item_id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
                 $('#barcode_scan_area').focus();
                 $('.search_result').css("display", "none");

            }
        });

    }, 600);
}

//USE TO CHANGE THE QUANTITY
function amend_qty(attr,val,item_id)
{       
   
        clearTimeout(timmer);
        timmer = setTimeout(function callback(){
        //get_search_result(search_item);
       //  var int_val = parseInt(val);
          var int_val = val;
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('purchase/update_pr_qty/'); ?>'+attr+'/'+int_val+'/'+item_id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
                 $('#barcode_scan_area').focus();
                 $('.search_result').css("display", "none");
            }
        });
    }, 1000);
}

//USE TO CHANGE THE DSICOUNT
function amend_discount(val,item_id)
{       

       clearTimeout(timmer);
        timmer = setTimeout(function callback(){
        //get_search_result(search_item);
        var int_val = parseInt(val);
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('supply/discount_qty/'); ?>'+int_val+'/'+item_id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
                 $('#barcode_scan_area').focus();
                 $('.search_result').css("display", "none");
            }
        });
    }, 1000);
}

    //USED TO ADD ITEM IN TEMP TABLE
    function add_item_invoice(data)
    {   
        
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
        {
            if(/^[a-zA-Z0-9- ]*$/.test(data) == true) 
            {
                get_search_result(data);
            }
        }, 1000);
        $('#barcode_scan_area').focus();
    }


    //USED TO CLEAR THE TEMP TABLE
    function clear_invoice()
    {

       // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url("purchase/clear_temp_invoice"); ?>',
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
                 $('#barcode_scan_area').focus();
            }
        }); 
    }

    //USED TO FIND THE PREVIOUS BALANCES OF THE CUSTOMER 
    function search_customer_payments(cus_id)
    {
        $('#barcode_scan_area').focus();
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('invoice/search_previous_cus_balance/'); ?>'+cus_id,
            success: function(response)
            {
                jQuery('#privious_balance').val(response);
            }
        });
    }

    //USED TO GET SEARCH RESULT
    function get_search_result(search_item)
    {
        if(search_item != '')
        {

           // alert('ree');
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: '<?php echo base_url("invoice/search_result_manual/"); ?>'+search_item,
                success: function(response)
                {
                    jQuery('#search_id_result_manual').html(response);
                     //$('#barcode_scan_area').val('');
                }
            }); 
        }
        else
        {
            $('.search_result').css("display", "none");
        }
    }

    //USED TO CLOSE OR HIDE THE SEARCH DIV
    function close_search_result()
    {
        $('#barcode_scan_area').val('');
        $('#barcode_scan_area').focus();
        $('.search_result').css("display", "none");
    }

    //USED TO ADD ITEM SEARCHED IN TEMP TABLE
    function add_search_item_invoice(id)
    {
        $('#barcode_scan_area').focus();
        $('.search_result').css("display", "none");
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('purchase/add_selected_item_pr/'); ?>'+id,
            success: function(response)
            {
                jQuery('#inner_invoice_area').html(response);
                 $('#barcode_scan_area').val('');
            }
        });
    }
</script>    