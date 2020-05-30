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
class Purchase extends CI_Controller
{
	// Purchase
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase List';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Purchases List :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'purchase';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Trans ID ',
			'Bill No',
			'Date',
			'Supplier',
			'Total',
			'Cash Paid',
			'Balance',
			'Method',
			'Payment Date',
			'Status',
			'Action'
		);

		//FETCHING DATES FROM TEXT FIELDS 
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));	

		if($date1 == NULL AND $date2 == NULL)
		{
			//ASSIGNING DEFAULT DATES 
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_purchased(0,$date1,$date2);
		$data['purchase_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}	

	//USED TO LIST THE PURCHASE RETURN
	//Purchase/return_list
	public function return_list()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase Return';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Purchases Return List :';


		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'purchase_return';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Trans ID ',
			'Bill No',
			'Date',
			'Supplier',
			'Total',
			'Cash Recieved',
			'Receivable',
			'Method',
			'Payment Date',
			'Status',
			'Action'
		);

		//FETCHING DATES FROM TEXT FIELDS 
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));	

		if($date1 == NULL AND $date2 == NULL)
		{
			//ASSIGNING DEFAULT DATES 
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_purchased(1,$date1,$date2);
		$data['purchase_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO SHOW PURCHASE RETURN 
	function return_purchase()
	{
		
		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase return';

		$user_name = $this->session->userdata('user_id');

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier','status');
		
		$data['supplier_list'] = $result;

		$result = $this->Crud_model->fetch_record('mp_stores', NULL);
		$data['store_list'] = $result;

		//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		// LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('preturn',$user_name['id']);

		$data['temp_view'] = 'purchase_return_template';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'return_purchase';
		
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	//USED TO CREATE Purchase
	//Purchase/create_purchase
	function create_purchase()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Create Purchase';

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier','status');
		$data['supplier_list'] = $result;

		$result = $this->Crud_model->fetch_record('mp_stores', NULL);
		$data['store_list'] = $result;

		//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		$user_name = $this->session->userdata('user_id');

		// LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('purchase',$user_name['id']);

		$data['temp_view'] = 'purchase_item_template';
		
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'create_purchase';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

  //Purchase/add_selected_item
  //USED TO ADD ITEM INTO TEMP PURCHASE TABLE USING BARCODE
  function add_selected_item($id)
  {
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');
    $user_name = $this->session->userdata('user_id');

    if($id != '')
    {
      $result = $this->Crud_model->fetch_record_by_id('mp_productslist',$id);

      if($result != NULL)
      {

      $check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_purchase','product_id',$id,$user_name['id'],'purchase');

		if($check_item_in_temp != NULL)
		{
			$pack = $check_item_in_temp[0]->qty+1;

			$args = array(
				'table_name' => 'mp_temp_purchase',
				'id' => $check_item_in_temp[0]->id
			);

			$data = array(
				'qty' => $pack
			);

			$this->Crud_model->edit_record_id($args, $data);

		}
		else
		{
			//CALCULATING TAX USING EACH ITEMS
			$tax_amount = ($result[0]->tax/100)*$result[0]->retail;

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
			$args = array(
				'product_id' => $result[0]->id,
				'product_name' => $result[0]->product_name,
				'weight' => $result[0]->mg,
				'cost' => $result[0]->purchase,
				'retail' => $result[0]->retail,
				'pack_cost' => $result[0]->pack_cost,
				'pack_retail' => $result[0]->whole_sale,
				'qty' => 1,
				'agentid' => $user_name['id'],
				'source' => 'purchase'
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Crud_model->insert_data('mp_temp_purchase', $args);
		}

      
    	}

		// DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_purchase('purchase',$user_name['id']);


		$this->load->view('purchase_item_template.php',$data);
		
    }
  }

   //Purchase/add_selected_item_pr
  //USED TO ADD ITEM INTO TEMP PURCHASE RETURN TABLE USING BARCODE
  function add_selected_item_pr($id)
  {
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');
    $user_name = $this->session->userdata('user_id');

    if($id != '')
    {
      $result = $this->Crud_model->fetch_record_by_id('mp_productslist',$id);

      if($result != NULL)
      {

      	$check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_purchase','product_id',$id,$user_name['id'],'preturn');

		if(($result[0]->quantity-$result[0]->packsize) >= 0)
		{

			$stockargs   = array(
			'table_name' =>'mp_productslist', 
			'id' =>$result[0]->id, 
			);

			$stockdata = array(
				'quantity' => $result[0]->quantity-$result[0]->packsize
			);

			$this->Crud_model->edit_record_id($stockargs, $stockdata);
			
			
			if($check_item_in_temp != NULL)
			{
				$pack = $check_item_in_temp[0]->qty+1;

				$args = array(
					'table_name' => 'mp_temp_purchase',
					'id' => $check_item_in_temp[0]->id
				);

				$data = array(
					'qty' => $pack
				);

				$this->Crud_model->edit_record_id($args, $data);
				
			}
			else
			{
				
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
				$args = array(
					'product_id' => $result[0]->id,
					'product_name' => $result[0]->product_name,
					'weight' => $result[0]->mg,
					'cost' => $result[0]->purchase,
					'retail' => $result[0]->retail,
					'pack_cost' => $result[0]->pack_cost,
					'pack_retail' => $result[0]->whole_sale,
					'manu_date' => $result[0]->manufacturing,
					'expire_date' => $result[0]->expire,
					'qty' => 1,
					'agentid' => $user_name['id'],
					'source' => 'preturn'
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_temp_purchase', $args);
			}
		}
      
    	}

		 // DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		 $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_purchase('preturn',$user_name['id']);


		$this->load->view('purchase_return_template.php',$data);
		
    }
  }

	//USED TO UPDATE QUANTITY 
	//Purchase/update_qty
	function update_qty($attr,$requested_qty = '' , $id = '')
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		//$requested_qty = intval($requested_qty);
		
		$user_name = $this->session->userdata('user_id');

		if($attr != '')
		{
			$args = array(
				'table_name' => 'mp_temp_purchase',
				'id' => $id
			);

			$data = array(
				$attr => $requested_qty
			);

			$this->Crud_model->edit_record_id($args,$data);
		}

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('purchase',$user_name['id']);
		
		// DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		$this->load->view('purchase_item_template.php',$data);

	}

	//USED TO UPDATE QUANTITY 
	//Purchase/update_pr_qty
	function update_pr_qty($attr,$requested_qty = '' , $id = '')
	{
		
		$this->load->model('Crud_model');

		$this->load->model('Pos_transaction_model'); 
          
		$requested_qty = intval($requested_qty);
		
        $user_name = $this->session->userdata('user_id');

        if($requested_qty != '' AND $id != '' AND  $requested_qty > -1)
        {
			
			$temp_invoice = $this->Crud_model->fetch_record_by_id('mp_temp_purchase',$id);
			
            $product_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$temp_invoice[0]->product_id);

            $bal = 0;
            $new_qty = 0;

			//$qty = $requested_qty * $temp_invoice[0]->packsize;

            if($temp_invoice[0]->qty > $requested_qty)
            {

              $pack = $temp_invoice[0]->qty - $requested_qty;

              $temp_qty = $temp_invoice[0]->qty - $pack;

              $new_qty = $product_stock[0]->packsize * $pack;

              $new_qty = $product_stock[0]->quantity + $new_qty;

              $pack = $requested_qty;
            }
            else if($temp_invoice[0]->qty < $requested_qty)
            {
               $pack =  $requested_qty - $temp_invoice[0]->qty;

               $new_qty = $product_stock[0]->quantity - ($pack*$product_stock[0]->packsize);

               $pack = $pack + $temp_invoice[0]->qty;

               $temp_qty = $pack * $product_stock[0]->packsize;
            }

            if($temp_invoice[0]->qty != $requested_qty AND $new_qty >= 0)
            {
               $new_args = array(
                'table_name' => 'mp_productslist',
                'id' => $temp_invoice[0]->product_id
               );

              $new_data = array(
                'quantity' => $new_qty
              );

            
              $temp_args = array(
                  'table_name' => 'mp_temp_purchase',
                  'id' => $id
              );

              $temp_data = array(
                'qty' => $pack
              );
			  
              $this->Pos_transaction_model->general_whole_transaction($new_args,$new_data , $temp_args, $temp_data);
          }

      }

		// DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');
		 
		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE		
		$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('preturn', $user_name['id']);
		
		$this->load->view('purchase_return_template.php',$data);

	}
	
	//Purchase/clear_temp_invoice
  //USED TO CLEAR TEMP PURCHASE
  function clear_temp_invoice()
  {
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    //GET THE CURRENT USER
    $user_name = $this->session->userdata('user_id');


    $this->Crud_model->delete_record_by_userid('mp_temp_purchase','purchase',$user_name['id']);

      //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
      $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_purchase','purchase',$user_name['id']);

      $this->load->view('purchase_item_template.php',$data);
  } 

  //Purchase/delete_item_temporary_pr
  //USED TO DELETE AN ITEM FROM TEMPORARY TABLE OF BARCODE ITEMS
  function delete_item_temporary_pr($item_id)
  { 
    // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
    $this->load->model('Crud_model');

    //FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
    $result = $this->Crud_model->fetch_record_by_id('mp_temp_purchase',$item_id);   

    //FETCH THE ITEM FROM STOCK TABLE 
    $result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$result[0]->product_id);

    // TABLENAME AND ID FOR DATABASE ACTION
    $args = array(
      'table_name' => 'mp_productslist',
      'id' => $result[0]->product_id
    );

    $data = array(
      'quantity' => $result_stock[0]->quantity + ($result[0]->qty * $result_stock[0]->packsize)
    );

    // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
    $this->Crud_model->edit_record_id($args, $data);

    // DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
    $this->Crud_model->delete_record('mp_temp_purchase', $item_id);
    
    //USER ID
    $user_name = $this->session->userdata('user_id');

    // DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
    $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

	//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
	$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('preturn', $user_name['id']);
				
	$this->load->view('purchase_return_template.php', $data);
  }

	//Purchase/delete_item_temporary
	//USED TO DELETE AN ITEM FROM TEMPORARY TABLE OF BARCODE ITEMS
	function delete_item_temporary($item_id)
	{ 
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
		$this->Crud_model->delete_record('mp_temp_purchase', $item_id);

		//USER ID
		$user_name = $this->session->userdata('user_id');

		// DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_purchase('purchase',$user_name['id']);

		$this->load->view('purchase_item_template.php',$data);
	} 



	//USED TO ADD PURCHASE INTO DATAABASE
	//	Purchase/add_purchase
	public function add_purchase()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$this->load->model('Transaction_model');

		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$pur_supplier 	 = html_escape($this->input->post('pur_supplier'));
		$pur_store 		 = html_escape($this->input->post('pur_store'));
		$pur_invoice 	 = html_escape($this->input->post('pur_invoice'));
		$pur_total 		 = html_escape($this->input->post('pur_total'));
		$pur_method 	 = html_escape($this->input->post('pur_method'));
		$pur_date 		 = html_escape($this->input->post('pur_date'));
		$total_paid 	 = html_escape($this->input->post('pur_paid'));
		$offered_discount = html_escape($this->input->post('offered_discount'));
		$pur_description = html_escape($this->input->post('pur_description'));
		$bank_id 		 = html_escape($this->input->post('bank_id'));
		$ref_no 		 = html_escape($this->input->post('ref_no'));
		$save_available_balance = html_escape($this->input->post('save_available_balance'));
		$picture 		 = $this->Crud_model->do_upload_picture("pur_picture", "./uploads/purchase/");
		$status 		 = html_escape($this->input->post('status'));


		//USED TO REDIRECT TO LOCATION DEFINED
		if($status == 0)
		{
			$redirect = 'purchase';
		}
		else
		{
			$redirect = 'purchase/return_list';
		}

		if(($save_available_balance-$total_paid) < 0 AND $pur_method == 'Cheque' AND $status == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Insufficient balance available ',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'date' => date('Y-m-d'),
				'supplier_id' => $pur_supplier,
				'store' => $pur_store,
				'offered_discount' => $offered_discount,
				'invoice_id' => $pur_invoice,
				'total_amount' => $pur_total,
				'payment_type_id' => $pur_method,
				'payment_date' => $pur_date,
				'cash' => $total_paid,
				'description' => $pur_description,
				'cus_picture' => $picture,
				'status' => $status,
				'bank_id' => $bank_id,
				'credithead' => ($pur_method == 'Cash' ? '2' : '16'),
				'ref_no' => $ref_no
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Transaction_model->purchase_transaction($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added successfully',
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
		}	

		redirect($redirect);
	}

	// Customer/Delete
	function delete($args)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS

		$this->load->model('Crud_model');

		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID

		$this->Crud_model->delete_image('./uploads/customers/', $args, 'mp_customer');

		// DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID

		$result = $this->Crud_model->delete_record('mp_customer', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Customer record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Customer record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('customers');
	}

	// Customers/Edit
	function edit()
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$edit_customer_id = html_escape($this->input->post('edit_customer_id'));
		$edit_customer_name = html_escape($this->input->post('edit_customer_name'));
		$edit_customer_email = html_escape($this->input->post('edit_customer_email'));
		$edit_customer_address = html_escape($this->input->post('edit_customer_address'));
		$edit_customer_contatc1 = html_escape($this->input->post('edit_customer_contatc1'));
		$edit_customer_contact_two = html_escape($this->input->post('edit_customer_contact_two'));
		$edit_customer_company = html_escape($this->input->post('edit_customer_company'));
		$edit_customer_city = html_escape($this->input->post('edit_customer_city'));
		$edit_customer_country = html_escape($this->input->post('edit_customer_country'));
		$edit_customer_description = html_escape($this->input->post('edit_customer_description'));
		$edit_picture = $this->Crud_model->do_upload_picture("edit_customer_picture_name", "./customers/");

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_customer',
			'id' => $edit_customer_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		// DEFINES IF NO IMAGES IS SELECTED SO PRIVIOUS PICTURE REMAINS SAME
		if ($edit_picture == "default.jpg")
		{
			$data = array(
				'customer_name' => $edit_customer_name,
				'cus_email' => $edit_customer_email,
				'cus_address' => $edit_customer_address,
				'cus_contact_1' => $edit_customer_contatc1,
				'cus_contact_2' => $edit_customer_contact_two,
				'cus_company' => $edit_customer_company,
				'cus_city' => $edit_customer_city,
				'cus_country' => $edit_customer_country,
				'cus_description' => $edit_customer_description
			);
		}
		else
		{

			// DEFINES IF  IMAGES IS SELECTED SO UPDATE PRIVIOUS PICTURE
			$data = array(
				'customer_name' => $edit_customer_name,
				'cus_email' => $edit_customer_email,
				'cus_address' => $edit_customer_address,
				'cus_contact_1' => $edit_customer_contatc1,
				'cus_contact_2' => $edit_customer_contact_two,
				'cus_company' => $edit_customer_company,
				'cus_description' => $edit_customer_description,
				'cus_picture' => $edit_picture
			);

			// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
			$this->Crud_model->delete_image('./uploads/customers/', $edit_customer_id, 'mp_customer');
		}

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Customer Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Customer Category cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('customers');
	}

	//Customer/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'view_purchase_detail')
		{
			$data['single_purchase'] = $this->Crud_model->fetch_record_by_id('mp_purchase',$param);

			$data['purchase_list'] = $this->Crud_model->fetch_purchase_list($param);

			//model name available in admin models folder
			$this->load->view( 'admin_models/view_purchase_detail.php',$data);
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

		redirect('customers');
	}
}