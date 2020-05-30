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
class Accounts extends CI_Controller
{
     // Accounts
     public function index()
     {

      // DEFINES PAGE TITLE
      $data['title'] = 'Chart of accounts';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Chart of accounts :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'chart_of_accounts';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Name',
       'Nature',
       'Type',
       'Expense type',
       ''
      );

      // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_head', NULL);
      $data['chart_list'] = $result;

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }

     //USED TO ADD CHART OF ACCOUNT
     //Accounts/chart_of_account
     public function chart_of_account()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // DEFINES READ MEDICINE details FORM MEDICINE FORM
      $name = html_escape($this->input->post('name'));
      $nature = html_escape($this->input->post('nature'));
      $type = html_escape($this->input->post('type'));
       $expense_type = html_escape($this->input->post('expense_type'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
       'name' => $name,
       'nature' => $nature,
       'type' => $type,
       'expense_type' => ($nature == 'Expense' ? $expense_type : '-')
      );

      // CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
      $result = $this->Crud_model->check_email_address('mp_head', 'name', $name);
      if ($result == NULL)
      {
          // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
          $result = $this->Crud_model->insert_data('mp_head', $args);
         
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
           'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot be added',
           'alert' => 'danger'
          );
          $this->session->set_flashdata('status', $array_msg);
         }
       }
      else
      {
         $array_msg = array(
          'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sorry already exists !',
          'alert' => 'danger'
         );
         $this->session->set_flashdata('status', $array_msg);
      }
      redirect('accounts');
     }

     // Accounts/delete
     function delete($args)
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
      $result = $this->Crud_model->delete_record('mp_head', $args);
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
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Record cannot be changed',
        'alert' => 'danger'
       );
       $this->session->set_flashdata('status', $array_msg);
      }

      redirect('accounts');

     }

     // Accounts/Edit
     function edit_charts()
     {

      // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
      $this->load->model('Crud_model');

      // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
      $head_id = html_escape($this->input->post('head_id'));
      $name = html_escape($this->input->post('name'));
      $edit_nature = html_escape($this->input->post('edit_nature'));
      $edit_type = html_escape($this->input->post('edit_type'));
      $expense_type = html_escape($this->input->post('expense_type'));

      // TABLENAME AND ID FOR DATABASE ACTION
      $args = array(
       'table_name' => 'mp_head',
       'id' => $head_id
      );

      
       // DEFINES IF  IMAGES IS SELECTED SO UPDATE PRIVIOUS PICTURE
       $data = array(
        'name' => $name,
        'nature' => $edit_nature,
        'type' => $edit_type,
         'expense_type' => ($edit_nature == 'Expense' ? $expense_type : '-')
       );

      // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
      $result = $this->Crud_model->edit_record_id($args, $data);
      if ($result == 1)
      {
       $array_msg = array(
        'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Head editted',
        'alert' => 'info'
       );
       $this->session->set_flashdata('status', $array_msg);
      }
      else
      {
       $array_msg = array(
        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Head cannot be editted',
        'alert' => 'danger'
       );
       $this->session->set_flashdata('status', $array_msg);
      }
      redirect('accounts');
     }

     //Accounts/popup
     //DEFINES A POPUP MODEL OG GIVEN PARAMETER
     function popup($page_name = '',$param = '')
     {
      $this->load->model('Crud_model');

      if($page_name  == 'edit_customer_model')
      {
       $data['single_customer'] = $this->Crud_model->fetch_record_by_id('mp_customer',$param);
       //model name available in admin models folder
       $this->load->view( 'admin_models/edit_models/edit_customer_model.php',$data);
      } 
      else if($page_name  == 'add_chart_of_accounts')
      {
       //USED TO REDIRECT LINK
       $data['link'] = 'Accounts/chart_of_account';

       //model name available in admin models folder
       $this->load->view( 'admin_models/add_models/add_chart_of_account_model.php',$data);
      }
      else if($page_name  == 'edit_chart_of_accounts')
      {
       
        $data['head_data'] = $this->Crud_model->fetch_record_by_id('mp_head',$param );
        $this->load->view( 'admin_models/edit_models/edit_chart_of_accounts',$data);
      }  
      else if($page_name  == 'edit_customer_payment_model')
      {
       
       $data['customer_list'] = $this->Crud_model->fetch_record('mp_customer', NULL);

       $data['customer_payments'] = $this->Crud_model->fetch_record_by_id('mp_customer_payments',$param );
       
       $this->load->view( 'admin_models/edit_models/edit_customer_payment_model.php',$data);
      }
      
     }

     // Customer/change_status/id/status
     function change_status($id, $status)
     {

      // TABLENAME AND ID FOR DATABASE ACTION
      $args = array(
       'table_name' => 'mp_customer',
       'id' => $id
      );

      // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
      $data = array(
       'cus_status' => $status
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

      redirect('Accounts');
     }


     //USED TO CALCULATE THE CUSTOMER LADGER 
     function ledger()
     {
     
      // DEFINES PAGE TITLE
      $data['title'] = 'Customer ledger';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Customer Ledger :';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_ledger';

      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_customer','status');
      $data['customer_list'] = $result;

      $data['ledger'] = '';

      $data['return_data'] = '';

      $data['recieved_payments'] = '';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Date',
       'Discount(%)',
       'Total Bill',
       'Bill Piad',
       'Balance',
       'Invoice No'
      );

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
      
     }

     //USED TO CREATE LEDGER
     function create_ledger()
     {
      // RETRIEVING  VALUES FROM FORM CUSTOMER LEDGER FORM
       $customer_id = html_escape($this->input->post('customer_id'));
      $ledger_data = '';
      $this->load->model('Accounts_model');
      $this->load->model('Crud_model');

      $ledger_data = $this->Accounts_model->fetch_customer_ledger($customer_id);

      $data['ledger'] = $ledger_data;

      // DEFINES PAGE TITLE
      $data['title'] = 'Customer ledger';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Customer Ledger :';
      if($ledger_data != NULL)
      {
       $data['heading'] = $ledger_data[0]->customer_name.' Ledger';

       $data['email_phone'] = $ledger_data[0]->cus_email.' | '.$ledger_data[0]->cus_contact_1;
      }

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_ledger';
      
      $result = $this->Crud_model->fetch_record('mp_customer','status');

      $data['customer_list'] = $result;
      
      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Date',
       'Discount(%)',
       'Total Bill',
       'Bill Piad',
       'Balance',
       'Invoice No'
      );  

      // DEFINES THE TABLE HEAD FOR RETURN ITEMS
      $data['table_heading_names_of_coloums_retun'] = array(
       'Date',
       'Item name',
       'Total Bill',
       'Bill Piad',
       'Balance',
       'Invoice No'
      );  

      // DEFINES THE TABLE HEAD FOR PAID ITEMS BY Accounts
      $data['table_heading_names_of_coloums_recieved'] = array(
       'Date',
       'Method',
       'Recieved by',
       'Recieved Cash',
       'Description'
      );

      $data['return_data'] = $this->Crud_model->fetch_attr_record_by_id('mp_return_item','cus_id',$customer_id );

      $data['recieved_payments'] = $this->Crud_model->fetch_attr_record_by_id('mp_customer_payments','customer_id',$customer_id );

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }

     //USED TO LIST THE CUSTOMER PAYMENT 
     //Customer/payment_list 
     function payment_list()
     {
      // DEFINES PAGE TITLE
      $data['title'] = 'Customer payment';

      // DEFINES NAME OF TABLE HEADING
      $data['table_name'] = 'Customer payment:';

      // DEFINES WHICH PAGE TO RENDER
      $data['main_view'] = 'customer_payment_list';

      // DEFINES THE TABLE HEAD
      $data['table_heading_names_of_coloums'] = array(
       'Trans Id',
       'Csutomer Name',
       'Amount',
       'Method',
       'Date',
       'Description',
       'Action'
      );
      
      // DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
      $this->load->model('Crud_model');
      $result = $this->Crud_model->fetch_record('mp_customer_payments', NULL);
      $data['customer_payment'] = $result;

      // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
      $this->load->view('main/index.php', $data);
     }
}