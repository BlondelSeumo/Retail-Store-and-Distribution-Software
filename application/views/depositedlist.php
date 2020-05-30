<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <ol class="breadcrumb pull-left">
                <li>
                    <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="active">Bank deposit</li>
            </ol>
        </div>
        <div class="col-md-6">
            <div class="pull pull-right">
                <a type="button" class="btn btn-info btn-flat" href="<?php echo base_url('bank/deposit'); ?>" ><i class="fa fa-plus-square" aria-hidden="true"></i>        Create Deposit
                </a>
                <button onclick="printDiv('print-section')" class="btn btn-default  btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print / Pdf
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
                <?php
                    $attributes = array('id'=>'written_cheque','method'=>'post','class'=>'');
                ?>

                <?php echo form_open('bank/deposit_list',$attributes); ?>
                <div class="row no-print">
                    <div class="col-md-3 col-sm-4 ">
                        <div class="form-group">
                            <label for="date_from" class="col-sm-5 control-label">
                                Date From
                            </label>
                            <div class="col-sm-7">
                                <?php 
                                    $data = array('class'=>'form-control','id'=>'date_from','type'=>'date','name'=>'date1');
                                    echo form_input($data); 
                                ?>
                            </div>   
                        </div>
                    </div> 
                    <div class="col-md-3 col-sm-4">
                        <div class="form-group">
                            <label for="date_from" class="col-sm-4 control-label">
                                Date To
                            </label>
                            <div class="col-sm-8 col-md-8">
                                <?php 
                                     $data1 = array('class'=>'form-control','type'=>'date','name'=>'date2');
                                    echo form_input($data1);
                                ?>
                            </div>   
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="form-group">
                            <?php
                                $data = array('class'=>'btn btn-info','type' => 'submit','name'=>'btnSubmit','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Search deposits');
                                echo form_button($data);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" onchange="search_transaction(this.value)" name="timeperiod">
                                <option value="Filter">Filter </option>
                                <option value="month">This Month </option>
                                <option value="three">Last 3 Months </option>
                                <option value="year"> This Year </option>
                                <option value="all">  All </option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?> 
                <div class="col-md-12 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <?php
                                foreach ($table_heading_names_of_coloums as $table_head)
                                {

                                ?>
                                    <th>
                                        <?php echo $table_head; ?>
                                    </th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($deposit_list != NULL)
                                {
                                    foreach ($deposit_list as $deposit)
                                    {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $deposit->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->bankname; ?>
                                    </td> 
                                    <td>
                                        <?php echo $deposit->headname; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->total_paid; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($deposit->transaction_status == 0)
                                            {
                                                echo 'Deposited';
                                            }
                                            else
                                            {
                                                echo 'Not Deposited';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                     <a href="<?php echo base_url('prints/deposit/'.$deposit->transaction_id); ?>" >
                                                        <i class="fa fa-link"></i> 
                                                        Preview
                                                    </a> 
                                                 </li> 
                                                <?php 
                                                if($deposit->transaction_status == 0)
                                                {   
                                                ?> 
                                                    <li>
                                                        <a onclick="confirmation_alert('make this not deposited ','<?php echo base_url().'bank/change_deposit_status/'.$deposit->bank_trans_id.'/1'; ?>')"  href="javascript:void(0)" ><i class="fa fa-times-circle-o"></i> Not Deposited
                                                        </a>
                                                    </li>
                                                <?php    
                                                }
                                                else
                                                {
                                                 ?>
                                                    <li>
                                                        <a onclick="confirmation_alert('make this deposited ','<?php echo base_url().'bank/change_deposit_status/'.$deposit->bank_trans_id.'/0'; ?>')"  href="javascript:void(0)"  href=""><i class="fa fa-check-circle"></i> Deposited
                                                        </a>
                                                    </li>
                                                <?php 
                                                  }
                                                 ?> 
                                                 <li>
                                                    <a  href="<?php echo base_url('bank/edit_deposit/'.$deposit->transaction_id); ?>">
                                                        <i class="fa fa-pencil"></i> 
                                                        Edit
                                                    </a>
                                                </li>  
                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                                <?php

                                        }
                                    }

                                 ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script type="text/javascript">
    function search_transaction(period)
    {
        window.location = '<?php echo base_url('bank/deposit_list/')?>'+period;
     
    }
</script>

<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 