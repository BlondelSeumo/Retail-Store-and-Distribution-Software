            var timmer;
            function count_debits() 
            {
                clearTimeout(timmer);
                
                 timmer = setTimeout(function callback()
                { 
                    var total_debit = 0;
                     $('input[name="debitamount[]"]').each(function() 
                     {  
                         if($(this).val() != '')
                         {
                             total_debit = total_debit + parseFloat($(this).val());
                         }
                      });

                     $('input[name="total_debit_amount"]').val(total_debit);

                    //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
                     check_validity()

                }, 800); 
            }            
            function count_credits() 
            {
                clearTimeout(timmer);
                
                 timmer = setTimeout(function callback()
                { 
                    var total_credits = 0;
                     $('input[name="creditamount[]"]').each(function() 
                     {  
                        if($(this).val() != '')
                        {
                            total_credits = total_credits + parseFloat($(this).val());
                        }  
                     });

                     $('input[name="total_credit_amount"]').val(total_credits);

                     //USED TO CHECK THE VALIDITY OF THIS TRANSACTION
                     check_validity();

                }, 800); 
            }
            function check_validity()
            {
                var total_debit = $('input[name="total_debit_amount"]').val(); 
                var total_credit = $('input[name="total_credit_amount"]').val();
                
                if(total_debit != total_credit)
                {   
                    if(total_debit > total_credit)
                    {
                        $('#transaction_validity').html(total_credit-total_debit);
                    }
                    else
                    {
                        $('#transaction_validity').html(total_debit-total_credit);
                    }   

                    //USED TO DISABLED THE BUTTON IF ANY ERROR OCCURED
                    $('#btn_save_transaction').prop('disabled', true);
                }
                else
                {
                    $('#transaction_validity').html('');
                    $('#btn_save_transaction').prop('disabled', false);
                }

            }