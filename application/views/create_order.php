<section class="content">
    <div class="box" id="print-section">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Create  Order
            </h3>
            <small>
                <br />
                Note : In create order wholesale prices will be use.   
            </small>
        </div>
        <div class="box-body box-bg ">
            <?php
                $attributes = array('id'=>'create_order_form', 'autocomplete'=>'off','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('order_list/add_order_invoice',$attributes); ?>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Salesman details :
                      <small >Select salesman for generating order.</small>    
                    </h4>   
                </div>      
                <div class="col-md-12">
                    <div class="form-group">
                        <label>
                            Salesman
                        </label>
                        <select name="salesman_id" class="form-control select2 input-lg">
                            <?php 
                            if($salesman_list != NULL)
                            {
                                foreach ($salesman_list as $single_sales) 
                                {
                            ?>
                                <option value="<?php echo $single_sales->id; ?>">
                                    <?php echo $single_sales->name; ?>     
                                </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>                         
            </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Create order items :
                 <small >Create an order list for salesman purpose only. This list will not reduce any item from stock.</small>   
                </h4>  

            </div>
            <div class="col-md-12 ">
                <div class="form-group">
                    <label ><i class="fa fa-search"  aria-hidden="true"></i> <b>SEARCH ITEMS :</b></label>
                    <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                    <div id="search_id_result_manual"></div>
                     <small>Search through product name (e.g aquafina). </small>
                 </div>                   
            </div>        
        </div>
        <div class="row">
            <div class="col-md-12 ">      
                <div  id="inner_invoice_area">
                    <?php $this->load->view($temp_view,$temp_data); ?> 
                </div>    
            </div>
        </div>
    <?php form_close(); ?>
      </div>
  </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>

<!-- Bootstrap model  ends--> 
<?php $this->load->view('ajax/order_item_template.php'); ?>