<?php
  if($this->session->userdata('user_id') == "") 
  {  
    redirect('login');
  }
  else
  {
    $user_id = $this->session->userdata('user_id');

    //TO AVOID USER TO ACCESS THE UNASSIGNED LINKS
    if(Authenticate_Url($user_id['id'],$this->uri->segment(1)) != NULL)
    {
    }
    else
    {
     // redirect('profile');
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
  <title><?php echo isset($title) ? $title : 'Shop | Dashboard' ; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/fontawesome/css/font-awesome.css">
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/css/import-font.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/flat/blue.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Datatable css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">  
    
    
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>assets/dist/css/stellarnav.css">
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-yellow sidebar-collapse">
<div class="wrapper">
  <?php $this->load->view('main/stylings.php'); ?>
  <?php
   if(uri_string() != 'invoice' AND uri_string() != 'return_items')
  {
  ?>
   <!-- Header  -->
   <?php $this->load->view('main/header'); ?>
  <!-- Header ends-->
  <?php
    }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- pages navigates here -->
       <?php $this->load->view($main_view); ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  if(uri_string() != 'invoice' AND uri_string() != 'return_items')
  {
  ?>
  <!-- Footer  -->
     <?php $this->load->view('main/footer'); ?>
  <!-- Footer Ends -->
  <?php
    }
  ?>
</div>
<!-- ./wrapper -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Bootstrap Gowl -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-growl/jquery.bootstrap-growl.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/jquery.validate.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/stellarnav.min.js"></script>

<!-- For All Plug-in Activation & Others -->
<script type="text/javascript">
  jQuery(document).ready(function($) {
			jQuery('.stellarnav').stellarNav({
				theme: 'light',
				breakpoint: 1440,
				position: 'left'
			});
		});
</script>

<!-- Page Script -->
<script>
   //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();
     

  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $("#example3").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

  $(function () 
  {
    //Initialize Select2 Elements
    $(".select2").select2();


  });

   function alertFunc(status,message){
      $.bootstrapGrowl(message, {
      ele: 'body', // which element to append to
      type: status, // (NULL, 'info', 'error', 'success')
      offset: {from: 'top', amount: 10}, // 'top', or 'bottom'
      align: 'right', // ('left', 'right', or 'center')
      width: 300, // (integer, or 'auto')
      delay: 3000,
      allow_dismiss: true,
      stackup_spacing: 10 // spacing between consecutively stacked growls.
    });
  };
  </script>

<?php
 if($this->session->flashdata('status') == "")
 {

 }
 else
 {

    $message = $this->session->flashdata('status');
    echo "<script>alertFunc('".$message['alert']."','".$message['msg']."')</script>";


 }
?>
</body>
</html>
<?php
  }
?>