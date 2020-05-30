<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
                <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Bank book</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat   pull-right "><i class="fa fa-print  pull-left"></i> Print / Pdf
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content" id="print-section">
        <div class="box-header no-print">
            <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Bank Book</h3>
        </div>
        <div class="row no-print bank-book-setting">
            <?php
                $attributes = array('id'=>'bank_form','method'=>'post',);
            ?>
            <?php echo form_open('bank/bank_book',$attributes); ?>
                    <div class="col-md-3 col-sm-6 ">
                        <div class="form-group">
                            <label for="date_from" class="col-md-4 col-sm-4 control-label">
                                Date From
                            </label>
                            <div class="col-md-8 col-sm-8">
                                <?php 
                                    $data = array('class'=>'form-control','id'=>'date_from','type'=>'date','name'=>'date1');
                                    echo form_input($data); 
                                ?>
                            </div>   
                        </div>
                    </div> 
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="date_from" class="col-md-4 col-sm-4  control-label">
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
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="date_from" class="col-md-2 col-sm-2 control-label">
                             Bank:
                            </label>
                            <div class="col-sm-10 col-md-10">
                                <select name="bank_id" class="form-control input-lg">
                                <?php 
                                  foreach ($bank_list as $single_bank) 
                                  {
                                ?>
                                     <option value="<?php echo $single_bank->id ?>">
                                      <?php echo $single_bank->bankname.' | '.$single_bank->branch.' | '.$single_bank->branchcode.' | '.$single_bank->title.' | '.$single_bank->accountno;  ?>
                                      </option>
                                <?php   
                                  }
                                ?>   
                                </select>
                            </div>   
                        </div>
                    </div>                        
                    <div class="col-md-2 col-sm-6">
                        <?php
                            $data = array('class'=>'btn btn-info ','type' => 'submit','name'=>'searchecord','value'=>'true', 'content' => '<i class="fa fa-search" aria-hidden="true"></i> Generate Bank Book');
                            echo form_button($data);
                        ?>
                    </div>
                <?php echo form_close(); ?>
                </div>
        <?php 
            if($bank != '')
            {
        ?>
    <div class="row">
        <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 style="text-align:center"> Bank Book </h2>
                <h3 style="text-align:center">
                    <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;
                    ?>
                </h3>
                <h4 style="text-align:center"> <b><?php echo $bankname[0]->bankname; ?> </b>
                </h4>
                <h4 style="text-align:center">As of : <b><?php echo $to; ?> </b>
                </h4>
                <h4 style="text-align:center">Created : <b><?php echo Date('Y-m-d'); ?> </b>
                </h4>
            </div>
            <div class="col-md-3"></div>  
    </div>
    <div class="box-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header balancesheet-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
               
                <div class="col-md-12 table-responsive">
                    <table id="" class="table  table-striped">
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
                                $total_deposits = 0;
                                if($deposit_list != NULL)
                                {
                                    foreach ($deposit_list as $deposit)
                                    {
                                        $total_deposits = $total_deposits + $deposit->amount;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $deposit->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->method; ?>
                                    </td> 
                                    <td>
                                        <?php echo $deposit->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $deposit->amount; ?>
                                    </td>
                                </tr>

                                <?php
                                        }
                                    }
                                 ?>
                                 <tr class="balancesheet-row">
                                     <td  colspan="4"> Total Deposits </td>
                                     <td ><b><?php echo number_format($total_deposits,'3','.',''); ?></b></td>
                                 </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header balancesheet-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $table_name2; ?></h3>
                </div>
                <div class="col-md-12 table-responsive">
                    <table id="" class="table  table-striped">
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
                                $total_cheque = 0;
                                if($cheque_list != NULL)
                                {
                                    foreach ($cheque_list as $cheque)
                                    {
                                        $total_cheque = $total_cheque + $cheque->amount;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $cheque->date; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->method; ?>
                                    </td> 
                                    <td>
                                        <?php echo $cheque->ref_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->customer_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $cheque->amount; ?>
                                    </td>
                                </tr>

                                <?php
                                        }
                                    }
                                 ?>
                                 <tr class="balancesheet-row">
                                     <td  colspan="4"> Total cheques written </td>
                                     <td ><b><?php echo number_format($total_cheque,'3','.',''); ?></b></td>
                                 </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        }
        ?>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 