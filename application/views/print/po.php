<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-sm pull-right "><i class="fa fa-print pull-left"></i> Print Report
                </button>
            </div>
        </div>        
    </div> 
    <hr />
</section>
<section class="content" id="print-section">
    <div class="invoice invoice-body">
        <div class="row">
           <div class="col-md-4 col-sm-4 pull-left">
               <h3><?php echo $default_data[0]->companyname; ?></h3>
               <h4><?php echo $default_data[0]->address; ?></h4>
               <h4><?php echo $default_data[0]->email; ?></h4>
               <h4><?php echo $default_data[0]->contact; ?></h4>
           </div>
           <div class="col-md-4 col-sm-4 pull-right">
               <img class="print-logo-size pull-right" src="<?php echo base_url('uploads/systemimgs/'.$default_data[0]->logo); ?>" />
           </div>
        </div>  
        <br />
        <div class="row"> 
           <div class="col-md-12">
                <h2 class="invoice-title"><b>PURCHASE ORDER</b></h2>
           </div> 
       </div> 
       <div class="row set-border-bottom"> 
           <div class="col-md-4 col-sm-4 pull-left">
                <h3 ><b>TO </b></h3>
                <h4 > <?php echo $user_data[0]->customer_name; ?></h4>
           </div>  
           <div class="col-md-4 col-sm-4 pull-right">
                <span class="pull-right">
                    <h4 ><b class="invoice-heading"> PO NO </b><span class="pull-right" > <?php echo $order_data[0]->id; ?></span></h4>
                    <h4 ><b class="invoice-heading"> DATE  </b> <span class="pull-right" > <?php echo $order_data[0]->date; ?> </span></h4> 
                    <h4 ><b class="invoice-heading"> EXPIRATION DATE  </b> <span class="pull-right" > <?php echo $order_data[0]->expire_date; ?> </span></h4>
                </span>
           </div> 
          
       </div>
       <?php 
        $subtotal = 0;
        $tax = 0;
        
        if($sales_data != NULL)
        {
            
        ?>
       <div class="row">
           <div class="col-md-12">
               <table class="table table-striped table-hover">
                   <tr class="table-invoice-row">
                       <th>SNO</th>
                       <th>SERVICE</th>
                       <th>DESCRIPTION</th>
                       <th>QTY</th>
                       <th>RATE</th>
                       <th>AMOUNT</th>
                   </tr>
                   <?php 
                    $sno = 1;
                    foreach ($sales_data  as $sale) 
                    {
                        $subtotal = $subtotal + ($sale->qty*$sale->price);
                        $tax      = $tax      + $sale->tax;
                    ?>
                   <tr>
                       <td><b><?php echo $sno++; ?></b></td>
                       <td><b><?php echo $sale->product_id; ?></b></td>
                       <td><?php echo $sale->description; ?></td>
                       <td><?php echo $sale->qty; ?></td>
                       <td><?php echo $sale->price; ?></td>
                       <td><?php echo $sale->qty*$sale->price; ?></td>
                   </tr>
                   <?php 
                    }
                   ?>
               </table>
           </div>
       </div>
       <?php 
        }
        ?>
       <div class="row">
           <div class="col-md-4 col-sm-4 pull-left"></div>
           <div class="col-md-4 col-sm-4 pull-right">
            <table class="table footer-table">
                   <tr>
                       <td><b>SUBTOTAL</b></td>
                       <td><?php echo $subtotal; ?></td>
                   </tr>
                   <tr>
                       <td><b>TOTAL</b></td>
                       <td><?php echo $subtotal + $tax; ?></td>
                   </tr>
               </table>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <p>Message : <?php echo $order_data[0]->invoicemessage; ?></p>
           </div>
       </div> 
       <div class="row">
           <div class="col-md-12 text-center accepted-row">
               <p><span  >Accepted By ___________________ </span> <span > Accepted Date ___________________ </span></p>
           </div>
       </div>
    </div>
</section>