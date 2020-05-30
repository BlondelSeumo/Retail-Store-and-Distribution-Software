    var timmer;
    //CALCULATE OVERALL SELLING PRICE
    function calculate_selling()
    {
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
         {   
             var edit_packsize = $('#edit_packsize').val();   
             var sell = $('#unit_selling_price').val(); 
             var total =  edit_packsize*sell;  
             $('#total_selling').val(total);      
             $('#wholesale').val(total);      

          }, 800);
    }
    //CALCULATE OVERALL COST
    function calculate_cost()
    {   
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          {
                   
             var edit_packsize = $('#edit_packsize').val();         
             var cost = $('#unit_cost_price').val();         
             var total =  edit_packsize*cost;
             $('#total_purchase').val(total);      

          }, 800);
    }