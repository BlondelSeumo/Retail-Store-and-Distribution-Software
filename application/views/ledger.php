<section class="content-header">
    <div class="row">
        <div class="col-md-6">
           <ol class="breadcrumb pull-left">
            <li>
                <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="active">General ledger</li>
        </ol>
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
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> General Ledger</h3>
        </div>
        <div class="box-body box-bg ">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'ledger_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements/ledger_accounts',$attributes); ?>
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
                            $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Create ledger');
                            echo form_button($data);
                        ?>
                    </div>
                </div>
            </div>
            </div>
            <div  class="col-md-1"></div>
        </div>
        <?php form_close(); ?>
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2 style="text-align:center">General Ledger </h2>
                    <h3 style="text-align:center">
                        <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                        ?>
                    </h3>
                   <h4 style="text-align:center"><b> From </b> <?php echo $from; ?> <b> To </b> <?php echo $to; ?></h4>
                   <h4 style="text-align:center"><b> Created  </b> <?php echo Date('Y-m-d'); ?> </h4>
                </div>
            <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <?php echo $ledger_records; ?>
        </div>
    </section>

<script type="text/javascript">
    var timmer;
    function calculate_func(val)
    {
        clearTimeout(timmer);
        timmer = setTimeout(function callback()
          { 
             var grand_total = $('#grand_total').val();         
             var balance =  grand_total-val;
             $('#balance_field').val(balance);      

          }, 800);
    }
</script>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 