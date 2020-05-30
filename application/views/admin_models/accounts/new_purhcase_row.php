<tr>
   <td>
        <select class="form-control select2 "  name="product[]" id="product_name">
            <option value="0" >Choose</option>
            <?php
            //category_names from mp_category table;
            if($product_list != NULL)
            {       
                foreach ($product_list as $single_product)
                {
                  if($single_product->type == 1)
                  {
            ?>
                    <option data-price="<?php echo $single_product->cost; ?>" data-description="<?php echo $single_product->description; ?>" data-tax="<?php echo $single_product->sale_tax; ?>" value="<?php echo $single_product->id; ?>" ><?php echo $single_product->product_name; ?> 
                    </option>
            <?php
                 }
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
            $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'descriptionarr[]','reqiured'=>'','id'=>'des_id');
            echo form_input($data);
        ?>
   </td>    
   <td>
        <?php
            $data = array('class'=>'form-control input-lg qty','type'=>'number','name'=>'qty[]','id'=>'quantity_item','step'=>'any','reqiured'=>'','value'=>'0');
            echo form_input($data);
        ?>
   </td>    
   <td>
        <?php
            $data = array('class'=>'form-control input-lg price','type'=>'number','name'=>'price[]','id'=>'price','step'=>'any','reqiured'=>'','value'=>'0');
            echo form_input($data);
        ?>
   </td>      
   <td>
        <?php
            $data = array('class'=>'form-control input-lg item_Subtotal','type'=>'number','name'=>'subtotal[]','id'=>'amount','step'=>'any','reqiured'=>'','value'=>'0');
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