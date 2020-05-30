<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-user" aria-hidden="true"></i>  Customer profile: </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div id="print-section-model" class="box-body">
                    <div class="form-group">
                        <button onclick="printDiv('print-section-model')" class="btn btn-default btn-flat pull-right no-print"><i class="fa fa-print pull-left"></i> Print 
                        </button>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Customer Name:'); ?>
                        <?php
        					$data = array('class'=>'form-control','type'=>'text','disabled'=>'disabled','name'=>'edit_customer_name','value'=>$single_cus[0]->customer_name,'reqiured'=>'');
        					echo form_input($data);
        				?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Customer Email:'); ?>
                        <?php
    						$data = array('class'=>'form-control','type'=>'email','disabled'=>'disabled','name'=>'edit_customer_email','value'=>$single_cus[0]->cus_email,'reqiured'=>'');
    						echo form_input($data);
    					?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Customer Address:'); ?>
                        <?php
    						$data = array('class'=>'form-control','type'=>'text','disabled'=>'disabled','name'=>'edit_customer_address','value'=>$single_cus[0]->cus_address,'reqiured'=>'');
    						echo form_input($data);
            			  ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Customer Contact1:'); ?>
                        <?php
    						$data = array('class'=>'form-control','type'=>'number','disabled'=>'disabled','name'=>'edit_customer_contatc1','value'=>$single_cus[0]->cus_contact_1,'reqiured'=>'');
    						echo form_input($data);
        			   ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Customer Contact2(Optional):'); ?>
                        <?php
    						$data = array('class'=>'form-control','type'=>'number','disabled'=>'disabled','name'=>'edit_customer_contact_two','value'=>$single_cus[0]->cus_contact_2,'reqiured'=>'');
    						echo form_input($data);
    					?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Company:'); ?>
                        <?php
    						$data = array('class'=>'form-control','type'=>'text','disabled'=>'disabled','name'=>'edit_customer_company','value'=>$single_cus[0]->cus_company,'reqiured'=>'');
    						echo form_input($data);
    					?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('City:'); ?>
                        <?php

    						$data = array('class'=>'form-control','type'=>'text','disabled'=>'disabled','name'=>'edit_customer_city','value'=>$single_cus[0]->cus_city,'reqiured'=>'');
    						echo form_input($data);

    					?>

                    </div>
                    <div class="form-group">
                        <?php echo form_label('Country:'); ?>
                        <?php
    						$data = array('class'=>'form-control','disabled'=>'disabled','type'=>'text','name'=>'edit_customer_country','value'=>$single_cus[0]->cus_country,'reqiured'=>'');
    						echo form_input($data);
    					?>
                    </div>

                    <div class="form-group">
                        <?php echo form_label('description:'); ?>
                        <?php
    						$data = array('class'=>'form-control','disabled'=>'disabled','type'=>'text','name'=>'edit_customer_description','value'=>$single_cus[0]->cus_description,'reqiured'=>'');
    						echo form_input($data);
    					?>
                    </div>
                    <div class="form-group">
                        <?php
    						echo img(array('width'=>'100','height'=>'100','class'=>'img-circle','name'=>'Edit_customer_picture','src'=>base_url().'uploads/customers/'.$single_cus[0]->cus_picture));
    					?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
