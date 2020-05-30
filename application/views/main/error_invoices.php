<div class="row">
	<div class="col-md-12 ">
		<?php
			$attributes = array('id'=>'','method'=>'post',);
		?>
		<?php echo form_open($actionresult,$attributes); ?>
			<div class="col-md-12  ">
			   <div class="form-group margin ">
					<?php echo form_label('Date From:'); ?>
					<div class="input-group date ">
					  <div class="input-group-addon   ">
						<i class="fa fa-calendar "></i>
					  </div>
					   <?php
							$data = array('class'=>'form-control pull-right input-lg ','type'=>'date','id'=>'datepicker','name'=>'date1','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
							echo form_input($data);
						?>
					</div>
				<!-- /.input group -->
			  </div>
			  </div>
			   <div class="col-md-12">
					<div class="form-group margin">
						<?php echo form_label('Date To:'); ?>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						   <?php
								$data = array('class'=>'form-control pull-right input-lg ' ,'type'=>'date','id'=>'datepicker','name'=>'date2','placeholder'=>'e.g 12-08-2018','reqiured'=>'');
								echo form_input($data);
							?>
						</div>
					</div>
			  </div>   
			  <div class="col-md-12">
				<?php
					$data = array('class'=>'btn btn-info btn-flat btn-lg  pull-right','name'=>'searchecord','value'=>'Search invoices');
					echo form_submit($data);
				 ?> 
			</div>  
			<?php echo form_close(); ?>		
		 </div>
	  </div>  
<!-- Main content -->
<section style="padding-top:5%;"class="content">
	<div class="row">
	  <div class="error-page">
		<h2 class=" text-blue text-center"><?php echo $heading1; ?></h2>
	  </div>
	</div>
	<div class="row">
		<div class="error-page">
			  <h4 class=" text-center"><i class="fa fa-warning text-red"></i> <?php echo $heading2; ?></h4> 
		</div>
	</div>
    <!-- /.error-page -->
</section>
<!-- /.content -->