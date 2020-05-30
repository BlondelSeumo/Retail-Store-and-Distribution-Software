<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Assign role</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="box box-danger">
            <div class="box-body">
                <div class="col-md-12">
                    <?php
    					$attributes = array('id'=>'multiple_roles_form','method'=>'post','class'=>'form-horizontal');
        			?>
                    <?php echo form_open('multiple_roles/add_role',$attributes); ?>
                        <div class="form-group">
                            <?php echo form_label('Select User :'); ?>
                                <select class="form-control input-lg" name="user_id" style="width: 100%;">
                                    <option value="0"> Select User </option>
                                    <?php
        								if($user_list != NULL)
                                        {
        									foreach ($user_list as $obj_user_list)
                                            {
            						?>
                                        <option value="<?php echo $obj_user_list->id; ?>">
                                            <?php echo 'Name : '.$obj_user_list->user_name.' | Email : '.$obj_user_list->user_email; ?>
                                        </option>
                                        <?php
            									}
            								}
                                            else
                                            {
            									echo "No User Record Found";
            								}
        				                ?>
                                </select>
                        </div>
                        <hr />
                        <?php
        					if($result_roles != NULL)
                            {
        						foreach ($result_roles as $obj_result_roles)
                                {
        				?>
                        <div class="form-group">
                            <?php echo form_label($obj_result_roles->name.' :'); ?>
                                <?php
                						$data = array('class'=>'','type'=>'hidden','value'=>$obj_result_roles->id,'name'=>'menu_id[]','reqiured'=>'');
                						echo form_input($data);
                				?>
                                    <select class="form-control input-lg" name="role_id[]" style="width: 100%;">
                                        <option value="0"> No</option>
                                        <option value="1"> Yes</option>
                                    </select>
                        </div>
                        <?php
        						}
        					}
                            else
                            {
        						echo "No Menu Items Found";
        					}

        				?>
                    <div class="form-group">
                        <?php
            				$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Role');
            				echo form_button($data);
            			 ?>

                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>