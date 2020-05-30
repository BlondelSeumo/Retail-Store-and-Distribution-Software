        function checkDiscount(value) 
        {
            if (parseInt(value) > 100 || parseInt(value) < 0) 
            {
                $('#saveinvoice').attr('disabled', true);
                $("#discountfield").css("border-color", "#c00");

            } 
            else 
            {
                $("#discountfield").css("border-color", "#ccc");
                $('#saveinvoice').attr('disabled', false);
            }

        } 

        var tempgross = 0;

         function checkquantity(id, qty, value) 
         {
            if (qty < value || value == 0) 
            {

                $('#saveinvoice').attr('disabled', true);
                $("#quantity" + id).css("border-color", "#c00");

            } 
            else 
            {

                $("#quantity" + id).css("border-color", "#ccc");
                $('#saveinvoice').attr('disabled', false);

            }
        }


        // CREATING BLANK invoice ENTRY
        var blank_invoice_medicine_row = '';
        $(document).ready(function() 
        {
            blank_invoice_medicine_row = $('#tbody').html();
        })

           $("#add_medicine_to_dom").change(function() 
           {

            var id = $(this).find(':selected').data('id');
            var medname = $(this).find(':selected').data('name');
            var sku = $(this).find(':selected').data('sku');
            var mg = $(this).find(':selected').data('mg');
            var quantity = $(this).find(':selected').data('qty');
            var retail = $(this).find(':selected').data('retail');
            var purchase = $(this).find(':selected').data('purchase');
             var tax = $(this).find(':selected').data('tax');

            var n = ($('#tbody tr').length - 0) + 1;

            blank_invoice_medicine_row = '<tr >' +
                 '<td><input type="text" readonly class="form-control part_sku" value="' + sku + '"  name="part_sku[]"></td>' +
                '<td><input type="hidden"  class="" value="' + id + '" name="medicine_id[]" /><input type="hidden"  class="" value="' + purchase + '" name="medicine_purchase[]" /><input type="text" readonly class="form-control medicine_name " value="' + medname + '" name="medicine_name[]"></td>' +
                '<td><input type="text" readonly class="form-control medicine_category" value="' + mg + '"  name="medicine_weight[]"></td>' +
                '<td><input type="number" readonly class="form-control medicine_price" value="' + retail + '" name="medicine_price[]"></td>' +
                '<td><input type="number" class="form-control medicine_quantity" value="0" id="quantity' + id + '" onkeyup="checkquantity(' + id + ',' + quantity + ',this.value)"  name="medicine_quantity[]"></td>' +
                '<td><input type="number" readonly class="form-control medicine_tax" value="0" id=""  name="medicine_tax[]"><input type="hidden"  class="form-control tax_amount " value="' + tax + '" id=""  name="medicine_tax_percent[]" /></td>' +
                '<td><input type="number" readonly class="form-control Medicine_Subtotal " value="" name="Medicine_Subtotal[]"></td>' +
                '<td> <button type="button" class="btn btn-default" onclick="deleteParentElement(this)">    <i class="fa fa-trash-o" aria-hidden="true"></i></button></td>' +
                '</tr>';

            $('#tbody').append(blank_invoice_medicine_row);
        });
        //$('#add_medicine_to_dom').focus().select();

        // REMOVING invoice ENTRY
        function deleteParentElement(n) 
        {
            $('.gross_total').html(0);
            $('#amount_total').val(0);
            $('#taxfield').val(0);
            n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        }

        $('body').delegate('.medicine_quantity,.medicine_price,.discountbox', 'keyup', function() 
        {
            var tableRow = $(this).parent().parent();
            var medicine_quantity = tableRow.find('.medicine_quantity').val();
            var medicine_price = tableRow.find('.medicine_price').val();
            var discountbox = tableRow.find('.discountbox').val();
            var tax_amount = tableRow.find('.tax_amount').val();
            if (typeof(discountbox) == "undefined") 
            {
                discountbox = 0;
                $('#discountfield').val(0);
            }

            var CalculatedAmount = (medicine_quantity * medicine_price);
            var  taxamount = CalculatedAmountTax(CalculatedAmount,tax_amount);

            tableRow.find('.medicine_tax').val(taxamount.toFixed(2));
            tableRow.find('.Medicine_Subtotal').val(CalculatedAmount);
            AddSubtotals(discountbox);
        });

        function AddSubtotals(discountbox) 
        {
            var CalculatedAmountWit = 0;
            var totalGrossAmount = 0;
            var totalTaxAmount = 0;

            $('.Medicine_Subtotal').each(function(i, e) 
            {
                var subAmount = $(this).val() - 0;

                totalGrossAmount += subAmount;
            });

             $('.medicine_tax').each(function(i, e) 
             {
                var tax_Amount = $(this).val() - 0;

                totalTaxAmount += tax_Amount;
            });

             tempgross = totalGrossAmount;

            if (typeof discountbox == 'undefined') 
            {
                discountbox = 0;
            }

            if (discountbox != 0) 
            {

                CalculatedAmountWithDis = (totalGrossAmount / 100) * discountbox;
                tempgross = (tempgross - CalculatedAmountWithDis)+totalTaxAmount;
            }
            else
            {
                tempgross = tempgross+totalTaxAmount; 
            }

            $('.gross_total').html(totalGrossAmount.toFixed(2));
              $('#taxfield').val(totalTaxAmount.toFixed(2));
            $('#amount_total').val(tempgross.toFixed(2));
        }

        function CalculatedAmountTax(retail,tax)
        {
           return (retail / 100) * tax;  
        }


        function calship(val) 
        {
            $('#amount_total').val(parseInt(tempgross + parseInt(val)));

        }