<section class="content-header">
    <div class="row">
      <ol class="breadcrumb pull-right">
          <li>
              <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url('bank/written_cheque'); ?>"> Cheques</a>
          </li>
          <li class="active">Print cheque</li>
      </ol>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat pull-right "><i class="fa fa-print  pull-left"></i> Print / Pdf
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-body">
            <div class="row" >
                <div class="col-md-12" >
                  <h5  class="purchase-heading" > <i class="fa fa-check-circle"></i>  Cheque <span class="pull-right"> <i class="fa fa-calendar"></i> Cheque Date : 
                    <p><?php echo $trans_data[0]->date; ?></p></span>
                      <small>Preview cheque details</small>
                  </h5>
                  <div class="col-md-12 cheque-area-border" >
                     <div class="col-md-3" >
                        <div class="form-group cheque-setting-top">
                             <label><i class="fa fa-check-circle"></i> Bank</label>
                             <p><?php echo $trans_data[0]->bankname; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2" >
                      <div class="form-group ">
                          <?php echo form_label(''); ?>
                          <label><i class="fa fa-check-circle"></i> Cheque No</label>
                          <p><?php echo $trans_data[0]->ref_no; ?></p>
                      </div>                       
                    </div> 
                    <div class="col-md-3" >                      
                      <div class="form-group">
                          <label><i class="fa fa-check-circle"></i> Payee Name</label>
                          <p><?php echo $trans_data[0]->customer_name; ?></p>
                      </div>   
                    </div>  
                    <div class="col-md-2" > 
                      <div class="form-group">
                          <label><i class="fa fa-check-circle"></i> Account</label>
                          <p><?php echo $trans_data[0]->headname; ?></p>
                      </div>                         
                    </div> 
                    <div class="col-md-2" >                        
                      <div class="form-group">
                          <label><i class="fa fa-check-circle"></i> Amount</label>
                          <p><?php echo $trans_data[0]->total_paid; ?></p>
                      </div>                                         
                    </div>   
                    <div class="col-md-12" >                                      
                      <div class="form-group">
                          <label><i class="fa fa-check-circle"></i> Narration</label>
                           <p><?php echo $trans_data[0]->naration; ?></p>
                      </div>                    
                    </div>                    
                  </div>  
              </div>  
            </div>  
        </div>
    </div>
</section>