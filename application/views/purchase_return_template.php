<div class="col-md-12 set-no-padding">
 <table class="table table-striped table-bordered table_height_set">
    <thead>
        <tr> 
            <th>Item</th>
            <th>Weight</th>
            <th>Qty (Packs)</th>
            <th>Unit Cost </th>
            <th>Unit Retail</th>
            <th>Pack Cost</th>
            <th>Pack Retail</th>
            <th>Manu</th>
            <th>Exp</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
 <?php    
    $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency']; 
   
    $total_gross = 0;
    

if($temp_data != NULL)
{
    foreach ($temp_data as $single_val) 
    {
         $total_gross = number_format($total_gross+($single_val->pack_cost*$single_val->qty),3,'.','');
 
 ?>
    <tr > 
        <td><?php echo $single_val->product_name; ?></td>
        <td><?php echo $single_val->weight.' '.$single_val->unit_type; ?></td>
        <td>
            <input type="number" onkeyup="amend_qty('qty',this.value,'<?php echo $single_val->id; ?>')" class="supply_fields" value="<?php echo $single_val->qty; ?>" name="supply_qty" id="supply_qty" />  
        </td>
         <td>
            <input type="number"  disabled step="any" value="<?php echo $single_val->cost; ?>" name="purchase_cost" id="purchase_cost">
        </td>   
         <td>
            <input type="number"  disabled  class="supply_fields" step="any" value="<?php echo $single_val->retail; ?>" name="purchase_retail" id="purchase_retail">
        </td>         
        <td>
            <input type="number" disabled  class="supply_fields" step="any" value="<?php echo $single_val->pack_cost; ?>" name="purchase_cost_pack" id="purchase_cost_pack">
        </td>
        <td>
            <input type="number"  disabled  class="supply_fields" step="any" value="<?php echo $single_val->pack_retail; ?>" name="purchase_cost_pack" id="purchase_cost_pack">  
        </td>
        <td>
            <input type="date" disabled class="supply_fields" value="<?php echo $single_val->manu_date; ?>" name="manu_date" id="manu_date">  
        </td>
        <td>
            <input type="date" disabled  class="supply_fields" value="<?php echo $single_val->expire_date; ?>"  name="expire_date" id="expire_date">  
        </td>
       
        <td >
            <a onclick="delete_item('<?php echo $single_val->id; ?>')" ><i class="fa fa-trash margin" aria-hidden='true'></i>
            </a>  
        </td>
    </tr>
     <?php 
       } 
    } 
      ?> 
    </tbody>
 </table>  
</div>
<div class="row">
    <div class="col-md-12 ">
        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Purchase Detail :</h4>
        <div class="col-md-3 ">
            <div class="form-group">
                <?php echo form_label('Grand Total'); ?>
                <?php
                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'pur_total','id'=>'grand_total','step'=>'any','value'=>$total_gross);
                    echo form_input($data);
                ?>
            </div> 
            <small>mention the amount of total bill </small>               
        </div>                    
        <div class="col-md-3">                
                <div class="form-group">
                    <label>Upload image</label>
                        <div class="input-group">
                        <input type="file" name="pur_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
                    </div>
                </div>
                <small>capture or scan bill image  </small>
        </div>                 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Payment Detail :</h4>
        <div class="col-md-3">
            <div class="form-group">
                <?php echo form_label('Payment Method'); ?>
                <select name="pur_method" id="payment_id" class="form-control input-lg">
                    <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                <
                </select>
            </div>
            <small>method of payment cash or cheque  </small>
        </div>                
        <div class="col-md-3">
            <div class="form-group">
                <?php echo form_label('Payment Date'); ?>
                <?php
                    $data = array('class'=>'form-control input-lg','type'=>'date','name'=>'pur_date','reqiured'=>'');
                    echo form_input($data);
                ?>
            </div>
            <small>date of bill paid  </small>
        </div>                
        <div class="col-md-3">
            <div class="form-group">
                <?php echo form_label('Cash recieved'); ?>
                <?php
                    $data = array('class'=>'form-control input-lg','onkeyup'=>'calculate_func(this.value)','type'=>'number','name'=>'pur_paid','step'=>'any','value'=>$total_gross);
                    echo form_input($data);
                ?>
            </div>
            <small>how much you paid against total bill. </small>
        </div>                
        <div class="col-md-3">
            <div class="form-group">
                <?php echo form_label('Balance'); ?>
                <?php
                    $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'balance_field','name'=>'pur_balance','step'=>'any','value'=>0);
                    echo form_input($data);
                ?>
            </div>
                <small>remaing amount you will recieve in future.</small>
        </div>
    </div>
</div>
<div class="row">
    <br />
    <div class="col-md-12">
        <div class="bank-section-details">
            <div class="col-md-9">
                <div class="form-group ">
                    <label>Deposit bank: </label>               
                    <select class="form-control select2" name="bank_id" id="bank_id"  style="width: 100%;">
                        <option value="0"> Bank account</option>
                        <?php
                        //category_names from mp_category table;
                        if($bank_list != NULL)
                        {       
                            foreach ($bank_list as $single_bank)
                            {
                        ?>
                            <option value="<?php echo $single_bank->id; ?>" ><?php echo $single_bank->bankname.' | TITLE '.$single_bank->title.' | Account '.$single_bank->accountno.' | Branch '.$single_bank->branch.' | Code '.$single_bank->branchcode; ?> 
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
                    <h5>Available balance PKR <b id="available_balance"> 0 </b></h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" id="bank-cheque-no">
                    <?php echo form_label('Cheque No:'); ?>
                    <?php               
                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'ref_no','reqiured'=>'');
                        echo form_input($data);             
                    ?>
                    <?php               
                        $data = array('type'=>'hidden','id'=>'save_available_balance','name'=>'save_available_balance','value'=>'0','reqiured'=>'');
                        echo form_input($data);             
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Return  Description:</h4>
            <?php
                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'pur_description','placeholder'=>'Any description','reqiured'=>'');
                echo form_input($data); 

                $data = array('type'=>'hidden','name'=>'status','value'=>'1','reqiured'=>'');
                echo form_input($data);
            ?>
        </div>
            <small>any description you want to add for future help.</small>
    </div>
</div>            
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php
                $data = array('class'=>'btn btn-info btn-flat margin btn-lg pull-right ','type' => 'submit','name'=>'btn_submit_customer','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Save Purchased return');
                
                echo form_button($data);
                ?>  
        </div>
    </div>
</div>
<?php form_close(); ?>

<?php $this->load->view('ajax/purchase_return_bill_template.php'); ?>

<script type="text/javascript">
    $('#payment_id').change(function()
    {
        var method = $('#payment_id').val();
        if(method == 'Cheque')
        {
            $('.bank-section-details').css('display','block');
        }
        else
        {
            $('.bank-section-details').css('display','none');
        }
});

    $('#bank_id').change(function(){
    var bank_id = $('#bank_id').val();

    if(bank_id != 0)
    {
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: '<?php echo base_url('bank/check_available_balance/'); ?>'+bank_id,
            success: function(response)
            {
                $('#available_balance').html(response);
                $('#save_available_balance').val(response);
            }
        });
        $('#bank-cheque-no').css('display','block');
    }
});
</script>