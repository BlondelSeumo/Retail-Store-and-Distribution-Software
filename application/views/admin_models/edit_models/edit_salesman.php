<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> 
	Edit sales man 
</h4>
</div>
  <div class="modal-body">
	<div class="row">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-12">
			<?php
				$attributes = array('id'=>'edit_salesman','method'=>'post','class'=>'form-horizontal');

			?>
			<?php echo form_open_multipart('supply/edit_salesman',$attributes); ?>
	          <div class="form-group">	
	          	<?php 
	          		$data = array('class'=>'form-control input-lg','type'=>'hidden','name'=>'edit_salesman_id','value'=>$single_salesman[0]->id);
						echo form_input($data);
	          	 ?>
				 <?php echo form_label('Name:'); ?>
				 <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'name','value'=>$single_salesman[0]->name);
					echo form_input($data);
				?>
	          </div>
			   <div class="form-group">
				<?php echo form_label('Contact No:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'contact_no','value'=>$single_salesman[0]->contact);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Address:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'address','value'=>$single_salesman[0]->address);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Description:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'description','value'=>$single_salesman[0]->description);
					echo form_input($data);
				?>
	          </div>
	           <div class="form-group">
				<?php echo form_label('Reference:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'text','name'=>'reference','value'=>$single_salesman[0]->ref);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
				<?php echo form_label('Date:'); ?>
	           <?php
					$data = array('class'=>'form-control input-lg','type'=>'date','name'=>'date','value'=>$single_salesman[0]->date);
					echo form_input($data);
				?>
	          </div>
	          <div class="form-group">
               <?php
				
					echo img(array('width'=>'100','height'=>'100','class'=>'img-circle','name'=>'edit_sales_picture','src'=>base_url().'uploads/salesman/'.$single_salesman[0]->cus_picture));
				?>	
			</div>
			   <div class="form-group">
	            <label>Upload Picture </label>
					<div class="input-group">
	      				<input type="file" class="form-control input-lg" name="salesman_picture" data-validate="required" data-message-required="Value Required" >
	            	</div>
	          </div>
			  <div class="form-group">  				
				<?php
					$data = array('class'=>'btn btn-info btn-lg btn-flat margin','type' => 'submit','id'=>'','name'=>'btn_submit_Testamonial','value'=>'true', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Update');
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
