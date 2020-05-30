<tr>
   <td >
        <select name="account_head[]" class="form-control select2 input-lg">
            <?php echo $accounts_records; ?>
        </select>
   </td>
   <td>
   </td> 
   <td>
        
   </td> 
   <td>
        <?php
            $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'debitamount[]','step'=>'any','value'=>'0','reqiured'=>'','onkeyup'=>'count_debits()');
            echo form_input($data);
        ?>
   </td>
</tr>