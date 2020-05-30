<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button onclick="printDiv('print-section')" class="btn btn-default btn-flat btn-lg   pull-right ">
                    <i class="fa fa-print pull-left "></i> Print Barcodes
                </button>
            </div>
        </div>
    </div>
</section>
<section class="content">   
    <div class="row">
        <div class="col-xs-12">
            <div class="box-header">
                    <h1 class="box-title">
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 
                            Product name : <?php echo $brand_name; ?>
                    </h1>
                </div>
            <div class="box" id="print-section">
                <div class="barcode-section">
                    <?php 
                        $i = 0;
                        while ($i < $barcode_qty) 
                        {
                    ?>
                            <div class="col-md-3 col-sm-6 col-xs-12 each_code">
                                <center><?php echo $barcode;  ?></center>
                            </div>
                    <?php
                            $i++;  
                        }
                        
                     ?>
                </div>
            </div>
        </div>
    </div>
</section>