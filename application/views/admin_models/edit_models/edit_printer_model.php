<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i>
	 Edit printer 
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger">
        	<div class="box-body">
	         	<div class="col-md-12">
				 <?php
					$attributes = array('id'=>'printer_form','method'=>'post','class'=>'form-horizontal');
				  ?>
					<?php echo form_open('printer_settings/edit',$attributes); ?>  
			         <div class="form-group">    
						<?php
							$data = array('class'=>'','type'=>'hidden','name'=>'edit_id','value'=>$single_printer[0]->id);
							echo form_input($data);	


							echo form_label('Printer Name:');
							$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'printer_name','value'=>$single_printer[0]->printer_name,'reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>			         
			         <div class="form-group">    
						<?php
							echo form_label('Font Size:');
							$data = array('class'=>'form-control input-lg','type'=>'number','name'=>'font_size','value'=>$single_printer[0]->fontsize,'reqiured'=>'');
							echo form_input($data);							
						?>           
			         </div>	    
					 <div class="form-group">  				
						<?php
							$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_submit_category','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Printer');
							
							echo form_button($data);	
						 ?>    
			         </div>
						<?php echo form_close(); ?>			    		
	        	</div>	
     		</div>				  
		</div>
	</div>
</div>