<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                             Upload Backup file:
                    </h3>
                </div>
                <div class="box-body">
                     <div class="row">
                         <div class="col-md-12">
                            <?php
                                $attributes = array('id'=>'Service_form','method'=>'post','class'=>'form-horizontal');
                            ?>
                            <?php echo form_open_multipart('backup/restore',$attributes); ?>
                                <div class="form-group text-center">
                                    <div class="col-md-12" style="color:#c00;">
                                        <h3>Important Notes</h3> 
                                        <h4>*Please make sure that you are uploading right file</h4>    
                                        <h4>*Please make sure that file name starts with only pos_shop_date_backup name </h4>  
                                        <h4>*Please make sure that file extension should be .txt</h4>  
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label>Upload backup file</label>
                                        <div class=" text-center">
                                             <input type="file" style="width:600px; margin:0 auto; height: 60px;" class="form-control input-lg " name="backup_file" data-validate="required" data-message-required="Value Required" />
                                        </div>
                                </div>
                                <div class="form-group text-center">                  
                                    <?php
                                        $data = array('class'=>'btn btn-default btn-flat btn-lg ','type' => 'submit','name'=>'btn_submit_Service','value'=>'true', 'content' => '<i class="fa fa-upload" aria-hidden="true"></i> Click here to restore Backup ');
                                        echo form_button($data);
                                     ?>    
                                  </div>
                              <?php echo form_close(); ?>
                         </div>
                     </div>   
                </div>
            </div>
        </div>
    </div>
</section>