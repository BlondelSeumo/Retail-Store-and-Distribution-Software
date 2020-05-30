<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-sm-12">
            <div class="box " >
                <div class="box-header box-title">
                    <h4 ><i class="fa fa-pencil" aria-hidden="true"></i> 
                        Product detail
                    </h4>
                </div>
                <?php
                    $attributes = array('id'=>'update_product_list_form','method'=>'post','class'=>'');
                ?>
                <?php echo form_open_multipart('product/edit',$attributes); ?>
                <div class="box-body bg-setting-product">
                    <?php 
                        $data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'edit_product_id','value'=>$product[0]->id);
                     echo form_input($data);
                     ?>
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i>  Product Info</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Product Name:'); ?>
                                <?php           
                                $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_product_name','value'=>$product[0]->product_name,'reqiured'=>'');
                                echo form_input($data);         
                                ?> 
                            </div>
                            <small>Name of the product ? </small>
                        </div>                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('SKU:'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_sku','value'=>$product[0]->sku,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            <small>Stock keeping unit ?  </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Barcode:'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_barcode','value'=>$product[0]->barcode,'reqiured'=>'');
                                        echo form_input($data);
                                ?>  
                            </div>
                            <small>Product barcode  and  make sure it should be unique ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Type:'); ?>
                                <?php 
                                    $type_options = array(
                                        'Finished Products'  => ' Finished Products',
                                        'Raw Product'  => 'Raw Product',
                                        'Ticket'  => 'Ticket'
                                          );
                                   
                                        $extra = array(
                                        'id'       => '',
                                        'onChange' => '',
                                        'class'=>'form-control select2'
                                        );

                                        echo form_dropdown('edit_type', $type_options, array($product[0]->type),$extra); 
                                     ?>   
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo form_label('Description:'); ?>
                            <textarea name="edit_description" class="form-control" rows="5"><?php echo $product[0]->description; ?></textarea>  
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Upload item image:</label>
                                    <div class="input-group">
                                        <input type="file" name="product_picture" data-validate="required" class="form-control input-lg" data-message-required="Value Required" >
                                    </div>
                            </div>
                            <small>Product scan or captured image ?</small>
                        </div>                        
                        <div class="col-md-4">
                            <img class="img-circle" width="80" height="80" src="<?php echo base_url('uploads/products/'.$product[0]->image)?>" />
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Grouping </h4>
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Brand:</label>                
                                    <?php
                                    if($brand != NULL)
                                      {
                                        foreach ($brand as $single_brand)
                                        {
                                            $brand_options[$single_brand->id] = $single_brand->name;
                                        } 
                                      }
                                      else
                                      {
                                        $brand_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }
                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('brand_id', $brand_options, array($product[0]->brand_id),$extra); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Brand Sector:</label>                
                                    <?php
                                        if($brandsector != NULL)
                                      {
                                        foreach ($brandsector as $single_sector)
                                        {
                                            $sector_options[$single_sector->id] = $single_sector->sector;
                                        } 
                                      }
                                      else
                                      {
                                        $sector_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('sector_id', $sector_options, array($product[0]->brand_sector_id),$extra); 
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Category: </label>                
                                     <?php
                                        if($catagory != NULL)
                                      {
                                        foreach ($catagory as $single_catagory)
                                        {
                                            $catagory_options[$single_catagory->id] = $single_catagory->category_name;
                                        } 
                                      }
                                      else
                                      {
                                        $catagory_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('edit_category_id', $catagory_options, array($product[0]->category_id),$extra); 
                                    ?>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="box-body bg-setting-product">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i> Unit and Weights: </h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Unit Type: </label>    
                                    <?php
                                     if($units != NULL)
                                      {
                                        foreach ($units as $single_unit)
                                        {
                                            $unit_options[$single_unit->symbol] = $single_unit->name.' '.$single_unit->symbol;
                                        } 
                                      }
                                      else
                                      {
                                        $unit_options = array(
                                                        '0'  => 'No record available'
                                          );
                                      }

                                     $extra = array(
                                              'id'       => '',
                                              'onChange' => '',
                                              'class'=>'form-control select2'
                                            );

                                    echo form_dropdown('unit', $unit_options, array($product[0]->unit_type),$extra); 
                                    ?>
                            </div>
                            <small>Product weight measurement ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Unit Weight: '); ?>
                                <?php               
                                $data = array('class'=>'form-control input-lg','type'=>'number','id'=>'product_mg','name'=>'edit_mg','value'=>$product[0]->mg,'reqiured'=>'');
                                     echo form_input($data);         
                                 ?>  
                            </div>
                            <small>Single product weight ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Net Weight: '); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'net_weight','value'=>$product[0]->net_weight,'reqiured'=>'');
                                    echo form_input($data);
                                ?>  
                            </div>
                            <small>Total weight of packsize ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Pack Size: '); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','readonly'=>'readonly','name'=>'packsize','value'=>$product[0]->packsize,'reqiured'=>'');
                                    echo form_input($data);
                                ?>  
                            </div>
                            <small>Product Packsize </small>
                        </div>
                    </div>                    
                </div>
                <div class="box-body">
                    <h4 class="purchase-heading" > <i class="fa fa-check-circle"></i>  Extra information</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Minimum stock level required:'); ?>
                                <?php
                                    $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_min_stock','value'=>$product[0]->min_stock,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            <small>Product alert indicator level ? </small>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Side Effects:'); ?>
                                <?php               
                                    $data = array('class'=>'form-control input-lg','type'=>'text','id'=>'sideeffects','name'=>'edit_side_effects','value'=>$product[0]->sideeffects,'reqiured'=>'');
                                    echo form_input($data);         
                                ?>
                            </div>
                            <small>Side effects of product ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php
                                    $data = array('type'=>'hidden','id'=>'edit_packsize','name'=>'edit_packsize','value'=>$product[0]->packsize,'reqiured'=>'');
                                    echo form_input($data);          
                                ?>
                                <?php echo form_label('Sales Tax (%) Per Unit :'); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'number','name'=>'edit_tax','value'=>$product[0]->tax,'step'=>'any','reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            <small>Sales tax on each product in % ? </small>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label('Unit Location in store: '); ?>
                                <?php
                                        $data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_location','value'=>$product[0]->location,'reqiured'=>'');
                                        echo form_input($data);
                                ?>
                            </div>
                            <small>Location where you stored this product in store. </small>
                        </div> 
                    </div>                                       
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                                    $data = array('class'=>'btn btn-info btn-flat btn-lg pull-right','type' => 'submit','name'=>'btn_submit_product','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update product');
                                    
                                    echo form_button($data);
                                ?>
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/dist/js/backend/product_details.js"></script>