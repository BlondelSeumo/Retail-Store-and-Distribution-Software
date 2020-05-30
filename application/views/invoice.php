<section class="invoice">
    <?php
        $attributes = array('id'=>'invoice_form','autocomplete'=>'off','method'=>'post','class'=>'form-horizontal');
    ?>
    <?php echo form_open('invoice/add_auto_invoice',$attributes); ?>
    <!-- title row -->
    <div class="row">
        <div class="col-md-3">
            <h3 >
            <i class="fa fa-globe"></i> Invoice No # <?php echo $invoice; ?>
          </h3>
        </div> 
        <div class="col-md-1 pull-right ">
            <a class="pull-right btn-flat homescreen-icon btn btn-primary" href="<?php echo base_url('supply/create_new_supply'); ?>">   <i class="fa fa-truck"></i>    Whole sale
            </a>
        </div>        
        <div class="col-md-1 pull-right ">
            <a class="pull-right btn-flat homescreen-icon btn btn-primary" href="<?php echo base_url('homepage'); ?>">   <i class="fa fa-dashboard"></i>    Home screen
            </a>
        </div>                
        <div class="col-md-1 pull-right ">
            <a class="pull-right btn-flat pos-invoice-btn homescreen-icon btn btn-primary" href="<?php echo base_url('invoice/manage'); ?>">   <i class="fa fa-file-text"></i>    Invoices
            </a>
        </div>

    </div>
    <div class="col-md-6 ">
        <div class="form-group">
            <label><i class="fa fa-barcode"  aria-hidden="true"></i> SCAN BARCODE OR SEARCH ITEMS</label>
            <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
            <div id="search_id_result_manual"></div> 
            <small>Search through product name (e.g aquafina) .</small>      
        </div>                         
    </div>        
    <div class="col-md-6 ">
        <div class="form-group">
            <label><a onclick="show_modal_page('<?php echo base_url().'payee/popup/add_payee_model'; ?>')" href="#">Add account</a></label> <br/>
            <select name="customer_id" onchange="search_customer_payments(this.value)" class="form-control select2" id="customer_id" style="width: 100%;">
            <?php
                if($customer_record != NULL)
                {
                    foreach ($customer_record as $single_customer)
                    {
            ?>
                        <option value="<?php echo $single_customer->id; ?>">
                            <?php echo 'Name : '.$single_customer->customer_name;?>
                        </option>
            <?php
                    }
                }
                else
                {
                    echo "No Record Found";
                }
            ?>
        </select>
        <small>Make sure to select right customer whom your are suppling, to maintian accounts.</small>
        </div>
    </div>
    <div class="row">     
        <div  id="inner_invoice_area" class="col-md-12 ">
            <?php $this->load->view($temp_view,$temp_data); ?>
        </div> 
         <p class="col-md-12">
            <small class="instructions ">
             <b>ESC</b> New or Clear invoice <b>F4</b> Return items & <b>Enter</b> Saving invoice <b>F2</b> View invoices
            </small>
        </p>   
    </div>
</section>
 <!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 

 <!-- AJAX FUNCTIONS   -->
<?php $this->load->view('ajax/invoice.php'); ?>