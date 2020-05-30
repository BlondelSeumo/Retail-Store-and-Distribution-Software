<section class="content">
    <div class="box" id="print-section">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>        Create  Supply
            </h3>
            <small>
                <br />
                Note : In create supply wholesale prices will be use.   
            </small>
        </div>
        <div class="box-body box-bg ">
            <?php
                $attributes = array('id'=>'create_supply_form', 'autocomplete'=>'off','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('supply/add_supply_invoice',$attributes); ?>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> General details :
                      <small >Select region where you are suppling.</small>    
                    </h4>   
                </div>      
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Salesman
                        </label>
                        <select name="salesman_id" class="form-control input-lg">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Store
                        </label>
                        <select name="store_id" class="form-control input-lg">
                            <?php 
                            if($store_list != NULL)
                            {
                                foreach ($store_list as $single_store) 
                                {
                            ?>
                                <option value="<?php echo $single_store->id; ?>">
                                    <?php echo $single_store->name; ?>     
                                </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>         
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>Driver Name (<a onclick="show_modal_page('<?php echo base_url().'supply/popup/add_driver_model'; ?>')" href="#">add new driver</a>)
                        </label>
                        <select name="driver_id" class="form-control input-lg">
                            <?php 
                            if($drivers_list != NULL)
                            {
                                foreach ($drivers_list as $single_driver) 
                                {
                            ?>
                                <option value="<?php echo $single_driver->id; ?>">
                                    <?php echo $single_driver->name; ?>     
                                </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>    
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>Supply Vehicle (<a onclick="show_modal_page('<?php echo base_url().'supply/popup/add_vehicle_model'; ?>')" href="#">add new vehicle</a>)
                        </label>
                        <select name="vehicle_id" class="form-control input-lg">
                            <?php 
                            if($vehicle_list != NULL)
                            {
                                foreach ($vehicle_list as $single_vehicle) 
                                {
                                ?>
                                    <option value="<?php echo $single_vehicle->id; ?>">
                                        <?php echo $single_vehicle->name; ?>     
                                    </option>
                                <?php 
                                 }
                            }
                            ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label>Region/Town (<a onclick="show_modal_page('<?php echo base_url().'initilization/popup/add_town_model'; ?>')" href="#">add new town</a>)
                        </label>
                        <select name="region_id" class="form-control select2 input-lg">
                            <?php 
                            if($town_list != NULL)
                            {
                                foreach ($town_list as $single_town) 
                                {
                                ?>
                                    <option value="<?php echo $single_town->id; ?>">
                                        <?php echo ' Region '.$single_town->region.' | Town '.$single_town->name; ?>     
                                    </option>
                                <?php 
                                 }
                            }
                            ?>
                        </select>
                        <small>e.g Select region or town where you are suppling goods.</small>
                    </div>
                </div>            
            </div>
        <div class="row">
            <div class="col-md-12">
                <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Create supply items :
                 <small >Create a invoice for wholesale purpose.</small>   
                </h4>  

            </div>
            <div class="col-md-6 ">
                <div class="form-group">
                    <label ><i class="fa fa-search"  aria-hidden="true"></i> <b>SEARCH ITEMS :</b></label>
                    <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                    <div id="search_id_result_manual"></div>
                     <small>Search through product name (e.g aquafina). </small>
                 </div>                   
            </div>        
            <div class="col-md-6 ">
                <div class="form-group">
                    <label> <a onclick="show_modal_page('<?php echo base_url().'supply/popup/add_payee_model'; ?>')" href="#">Create Account</a>
                    </label>
                     <select name="customer_id" onchange="search_customer_payments(this.value)" class="form-control select2" id="customer_id">
                        <?php
                            if($customer_list != NULL)
                            {
                                foreach ($customer_list as $single_customer)
                                {
                        ?>
                             <option value="<?php echo $single_customer->id; ?>">
                                <?php echo 'Name : '.$single_customer->customer_name;

                                ?>
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
                    <small> Make sure to select right customer whom your are suppling, to maintian his/her accounts.</small>
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
<?php $this->load->view('ajax/supply_invoice_script.php'); ?>