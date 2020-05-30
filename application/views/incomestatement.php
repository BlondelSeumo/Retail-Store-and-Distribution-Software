<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
                <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">income</li>
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
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Income statement</h3>
        </div>
        <div class="box-body box-bg ">
            <div class="make-container-center">
            <?php
                $attributes = array('id'=>'ledger_accounts','method'=>'post','class'=>'');
            ?>
            <?php echo form_open_multipart('statements/income_statement',$attributes); ?>
            <div class="row no-print">
                <div  class="col-md-12">
                    <div  class="col-md-3"></div>
                        <div  class="col-md-8">
                            <div class="col-md-8 col-sm-4">
                                <div class="form-group">
                                    <label for="date_from" class="col-sm-3   col-md-3 control-label">
                                       Select year
                                    </label>
                                    <div class="col-sm-9 col-md-9">
                                        <select class="form-control" name="year">
                                            <option  value="2017"> 2017</option>
                                            <option  value="2018"> 2018</option>
                                            <option  value="2019"> 2019</option>
                                            <option  value="2020"> 2020</option>
                                            <option  value="2021"> 2021</option>
                                        </select>
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <div class="form-group">
                                    <?php
                                        $data = array('class'=>'btn btn-info pull-right','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Create Statement');
                                        echo form_button($data);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div  class="col-md-1"></div>
                    </div>    
            <?php form_close(); ?>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                  <h3 style="text-align:center">Statement of income </h3>
                  <h3 style="text-align:center">
                    <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                    ?>
                   </h3>
                   <h4 style="text-align:center"> Reporting period: <?php echo $from.' to '.$to; ?> <b>
                   </h4>                   
                   <h4 style="text-align:center"> Created <?php echo Date('Y-m-d'); ?> <b>
                   </h4>
                </div>
                <div class="col-md-3"></div>  
        </div>
        <div class="row">
            <div class="col-md-12">
                 <table class="table table-striped table-hover">
                     <tbody>
                        <?php echo $income_records; ?>
                     </tbody>
                 </table>
            </div>
           
        </div>
            </div>
        </div>
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