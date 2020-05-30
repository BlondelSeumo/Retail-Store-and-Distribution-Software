<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <div class="pull pull-left">
                 <ol class="breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Services</li>
                </ol>
            </div>
        </div> 
        <div class="col-md-6">
            <div class="pull pull-right">
                <button type="button" onclick="show_modal_page('<?php echo base_url();?>services/popup/add_product_model')" class="btn btn-info btn-flat " ><i class="fa fa-plus-square" aria-hidden="true"></i>
                    Add Services
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default  btn-flat   pull-right "><i class="fa fa-print pull-left"></i> Print / Pdf </button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                        <?php echo $table_name; ?>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                        foreach ($table_heading_names_of_coloums as $table_head)
                                        {
                                    ?>
                                        <th>
                                            <?php echo $table_head; ?>
                                        </th>
                                        <?php
                                            }
                                        ?>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                $currency =  $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['currency'];

                                if($productlist != NULL)
                                {
                                    foreach ($productlist as $single_product)
                                    {
                            ?>
                                <tr>
                                    <td>
                                        <?php echo '<b>'.'Service'.'</b> '.$single_product->product_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $currency.' '.$single_product->price; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_product->sale_tax.' %'; ?>
                                    </td>
                                    <td>
                                        <?php echo $single_product->name; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($single_product->type == 0)
                                            {
                                                echo "Service";
                                            } 
                                            else
                                            {
                                                echo "Finished Product";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group pull no-print pull-right">
                                            <button type="button" class="drop-menu-table btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li onclick="show_modal_page('<?php echo base_url().'services/popup/edit_product_model/'.$single_product->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
                                                <li>
                                                    <a  onclick="confirmation_alert(' delete this ','<?php echo base_url().'services/delete/'.$single_product->id; ?>')"  href="javascript:void(0)" ><i class="fa fa-trash-o"></i> Delete
                                                    </a>
                                                </li>   
                                                </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr >
                                    <td  > 
                                       <small> Description :  <?php echo $single_product->description; ?>
                                       </small>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                else
                                {
                                    echo '<p><i class="fa fa-question-circle"> '.'No record found'.'</i></p>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 