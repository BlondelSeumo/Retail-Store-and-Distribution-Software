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
class Expense extends CI_Controller
{
	
	// Expense
	function index($period = '')
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
		// DEFINES PAGE TITLE
		$data['title'] = 'Expense List';
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Expense  from ' . $date1 . ' to ' . $date2;
		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add Expense';
		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add Expense';
		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Expense';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'expenselist';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Date',
			'Type',
			'Method',
			'Ref no',
			'Payee',
			'Total',
			'Paid',
			'Created by',
			'',
		);
		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$data['expense_record_list'] = $this->Crud_model->fetch_record_expense($date1, $date2);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// Expense/bank_expense
	function bank_expense($period = '')
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
		// DEFINES PAGE TITLE
		$data['title'] = 'Bank Expense List';
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Expense  from ' . $date1 . ' to ' . $date2;
		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add Expense';
		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add Bank Expense';
		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Expense';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'bank_expense_list';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Date',
			'Type',
			'Bank',
			'Total',
			'Created by',
			'',
		);
		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$data['expense_record_list'] = $this->Crud_model->fetch_record_bankexpense($date1, $date2);
		// DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// expense/add_expense_form
	function add_expense_form()
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Create Expense';
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['head_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Expense');
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_bank
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
		// DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'add_expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// expense/add_bank_expense
	function add_bank_expense()
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Create Bank Expense';
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['head_list'] = $this->Crud_model->fetch_bank_expense_heads();
		// DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_bank
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'add_bank_expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// expense/edit_expense
	function edit_expense($expense_id)
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Update Expense';
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['head_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Expense');
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_bank
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
		// PARENT DATA OF REFUND
		$data['parent_row'] = $this->Crud_model->fetch_record_by_id('mp_expense', $expense_id);
		// CHILD DATA OF REFUND
		$data['child_row'] = $this->Crud_model->fetch_attr_record_by_id('mp_sub_expense', 'expense_id', $expense_id);
		// BANK TRANSACTION ID IF FOUND
		$data['bank_row'] = $this->Crud_model->fetch_attr_record_by_id(' mp_bank_transaction', 'transaction_id', $data['parent_row'][0]->transaction_id);
		if ($data['bank_row'] != NULL)
		{
			$data['bank_balance'] = $this->Crud_model->check_available_balance($data['bank_row'][0]->bank_id);
		}
		else
		{
			$data['bank_balance'] = NULL;
			$data['bank_row'] = 0;
		}
		// DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// expense/edit_bank_expense
	function edit_bank_expense($expense_id)
	{
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Update Expense';
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['head_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Expense');
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_bank
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
		// PARENT DATA OF REFUND
		$data['parent_row'] = $this->Crud_model->fetch_record_by_id('mp_expense', $expense_id);
		// CHILD DATA OF REFUND
		$data['child_row'] = $this->Crud_model->fetch_attr_record_by_id('mp_sub_expense', 'expense_id', $expense_id);
		// BANK TRANSACTION ID IF FOUND
		$data['bank_row'] = $this->Crud_model->fetch_attr_record_by_id('mp_bank_transaction', 'transaction_id', $data['parent_row'][0]->transaction_id);
		if ($data['bank_row'] != NULL)
		{
			$data['bank_balance'] = $this->Crud_model->check_available_balance($data['bank_row'][0]->bank_id);
		}
		else
		{
			$data['bank_balance'] = NULL;
			$data['bank_row'] = 0;
		}
		// DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_bank_expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// Expense/popup
	// DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');
		if ($page_name == 'new_bill_row')
		{
			$this->load->model('Crud_model');
			// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
			$data['head_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Expense');
			// DEFINE TO FETCH THE LIST OF SUPPLIER
			$data['payee_list'] = $this->Crud_model->fetch_payee_record('supplier', 'status');
			// DEFINES TO FETCH THE LIST OF BANK ACCOUNTS
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
			// model name available in admin models folder
			$this->load->view('admin_models/accounts/new_bill_row.php', $data);
		}
	}
	// Expense/add_expense
	// USED TO ADD EXPENSE INTO TABLE
	function add_expense()
	{
		$this->load->model('Crud_model');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM
		$save_available_balance = html_escape($this->input->post('save_available_balance'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$payment_method = html_escape($this->input->post('payment_method'));
		$date = html_escape($this->input->post('date'));
		$ref_no = html_escape($this->input->post('ref_no'));
		$bank_id = html_escape($this->input->post('bank_id'));
		// ARRAY OF INPUTS
		$account_head = html_escape($this->input->post('account_head'));
		$description_arr = html_escape($this->input->post('descriptionarr'));
		$amount = html_escape($this->input->post('amount'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$total_paid = html_escape($this->input->post('total_paid'));
		$memo = html_escape($this->input->post('memo'));
		$attachment = $this->Crud_model->do_upload_picture("attachment", "./uploads/expense/");
		if ($payment_method == 'Cheque' AND $bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect(base_url('expense'));
		}
		if (count($account_head) > 0 AND $total_bill > 0)
		{
			// $picture = html_escape($this->input->post('picture'));
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Expense_model');
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'payment_method' => $payment_method,
				'payee_id' => $payee_id,
				'date' => ($date == NULL ? date('Y-m-d') : $date) ,
				'ref_no' => $ref_no,
				'bank_id' => $bank_id,
				'user' => $added_by,
				'account_head' => $account_head,
				'description_arr' => $description_arr,
				'amount' => $amount,
				'total_bill' => $total_bill,
				'total_paid' => $total_paid,
				'memo' => $memo,
				'credithead' => ($payment_method == 'Cash' ? '2' : '16') ,
				'attachment' => $attachment,
			);
			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Expense_model->add_expense_transaction($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Cannot Created',
					'alert' => 'danger',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty expense !!',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('expense');
	}
	// Expense/save_bank_expense
	// USED TO SAVE BANK EXPENSE INTO TABLE
	function save_bank_expense()
	{
		$this->load->model('Crud_model');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM
		$save_available_balance = html_escape($this->input->post('save_available_balance'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$bank_id = html_escape($this->input->post('bank_id'));
		// ARRAY OF INPUTS
		$account_head = html_escape($this->input->post('account_head'));
		$description_arr = html_escape($this->input->post('descriptionarr'));
		$amount = html_escape($this->input->post('amount'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$memo = html_escape($this->input->post('memo'));
		$attachment = $this->Crud_model->do_upload_picture("attachment", "./uploads/bank_expense/");
		if ($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect(base_url('expense'));
		}
		if (count($account_head) > 0 AND $total_bill > 0)
		{
			// $picture = html_escape($this->input->post('picture'));
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Expense_model');
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'date' => ($date == NULL ? date('Y-m-d') : $date) ,
				'bank_id' => $bank_id,
				'payee_id' => $payee_id,
				'user' => $added_by,
				'account_head' => $account_head,
				'description_arr' => $description_arr,
				'amount' => $amount,
				'total_bill' => $total_bill,
				'total_paid' => $total_bill,
				'memo' => $memo,
				'credithead' => 16,
				'attachment' => $attachment,
			);
			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Expense_model->add_bank_expense_transaction($args);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Cannot Created',
					'alert' => 'danger',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty expense !!',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('expense/bank_expense');
	}
	// Expense/update_expense
	// USED TO UPDATE EXPENSE INTO TABLE
	function update_expense()
	{
		$this->load->model('Crud_model');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM
		$bank_amount = html_escape($this->input->post('save_available_balance'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$payment_method = html_escape($this->input->post('payment_method'));
		$date = html_escape($this->input->post('date'));
		$ref_no = html_escape($this->input->post('ref_no'));
		$bank_id = html_escape($this->input->post('bank_id'));
		// ARRAY OF INPUTS
		$account_head = html_escape($this->input->post('account_head'));
		$description_arr = html_escape($this->input->post('descriptionarr'));
		$amount = html_escape($this->input->post('amount'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$total_paid = html_escape($this->input->post('total_paid'));
		$memo = html_escape($this->input->post('memo'));
		$transaction_id = html_escape($this->input->post('transaction_id'));
		$expense_id = html_escape($this->input->post('expense_id'));
		$attachment = $this->Crud_model->do_upload_picture("attachment", "./uploads/expense/");
		if ($payment_method == 'Cheque' AND $bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect(base_url('expense'));
		}
		if ($payment_method == 'Cheque' AND $bank_amount <= 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Unsufficient amount in account !!',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			if (count($account_head) > 0 AND $total_bill > 0)
			{
				// $picture = html_escape($this->input->post('picture'));
				// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
				$this->load->model('Expense_model');
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'payment_method' => $payment_method,
					'payee_id' => $payee_id,
					'ref_no' => $ref_no,
					'bank_id' => $bank_id,
					'account_head' => $account_head,
					'description_arr' => $description_arr,
					'amount' => $amount,
					'total_bill' => $total_bill,
					'total_paid' => $total_paid,
					'memo' => $memo,
					'credithead' => ($payment_method == 'Cash' ? '2' : '16') ,
					'memo' => $memo,
					'transaction_id' => $transaction_id,
					'expense_id' => $expense_id,
					'attachment' => $attachment,
				);
				if ($attachment != "default.jpg")
				{
					// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
					$this->Crud_model->delete_image_custom('./uploads/expense/', $expense_id, 'attachment', 'mp_expense');
				}
				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Expense_model->update_expense_transaction($args);
				if ($result != NULL)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
						'alert' => 'info',
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Cannot updated',
						'alert' => 'danger',
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty expense !!',
					'alert' => 'danger',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		redirect('expense');
	}
	// Expense/update_bank_expense
	// USED TO UPDATE BANK EXPENSE INTO TABLE
	function update_bank_expense()
	{
		$this->load->model('Crud_model');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM
		$bank_amount = html_escape($this->input->post('save_available_balance'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$bank_id = html_escape($this->input->post('bank_id'));
		// ARRAY OF INPUTS
		$account_head = html_escape($this->input->post('account_head'));
		$description_arr = html_escape($this->input->post('descriptionarr'));
		$amount = html_escape($this->input->post('amount'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$memo = html_escape($this->input->post('memo'));
		$transaction_id = html_escape($this->input->post('transaction_id'));
		$expense_id = html_escape($this->input->post('expense_id'));
		$attachment = $this->Crud_model->do_upload_picture("attachment", "./uploads/bank_expense/");
		if ($payment_method == 'Cheque' AND $bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect(base_url('expense'));
		}
		if ($attachment != "default.jpg")
		{
			// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
			$this->Crud_model->delete_image_custom('./uploads/bank_expense/', $expense_id, 'attachment', 'mp_expense');
		}
		if ($bank_amount <= 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Unsufficient amount in account !!',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			if (count($account_head) > 0 AND $total_bill > 0)
			{
				// $picture = html_escape($this->input->post('picture'));
				// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
				$this->load->model('Expense_model');
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'payee_id' => $payee_id,
					'bank_id' => $bank_id,
					'account_head' => $account_head,
					'description_arr' => $description_arr,
					'amount' => $amount,
					'total_bill' => $total_bill,
					'memo' => $memo,
					'credithead' => 16,
					'memo' => $memo,
					'transaction_id' => $transaction_id,
					'expense_id' => $expense_id,
					'attachment' => $attachment,
				);
				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Expense_model->update_bank_expense_transaction($args);
				if ($result != NULL)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
						'alert' => 'info',
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Cannot updated',
						'alert' => 'danger',
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty expense !!',
					'alert' => 'danger',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		redirect('expense/bank_expense');
	}
	// Expense/calculate_tax
	function calculate_tax()
	{
		$tax = html_escape($this->input->post('tax_data_arr'));
		$price_arr = html_escape($this->input->post('price_arr'));
		if ($tax != NULL)
		{
			$data['taxes'] = $tax;
			$data['price'] = $price_arr;
			// model name available in admin models folder
			$this->load->view('admin_models/accounts/new_tax_row.php', $data);
		}
	}
	// USED TO DELETE A EXPENSE TRANSACTION
	// Expense/delete_expense
	function delete_expense($id = '')
	{
		if ($id == '')
		{
			redirect('expense');
		}
		$this->load->model('Crud_model');
		$expense_record = $this->Crud_model->fetch_record_by_id('mp_expense', $id);
		$tran_id = $expense_record[0]->transaction_id;
		$this->Crud_model->delete_attr_record('mp_sub_expense', 'expense_id', $id);
		$this->Crud_model->delete_record('mp_expense', $id);
		// DELETING ALL SUB ENTRY
		$this->Crud_model->delete_attr_record('mp_sub_entry', 'parent_id', $tran_id);
		$result = $this->Crud_model->delete_record('mp_generalentry', $tran_id);
		if ($result)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Deleted successfully',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be deleted',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('expense');
	}
}
