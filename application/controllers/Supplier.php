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
class Supplier extends CI_Controller
{
	// supplier
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'supplier List';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Supplier List :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Name',
			'Email',
			'Address',
			'Contact1',
			'Picture',
			'Status',
			'Action'
		);
		
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier',NULL);
		$data['supplier_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO LIST THE SUPPLIER PAYMENT 
	//Supplier/payment_list 
	function payment_list()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Supplier payment';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Supplier payment:';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier_payment_list';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Trans Id',
			'Supplier Name',
			'Mode',
			'Amount',
			'Method',
			'Date',
			'Description',
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
		
		// DEFINES TO LOAD THE DATA USING GIVEN DATES 
		$this->load->model('Accounts_model');
		$result = $this->Accounts_model->fetch_record_date('mp_supplier_payments', $date1, $date2);
		$data['supplier_payment'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO ADD SUPPLIER PAYMENTS 
	//Supplier/add_supplier_payments
	function add_supplier_payments()
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$this->load->model('Transaction_model');

		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$pur_supplier = html_escape($this->input->post('pur_supplier'));
		$mode = html_escape($this->input->post('mode'));
		$amount = html_escape($this->input->post('amount'));
		$method_id = html_escape($this->input->post('payment_id'));
		$description = html_escape($this->input->post('description'));
		$user_date = Date('Y-m-d');
		$user_name = $this->session->userdata('user_id');
		$bank_id = html_escape($this->input->post('bank_id'));
		$ref_no = html_escape($this->input->post('ref_no'));
		$save_available_balance = html_escape($this->input->post('save_available_balance'));

		//MODE 0 PAYING  1 RECEIVING
		if(($save_available_balance-$amount) <= 0 AND $method_id == 'Cheque' AND $mode == 0)
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
				'supplier_id' => $pur_supplier,
				'amount' => $amount,
				'method' => $method_id,
				'date' => $user_date,
				'description' => $description,
				'agentname' => $user_name['name'],
				'mode' => $mode,
				'bank_id' => $bank_id,
				'credithead' => ($method_id == 'Cash' ? '2' : '16'),
				'ref_no' => $ref_no
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Transaction_model->supplier_payment_collection($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
					
		}
		redirect('supplier/payment_list');
	}

	//USED TO UPDATE SUPPLIER PAYMENTS 
	//supplier/edit_supplier_payments
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
		
		$get_transaction_result = $this->Crud_model->fetch_record_by_id('mp_supplier_payments',$status_id);
		$transaction_id =  $get_transaction_result[0]->transaction_id;
		
		$data2  = array(
			'amount' => $amount, 
		);

		// TABLENAME AND ID FOR DATABASE ACTION
		$args2 = array(
			'table_name' => 'mp_sub_entry',
			'id' => $transaction_id
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_transac($args2, $data2);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'supplier_id' => $pur_supplier,
			'amount' => $amount,
			'description' => $description
		);
			
		
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_supplier_payments',
			'id' => $status_id
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> Payment Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Payment cannot be editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('supplier/payment_list');
	}

	//	suppliers/add_supplier
	public function add_supplier()
	{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// DEFINES READ MEDICINE details FORM MEDICINE FORM
			$customer_name = html_escape($this->input->post('customer_name'));
			$customer_email = html_escape($this->input->post('customer_email'));
			$customer_cnic = html_escape($this->input->post('customer_cnic'));
			$customer_type = html_escape($this->input->post('customer_type'));
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
				'cus_type' => $customer_type,
				'cus_date' => date('Y-m-d'),
				'cus_picture' => $picture,
				'customer_nationalid' => $customer_cnic,
				'type' => 'supplier'
			);

			// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
			$email_record_data = $this->Crud_model->check_email_address('mp_payee', 'cus_email', $customer_email);

			if ($email_record_data == NULL)
			{
				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_payee',$args);
				if ($result != NULL)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Supplier added Successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error supplier cannot be added',
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
		redirect('supplier');
	}

	// supplier/delete
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
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"/> supplier record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error supplier record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('supplier');
	}

	// supplier/edit
	public function edit()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// DEFINES READ MEDICINE details FORM MEDICINE FORM
			$edit_customer_id = html_escape($this->input->post('edit_customer_id'));
			$customer_name = html_escape($this->input->post('customer_name'));
			$customer_email = html_escape($this->input->post('customer_email'));
			$customer_cnic = html_escape($this->input->post('customer_cnic'));
			$customer_type = html_escape($this->input->post('customer_type'));
			$customer_address = html_escape($this->input->post('customer_address'));
			$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
			$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
			$customer_company = html_escape($this->input->post('customer_company'));
			$customer_region = html_escape($this->input->post('customer_region'));
			$customer_town = html_escape($this->input->post('customer_town'));
			$customer_description = html_escape($this->input->post('customer_description'));
			$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/supplier/");

			$upload_data = $this->upload->data();
	  		$file_name =   $upload_data['file_name'];

			// TABLENAME AND ID FOR DATABASE ACTION
			$args = array(
				'table_name' => 'mp_payee',
				'id' => $edit_customer_id
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
					'cus_type' => $customer_type,
					'cus_date' => date('Y-m-d'),
					'type' => 'supplier'
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
					'cus_type' => $customer_type,
					'cus_date' => date('Y-m-d'),
					'cus_picture' => $picture,
					'type' => 'supplier'
				);

				// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
				$this->Crud_model->delete_image('./uploads/supplier/', $edit_customer_id, 'mp_payee');
			}

			// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
			$result = $this->Crud_model->edit_record_id($args, $data);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Supplier Editted',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Supplier cannot be Editted',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}

		redirect('supplier');
	}

	// supplier/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_payee',
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
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Status changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error Status cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('supplier');
	}

	//supplier/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_supplier_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_supplier_model.php');
		}
		else if($page_name  == 'edit_supplier_model')
		{
			$data['single_supplier'] = $this->Crud_model->fetch_record_by_id('mp_payee',$param);
			//model name available in admin models folder
			$this->load->view( 'admin_models/edit_models/edit_supplier_model.php',$data);
		}		
		else if($page_name  == 'add_supplier_payment_model')
		{
			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier',NULL);
			
			$this->load->view( 'admin_models/add_models/add_supplier_payment_model.php',$data);
		}		
		else if($page_name  == 'edit_supplier_payment')
		{
			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier',NULL);

			$data['supplier_payments'] = $this->Crud_model->fetch_record_by_id('mp_supplier_payments',$param );
			
			$this->load->view( 'admin_models/edit_models/edit_supplier_payment.php',$data);
		} 
		
	}

	//USED TO CALCULATE THE CUSTOMER LADGER 
	function ledger()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Supplier ledger';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Supplier Ledger :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'supplier_ledger';

		$data['bank_transactions'] = '';
		
		$data['expense_transactions'] = '';

		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_payee_record('supplier','status');
		$data['supplier_list'] = $result;

		$data['ledger'] = '';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Payment date',
			'Bill ID',
			'Total Bill',
			'Bill paid',
			'Balance',
			'Method',
			'Description',
			'View bill'
		);

		$data['balance_paid'] = '';

		$data['balance_recieved'] = '';

		$data['ledger_return_data'] = '';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//USED TO SHOW THE SUPPLIER LEDGER 
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
			'Description'
		);		

		$data['table_heading_names_of_coloums_returns'] = array(
			'Payment date',
			'Trans ID',
			'Total Return',
			'Recieved',
			'Balance',
			'Method',
			'Description'
		);

		$data['table_heading_names_of_coloums_balance_paid'] = array(
			'Payment date',
			'Trans ID',
			'Balance Paid',
			'Method',
			'Description'
		);		

		$data['table_heading_names_of_coloums_balance_recieved'] = array(
			'Payment date',
			'Trans ID',
			'Balance Recieved',
			'Method',
			'Description'
		);

		// DEFINES THE TABLE HEAD FOR EXPENSE PAID ITEMS TO SUPPLIER
		$data['table_heading_names_of_coloums_expense'] = array(
			'Date',
			'Method',
			'Payee',
			'Recieved by',
			'Total Bill',
			'Total Paid',
			'Balance',
			'Description'
		);

		// DEFINES THE TABLE HEAD FOR BANK TRANSACTION
		$data['table_heading_names_of_coloums_transaction'] = array(
			'Date',
			 'Bank',
			'Payee'	,
			'Amount',
			'Cheque No',
			'Action',
			'Status'
		);


		// RETRIEVING  VALUES FROM FORM CUSTOMER LEDGER FORM
		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));

		if($date1 == NULL OR $date1 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// RETRIEVING  VALUES FROM FORM CUSTOMER LEDGER FORM
		 $supplier_id = html_escape($this->input->post('supplier_id'));
		 if($supplier_id != NULL)
		 {
			$ledger_data = '';
			$this->load->model('Accounts_model');
			$this->load->model('Crud_model');

			$ledger_data = $this->Accounts_model->fetch_supplier_ledger($date1,$date2,$supplier_id,0);

			$ledger_return_data = $this->Accounts_model->fetch_supplier_ledger($date1,$date2,$supplier_id,1);
			
			if($ledger_data != NULL)
			{
				$data['heading'] = $ledger_data[0]->customer_name;

				$data['email_phone'] = $ledger_data[0]->cus_email.' | '.$ledger_data[0]->cus_contact_1;
			}

			//HAS A DATA OF PURCHASE
			$data['ledger'] = $ledger_data;

			//HAS A DATA OF PURCHASE RETURN
			$data['ledger_return_data'] = $ledger_return_data;

			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'supplier_ledger';

			//USED TO FETCH SUPPPLIERS
			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier','status');

			//USED TO FETCH THE SUPPLIER PAID BALANCES
			$data['balance_paid'] = $this->Accounts_model->supplier_payment_modes($date1,$date2,$supplier_id,'0');

			//USED TO FETCH THE SUPPLIER RECIEVED BALANCES
			$data['balance_recieved'] = $this->Accounts_model->supplier_payment_modes($date1,$date2,$supplier_id,'1');

			//PAYMENTS THROUGH BANKS
			$data['bank_transactions'] = $this->Accounts_model->payee_written_cheques($supplier_id,$date1,$date2);

			//EXPENSE PAYMENTS THROUGH CASH
			$data['expense_transactions'] = $this->Crud_model->expense_through_user($date1,$date2,'Cash',$supplier_id);
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		
			$this->load->view('main/index.php', $data);

		}
		else
		{
			redirect('homepage');
		}
	}
}