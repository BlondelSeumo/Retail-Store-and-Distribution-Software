<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
		  	Edit requested item
		  </h4>
</div>
<div class="modal-body">
   <div class="row">
          <div class="box box-danger">
            <div class="box-body">
              <div class="col-md-12">
			 <?php
					$Edit_attributes = array('id'=>'Edit_Todolist_form','method'=>'post','class'=>'form-horizontal');
			  ?>
			<?php echo form_open('todolist/edit/',$Edit_attributes); ?> 			  
              <div class="form-group">    
				<?php
						echo form_label('Requested item:');
						$data = array('class'=>'form-control','type'=>'hidden','name'=>'edit_todo_id','value'=>$single_todo[0]->id);
						echo form_input($data);	
						$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'edit_todo_name','value'=>$single_todo[0]->title);
						echo form_input($data);									
				?>
              </div>			 			  
              <div class="form-group">    
				<?php
						echo form_label('Date to remind:');
						$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'edit_todolist_date','value'=>$single_todo[0]->date);
						echo form_input($data);									
				?>           
              </div>	
			  
			  <div class="form-group">  				
                 <?php
					$data = array('class'=>'btn btn-info btn-flat btn-lg','type' => 'submit','name'=>'btn_todo_list','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update Request');
					
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