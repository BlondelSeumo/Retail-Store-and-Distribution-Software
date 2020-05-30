<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> 
		Edit town
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="box box-danger">
			<div class="box-body">	
				<div class="col-md-12">
					<?php
						$attributes = array('id'=>'town_form','method'=>'post','class'=>'form-horizontal');
					?>
					<?php echo form_open($link,$attributes); ?>		
					<div class="form-group">
						<label> Town </label>		
						<?php 
							$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_town_id','value'=>$town[0]->id);
							echo form_input($data);
						 ?>
						
						<?php			
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'town_name','value'=>$town[0]->name,'reqiured'=>'');
							echo form_input($data);			
						?>
					</div>		
					<div class="form-group">
						<?php
						echo form_label('Region:');
						if($region != NULL)
                          {
                            foreach ($region as $single_region)
                             {
                                $head_options[$single_region->name] = $single_region->name;
                             } 
                          }
                          else
                          {
                             $head_options = array(
                                            '0'  => 'No record available'
                              );
                          }
                     	 $extra = array(
                                  'id'       => '',
                                  'onChange' => '',
                                  'class'=>'form-control input-lg '
                                );
                      	echo form_dropdown('region', $head_options, '',$extra);
						?>					
					</div>					
					<div class="form-group">
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_medicine','value'=>'true', 'content' => '<i class="fa fa-pencil" aria-hidden="true"></i> Update town');
							
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