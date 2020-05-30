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
class Invoice extends CI_Controller
{
	//invoice
	public function index()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Invoice';

		$data['main_view'] = 'invoice';

		$user_name = $this->session->userdata('user_id');
		
		// DEFINES PAGE invoice NUMBER
		$invoice = $this->Crud_model->fetch_last_record("mp_invoices");

		if ($invoice == NULL)
		{
			$data['invoice'] = 1;
		}
		else
		{
			$value = $invoice[0]->id;
			$data['invoice'] = $value + 1;
		}
		//FETCHING THE LIST OF CUSTOMERS
		$customer_record = $this->Crud_model->fetch_payee_record('customer','status');
		
		$data['customer_record'] = $customer_record;

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);
		
		$data['temp_view'] = 'invoice_template';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//invoice/delete_item_temporary
	//USED TO DELETE AN ITEM FROM TEMPORARY TABLE OF BARCODE ITEMS
	function delete_item_temporary($item_id)
	{	
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		//FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
		$result = $this->Crud_model->fetch_record_by_id('mp_temp_barcoder_invoice',$item_id);		

		//FETCH THE ITEM FROM STOCK TABLE 
		$result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$result[0]->product_id);

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_productslist',
			'id' => $result[0]->product_id
		);

		$data = array(
			'quantity' => $result_stock[0]->quantity+$result[0]->qty
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$this->Crud_model->edit_record_id($args, $data);

		// DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
		$this->Crud_model->delete_record('mp_temp_barcoder_invoice', $item_id);
		
		//USER ID
		$user_name = $this->session->userdata('user_id');

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);
		
		$this->load->view('invoice_template.php',$data);
	}

	//invoice/clear_temp_invoice
	//USED TO CLEAR TEMP INVOICE
	function clear_temp_invoice()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		//GET THE CURRENT USER
		$user_name = $this->session->userdata('user_id');

		//FETCH THE ITEM FROM DATABSE TABLE TO ADD AGAIN TO STOCK
		$result = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);

		if($result  != NULL)
		{

			foreach ($result as $single_item) 
			{
				//FETCH THE ITEM FROM STOCK TABLE 
				$result_stock = $this->Crud_model->fetch_record_by_id('mp_productslist',$single_item->product_id);

				// TABLENAME AND ID FOR DATABASE ACTION
				$args = array(
					'table_name' => 'mp_productslist',
					'id' => $single_item->product_id
				);


				$data = array(
					'quantity' => $result_stock[0]->quantity+$single_item->qty
				);

				// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
				$this->Crud_model->edit_record_id($args, $data);

			}

			$this->Crud_model->delete_record_by_userid('mp_temp_barcoder_invoice','pos',$user_name['id']);
		}

			//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
			$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);

			$this->load->view('invoice_template.php',$data);
	}

	//invoice/add_barcode_item
	//USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
	function add_barcode_item($barcode)
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		$user_name = $this->session->userdata('user_id');

		$result = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$barcode);
		if($result != NULL)
		{

			$check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','barcode',$barcode,$user_name['id'],'pos');

			if($result[0]->quantity > 0)
			{
				$stockargs   = array(
					'table_name' =>'mp_productslist', 
					'id' =>$result[0]->id, 
				);

				$stockdata = array(
					'quantity' => $result[0]->quantity-1
				);

				$this->Crud_model->edit_record_id($stockargs, $stockdata);

				if($check_item_in_temp != NULL)
				{
					$qty = '';

					$qty = $check_item_in_temp[0]->qty+1;

					$args = array(
						'table_name' => 'mp_temp_barcoder_invoice',
						'id' => $check_item_in_temp[0]->id
					);

					$data = array(
						'qty' => $qty
					);

					$this->Crud_model->edit_record_id($args, $data);
				}
				else
				{
					$tax_amount = ($result[0]->tax/100)*$result[0]->retail;

					// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
					$temp_data = array(
					'barcode' => $result[0]->barcode,
					'product_no' => $result[0]->sku,
					'product_id' => $result[0]->id,
					'product_name' => $result[0]->product_name,
					'mg' => $result[0]->mg,
					'price' => $result[0]->retail,
					'purchase' => $result[0]->purchase,
					'qty' => 1,
					'tax' => $tax_amount,
					'agentid' => $user_name['id'],
					'source' => 'pos'
					);

					// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
					$result = $this->Crud_model->insert_data('mp_temp_barcoder_invoice', $temp_data);
				}
			}
		}
		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);
		
		$this->load->view('invoice_template.php',$data);
	}

	//invoice/add_selected_item
	//USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
	function add_selected_item($id)
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$user_name = $this->session->userdata('user_id');

		if($id != '')
		{
			$result = $this->Crud_model->fetch_record_by_id('mp_productslist',$id);

			$check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','product_id',$id,$user_name['id'],'pos');


				if($result[0]->quantity > 0)
				{
					$stockargs   = array(
						'table_name' =>'mp_productslist', 
						'id' =>$result[0]->id, 
					);

					$stockdata = array(
						'quantity' => $result[0]->quantity-1
					);

					$this->Crud_model->edit_record_id($stockargs, $stockdata);

					if($check_item_in_temp != NULL)
					{
						$qty = $check_item_in_temp[0]->qty+1;

						$args = array(
							'table_name' => 'mp_temp_barcoder_invoice',
							'id' => $check_item_in_temp[0]->id
						);

						$data = array(
							'qty' => $qty
						);

						$this->Crud_model->edit_record_id($args, $data);
					}
					else
					{
						if($result != NULL)
						{
							$tax_amount = ($result[0]->tax/100)*$result[0]->retail;

							// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
								$args = array(
									'barcode' => $result[0]->barcode,
									'product_no' => $result[0]->sku,
									'product_id' => $result[0]->id,
									'product_name' => $result[0]->product_name,
									'mg' => $result[0]->mg,
									'price' => $result[0]->retail,
									'purchase' => $result[0]->purchase,
									'qty' => 1,
									'tax' => $tax_amount,
									'agentid' => $user_name['id'],
									'source' => 'pos'
								);
								// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
								$result = $this->Crud_model->insert_data('mp_temp_barcoder_invoice', $args);
						}
				}

			}
				//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
				$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);

				$this->load->view('invoice_template.php',$data);
		}
	}

	//invoice/search_result_manual
	//USED TO SEARCH MANUAL ITEMS
	function search_result_manual($search_result)
	{
		if($search_result != NULL)
		{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			$result = $this->Crud_model->search_items_stock($search_result);
			//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
			$data['search_result'] = $result;
			$this->load->view('search_list.php',$data);
		}
	}

	// invoice/manage
	public function manage()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Invoices';

		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');
		$first_date = html_escape($this->input->post('date1'));
		$second_date = html_escape($this->input->post('date2'));
		$invoice_no = html_escape($this->input->post('invoice_no'));
		if ($invoice_no != NULL)
		{
			$this->load->model('Crud_model');
			$result_invoices = $this->Crud_model->fetch_record_by_id('mp_invoices', $invoice_no);
		}
		else
		{
			if ($first_date == NULL OR $second_date == NULL)
			{
				$first_date = date('Y-m-d');
				$second_date = date('Y-m-d');

				// FETCH SALES RECORD FROM invoices TABLE
				$result_invoices = $this->Accounts_model->fetch_record_date('mp_invoices', $first_date, $second_date);
			}
			else
			{
				// FETCH SALES RECORD FROM invoices TABLE
				$result_invoices = $this->Accounts_model->fetch_record_date('mp_invoices', $first_date, $second_date);
			}
		}

		if ($result_invoices != NULL)
		{
			$count = 0;
			foreach($result_invoices as $obj_result_invoices)
			{

				// FETCH SALES RECORD FROM SALES TABLE
				$result_sales = $this->Accounts_model->fetch_record_sales('mp_sales', 'order_id', $obj_result_invoices->id);
				if ($result_sales != NULL)
				{
					$collection[$count] = $result_sales;
					$count++;
				}
			}

			// ASSIGNED THE FETCHED RECORD TO DATA ARRAY TO VIEW
			$data['Sales_Record'] = $collection;

			$data['Model_Title'] = "Edit invoice";

			$data['Model_Button_Title'] = "Update invoices";

			$data['invoices_Record'] = $result_invoices;

			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'sales_invoices';

			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
		else
		{
			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'main/error_invoices.php';
			$data['actionresult'] = "invoice/manage";
			$data['heading1'] = "No invoices available. ";
			$data['heading2'] = "Oops! Sorry no invoices record availible in the given details";
			$data['details'] = "We will work on fixing that right away. Meanwhile, you may return or try using the search form.";
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
	}

	//invoice/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_customer_model')
		{
			//USED TO REDIRECT LINK
			$data['link'] = 'customers/add_customer';

			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_customer_model.php',$data);
		}
		else if($page_name  == 'edit_invoice_model')
		{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Accounts_model');

			// GET THE ROW FROM DATABASE FROM TABLE ID
			$data['invoice_data'] = $this->Accounts_model->get_by_id("mp_invoices","mp_sales",$param);

			//model name available in admin models folder
			$this->load->view('admin_models/edit_models/edit_invoice_model.php',$data);
		}
		else if($page_name  == 'add_customer_payment_pos_model')
		{
			$this->load->model('Accounts_model');

			$data['previous_amt'] = $this->Accounts_model->previous_balance($param);

			$data['cus_id'] = $param;

			$data['customer_list'] = $this->Crud_model->fetch_payee_record('customer',NULL);
			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');
			
			$this->load->view( 'admin_models/add_models/add_customer_payment_pos_model.php',$data);
		}
		else if($page_name  == 'new_row_po')
		{
			//$this->load->model('Crud_model');

			//DEFINE TO FETCH THE LIST OF SUPPLIER
			$data['payee_list'] = $this->Crud_model->fetch_record('mp_payee',NULL);

			//model name available in admin models folder
			$this->load->view('admin_models/accounts/new_row_po.php',$data);
		}	
	}

	public function add_customer()
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$customer_name = html_escape($this->input->post('customer_name'));
		$customer_email = html_escape($this->input->post('customer_email'));
		$customer_address = html_escape($this->input->post('customer_address'));
		$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
		$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
		$customer_company = html_escape($this->input->post('customer_company'));
		$customer_city = html_escape($this->input->post('customer_city'));
		$customer_country = html_escape($this->input->post('customer_country'));
		$customer_description = html_escape($this->input->post('customer_description'));
		$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/customers/");

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'customer_name' => $customer_name,
			'cus_email' => $customer_email,
			'cus_address' => $customer_address,
			'cus_contact_1' => $customer_contatc1,
			'cus_contact_2' => $customer_contact_two,
			'cus_company' => $customer_company,
			'cus_city' => $customer_city,
			'cus_country' => $customer_country,
			'cus_description' => $customer_description,
			'cus_picture' => $picture
		);

		// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
		$email_record_data = $this->Crud_model->check_email_address('mp_customer', 'cus_email', $customer_email);
		if ($email_record_data == NULL)
		{

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Crud_model->insert_data('mp_customer', $args);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Customer added Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Customer cannot be added',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sorry Email already exists !',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('invoice/pos2');
	}

	public function edit_invoice()
	{

		$product_quantity = html_escape($this->input->post('product_quantity'));

		$edit_product_id = html_escape($this->input->post('edit_product_id'));

		$edit_sales_id = html_escape($this->input->post('edit_sales_id'));

		$edit_product_discount = html_escape($this->input->post('edit_product_discount'));


		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$this->load->model('Transaction_model');
		
		//$edit_discount 	  = html_escape($this->input->post('edit_discount'));
		$edit_invoice_id  = html_escape($this->input->post('edit_invoice_id'));

		$edit_description = html_escape($this->input->post('edit_description'));

		//$total_bill = html_escape($this->input->post('total_bill'));

		$amountpaid  = html_escape($this->input->post('amountpaid'));

		$user_name = $this->session->userdata('user_id');

		$i = 0;
		$total_discount = 0;
		$total_bill = 0;

		while ($i < count($edit_product_discount))
		{
			

			$product_data = $this->Crud_model->fetch_record_by_id('mp_productslist',$edit_product_id[$i]);

			$total_bill = $total_bill + ($product_quantity[$i] * $product_data[0]->retail);

			$total_discount = $total_discount + (($product_quantity[$i] * $product_data[0]->retail)/100 * $edit_product_discount[$i]);

			$i++;
		}


		$data = array(
			'discount' => $total_discount,
			'status' => 1,
			'agentname' =>  $user_name['name'],
			'description' =>  $edit_description,
			'total_bill' => $total_bill,
			'bill_paid' =>  $amountpaid
		);

		$result = $this->Transaction_model->edit_invoice_transaction($data,$edit_invoice_id);
		if($result != NULL)
		{

			// DEFINES TO CALCULATE THAT HOW MUCH THE LOOP SHOULD ITERATE
			$i = 0;
			while ($i < count($product_quantity))
			{

				// GETTING THE VALUES FROM TEXTFIELD .THE ARRAYS OF VALUES WHICH WE CREATED
				// BY USING DOM
				// FETCHING THE SALES QTY FROM SALES TBLE THROUGH SALES ID
				$get_result = $this->Crud_model->fetch_record_by_id('mp_sales', $edit_sales_id[$i]);
				$get_med_quantity = $get_result[0]->qty;

				//RETURNED STOCK BY CUSTOMER
				$get_med_quantity = $get_med_quantity-$product_quantity[$i];

				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
				$args1 = array(
					'table_name' => 'mp_sales',
					'id' => $edit_sales_id[$i]
				);
				$data1 = array(
					'qty' => $product_quantity[$i],
					'discount' => $edit_product_discount[$i]
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->edit_record_given_field('id', $args1, $data1);

				if($get_med_quantity > 0)
				{

				//UPDATING PARTS STOCK
				$this->Crud_model->add_return_item_stock($edit_product_id[$i],$get_med_quantity);

				}
				$i++;
			}
		}

		if ($result != NULL)
		{

			$get_invoice_result = $this->Crud_model->fetch_record_by_id('mp_invoices',$edit_invoice_id);

			//ASSIGNING DATA TO ARRAY
			$data  = array(
				'invoice_id' => $edit_invoice_id, 
				'discount' => $total_discount, 
				'description' => $edit_description,
				'date' => $get_invoice_result[0]->date, 
				'status' => $get_invoice_result[0]->status, 
				'agentname' => $user_name['name'], 
				'cus_id' => $get_invoice_result[0]->cus_id,
				'total_bill' => $total_bill,
				'bill_paid' => $amountpaid,
				'cus_previous' => $this->return_previous_cus_balance($get_invoice_result[0]->cus_id)
			);

			//FETCHING UPDATED SALE TO PRINT
			 $data['item_data']   =  $this->Crud_model->fetch_attr_record_by_id('mp_sales','order_id',$edit_invoice_id);

			//CUSTOMER NAME
			$result = $this->Crud_model->fetch_record_by_id('mp_payee',$get_invoice_result[0]->cus_id);
			$cus_name = $result[0]->customer_name;  

			//COMPANY NAME
			$result = $this->Crud_model->fetch_record_by_id('mp_langingpage',1);
			$company_name = $result[0]->companyname; 

			//PRINTER NAME
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_printer','set_default',1);
			if($result != NULL)
			{
			  $printer_name = $result[0]->printer_name; 
			}
			else
			{
			  $printer_name = '';
			}
			
        	//ADDRESS 
			$result = $this->Crud_model->fetch_record_by_id('mp_contactabout',1);
			$address = $result[0]->address;

			// if($printer_name != '')
			// {
			// 	//BUSINESS AND OTHER INFO THAT MENTIONED ON THE TOP
			// 	$general_info = array(
			// 	'name' => $company_name ,
			// 	'address' => $address,
			// 	'receipt' => $data['invoice_id'],
			// 	'date' => date('Y-m-d'),
			// 	'customer' => $cus_name,
			// 	'customer_id' => $get_invoice_result[0]->cus_id,
			// 	'served' => $user_name['name'],
			// 	'thanks' => 'Thanks For Visiting Us.',
			// 	'about' => 'Developed by North Soft',
			// 	'contact' => ' Contact 03453302833',
			// 	'printer_name' => $printer_name,
			// 	'text_size' => 1,
			// 	'discount' => $total_discount
			// 	);


			//     $this->load->library('printer');
			//     $printer_result = $this->printer->generate_print($general_info,$data);
			// }
		
			// if($printer_result != 'success')
			// {
			// 	$array_msg = array(
			// 	'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Editted invoice successfully but no printer is deducted',
			// 	'alert' => 'info'
			// 	);
			// }
			// else
			// {
			// 	$array_msg = array(
			// 	'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invoice editted',
			// 	'alert' => 'info'
			// 	);
			// }
			
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error invoice cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('invoice/manage/');
	}

	//invoice/add_auto_invoice
	//USED TO ADD AUTOMATIC INVOICE
	function add_auto_invoice()
	{

		$this->load->model('Transaction_model');
	    $customer_id 	 = html_escape($this->input->post('customer_id'));
		$discountfield 	 = html_escape($this->input->post('discountfield'));
		$total_bill 	 = html_escape($this->input->post('total_bill'));
		$bill_paid 	 	 = html_escape($this->input->post('bill_paid'));
		$bill_cost 	 	 = html_escape($this->input->post('bill_cost'));
		$date 			 = date('Y-m-d');
		$status 		 = 0;
		$user_name 	     = $this->session->userdata('user_id');
		$agent 			 = $user_name['name'];
		
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_attr_record_by_id('mp_temp_barcoder_invoice','agentid',$user_name['id']);

		//$customer_previous = $this->return_previous_cus_balance($customer_id);

		if($result != NULL)
		{
			//ASSIGNING DATA TO ARRAY
			$data1  = array(
				'discount' => $discountfield, 
				'date' => $date, 
				'status' => $status, 
				'agentname' => $agent, 
				'cus_id' => $customer_id,
				'total_bill' => $total_bill-$discountfield,
				'bill_paid' => $bill_paid,
				'net_cost' => $bill_cost,
				'cus_previous' => ''
			);

			//USED TO CREATE A TRANSACTION FOR SALE AND ACCOUNTS
			$data = $this->Transaction_model->single_pos_transaction($data1); 

			if ($data != NULL)
			{
				//CUSTOMER NAME
				$result = $this->Crud_model->fetch_record_by_id('mp_payee',$customer_id);
				$cus_name = $result[0]->customer_name;  

				//COMPANY NAME
				$result = $this->Crud_model->fetch_record_by_id('mp_langingpage',1);
				$company_name = $result[0]->companyname;
				$company_address = $result[0]->address; 

				//PRINTER NAME
				$result = $this->Crud_model->fetch_attr_record_by_id('mp_printer','set_default',1);
				if($result != NULL)
				{
				  $printer_name = $result[0]->printer_name; 
				}
				else
				{
				  $printer_name = '';
				}
				

				
				// if($printer_name != '')
				// {
				// 	//BUSINESS AND OTHER INFO THAT MENTIONED ON THE TOP
				// 	$general_info = array(
				// 	'name' => $company_name ,
				// 	'address' => $company_address,
				// 	'receipt' => $data['invoice_id'],
				// 	'date' => date('Y-m-d'),
				// 	'customer' => $cus_name,
				// 	'customer_id' => $customer_id,
				// 	'served' => $agent,
				// 	'thanks' => 'Thanks For Visiting Us.',
				// 	'about' => 'Developed by North Soft',
				// 	'contact' => ' Contact 03453302833',
				// 	'printer_name' => $printer_name,
				// 	'text_size' => 1,
				// 	'discount' => $discountfield
				// 	);

				// 	//UN COMMENT THE BELOW LINE WHEN CONNETED RO PRINTER 
				//     $this->load->library('printer');
				//   $printer_result =  $this->printer->generate_print($general_info,$data);
				// }

				if($printer_result != 'success')
				{
					$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invoice successfull but no printer is deducted',
					'alert' => 'info'
					);
				}
				else
				{
					$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created successfully',
					'alert' => 'info'
					);
				}


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
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry no items selected',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
			
		redirect('invoice'); 
	}

	// //USED TO SEARCH CUSTOMERS PRIVIOUS BALANCE 
	// //Invoice/search_previous_cus_balance
	// function search_previous_cus_balance($cus_id)
	// {
	// 	$this->load->model('Accounts_model');
	//     $result = $this->Accounts_model->previous_balance($cus_id);
	// 	echo $result;
	// }	

	// //USED TO SEARCH CUSTOMERS PRIVIOUS BALANCE 
	// //Invoice/search_previous_cus_balance
	// function return_previous_cus_balance($cus_id)
	// {
	// 	$this->load->model('Accounts_model');
	//     return $this->Accounts_model->previous_balance($cus_id);
	// }

	//USED TO UPDATE QUANTITY 
    //Invoice/update_qty
    function update_qty($val = '' , $id = '')
    {	
    	
      $this->load->model('Crud_model'); 
      $this->load->model('Pos_transaction_model'); 
      $user_name = $this->session->userdata('user_id');
      $val = intval($val);

      if($val != '' AND $id != '' AND  $val > -1)
      {

        $result = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','id',$id,$user_name['id'],'pos');

        $result_stk = $this->Crud_model->fetch_record_by_id('mp_productslist',$result['0']->product_id);

        $bal = 0;
        $new_qty = 0;

        if($result[0]->qty > $val)
        {
          $bal = $result[0]->qty-$val;
          $new_qty = $result_stk[0]->quantity+$bal;
        }
        else if($result[0]->qty < $val)
        {
           $bal = $val-$result[0]->qty;
           $new_qty = $result_stk[0]->quantity-$bal;

        }

        if($result[0]->qty != $val AND $new_qty >= 0)
        {
	          $new_args = array(
	            'table_name' => 'mp_productslist',
	            'id' => $result['0']->product_id
	          );

              $new_data = array(
                'quantity' => $new_qty
              );

              $temp_args = array(
                  'table_name' => 'mp_temp_barcoder_invoice',
                  'id' => $id
                );

              $temp_data = array(
                'qty' => $val
              );

            $this->Pos_transaction_model->general_pos_transaction($new_args, $new_data ,$temp_args ,$temp_data);
        }

      }
        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);
        $this->load->view('invoice_template.php',$data);
    }

    //USED TO UPDATE DISCOUNT 
    //Invoice/discount_qty
    function discount_qty($val = '' , $id = '')
    {	
    	
      $this->load->model('Crud_model'); 
      $user_name = $this->session->userdata('user_id');

      $val = intval($val);

      if($val != '' AND $id != '' AND  $val > -1)
      {

        $result = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','id',$id,$user_name['id'],'pos');
		

              $temp_args = array(
                  'table_name' => 'mp_temp_barcoder_invoice',
                  'id' => $id
                );

              $temp_data = array(
                'discount' => $val
              );

              $this->Crud_model->edit_record_id($temp_args,$temp_data);
      }
        //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','pos',$user_name['id']);

        $this->load->view('invoice_template.php',$data);
    }

    //USED TO SHOW THE DETAIL OF  RETURN INVOICE 
    //Invoice/single_invoice/ID
    function single_invoice($return_id)
    {
    	// DEFINES PAGE TITLE
		$data['title'] = 'Invoice';

		$this->load->model('Accounts_model'); 
		$data['invoice_data'] = $this->Accounts_model->fetch_single_invoice_items($return_id);

    	// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'single_invoice';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);


    }
}