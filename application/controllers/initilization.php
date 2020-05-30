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
class Initilization extends CI_Controller
{

  //CONSTRUCTOR
  function __construct() 
  {
      parent::__construct();

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
       $this->load->model('Crud_model');
  }
 
   // Initilization
   public function index()
   {
    // DEFINES PAGE TITLE
    $data['title'] = 'Brand List';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Brand List :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'brand';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Brand ID',
     'Name',
     'Company',
     'Action'
    );

    // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
    
    $result = $this->Crud_model->fetch_record_brand('mp_brand', NULL);
    $data['brand_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

   //USED TO ADD BRAND INTO DATABASE
   //Initilization/add_brand
   function add_brand()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $company_id = html_escape($this->input->post('company_id'));
      $brand_name = html_escape($this->input->post('brand_name'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'company_id' => $company_id,
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization');
   } 

   //USED TO EDIT BRAND
   //Initilization/edit_brand
   function edit_brand()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
        $edit_brand_id = html_escape($this->input->post('edit_brand_id'));
        $edit_brand_name = html_escape($this->input->post('brand_name'));

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
          'table_name'=>'mp_brand',
          'id' => $edit_brand_id
        );

        $data = array(
          'name'=>$edit_brand_name
        );

        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Crud_model->edit_record_id($args, $data);
        if ($result == 1)
        {
          $array_msg = array(
            'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
            'alert' => 'info'
          );
          $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
          $array_msg = array(
            'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
            'alert' => 'danger'
          );
          $this->session->set_flashdata('status', $array_msg);
        }

        redirect('initilization');
   }

   //USED TO LIST THE BRAND SECTOR
   // Initilization/brand_sector
   public function brand_sector()
   {

    // DEFINES PAGE TITLE
    $data['title'] = 'Brand Sector';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Brand Sector :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'brand_sector';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Name',
     'Created At',
     'Updated At',
     'Action'
    );

    $result = $this->Crud_model->fetch_record('mp_brand_sector', NULL);
    $data['brand_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

   //USED TO ADD BRAND SECTOR INTO DATABASE
   //Initilization/add_brand_sector
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/brand_sector');
   }

   //USED TO EDIT BRAND SECTOR 
   //Initilization/edit_brand_sector
   function edit_brand_sector()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $edit_brand_sector_id = html_escape($this->input->post('edit_brand_sector_id'));
      $edit_brand_sector = html_escape($this->input->post('brand_sector_name'));


      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'table_name'=>'mp_brand_sector',
        'id' => $edit_brand_sector_id
      );

      $data = array(
        'sector'=>$edit_brand_sector,
        'updated'=>date('Y-m-d')
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/brand_sector');
   }


   // Initilization/region
   public function region()
   {

    // DEFINES PAGE TITLE
    $data['title'] = 'Region List';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Region List :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'region';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Name',
     'Region Code',
     'Action'
    );

    $result = $this->Crud_model->fetch_record('mp_region', NULL);
    $data['region_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

   
   //USED TO ADD REGION 
   // Initilization/add_region

   function add_region()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $region = html_escape($this->input->post('region'));
      $code = html_escape($this->input->post('code'));


      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $region,
        'code' => $code
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_region', $args);
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/region');
   }

   //USED TO UPDATE REGION 
   //Initilization/edit_region
   function edit_region()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $edit_region_id = html_escape($this->input->post('edit_region_id'));
      $region = html_escape($this->input->post('region'));
      $code = html_escape($this->input->post('code'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'table_name'=>'mp_region',
        'id' => $edit_region_id
      );

      $data = array(
        'name'=>$region,
        'code'=>$code
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/region');
   }

   //USED TO LIST TOWN
   // Initilization/town
   public function town()
   {

    // DEFINES PAGE TITLE
    $data['title'] = 'Town List';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Town list :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'town';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Town Name',
     'Region',
     'Action'
    );

    $result = $this->Crud_model->fetch_record('mp_town', NULL);
    $data['town_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

  //USED TO ADD TOWN
  //Initilization/add_town
   function add_town()
   {
       // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $town_name = html_escape($this->input->post('town_name'));
      $region = html_escape($this->input->post('region'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $town_name,
        'region' => $region
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_town', $args);
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/town');
   } 

   //USED TO EDIT TOWN 
   //Initilization/edit_town
   function edit_town()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $edit_town_id = html_escape($this->input->post('edit_town_id'));
      $town = html_escape($this->input->post('town_name'));
      $region = html_escape($this->input->post('region'));
      $status = html_escape($this->input->post('status'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'table_name'=>'mp_town',
        'id' => $edit_town_id
      );

      $data = array(
        'name'=>$town,
        'region'=>$region,
        'status'=>$status
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/town');
   }
   //USED TO LIST UNITS
   // Initilization/units
   public function units()
   {

    // DEFINES PAGE TITLE
    $data['title'] = 'Unit list';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Unit list :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'units';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Name',
     'Symbol',
     'Action'
    );

    $result = $this->Crud_model->fetch_record('mp_units', NULL);
    $data['unit_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

   //USED TO ADD UNIT 
   //Initilization/add_unit
   function add_unit()
   {
       // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $unit_name = html_escape($this->input->post('unit_name'));
      $symbol = html_escape($this->input->post('symbol'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $unit_name,
        'symbol' => $symbol
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_units', $args);
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/units');
   }

   //USED TO UPDATE UNIT 
   //Initilization/edit_unit
   function edit_unit()
   {
      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $edit_unit_id = html_escape($this->input->post('edit_unit_id'));
      $edit_unit = html_escape($this->input->post('unit_name'));
      $edit_symbol = html_escape($this->input->post('symbol'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'table_name'=>'mp_units',
        'id' => $edit_unit_id
      );

      $data = array(
        'name'=>$edit_unit,
        'symbol'=>$edit_symbol
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/units');
   }

   //USED TO LIST STORES
   // Initilization/stores
   public function stores()
   {

    // DEFINES PAGE TITLE
    $data['title'] = 'Store list';

    // DEFINES NAME OF TABLE HEADING
    $data['table_name'] = 'Store list :';

    // DEFINES WHICH PAGE TO RENDER
    $data['main_view'] = 'store';

    // DEFINES THE TABLE HEAD
    $data['table_heading_names_of_coloums'] = array(
     'Name',
     'Code',
     'Address',
     'Action'
    );

    $result = $this->Crud_model->fetch_record('mp_stores', NULL);
    $data['store_list'] = $result;

    // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
    $this->load->view('main/index.php', $data);
   }

   //USED TO ADD STORE 
   //Initilization/add_store
   function add_store()
   {

       // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $name = html_escape($this->input->post('name'));
      $code = html_escape($this->input->post('code'));
      $address = html_escape($this->input->post('address'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'name' => $name,
        'code' => $code,
        'address' => $address
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_stores', $args);
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
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/stores');
   }
  //USED TO EDIT STORE 
   //Initilization/edit_store
   function edit_store()
   {
       // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $edit_store_id = html_escape($this->input->post('edit_store_id'));
      $store_name = html_escape($this->input->post('store_name'));
      $code = html_escape($this->input->post('code'));
      $address = html_escape($this->input->post('address'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'table_name'=>'mp_stores',
        'id' => $edit_store_id
      );

      $data = array(
        'name'=>$store_name,
        'code'=>$code,
        'address'=>$address
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
          'alert' => 'info'
        );
        $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
        $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Updated',
          'alert' => 'danger'
        );
        $this->session->set_flashdata('status', $array_msg);
      }

      redirect('initilization/stores');
   }


   //USED TO DELETE THE ID FROM TABLE
   // initilization/delete
   function delete($table, $args)
   {

    $redirect = '';
    if($table == 'brand')
    {
        $redirect = 'initilization';
    }
    else if($table == 'brand_sector')
    {
         $redirect = 'initilization/brand_sector';
    }
    else if($table == 'region')
    {
         $redirect = 'initilization/region';
    }  
    else if($table == 'town')
    {
         $redirect = 'initilization/town';
    }  
    else if($table == 'units')
    {
         $redirect = 'initilization/units';
    }
    else if($table == 'stores')
    {
         $redirect = 'initilization/stores';
    }

    $table = 'mp_'.$table;
    
    // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
    $result = $this->Crud_model->delete_record($table, $args);
    if ($result == 1)
    {
     $array_msg = array(
      'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Record removed',
      'alert' => 'info'
     );

     $this->session->set_flashdata('status', $array_msg);
    }
    else
    {
     $array_msg = array(
      'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry exists in another record.',
      'alert' => 'danger'
     );
     $this->session->set_flashdata('status', $array_msg);
    }
      redirect($redirect);
   }


   //Initilization/popup
   //DEFINES A POPUP MODEL OG GIVEN PARAMETER
   function popup($page_name = '',$param = '')
   {
    $this->load->model('Crud_model');

  
    if($page_name  == 'edit_brand_model')
    {
      $data['company_list']  = $this->Crud_model->fetch_attr_record_by_id('mp_payee','type','company');

      $data['single_brand'] = $this->Crud_model->fetch_record_by_id('mp_brand',$param);
      //model name available in admin models folder
      $this->load->view( 'admin_models/edit_models/edit_brand_model.php',$data);
    } 
    else if($page_name  == 'add_brand_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_brand';

     $data['company_list']  = $this->Crud_model->fetch_attr_record_by_id('mp_payee','type','company');

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_model.php',$data);
    }   
    else if($page_name  == 'add_brand_sector')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_brand_sector';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_brand_sector.php',$data);
    }  
    else if($page_name  == 'edit_brand_sector')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/edit_brand_sector';

      $data['single_brand_sector'] = $this->Crud_model->fetch_record_by_id('mp_brand_sector',$param);

     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_brand_sector.php',$data);
    } 
    else if($page_name  == 'add_region_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_region';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_region_model.php',$data);
    } 
    else if($page_name  == 'edit_region_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/edit_region';

      $data['region'] = $this->Crud_model->fetch_record_by_id('mp_region',$param);

      //model name available in admin models folder
      $this->load->view( 'admin_models/edit_models/edit_region_model.php',$data);
    }  
    else if($page_name  == 'add_town_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_town';

      $data['region'] = $this->Crud_model->fetch_record('mp_region',NULL);

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_town_model.php',$data);
    } 
    else if($page_name  == 'edit_town_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/edit_town';

      $data['region'] = $this->Crud_model->fetch_record('mp_region',NULL);

      $data['town'] = $this->Crud_model->fetch_record_by_id('mp_town',$param);

      //model name available in admin models folder
      $this->load->view( 'admin_models/edit_models/edit_town_model.php',$data);
    }  
    else if($page_name  == 'add_unit_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_unit';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_unit_model.php',$data);
    }
    else if($page_name  == 'edit_unit_model')
    {
      //USED TO REDIRECT LINK
      $data['link'] = 'initilization/edit_unit';

      $data['single_unit'] = $this->Crud_model->fetch_record_by_id('mp_units',$param);

      //model name available in admin models folder
      $this->load->view( 'admin_models/edit_models/edit_unit_model.php',$data);
    }
    else if($page_name  == 'add_stores_model')
    {
     //USED TO REDIRECT LINK
     $data['link'] = 'initilization/add_store';

     //model name available in admin models folder
     $this->load->view( 'admin_models/add_models/add_stores_model.php',$data);
    }
    else if($page_name  == 'edit_stores_model')
    {

     //USED TO REDIRECT LINK
      $data['link'] = 'initilization/edit_store';

      $data['single_store'] = $this->Crud_model->fetch_record_by_id('mp_stores',$param);

     //model name available in admin models folder
     $this->load->view( 'admin_models/edit_models/edit_stores_model.php',$data);
    }
    else if($page_name  == 'add_csv_model')
    {
      if($param == 'brand')
      {
          $data['path'] = 'initilization/upload_csv_brand';
      }
      else if($param == 'brand_sector')
      {
          $data['path'] = 'initilization/upload_csv_brand_sector';
      }      
      else if($param == 'region')
      {
          $data['path'] = 'initilization/upload_csv_region';
      }      
      else if($param == 'town')
      {
          $data['path'] = 'initilization/upload_csv_town';
      }
    
      //model name available in admin models folder
      $this->load->view('admin_models/add_models/add_csv_model.php',$data);
    } 
    
  }

    //Initilization/export
   //USED FOR EXPORTING DATA INTO CSV FORMAT
   public function export($param)
   {
      $table_name = '';
      $filename = '';
      $redirect = '';

      if($param == 'brand')
      {

         $table_name = 'mp_brand';
         $filename = 'brandlist';
         $redirect = 'initilization';

        $args_fileheader  = array(
           'Name', 
          );

        $args_table_header  = array(
           'name'   
        );

      }
      else if($param == 'brand_sector')
      {

         $table_name = 'mp_brand_sector';
         $filename = 'brand_sector';
         $redirect = 'initilization/brand_sector';

        $args_fileheader  = array(
           'Sector', 
           'Created', 
           'Updated'
          );

        $args_table_header  = array(
           'sector' , 
           'created',   
           'updated'   
        );

      }      
      else if($param == 'region')
      {

        $table_name = 'mp_region';
        $filename = 'region';
        $redirect = 'initilization/region';

        $args_fileheader  = array(
             'Name', 
             'Code'
        );

        $args_table_header  = array(
             'name' , 
             'code'   
        );

      }      

      else if($param == 'town')
      {

        $table_name = 'mp_town';
        $filename = 'town';
        $redirect = 'initilization/town';

        $args_fileheader  = array(
             'Name', 
             'Region'
        );

        $args_table_header  = array(
             'name' , 
             'region'   
        );

      }

      //DEFINED IN HELPER FOLDER
      export_csv($filename,$args_fileheader,$args_table_header,$table_name);

      redirect($redirect);
    }

//USE FOR UPLOADING CSV FILE
 //Initialization/upload_csv_brand
 function upload_csv_brand()
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
             $data  = array(
               'name' => $importdata[0] 
             );
            $insert_result =  $this->Crud_model->insert_data('mp_brand',$data );
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

       redirect('initilization');

   }

 //USE FOR UPLOADING CSV FILE
 //Initialization/upload_csv_brand_sector
 function upload_csv_brand_sector()
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
             $data  = array(
               'sector' => $importdata[0], 
               'created' => $importdata[1], 
               'updated' => $importdata[2] 
             );
            $insert_result =  $this->Crud_model->insert_data('mp_brand_sector',$data );
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

       redirect('initilization/brand_sector');

   }

    //USE FOR UPLOADING CSV FILE
 //Initialization/upload_csv_brand_sector
 function upload_csv_region()
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
             $data  = array(
               'name' => $importdata[0], 
               'code' => $importdata[1]
             );
            $insert_result =  $this->Crud_model->insert_data('mp_region',$data );
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

       redirect('initilization/region');

   }

 //USE FOR UPLOADING CSV FILE
 //Initialization/upload_csv_brand_sector
 function upload_csv_town()
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
             $data  = array(
               'name' => $importdata[0], 
               'region' => $importdata[1] 
             );
            $insert_result =  $this->Crud_model->insert_data('mp_town',$data );
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

       redirect('initilization/town');

   }

}