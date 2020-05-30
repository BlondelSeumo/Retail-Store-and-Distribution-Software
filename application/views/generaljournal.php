<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
               <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">General journal</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print / Pdf</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box" id="print-section">
        <div class="box-header no-print">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> General Journal</h3>
        </div>
        <div class="box-body ">
            <?php
                $attributes = array('id'=>'general_journal','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements',$attributes); ?>
            <div class="row no-print ">
                <div  class="col-md-12">
                    <div  class="col-md-1"></div>
                        <div  class="col-md-8">
                            <div class="col-md-5 col-sm-4 ">
                                <div class="form-group">
                                    <label for="date_from" class="col-sm-4 control-label">
                                        Date From
                                    </label>
                                    <div class="col-sm-8">
                                        <?php 
                                            $data = array('class'=>'form-control','id'=>'date_from','type'=>'date','name'=>'from');
                                            echo form_input($data); 
                                        ?>
                                    </div>   
                                </div>
                            </div> 
                            <div class="col-md-5 col-sm-4">
                                <div class="form-group">
                                    <label for="date_from" class="col-sm-4 control-label">
                                        Date To
                                    </label>
                                    <div class="col-sm-8 col-md-8">
                                        <?php 
                                             $data1 = array('class'=>'form-control','type'=>'date','name'=>'to');
                                            echo form_input($data1);
                                        ?>
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4">
                                <div class="form-group">
                                    <?php
                                        $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Create statement');
                                        echo form_button($data);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-1"></div>
                </div>
                <?php form_close(); ?>
            <div class="make-container-center">
        <?php 
        if($transaction_records != NULL)
        {
        ?>
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                   <h2 style="text-align:center">General Journal </h2>
                   <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3>
                   <h4 style="text-align:center"><b>From</b> <?php echo $from; ?> <b> To </b> <?php echo $to; ?>
                   </h4>
                   <h4 style="text-align:center">Created <?php echo Date('Y-m-d'); ?> 
                   </h4>
                </div>
            <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <table class="table table-hover table-responsive" id="dataTable">
                <thead class="ledger_head">
                     <th class="col-md-2">DATE</th>
                     <th class="col-md-8">ACCOUNT TITLE AND EXPLANATION</th>
                     
                     <th class="col-md-1">DEBIT</th>
                     <th class="col-md-1">CREDIT</th>
                </thead>
                <tbody>   
                        <?php echo $transaction_records; ?>
                </tbody>
            </table>
        </div>

        <?php 
            }
            else
            {
                echo '<p class="text-center"> No record found</p>';
            }
        ?>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 