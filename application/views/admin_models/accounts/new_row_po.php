<tr>
    <td>
        <?php
            $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'product[]','reqiured'=>'','id'=>'des_id');
            echo form_input($data);
        ?>
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