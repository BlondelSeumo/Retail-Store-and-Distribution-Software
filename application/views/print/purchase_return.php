<section class="content-header">
    <div class="row">
      <div class="col-md-12">
            <ol class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                  <a href="<?php echo base_url('purchase/return_list'); ?>"> Purchase return</a>
                </li>
                <li class="active">Print purchase return</li>
            </ol>
      </div> 
    </div>
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
    <div class="invoice invoice-body invoice-border">
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
        <div class="row"> 
           <div class="col-md-12">
                <h2 class="invoice-title"><b>P.R RECEIPT</b></h2>
           </div> 
       </div> 
       <div class="row set-border-bottom"> 
           <div class="col-md-4 col-sm-4 pull-left">
                <h3 ><b>TO </b></h3>
                <h4> <?php echo $user_data[0]->customer_name; ?></h4>
                <p> </p>
           </div>  
           <div class="col-md-4 col-sm-4 pull-right">
                <span class="pull-right">
                    <h4 ><b class="invoice-heading"> PURCHASE NO : </b><span class="pull-right" > <?php echo $single_purchase[0]->id; ?></span></h4>
                    <h4 ><b class="invoice-heading"> DATE  :</b> <span class="pull-right" > <?php echo $single_purchase[0]->date; ?> </span></h4>
                </span>
           </div> 
          
       </div>
       <div class="row set-border-bottom"> 
           <div class="col-md-4 col-sm-4 pull-left">
                <h3 ><b>PAYMENT METHOD </b></h3>
                <h4 > <?php echo $single_purchase[0]->payment_type_id; ?></h4>
           </div>         
       </div>
       <?php 
          $subtotal = 0;
          $tax = 0;
        if($purchase_list != NULL)
        {
        ?>
       <div class="row">
           <div class="col-md-12">
               <table class="table table-striped table-hover">
                   <tr class="table-invoice-row">
                       <th>SNO</th>
                       <th>ITEMS</th>
                       <th>PACKS</th>
                       <th>RATE</th>
                       <th>AMOUNT</th>
                   </tr>
                   <?php 
                   $sno = 1;
                    foreach ($purchase_list  as $sale) 
                    {
                        $subtotal = $subtotal + ($sale->qty*$sale->pack_cost);
                        $tax      = $tax      + $sale->pack_cost;
                    ?>
                   <tr>
                       <td><?php echo $sno++; ?></td>
                       <td><b><?php echo $sale->product_name; ?></b></td>
                       <td><?php echo $sale->qty; ?></td>
                       <td><?php echo $sale->pack_cost; ?></td>
                       <td><?php echo $sale->qty*$sale->pack_cost; ?></td>
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
                       <td>TOTAL</td>
                       <td><?php echo number_format($subtotal,2,'.',','); ?></td>
                   </tr>
                   <tr>
                       <td>PAYMENT</td>
                       <td><?php echo number_format($single_purchase[0]->total_paid,2,'.',','); ?></td>
                   </tr>
                   <tr>
                       <td>BALANCE DUE <?php echo $default_data[0]->currency; ?></td>
                       <td><?php echo number_format($single_purchase[0]->total_bill - $single_purchase[0]->total_paid,2,'.',','); ?></td>
                   </tr>
               </table>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <p>Message : <?php echo $single_purchase[0]->description; ?></p>
           </div>
       </div>
    </div>
</section>