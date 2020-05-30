<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
{
  //CONSTRUCTOR
  function __construct() 
  {
      parent::__construct();

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
       $this->load->model('Crud_model');
  }

 // Product
 public function index()
 {

  // DEFINES PAGE TITLE
  $data['title'] = 'Product List';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Product List :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_add_button_name'] = 'Add New Product';

  // DEFINES THE TITLE NAME OF THE POPUP
  $data['page_title_model'] = 'Add New Product';

  // DEFINES THE TITLE NAME OF THE POPUP ADD STOCK
  $data['page_stock_button_name'] = 'Add New Stock';

  // DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
  $data['page_title_model_button_save'] = 'Save Product';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'product';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'No',
   'Name',
   'Weight',
   'Category',
   'Brand',
   'Sold',
   'Stock',
   'Cost',
   'Retail',
   'Worth',
   'Cost Pack',
   'Whole sale',
   'Pft Mrgn(Pack)',
   'Tax(%)',
   'Status',
   'Action'
  );

  // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
  $this->load->model('Crud_model');
  $product_record = $this->Crud_model->fetch_record_product('all');
  $data['product_record_list'] = $product_record;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USED TO ADD productS 
 //product/add_new_product
 function add_new_product()
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Product List';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Product List :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'add_product';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['catagory']  = $this->Crud_model->fetch_record('mp_category', 'status');
   
    $data['brand']  = $this->Crud_model->fetch_record('mp_brand',NULL);

    $data['brandsector']  = $this->Crud_model->fetch_record('mp_brand_sector',NULL);

    $data['units']  = $this->Crud_model->fetch_record('mp_units',NULL);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO SHOW DETAILS OF SINGLE PRODUCT 
 //product/product_details 
 function product_details($item_id)
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Product List';
    
    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'product_detail';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['product']  = $this->Crud_model->fetch_record_by_id('mp_productslist',$item_id);

    $data['catagory']  = $this->Crud_model->fetch_record('mp_category', 'status');
   
    $data['brand']  = $this->Crud_model->fetch_record('mp_brand',NULL);

    $data['brandsector']  = $this->Crud_model->fetch_record('mp_brand_sector',NULL);

    $data['units']  = $this->Crud_model->fetch_record('mp_units',NULL);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }

 //USED TO SHOW DETAILS OF STOCK 
 //product/product_details 
 function product_stock()
 {
    // DEFINES PAGE TITLE
    $data['title'] = 'Stock List';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'No',
     'Name',
     'SKU',
     'Weight',
     'Sold',
     'Return',
     'Stock',
     'Purchase',
     'Retail',
     'Worth',
     'W-sale',
     'Pack-cost',
     'Profit margin(Pack)',
     'Tax(%)',
     'Location'
    );
   
    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'product_stock_list';

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    $data['product']  = $this->Crud_model->fetch_record_product(0);

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
 }


 // product/add_stock_item
 public function add_stock_item()
 {

  // DEFINES READ Return_items details FORM Return_items FORM
  $item_id        = html_escape($this->input->post('item_id'));
  $cost           = html_escape($this->input->post('cost'));
  $retail         = html_escape($this->input->post('retail'));
  $pack_retail    = html_escape($this->input->post('pack_retail'));
  $pack_cost      = html_escape($this->input->post('pack_cost'));
  $manufacturing  = html_escape($this->input->post('manufacturing'));
  $expiry         = html_escape($this->input->post('expiry'));
  $edit_quantity  = html_escape($this->input->post('quantity'));
  $note           = html_escape($this->input->post('note'));
  $date           = date('Y-m-d');
  $user_name      = $this->session->userdata('user_id');
  $added_by       = $user_name['name'];

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
   
  // TABLENAME AND ID FOR DATABASE ACTION
  $data = array(
   'mid'          => $item_id,
   'purchase'     => $cost,
   'selling'      => $retail,
   'pack_retail_price'    => $pack_retail,
   'pack_purchase_price'    => $pack_cost,
   'manufacturing' => $manufacturing,
   'expiry'  => $expiry,
   'qty'    => $edit_quantity,
   'description' => $note,
   'date'   => $date, 
   'added'   => $added_by 
  );

  if($item_id != NULL)
  {
     // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
     $result_edit = $this->Crud_model->insert_data('mp_stock',$data);
  }

  
  if ($result_edit == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Stock added successfully',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Sorry item cannot be added',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 //product/pending_stock
 //USED TO GET THE LIST OF PENDING STOCK
 function pending_stock()
 {

  // DEFINES PAGE TITLE
  $data['title'] = 'Pending stock';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Pending Stock List :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_stock_button_name'] = 'Add New Stock';

  // DEFINES WHICH PAGE TO RENDER
$data['main_view'] = 'stock_list';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'No',
   'Product Name',
   'Weight',
   'Manufacturing',
   'Expiry',
   'Packs ',
   'Cost',
   'Retail',
   'P.Retail',
   'P.Cost',
   'Added date',
   'User',
   'Action'
  );

  //  FETCH ALL PENDING STOCK
  $this->load->model('Crud_model');
  $result = $this->Crud_model->fetch_stock_list();
  $data['stock_list'] = $result;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }

 //USE FOR UPLOADING CSV FILE
 //product/upload_csv
 function upload_csv()
 {
   $this->load->model('Crud_model');

   $user_name = $this->session->userdata('user_id');
   $added_by = $user_name['name'];

   //FETCHING THE CSV FILE TO UPLOAD RECORD INTO DATABASE TABLE
   $filename = $_FILES['upload_file']['tmp_name'];

  if($_FILES["upload_file"]["size"] > 0)
  {
   $file = fopen($filename, "r");
   while (($importdata = fgetcsv($file)))
   {

    $data = array(

      'category_id' => $importdata[0],  
       'product_name' => $importdata[1], 
       'mg' => $importdata[2],   
       'quantity' => $importdata[3],  
       'purchase' => $importdata[4],  
       'retail' => $importdata[5],
       'expire' => $importdata[6],  
       'manufacturing' => $importdata[7],  
       'sideeffects' => $importdata[8],  
       'description' => $importdata[9],
       'barcode' => $importdata[10], 
       'min_stock' => $importdata[11], 
       'packsize' => $importdata[12],   
       'sku' => $importdata[13],  
       'location' => $importdata[14],   
       'tax' => $importdata[15],   
       'type' => $importdata[16],   
       'brand_id' => $importdata[17],   
       'brand_sector_id' => $importdata[18],   
       'unit_type' => $importdata[19],   
       'net_weight' => $importdata[20],   
       'whole_sale' => $importdata[21]  

    );


   $insert_result =  $this->Crud_model->insert_data('mp_productslist',$data);

    }
    fclose($file);

    if ($insert_result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> '.'uploaded_successfully',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'error_in_uploading',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
   }
   else
   {
    $array_msg = array(
         'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'empty_file',
         'alert' => 'danger'
        );   
    $this->session->set_flashdata('status', $array_msg);
   }

   redirect('product');
 }

 // product/export
 //USED FOR EXPORTING DATA INTO CSV FORMAT
 public function export()
 {
    $args_fileheader  = array(
       'Category id', 
       'Product name',
       'Mg',   
       'Quantity',   
       'Purchase',  
       'Retail',  
       'Expire',  
       'Manufacturing',
       'Side Effects',
       'Description', 
       'Barcode', 
       'Minimum Level', 
       'Packsize',   
       'Sku',   
       'Location',  
       'Tax(%)',   
       'Product Type',   
       'Brand Id',   
       'Brand Sector',   
       'Unit',   
       'Net Weight', 
       'Whole sale'   
      );

    $args_table_header  = array(
       'category_id',  
       'product_name',
       'mg',   
       'quantity',  
       'purchase',  
       'retail',
       'expire',  
       'manufacturing',  
       'sideeffects',  
       'description',
       'barcode', 
       'min_stock', 
       'total_units', 
       'packsize',   
       'sku',  
       'location',   
       'tax',   
       'type',   
       'brand_id',   
       'brand_sector_id',   
       'unit_type',   
       'net_weight',   
       'whole_sale'   
    );

    //DEFINED IN HELPER FOLDER
    export_csv('products_list',$args_fileheader,$args_table_header,'mp_productslist');

    redirect('product');

 }

 // product/add_catagory
  public function add_catagory()
  {
    // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
    $category_name = html_escape($this->input->post('category_name'));
    $category_description = html_escape($this->input->post('category_description'));
    $date = date('Y-m-d');
    $user_name = $this->session->userdata('user_id');
    $added_by = $user_name['name'];

    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
    $args = array(
      'category_name' => $category_name,
      'description' => $category_description,
      'register_date' => $date,
      'added_by' => $added_by
    );

    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_category', $args);
    if ($result == 1)
    {
      $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Category added Successfully',
        'alert' => 'info'
      );
      $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
      $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
        'alert' => 'danger'
      );
      $this->session->set_flashdata('status', $array_msg);
    }

    redirect('product/add_new_product');
  }

 //product/popup
 //DEFINES A POPUP MODEL OG GIVEN PARAMETER
 function popup($page_name = '',$param = '')
 {

    $this->load->model('Crud_model');

    if($page_name  == 'add_stock_model')
    {
     // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
     $product_record = $this->Crud_model->fetch_record_product(0);
     $data['product_record_list'] = $product_record;
     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_stock_model.php',$data);
    } 
    else if($page_name  == 'edit_stock_model')
    {

     // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
     $product_record = $this->Crud_model->fetch_record_product(0);
     $data['product_record_list'] = $product_record;

     $data['single_stock'] = $this->Crud_model->fetch_record_by_id('mp_stock',$param);

     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_stock_model.php',$data);
    }
    else if($page_name  == 'add_csv_model')
    {
     $data['path'] = 'product/upload_csv';
     //model name available in admin models folder
     $this->load->view('admin_models/add_models/add_csv_model.php',$data);
    }  
    else if($page_name  == 'add_barcode_model')
    {
     //model name available in admin models folder
     $this->load->view('admin_models/add_models/add_barcode_model.php');
    }  
    else if($page_name  == 'edit_barcode')
    {
     $data['single_product'] = $this->Crud_model->fetch_record_by_id('mp_barcode',$param);
     //model name available in admin models folder
     $this->load->view('admin_models/edit_models/edit_barcode_model.php',$data);
    } 
    else if($page_name  == 'add_brand_model')
    {
     //USED TO ADD DATA
     $data['link'] = 'product/add_brand'; 

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_model.php',$data);
    }   
    else if($page_name  == 'add_brand_sector')
    {

     //USED TO ADD DATA
     $data['link'] = 'product/add_brand_sector';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_sector.php',$data);
    }        
    else if($page_name  == 'add_unit_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/add_unit';

      //model name available in admin models folder
      $this->load->view( 'admin_models/add_models/add_unit_model.php',$data);
    }  
    else if($page_name  == 'add_category_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'product/add_catagory';
      
      //model name available in admin models folder
      $this->load->view( 'admin_models/add_models/add_category_model.php',$data);
    }
  
 }


 //product/add_product
 public function add_product()
 {

  // DEFINES READ product details FORM product FORM
  $category_id = html_escape($this->input->post('category_id'));
  $product_name = html_escape($this->input->post('product_name'));
  $product_mg = html_escape($this->input->post('product_mg'));
  
  $barcode = html_escape($this->input->post('barcode'));
  $min_stock = html_escape($this->input->post('min_stock'));
 // $company_name = html_escape($this->input->post('company_name'));
  //$supplier_id = html_escape($this->input->post('supplier_id'));
 
  $packsize = html_escape($this->input->post('packsize'));
  $sku = html_escape($this->input->post('sku'));
  $location = html_escape($this->input->post('location'));
  $tax = html_escape($this->input->post('tax'));
  
  $side_effects = html_escape($this->input->post('side_effects'));
  $description = html_escape($this->input->post('description'));

  $type = html_escape($this->input->post('type'));
  $brand_id = html_escape($this->input->post('brand_id'));
  $sector_id = html_escape($this->input->post('sector_id'));
  $unit_symbol = html_escape($this->input->post('unit_symbol'));
  $net_weight = html_escape($this->input->post('net_weight'));
 
  $product_picture = $this->Crud_model->do_upload_picture("product_picture", "./uploads/product/");
  // $picture = html_escape($this->input->post('picture'));
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
  $args = array(
   'category_id' => $category_id,
   'product_name' => $product_name,
   'mg' => $product_mg,
   //'quantity' => $stock_quantity,
   //'purchase' => $purchase,
   //'retail' => $retail,
   //'total_units' => $total_units,
   'packsize' => $packsize,
   'sku' => $sku,
   'location' => $location,
   'tax' => $tax,
   //'expire' => $expiry_date,
   //'manufacturing' => $manufacturing_date,
   'sideeffects' => $side_effects,
   'barcode' => $barcode,
   'min_stock' => $min_stock,
   'description' => $description,
   'type' => $type,
   'image' => $product_picture,
   'brand_id' => $brand_id,
   'brand_sector_id' => $sector_id,
   'unit_type' => $unit_symbol,
   'net_weight' => $net_weight
  // 'whole_sale' => $whole_sale
  );

  $check_barcode_exist = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$barcode);
  if($check_barcode_exist == NULL OR $barcode == NULL)
  {
    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_productslist', $args);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error product cannot be added',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
  }
  else
  {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Barcode already exists',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
  }
  redirect('product');
 }

function random_number() 
{
  $result = '';

  for($i = 0; $i < 10; $i++) 
  {
    $result .= mt_rand(0,9);
  }

  //LOADING MODEL CLASS
    $this->load->model('Crud_model');
    $brand_check =  $this->Crud_model->fetch_attr_record_by_id('mp_barcode','random_no',$result);
    if($brand_check == NULL)
    {

    }
    else
    {
       $this->random_number(); 
    }

  return $result;
}

 //product/add_barcode
 public function add_barcode()
 {

    $barcode_no = $this->random_number();
    // DEFINES READ product details FORM product FORM
    $product_name = html_escape($this->input->post('product_name'));
    $product_description = html_escape($this->input->post('product_description'));
  
  //USED TO CHECK BRAND ALREADY EXISITS OR NOT 
   
  // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
   $args = array(
    'barcode' => $product_name,
    'random_no' =>$barcode_no,
    'description' => $product_description
    );

    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
    $result = $this->Crud_model->insert_data('mp_barcode', $args);
    if ($result == 1)
    {
      $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
      'alert' => 'info'
    );
      $this->session->set_flashdata('status', $array_msg);
   }
   else
   {

    $array_msg = array(
     'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
     'alert' => 'danger'
    );

    $this->session->set_flashdata('status', $array_msg);
   }

    redirect('product/generate_barcode');

 }


 // product/delete
 public function delete($args)
 {

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_productslist', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Product record removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Product cannot be deleted, it may exists in sales',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product');
 } 

 //product/update_to_stock
 //USED TO UPDATE PENDING STOCK TO FINAL STOCK
 function update_to_stock($stock_id = '')
 {

   if($stock_id != '')
   {

   // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
   $this->load->model('Crud_model');

   // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
   $stock_pending = $this->Crud_model->fetch_record_by_id('mp_stock', $stock_id);
   $fetched_pend_qty = $stock_pending[0]->qty;
   $fetched_mid = $stock_pending[0]->mid;
   $fetched_manufacturing = $stock_pending[0]->manufacturing;
   $fetched_expiry = $stock_pending[0]->expiry;
   $fetched_unit_cost = $stock_pending[0]->purchase;
   $fetched_unit_retail = $stock_pending[0]->selling;
   $fetched_pack_retail = $stock_pending[0]->pack_retail_price;
   $fetched_pack_purchase = $stock_pending[0]->pack_purchase_price;

  

   // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
   $item_fetch = $this->Crud_model->fetch_record_by_id('mp_productslist', $fetched_mid);
   $fetched_qty = $item_fetch[0]->quantity;
   $new_qty = ($fetched_pend_qty*$item_fetch[0]->packsize) + $fetched_qty;

   // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
   $data_edit = array(
    'manufacturing' => $fetched_manufacturing,
    'expire'        => $fetched_expiry,
    'purchase'      => $fetched_unit_cost,
    'retail'        => $fetched_unit_retail,
    'whole_sale'    => $fetched_pack_retail,
    'quantity'      => $new_qty,
    'pack_cost'     => $fetched_pack_purchase
   );

   // TABLENAME AND ID FOR DATABASE ACTION
   $args_edit = array(
    'table_name' => 'mp_productslist',
    'id' => $fetched_mid
   );

   // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
   $result_edit = $this->Crud_model->edit_record_id($args_edit, $data_edit);
   if ($result_edit == 1)
   {
    $array_msg = array(
     'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Stock added',
     'alert' => 'info'
    );

    $this->session->set_flashdata('status', $array_msg);

     $this->Crud_model->delete_record('mp_stock',$stock_id);

   }
   else
   {
    $array_msg = array(
     'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Sorry stock cannot be added',
     'alert' => 'danger'
    );

    $this->session->set_flashdata('status', $array_msg);
   }
  }

  redirect('product/pending_stock');
 }


 // product/delete_stock
 public function delete_stock($args)
 {

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_stock', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> stock record removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error stock record cannot be changed',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 //product/edit
 public function edit()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM

  $edit_product_id = html_escape($this->input->post('edit_product_id'));
  $edit_category_id = html_escape($this->input->post('edit_category_id'));
  $edit_product_name = html_escape($this->input->post('edit_product_name'));
  $edit_mg = html_escape($this->input->post('edit_mg'));
 

  $edit_packsize = html_escape($this->input->post('edit_packsize'));
  $edit_sku = html_escape($this->input->post('edit_sku'));
  $edit_location = html_escape($this->input->post('edit_location'));
  $edit_tax = html_escape($this->input->post('edit_tax'));
  $edit_side_effects = html_escape($this->input->post('edit_side_effects'));
  $edit_description = html_escape($this->input->post('edit_description'));
  $edit_barcode = html_escape($this->input->post('edit_barcode'));
  $edit_min_stock = html_escape($this->input->post('edit_min_stock'));
  $edit_type = html_escape($this->input->post('edit_type'));
  $brand_id = html_escape($this->input->post('brand_id'));
  $sector_id = html_escape($this->input->post('sector_id'));
  $unit = html_escape($this->input->post('unit'));
  $net_weight = html_escape($this->input->post('net_weight'));
  $edit_picture = $this->Crud_model->do_upload_picture("product_picture", "./uploads/product/");   
  //$check_barcode_exist = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$edit_barcode);

  //print_r($check_barcode_exist);
  //if(count($check_barcode_exist)  <= 1 OR $check_barcode_exist == '')
  if(TRUE)
  {  

    // TABLENAME AND ID FOR DATABASE ACTION
    $args = array(
     'table_name' => 'mp_productslist',
     'id' => $edit_product_id
    );

    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
    if($edit_picture == "default.jpg")
    {
        $data = array(
       'category_id' => $edit_category_id,
       'product_name' => $edit_product_name,
       'mg' => $edit_mg,
       'packsize' => $edit_packsize,
       'sku' => $edit_sku,
       'location' => $edit_location,
       'tax' => $edit_tax,
       'sideeffects' => $edit_side_effects,
       'min_stock' => $edit_min_stock,
       'barcode' => $edit_barcode,
       'type' => $edit_type,
       'brand_id' => $brand_id,
       'brand_sector_id' => $sector_id,
       'unit_type' => $unit,
       'net_weight' => $net_weight,
       
      );
    }
    else
    {
      $data = array(
        'category_id' => $edit_category_id,
        'product_name' => $edit_product_name,
        'mg' => $edit_mg,
        'packsize' => $edit_packsize,
        'sku' => $edit_sku,
        'location' => $edit_location,
        'tax' => $edit_tax,
        'sideeffects' => $edit_side_effects,
        'min_stock' => $edit_min_stock,
        'barcode' => $edit_barcode,
        'type' => $edit_type,
        'brand_id' => $brand_id,
        'brand_sector_id' => $sector_id,
        'unit_type' => $unit,
        'net_weight' => $net_weight,
        'image' => $edit_picture        
       );

      // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
      $this->Crud_model->delete_image('./uploads/product/', $edit_product_id, 'mp_productslist');         
    }


    // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
    $result = $this->Crud_model->edit_record_id($args, $data);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> product editted',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Editted',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }  

  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error barcode does not exists',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product');
 }

 //product/edit_stock
 public function edit_stock()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM
  $edit_stock_id = html_escape($this->input->post('edit_stock_id'));
  $edit_product_id = html_escape($this->input->post('edit_product_id'));
  $edit_manufacturing = html_escape($this->input->post('edit_manufacturing'));
  $edit_expiry = html_escape($this->input->post('edit_expiry'));
  $edit_qty = html_escape($this->input->post('edit_qty'));
  $edit_description = html_escape($this->input->post('edit_description'));
  

  // TABLENAME AND ID FOR DATABASE ACTION

  $args = array(
   'table_name' => 'mp_stock',
   'id' => $edit_stock_id
  );

  // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
  $data = array(
   'mid' => $edit_product_id,
   'manufacturing' => $edit_manufacturing,
   'expiry' => $edit_expiry,
   'qty' => $edit_qty,
   'description' => $edit_description
  );

  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
  $result = $this->Crud_model->edit_record_id($args, $data);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Stock editted',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error stock cannot be editted',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/pending_stock');
 }

 // product/change_status/id/status
 public function change_status($id, $status)
 {

    // TABLENAME AND ID FOR DATABASE ACTION
    $args = array(
     'table_name' => 'mp_productslist',
     'id' => $id
    );

    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
    $data = array(
     'status' => $status
    );

    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
    $result = $this->Crud_model->edit_record_id($args, $data);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Status changed Successfully!',
      'alert' => 'info'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Status cannot be changed',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }

    redirect('product');
 }

 //USED TO DELETE BARCODE
 function delete_barcode($args)
 {
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');
  $result = $this->Crud_model->delete_record('mp_barcode', $args);
  if ($result == 1)
  {
   $array_msg = array(
    'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Brand removed',
    'alert' => 'info'
   );
   $this->session->set_flashdata('status', $array_msg);
  }
  else
  {
   $array_msg = array(
    'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be changed',
    'alert' => 'danger'
   );
   $this->session->set_flashdata('status', $array_msg);
  }

  redirect('product/generate_barcode');
 }

 //USED TO UPDATE BARCODE
 function edit_barcode()
 {

  // RETRIEVING UPDATED VALUES FROM FORM product FORM

  $edit_barcode_id = html_escape($this->input->post('edit_barcode_id'));
  $product_name = html_escape($this->input->post('product_name'));
  $product_description = html_escape($this->input->post('product_description'));
   
  // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
  $this->load->model('Crud_model');

  //USED TO CHECK BRAND ALREADY EXISITS OR NOT 
   $brand_check =  $this->Crud_model->fetch_attr_record_by_id('mp_barcode','barcode',$brand_name);
   
   // TABLENAME AND ID FOR DATABASE ACTION
   $args = array(
    'table_name' =>'mp_barcode',
    'id'    => $edit_barcode_id
   );

   // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
   $data = array(
    'barcode' => $product_name,
    'description' => $product_description
   );

   

   // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
   $result = $this->Crud_model->edit_record_id($args, $data);
   if ($result == 1)
   {
    $array_msg = array(
     'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Product editted',
     'alert' => 'info'
    );
    $this->session->set_flashdata('status', $array_msg);
   }
   else
   {
    $array_msg = array(
     'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be editted',
     'alert' => 'danger'
    );
    $this->session->set_flashdata('status', $array_msg);
   }


  redirect('product/generate_barcode');
 }


 //USED TO SAVE BARCODES
 function generate_barcode()
 {
  // DEFINES PAGE TITLE
  $data['title'] = 'Barcodes List';

  // DEFINES NAME OF TABLE HEADING
  $data['table_name'] = 'Barcode List :';

  // DEFINES BUTTON NAME ON THE TOP OF THE TABLE
  $data['page_add_button_name'] = 'Create Code';

  // DEFINES THE TITLE NAME OF THE POPUP
  $data['page_title_model'] = 'Add new barcode';

  // DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
  $data['page_title_model_button_save'] = 'Save barcode';

  // DEFINES WHICH PAGE TO RENDER
  $data['main_view'] = 'barcodelist';

  // DEFINES THE TABLE HEAD
  $data['table_heading_names_of_coloums'] = array(
   'Product name',
   'Barcode',
   'Description',
   'Action'
  );

  // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
  $this->load->model('Crud_model');
  $barcode_record = $this->Crud_model->fetch_record('mp_barcode',NULL);
  $data['barcode_record_list'] = $barcode_record;

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
  $this->load->view('main/index.php', $data);
 }
 

 //USED TO PRINT ON PAPER
 function print_barcode($barcode_id,$qty)
 { 
  $this->load->model('Crud_model');

    // FETCHING THE Item QTY THOUGH ITS ID FROM Item TABLE
    $brand_fetch = $this->Crud_model->fetch_record_by_id('mp_barcode', $barcode_id);
    $brand_serial = $brand_fetch[0]->random_no;


    //CALLING A BARCODE LIBRARY
    $this->load->library('barcode');
  
    $data['barcode'] = $this->barcode->generate_bar128(stripcslashes($brand_serial));

    $data['barcode_qty'] = $qty;

    $data['brand_name'] = $brand_fetch[0]->barcode;

    // DEFINES WHICH PAGE TO RENDER
   $data['main_view'] = 'barcodeprintlist';

  // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);

   }

  //USED TO LIST THE EXPIRED product 
  //product/expired_list 
   function expired_list()
   {
      // DEFINES PAGE TITLE
      $data['title'] = 'Expired List';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Expired List :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'expired_list';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Product Name',
       'Weight',
       'Manufac',
       'Expiry',
       'Qty',
       'Purchase',
       'Retail',
       'Worth',
       'Location',
       'Action'
      );

      // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
      $this->load->model('Crud_model');
      $data['expire_result'] = $this->Crud_model->fetch_expired_record();
      

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
   }

  //USED TO LIST THE EXPIRED product IN STOCK 
  //product/expired_list 
   function expired_stock()
   {
      // DEFINES PAGE TITLE
      $data['title'] = 'Expired stock';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Expired stock :';

      // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'expired_stock';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Brand',
       'Weight',
       'Manufac',
       'Expiry',
       'Qty',
       'Purchase',
       'Retail',
       'Worth',
       'Location',
       'Action'
      );

      // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
      $this->load->model('Crud_model');
      $data['expire_result'] = $this->Crud_model->fetch_record_product(2);
      

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
   }

   //USED TO ADD BRAND INTO DATABASE
   //Product/add_brand
   function add_brand()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $brand_name = html_escape($this->input->post('brand_name'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $brand_name
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_brand', $args);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('product/add_new_product');
   } 


    //USED TO ADD BRAND SECTOR INTO DATABASE
   //Product/add_brand_sector
   function add_brand_sector()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $brand_sector = html_escape($this->input->post('brand_sector_name'));
      $status = html_escape($this->input->post('status'));
      $created = date('Y-m-d');
      $updated = date('Y-m-d');

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'sector' => $brand_sector,
        'created' => $created,
        'updated' => $updated
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_brand_sector', $args);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('product/add_new_product');
   }

}