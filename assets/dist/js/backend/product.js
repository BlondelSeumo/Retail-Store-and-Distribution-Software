/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/    
    var timmer;

    //CALCULATE OVERALL SELLING PRICE
    function calculate_selling()
    {

        clearTimeout(timmer);
        timmer = setTimeout(function callback()
         {
                   
            // var total_units = $('#total_units').val();    
             var pack = $('#unit_per_pack').val();   
             var sell = $('#unit_selling_price').val(); 
             var total =  pack*sell; 
             $('#total_selling').val(total);      
             $('#whole_sale_rate').val(total);      

          }, 200);
    }

    //CALCULATE STOCK QUANTITY
    function calculate_quantity()
    {   
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          {
                   
             var total_units    = $('#total_units').val();         
             var unit_per_pack  = $('#unit_per_pack').val();         
             var total =  total_units*unit_per_pack;
             $('#stock_quantity').val(total);      

          }, 300);
    }    


    //CALCULATE OVERALL COST
    function calculate_cost()
    {   
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          {
                   
            var pack = $('#unit_per_pack').val();         
             var cost = $('#unit_cost_price').val();         
             var total =  pack*cost;
             $('#total_purchase').val(total);      

          }, 300);
    }