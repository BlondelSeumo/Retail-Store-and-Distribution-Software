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
class Vouchers extends CI_Controller
{
	// Vouchers
	// USED TO GENERATE GENERAL JOURNAL
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Opening balances';
		$this->load->model('Crud_model');
		$data['heads_record'] = $this->Crud_model->fetch_record('mp_head', NULL);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'opening_balance';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Vouchers/open_user_account
	// USED TO OPENIG OF USER ACCOUNT BALANCES
	public function open_user_account()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Account holder balance';

		$this->load->model('Crud_model');

		$data['users'] = $this->Crud_model->fetch_record('mp_payee', NULL);

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'opening_account';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// USED TO GET PAYMENT VOUCHER LIST
	// Vouchers/payments
	public function payments($period = '')

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Debit Vouchers';
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
		$data['table_name'] = 'Debit Vouchers ' . $date1 . ' to ' . $date2;
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Date',
			'Voucher',
			'Account Title',
			'Amount',
			'Description',
			'Action'
		);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'debit_voucher_list';
		$this->load->model('Crud_model');
		$data['vouchers'] = $this->Crud_model->fetch_payment_vouchers($date1, $date2, 0);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GET JOURNAL VOUCHER LIST
	// Vouchers/journal_list
	public function journal_list($period = '')
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Journal Voucher';

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
		$data['table_name'] = 'Journal Voucher from ' . $date1 . ' to ' . $date2;
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Date',
			'Voucher No',
			'Account Title',
			'Amount',
			'Description',
			'Action'
		);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher_list';
		
		$this->load->model('Crud_model');
		$data['vouchers'] = $this->Crud_model->fetch_payment_vouchers($date1, $date2, 2);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GET CREDIT VOUCHER LIST
	// Vouchers/credit_vouchers
	public function credit_vouchers($period = '')

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Credit Vouchers';
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
		$data['table_name'] = 'Credit Vouchers ' . $date1 . ' to ' . $date2;
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Date',
			'Voucher No',
			'Account Title',
			'Amount',
			'Description',
			'Action'
		);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'credit_voucher_list';

		$this->load->model('Crud_model');
		$data['vouchers'] = $this->Crud_model->fetch_payment_vouchers($date1, $date2, 1);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE JOURNAL VOUCHER
	// Vouchers/journal_voucher
	function journal_voucher()
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		
		$to = html_escape($this->input->post('to'));
		
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		
		// DEFINES PAGE TITLE
		$data['title'] = 'Journal voucher';
		
		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();

		$this->load->model('Crud_model');
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		
		// USED TO FETCH PAYEE
		$data['payee_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'journal_voucher';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE PAYMENT VOUCHER
	// Vouchers/debit_voucher
	function debit_voucher()
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Debit voucher';
		// USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'debit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE PAYMENT VOUCHER
	// Vouchers/create_credit_voucher
	function create_credit_voucher()
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Credit voucher';
		// USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		$this->load->model('Statement_model');
		$data['accounts_records'] = $this->Statement_model->chart_list();
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'create_credit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO ADD INTO OPENING BALANCE
	function add_new_balance()
	{
		$account_head = html_escape($this->input->post('account_head'));
		$account_nature = html_escape($this->input->post('account_nature'));
		$amount = html_escape($this->input->post('amount'));
		$date = html_escape($this->input->post('date'));
		$description = html_escape($this->input->post('description'));
		$data = array(
			'head' => $account_head,
			'nature' => $account_nature,
			'amount' => $amount,
			'date' => $date,
			'description' => $description
		);
		$this->load->model('Transaction_model');
		$result = $this->Transaction_model->opening_balance($data);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('vouchers');
	}

	// USED TO ADD INTO ACCOUNT OPENING BALANCE
	function add_new_account_balance()
	{
		$user_account = html_escape($this->input->post('user_account'));
		$account_nature = html_escape($this->input->post('account_nature'));
		$amount = html_escape($this->input->post('amount'));
		$date = html_escape($this->input->post('date'));
		$description = html_escape($this->input->post('description'));
		$data = array(
			'payee_id' => $user_account,
			'nature' => $account_nature,
			'amount' => $amount,
			'date' => $date,
			'description' => $description
		);
		$this->load->model('Transaction_model');
		$result = $this->Transaction_model->new_opening_account_balance($data);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('payee/ledger/'.$user_account);
	}


	// Vouchers/popup
	// DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');
		if ($page_name == 'new_row')
		{
			$this->load->model('Statement_model');
			$data['accounts_records'] = $this->Statement_model->chart_list();
			// model name available in admin models folder
			$this->load->view('admin_models/accounts/new_row.php', $data);
		}
		else if ($page_name == 'new_row_payment')
		{
			$this->load->model('Statement_model');
			$data['accounts_records'] = $this->Statement_model->chart_list();
			// model name available in admin models folder
			$this->load->view('admin_models/accounts/new_pv_row.php', $data);
		}
	}
	// USED TO CREATE JOURNAL ENTRY
	// Statements/create_journal_voucher
	function create_journal_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$date = html_escape($this->input->post('date'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$creditamount = html_escape($this->input->post('creditamount'));
		$total_debit_amount = html_escape($this->input->post('total_debit_amount'));
		$total_credit_amount = html_escape($this->input->post('total_credit_amount'));

		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);
		$status = TRUE;
		for ($i = 0; $i < $count_rows; $i++)
		{
			if ((($debitamount[$i] > 0 AND $creditamount[$i] == 0) OR ($creditamount[$i] > 0 AND $debitamount[$i] == 0)) AND $account_head[$i] != 0)
			{
			}
			else
			{
				$status = FALSE;
			}
		}
		$data = array(
			'payee_id' => $payee_id,
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'total_debit_amount' => $total_debit_amount,
			'total_credit_amount' => $total_credit_amount,
			'voucher_type' => 2
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->journal_voucher_entry($data);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements/journal_voucher');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/journal_voucher');
		}
		redirect('vouchers/journal_list');
	}
	// USED TO CREATE PAYMENT ENTRY
	// Statements/create_payment_voucher
	function create_payment_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$total_credit = 0;
		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);
		$status = TRUE;
		for ($i = 0; $i < $count_rows; $i++)
		{
			if ($debitamount[$i] > 0)
			{
				$total_credit = $total_credit + $debitamount[$i];
			}
			else
			{
				$status = FALSE;
			}
		}
		$data = array(
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'payee_id' => $payee_id,
			'debitamount' => $debitamount,
			'creditamount' => $total_credit,
			'voucher_type' => 0
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->payment_voucher_entry($data);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('vouchers/debit_voucher');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/debit_voucher');
		}
		redirect('vouchers/payments');
	}
	// USED TO CREATE CREDIT ENTRY
	// Statements/save_credit_voucher
	function save_credit_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$total_credit = 0;

		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		
		$count_rows = count($account_head);
		$status = TRUE;
		for ($i = 0; $i < $count_rows; $i++)
		{
			if ($debitamount[$i] > 0)
			{
				$total_credit = $total_credit + $debitamount[$i];
			}
			else
			{
				$status = FALSE;
			}
		}
		$data = array(
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'payee_id' => $payee_id,
			'debitamount' => $debitamount,
			'creditamount' => $total_credit,
			'voucher_type' => 1
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->credit_voucher_entry($data);
			if ($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements/create_credit_voucher');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/create_credit_voucher');
		}
		redirect('vouchers/credit_vouchers');
	}
	// USED TO UPDATE DEBIT VOUCHERS
	// Voucher/update_debit_voucher
	function update_debit_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$transaction_id = html_escape($this->input->post('transaction_id'));
		$total_credit = 0;
		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);
		$status = TRUE;
		for ($i = 0; $i < $count_rows; $i++)
		{
			if ($debitamount[$i] >= 0)
			{
				$total_credit = $total_credit + $debitamount[$i];
			}
			else
			{
				$status = FALSE;
			}
		}
		$data = array(
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'payee_id' => $payee_id,
			'debitamount' => $debitamount,
			'transaction_id' => $transaction_id,
			'creditamount' => $total_credit
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->update_payment_voucher_entry($data);
			if ($result != NULL)
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
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while updating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements/payments');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/payments');
		}
		redirect('vouchers/payments');
	}
	// USED TO UPDATE JOURNAL VOUCHERS
	// Voucher/update_journal_voucher
	function update_journal_voucher()
	{
		$transaction_id = html_escape($this->input->post('transaction_id'));
		$description = html_escape($this->input->post('description'));
		$date = html_escape($this->input->post('date'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$creditamount = html_escape($this->input->post('creditamount'));
		$total_debit_amount = html_escape($this->input->post('total_debit_amount'));
		$total_credit_amount = html_escape($this->input->post('total_credit_amount'));
		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);
		$status = TRUE;
		if ($total_debit_amount == $total_credit_amount)
		{
		}
		else
		{
			$status = FALSE;
		}
		$data = array(
			'transaction_id' => $transaction_id,
			'payee_id' => $payee_id,
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'debitamount' => $debitamount,
			'creditamount' => $creditamount,
			'total_debit_amount' => $total_debit_amount,
			'voucher_type' => 2
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->update_journal_voucher_entry($data);
			if ($result != NULL)
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
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while creating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('vouchers/journal_list');
	}
	// USED TO UPDATE CREDIT VOUCHERS
	// Voucher/update_credit_voucher
	function update_credit_voucher()
	{
		$description = html_escape($this->input->post('description'));
		$payee_id = html_escape($this->input->post('payee_id'));
		$date = html_escape($this->input->post('date'));
		$account_head = html_escape($this->input->post('account_head'));
		$debitamount = html_escape($this->input->post('debitamount'));
		$transaction_id = html_escape($this->input->post('transaction_id'));
		$total_credit = 0;
		if ($date == NULL)
		{
			$date = date('Y-m-d');
		}
		$count_rows = count($account_head);
		$status = TRUE;
		for ($i = 0; $i < $count_rows; $i++)
		{
			if ($debitamount[$i] >= 0)
			{
				$total_credit = $total_credit + $debitamount[$i];
			}
			else
			{
				$status = FALSE;
			}
		}
		$data = array(
			'description' => $description,
			'date' => $date,
			'account_head' => $account_head,
			'payee_id' => $payee_id,
			'debitamount' => $debitamount,
			'transaction_id' => $transaction_id,
			'creditamount' => $total_credit
		);
		if ($status)
		{
			$this->load->model('Transaction_model');
			$result = $this->Transaction_model->update_credit_voucher_entry($data);
			if ($result != NULL)
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
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error while updating',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('statements/credit_vouchers');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Entry must be either a credit or a debit',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('vouchers/credit_vouchers');
		}
		redirect('vouchers/credit_vouchers');
	}
	// vouchers/vouchers_list
	// USED TO LIST THE PAID VOUCERS
	function vouchers_list()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Payment vouchers';
		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Payment vouchers:';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'payment_voucher_list';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Date',
			'Bank',
			'Account',
			'Recieved',
			'Amount',
			'Ref No',
			'Status',
			'Action'
		);
		$date1 = date('Y-m-') . '1';
		$date2 = date('Y-m-') . '31';
		$this->load->model('Accounts_model');
		$data['deposit_list'] = $this->Accounts_model->bank_deposits($date1, $date2);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO UPDATE JOURNAL VOUCHER
	// Voucher/edit_journal_voucher
	function edit_journal_voucher($trans_id)
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Edit journal voucher';
		// USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		$data['voucher_list'] = $this->Crud_model->fetch_record_payment_voucher($trans_id);
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_trans_all($trans_id);
		$data['accounts_records'] = $this->Crud_model->fetch_record('mp_head', NULL);
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_journal_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO UPDATE PAYMENT VOUCHER
	// Voucher/edit_payment_voucber
	function edit_debit_voucher($trans_id)
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Debit voucher';
		// USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		$data['voucher_list'] = $this->Crud_model->fetch_record_payment_voucher($trans_id);
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_trans($trans_id, 0);
		$data['accounts_records'] = $this->Crud_model->fetch_record('mp_head', NULL);
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_debit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO UPDATE CREDIT VOUCHER
	// Voucher/edit_credit_voucher
	function edit_credit_voucher($trans_id)
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$from = date('Y-m-') . '1';
			$to = date('Y-m-') . '31';
		}
		$this->load->model('Crud_model');
		// DEFINES PAGE TITLE
		$data['title'] = 'Credit voucher';
		// USED TO FETCH PAYEE
		$data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
		$data['voucher_list'] = $this->Crud_model->fetch_record_payment_voucher($trans_id);
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_trans($trans_id, 1);
		$data['accounts_records'] = $this->Crud_model->fetch_record('mp_head', NULL);
		$data['default'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_credit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
}