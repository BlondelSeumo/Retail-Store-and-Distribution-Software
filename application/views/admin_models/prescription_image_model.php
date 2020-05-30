<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Prescription image</h4>
</div>
<div class="modal-body">
     <button onclick="printDiv('print-section-model')" class="btn btn-default btn-flat pull-right "><i class="fa fa-print pull-left"></i> Print 
 	</button>
    <div id="print-section-model" class="form-group">
        <?php
			echo img(array('width'=>'500','height'=>'auto','name'=>'prescribtion_picture','src'=>base_url().'uploads/prescription/'.$pres_image[0]->cus_picture));
		?>
    </div>
</div>
