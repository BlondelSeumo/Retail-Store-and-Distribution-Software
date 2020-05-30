<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-md btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print Report</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                        <?php  echo $table_name; ?>
                    </h3>
                    <p>
                        <small>Used to generate the list of goods supplied to stores</small>
                    </p>
                </div>
                <div class="box-body">
                    <?php
                        $attributes = array('id'=>'distributed_list','method'=>'post','class'=>'');
                    ?>
                    <?php echo form_open_multipart('supply/generate_picklist',$attributes); ?>
                    <div class="row no-print">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Date From:'); ?>
                                    <?php $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date1');
                                    echo form_input($data); ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Date To:'); ?>
                                    <?php $data1 = array('class'=>'form-control input-lg','type'=>'date','name'=>'date2');
                                    echo form_input($data1); ?>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Salesman:'); ?>
                                    <select name="salesman_id" class="form-control select2 input-lg">
                                        <?php 
                                        foreach ($salesman_list as $single_salesman) 
                                        {
                                        ?>
                                            <option value="<?php echo $single_salesman->id; ?>">
                                                <?php echo $single_salesman->name.' | '.$single_salesman->address; 
                                                ?>     
                                            </option>
                                        <?php 
                                         }
                                        ?>
                                    </select>
                            </div> 
                            <div class="form-group">
                                <?php
                                    $data = array('class'=>'btn btn-primary btn-flat margin btn-md pull-right ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Generate report ');
                                    
                                    echo form_button($data);
                                 ?>  
                            </div>
                        </div>
                    </div>
                    <?php form_close(); ?>
                    <?php
                    if($pick_list != NULL)
                    {
                        
                    ?>
                    <div class="col-md-12">
                        <h2 class="text-center">
                            <?php 
                                echo $company_info[0]->companyname;
                            ?>
                        </h2>
                        <h4 class="text-center">Pick List / GIN (Salesman Wise) </h4>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6 text-left">From Date : <?php echo $date1; ?></div>
                        <div class="col-md-6 text-right">To Date : <?php echo $date2; ?></div>
                    </div>                    
                    <div class="col-md-12">
                        <div class="col-md-6 text-left">Sales man : <?php echo $salesman_name[0]->name; ?></div>
                        <div class="col-md-6 text-right">Print Date : <?php echo date('d-m-Y'); ?></div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6 text-left">Reporting Unit : All </div>
                        <div class="col-md-6 text-right">Reporting Oprion : Sales Man Wise</div>
                    </div>
                    <div class="col-md-12 table-responsive">
                    
                        <table id="" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Retail Price</th>
                                    <th>Pack Price</th>
                                    <th>Weight</th>
                                    <th>Quantity</th>
                                    <th>Issued</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($pick_list as $single_list)
                                {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_list['product_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['product_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['sku']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['retial_price']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['pack_price']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['weight']; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_list['qty']; ?>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                     ?>
                            </tbody>
                        </table>
                        
                        </div>
                        <?php
                            }             
                        ?>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 