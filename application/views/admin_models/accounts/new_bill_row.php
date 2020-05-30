<tr>
   <td>
        <select class="form-control select2 "  name="account_head[]" id="account_head">
            <option value="0" >Choose</option>
            <?php
            //category_names from mp_category table;
            if($head_list != NULL)
            {       
                foreach ($head_list as $single_head)
                {
            ?>
                  <option value="<?php echo $single_head->id; ?>" ><?php echo $single_head->name; ?> 
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
   </td>                                     
    <td>
        <?php
            $data = array('class'=>'form-control input-lg','type'=>'text','placeholder'=>'Any description','name'=>'descriptionarr[]','reqiured'=>'');
            echo form_input($data);
        ?>
   </td>    
   <td>
        <?php
            $data = array('class'=>'form-control input-lg amount','type'=>'number','name'=>'amount[]','id'=>'amount','step'=>'any','reqiured'=>'','value'=>'0');
            echo form_input($data);
        ?>
   </td>                           
   <td>
        <a  onclick="deleteParentElement(this)" href="javascript:void(0)">
            <i class="fa fa-trash bill-times-icon" aria-hidden="true"></i>
        </a>
   </td>
</tr>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });

</script>