<section class="content-header">
    <div class="row">
        <ol class="breadcrumb pull-right">
            <li>
                <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
              <a href="<?php echo base_url('vouchers/credit_vouchers'); ?>"> Credit Vouchers</a>
            </li>
            <li class="active"> Print credit voucher</li>
        </ol>
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
    <div class="invoice invoice-border invoice-body">
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
                <h2 class="invoice-title"><b>CREDIT VOUCHER</b></h2>
           </div> 
       </div> 
       <div class="row set-border-bottom"> 
           <div class="col-md-4 col-sm-4 pull-left">
                <h3 ><b>TO </b></h3>
                <h4 > <?php echo $user_data[0]->customer_name; ?></h4>
           </div>  
           <div class="col-md-4 col-sm-4 pull-right">
                <span class="pull-right">
                    <h4 ><b class="invoice-heading"> VOUCHER NO </b><span class="pull-right" > <?php echo $receipt_data[0]->id; ?></span></h4>
                    <h4 ><b class="invoice-heading"> DATE  </b> <span class="pull-right" > <?php echo $receipt_data[0]->receipt_date; ?> </span></h4>
                </span>
           </div> 
          
       </div>
       <?php 
          $total = 0;
        if($trans_data != NULL)
        {
        ?>
       <div class="row">
           <div class="col-md-12">
               <table class="table table-striped table-hover">
                   <tr class="table-invoice-row">
                       <th class="col-md-10" >CREDIT</th> 
                       <th class="col-md-2 text-center">TOTAL</th> 
                   </tr>
                   <?php 
                    foreach ($trans_data  as $single_trans) 
                    {
                        $total = $total + $single_trans->amount;
                    ?>
                   <tr>
                       <td><b><?php echo $single_trans->name; ?></b></td>
                       <td class="text-center" ><?php echo $single_trans->amount; ?></td>
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
           <div class="col-md-12">
               <p>Message : <?php echo $receipt_data[0]->memo; ?></p>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12 text-center accepted-row">
               <p><span  >Authorised Signnatory ___________________ </span> <span > Accountant ___________________ </span></p>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <p class="text-center"><i>Invoice generated through Bedana accounting software</i></p>
           </div>
       </div>
    </div>
</section>