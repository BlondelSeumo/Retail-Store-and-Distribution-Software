<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 11th December, 2018
*  @Developed : Team Spantik Lab
*  @URL       : www.spantiklab.com
*  @Envato    : https://codecanyon.net/user/spantiklab
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Payee extends CI_Controller
{
	// Payee
	public function index()

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Account Holder';
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Account Holders :';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'payee';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Name',
			'Email',
			'Address',
			'Contact1',
			'Picture',
			'Status',
			'Action',
		);
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record('mp_payee', NULL);
		$data['supplier_list'] = $result;
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO LIST THE SUPPLIER PAYMENT
	// Payee/payment_list
	function payment_list($period = '')
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Recieved payments';
		if ($period != '')
		{
			if ($period == 'month')
			{
				$date1 = date('Y-m') . '-1';
				$date2 = date('Y-m') . '-31';
			}
			else if ($period == 'three')
			{
				$month = date('m') - 2;
				$date1 = date('Y') . '-' . $month . '-1';
				$date2 = date('Y-m') . '-31';
			}
			else if ($period == 'year')
			{
				$year = date('Y');
				$date1 = $year . '-1-1';
				$date2 = $year . '-12-31';
			}
			else
			{
				$date1 = date('Y-m') . '-1';
				$date2 = date('Y-m') . '-31';
			}
		}
		else
		{
			$date1 = html_escape($this->input->post('date1'));
			$date2 = html_escape($this->input->post('date2'));
			if ($date1 == "" OR $date2 == "")
			{
				$date1 = date('Y-m') . '-1';
				$date2 = date('Y-m') . '-31';
			}
		}
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Recieved payment ' . $date1 . ' to ' . $date2;
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier_payment_list';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Receipt ID',
			'Invoice ID',
			'Account Title',
			'Mode',
			'Amount',
			'Method',
			'Ref No',
			'Date',
			'Description',
			'Action',
		);
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$data['payee_payment'] = $this->Crud_model->fetch_receive_payment($date1, $date2, 'mp_payee_payments');
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO ADD SUPPLIER PAYMENTS
	// Payee/add_supplier_payments
	function add_supplier_payments()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$this->load->model('Transaction_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$pur_supplier = html_escape($this->input->post('pur_supplier'));
		$mode = html_escape($this->input->post('mode'));
		$amount = html_escape($this->input->post('amount'));
		$description = html_escape($this->input->post('description'));
		$user_date = Date('Y-m-d');
		$user_name = $this->session->userdata('user_id');
		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'supplier_id' => $pur_supplier,
			'amount' => $amount,
			'method' => 'Cash',
			'date' => $user_date,
			'description' => $description,
			'agentname' => $user_name['name'],
			'mode' => $mode,
		);
		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Transaction_model->supplier_payment_collection($args);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee/payment_list');
	}
	// USED TO UPDATE SUPPLIER PAYMENTS
	// Payee/edit_supplier_payments
	function edit_supplier_payments()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// USER'S ACTIVE SESSION
		$user_name = $this->session->userdata('user_id');
		// RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
		$status_id = html_escape($this->input->post('status_id'));
		$pur_supplier = html_escape($this->input->post('pur_supplier'));
		$amount = html_escape($this->input->post('amount'));
		$description = html_escape($this->input->post('description'));
		$get_transaction_result = $this->Crud_model->fetch_record_by_id('mp_supplier_payments', $status_id);
		$transaction_id = $get_transaction_result[0]->transaction_id;
		$data2 = array(
			'amount' => $amount,
		);
		// TABLENAME AND ID FOR DATABASE ACTION
		$args2 = array(
			'table_name' => 'mp_sub_entry',
			'id' => $transaction_id,
		);
		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_transac($args2, $data2);
		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'supplier_id' => $pur_supplier,
			'amount' => $amount,
			'description' => $description,
		);
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_supplier_payments',
			'id' => $status_id,
		);
		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> payee Editted',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> payee cannot be editted',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee/payment_list');
	}
	// payee/add_payee
	public function add_payee()

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$customer_name = html_escape($this->input->post('customer_name'));
		$customer_email = html_escape($this->input->post('customer_email'));
		$customer_cnic = html_escape($this->input->post('customer_cnic'));
		// $customer_type = html_escape($this->input->post('customer_type'));
		$customer_address = html_escape($this->input->post('customer_address'));
		$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
		$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
		$customer_company = html_escape($this->input->post('customer_company'));
		$customer_region = html_escape($this->input->post('customer_region'));
		$customer_town = html_escape($this->input->post('customer_town'));
		$customer_description = html_escape($this->input->post('customer_description'));
		$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/supplier/");
		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'customer_name' => $customer_name,
			'cus_email' => $customer_email,
			'cus_address' => $customer_address,
			'cus_contact_1' => $customer_contatc1,
			'cus_contact_2' => $customer_contact_two,
			'cus_company' => $customer_company,
			'cus_region' => $customer_region,
			'cus_town' => $customer_town,
			'cus_description' => $customer_description,
			'cus_date' => date('Y-m-d') ,
			'cus_picture' => $picture,
			'customer_nationalid' => $customer_cnic,
			// 'type' => $customer_type
		);
		// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
		//$email_record_data = $this->Crud_model->check_email_address('mp_payee', 'cus_email', $customer_email);
		if (TRUE)
		{
			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Crud_model->insert_data('mp_payee', $args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Supplier added Successfully',
					'alert' => 'info',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error supplier cannot be added',
					'alert' => 'danger',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Sorry Email already exists !',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee');
	}
	// payee/delete
	public function delete($args)

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
		$this->Crud_model->delete_image('./uploads/supplier/', $args, 'mp_payee');
		$result = $this->Crud_model->delete_record('mp_payee', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"/> Account record removed',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error account record cannot be changed',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee');
	}
	// payee/edit
	public function edit()

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$edit_customer_id = html_escape($this->input->post('edit_customer_id'));
		$customer_name = html_escape($this->input->post('customer_name'));
		$customer_email = html_escape($this->input->post('customer_email'));
		$customer_cnic = html_escape($this->input->post('customer_cnic'));
		$customer_address = html_escape($this->input->post('customer_address'));
		$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
		$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
		$customer_company = html_escape($this->input->post('customer_company'));
		$customer_region = html_escape($this->input->post('customer_region'));
		$customer_town = html_escape($this->input->post('customer_town'));
		$customer_description = html_escape($this->input->post('customer_description'));
		$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/supplier/");
		$upload_data = $this->upload->data();
		$file_name = $upload_data['file_name'];
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_payee',
			'id' => $edit_customer_id,
		);
		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		// DEFINES IF NO IMAGES IS SELECTED SO PRIVIOUS PICTURE REMAINS SAME
		if ($picture == "default.jpg")
		{
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$data = array(
				'customer_name' => $customer_name,
				'cus_email' => $customer_email,
				'customer_nationalid' => $customer_cnic,
				'cus_address' => $customer_address,
				'cus_contact_1' => $customer_contatc1,
				'cus_contact_2' => $customer_contact_two,
				'cus_company' => $customer_company,
				'cus_region' => $customer_region,
				'cus_town' => $customer_town,
				'cus_description' => $customer_description,
				'cus_date' => date('Y-m-d') ,
			);
		}
		else
		{
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$data = array(
				'customer_name' => $customer_name,
				'cus_email' => $customer_email,
				'customer_nationalid' => $customer_cnic,
				'cus_address' => $customer_address,
				'cus_contact_1' => $customer_contatc1,
				'cus_contact_2' => $customer_contact_two,
				'cus_company' => $customer_company,
				'cus_region' => $customer_region,
				'cus_town' => $customer_town,
				'cus_description' => $customer_description,
				'cus_date' => date('Y-m-d') ,
				'cus_picture' => $picture,
			);
			// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
			$this->Crud_model->delete_image('./uploads/supplier/', $edit_customer_id, 'mp_payee');
		}
		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Account Editted',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Account cannot be Editted',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee');
	}
	// payee/change_status/id/status
	public function change_status($id, $status)

	{
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_payee',
			'id' => $id,
		);
		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'cus_status' => $status,
		);
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Status changed Successfully!',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error Status cannot be changed',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee');
	}
	// Payee/popup
	// DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');
		if ($page_name == 'add_payee_model')
		{
			// model name available in admin models folder
			$this->load->view('admin_models/add_models/add_payee_model.php');
		}
		else if ($page_name == 'edit_payee_model')
		{
			$data['single_supplier'] = $this->Crud_model->fetch_record_by_id('mp_payee', $param);
			// model name available in admin models folder
			$this->load->view('admin_models/edit_models/edit_payee_model.php', $data);
		}
		else if ($page_name == 'add_supplier_payment_model')
		{
			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier', NULL);
			$this->load->view('admin_models/add_models/add_supplier_payment_model.php', $data);
		}
		else if ($page_name == 'edit_supplier_payment')
		{
			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier', NULL);
			$data['supplier_payments'] = $this->Crud_model->fetch_record_by_id('mp_supplier_payments', $param);
			$this->load->view('admin_models/edit_models/edit_supplier_payment.php', $data);
		}
	}
	
	// USED TO CALCULATE THE CUSTOMER LADGER
	function ledger($account_id = '', $period = '')
	{
		if ($account_id != '')
		{
			if ($period != '')
			{
				if ($period == 'month')
				{
					$date1 = date('Y-m') . '-1';
					$date2 = date('Y-m') . '-31';
				}
				else if ($period == 'three')
				{
					$month = date('m') - 2;
					$date1 = date('Y') . '-' . $month . '-1';
					$date2 = date('Y-m') . '-31';
				}
				else if ($period == 'year')
				{
					$year = date('Y');
					$date1 = $year . '-1-1';
					$date2 = $year . '-12-31';
				}
				else
				{
					$date1 = date('Y-m') . '-1';
					$date2 = date('Y-m') . '-31';
				}
			}
			else
			{
				$date1 = html_escape($this->input->post('date1'));
				$date2 = html_escape($this->input->post('date2'));
				if ($date1 == "" OR $date2 == "")
				{
					$date1 = date('Y-m') . '-1';
					$date2 = date('Y-m') . '-31';
				}
			}
			$this->load->model('Crud_model');

			// ACCOUNT HOLDER DATA
			$data['payee_details'] = $this->Crud_model->fetch_record_by_id('mp_payee', $account_id);
			
			// DEFINES PAGE TITLE
			$data['title'] = 'Account Statement ' . $data['payee_details'][0]->customer_name;
			
			// DEFINES NAME OF TABLE HEADING
			$data['date1'] = $date1;

			// DEFINES THE DATA2
			$data['date2'] = $date2;

			// DATA TABLE NAME
			$data['table_name'] = 'Account Statement :';

			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'supplier_ledger';

			$data['transactions'] = $this->Crud_model->fetch_account_statement($account_id, $date1, $date2, $period);
			/*echo '<pre>';
			print_r($data['transactions']);
			*/
			// die();
			// COMPANY DATA DEFAULT
			$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
			
			// ACCOUNT HOLDER ID
			$data['account_id'] = $account_id;

			// PERIOD
			$data['period'] = $period;
			
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
		else
		{
			redirect('payee');
		}
	}
	// USED TO SHOW THE SUPPLIER LEDGER
	function Create_ledger()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Supplier ledger';
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Supplier ledger';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier_ledger';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Payment date',
			'Trans ID',
			'Total Bill',
			'Bill paid',
			'Balance',
			'Method',
			'Description',
		);
		$data['table_heading_names_of_coloums_returns'] = array(
			'Payment date',
			'Trans ID',
			'Total Return',
			'Recieved',
			'Balance',
			'Method',
			'Description',
		);
		$data['table_heading_names_of_coloums_balance_paid'] = array(
			'Payment date',
			'Trans ID',
			'Balance Paid',
			'Method',
			'Description',
		);
		$data['table_heading_names_of_coloums_balance_recieved'] = array(
			'Payment date',
			'Trans ID',
			'Balance Recieved',
			'Method',
			'Description',
		);
		// RETRIEVING  VALUES FROM FORM CUSTOMER LEDGER FORM
		$supplier_id = html_escape($this->input->post('supplier_id'));
		if ($supplier_id != NULL)
		{
			$ledger_data = '';
			$this->load->model('Accounts_model');
			$this->load->model('Crud_model');
			$ledger_data = $this->Accounts_model->fetch_supplier_ledger($supplier_id, 0);
			$ledger_return_data = $this->Accounts_model->fetch_supplier_ledger($supplier_id, 1);
			if ($ledger_data != NULL)
			{
				$data['heading'] = $ledger_data[0]->customer_name . ' Ledger';
				$data['email_phone'] = $ledger_data[0]->cus_email . ' | ' . $ledger_data[0]->cus_contact_1;
			}
			// HAS A DATA OF PURCHASE
			$data['ledger'] = $ledger_data;
			// HAS A DATA OF PURCHASE RETURN
			$data['ledger_return_data'] = $ledger_return_data;
			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'supplier_ledger';
			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier', 'status');
			// USED TO FETCH THE SUPPLIER PAID BALANCES
			$data['balance_paid'] = $this->Accounts_model->supplier_payment_modes($supplier_id, '0');
			// USED TO FETCH THE SUPPLIER RECIEVED BALANCES
			$data['balance_recieved'] = $this->Accounts_model->supplier_payment_modes($supplier_id, '1');
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
		else
		{
			redirect('homepage');
		}
	}
	// USED TO SEND EMAIL
	function sendmail($receive_id)
	{
		$this->load->model('Crud_model');
		$this->load->model('Email_model');
		$default_data = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$receipts_data = $this->Crud_model->fetch_product_receipt($receive_id);
		$user_data = $this->Crud_model->fetch_record_by_id('mp_payee', $receipts_data[0]->payee_id);
		// MAILING INFO
		$mail_data = array(
			'company' => $default_data[0]->companyname,
			'customer_email' => $user_data[0]->cus_email,
			'sender_email' => $default_data[0]->email,
			'title' => 'RECEIPT NO ' . $receive_id . ' ' . $default_data[0]->companyname,
			'customer_name' => $user_data[0]->customer_name,
			'title1' => 'TOTAL',
			'balance' => $default_data[0]->currency . ' ' . $receipts_data[0]->total_bill,
			'title2' => 'BALANCE DUE',
			'due_date' => $default_data[0]->currency . ' ' . $receipts_data[0]->total_bill - $receipts_data[0]->total_paid,
			'request_no' => $receive_id,
			'logo' => base_url() . 'uploads/systemimgs/' . $default_data[0]->logo,
			'button_text' => 'View receipt',
			'type' => 'RECEIPT NO',
			'source' => 'receive receipt',
			'color' => $default_data[0]->primarycolor,
			'payee_id' => $receipts_data[0]->payee_id,
		);
		$result = $this->Email_model->email_request($mail_data);
		if ($result)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Send successfully',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be Sent',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee/payment_list');
	}
	function accountstatement($payee_id)
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Account Statement';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier_ledger';
		$data['payee_transactions'] = $this->Crud_model->payee_account_statement($payee_id);
		$this->load->view('main/index.php', $data);
	}
}
