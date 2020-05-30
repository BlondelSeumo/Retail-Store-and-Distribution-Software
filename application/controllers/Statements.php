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
class Statements extends CI_Controller
{	
	// Statements
	// USED TO GENERATE GENERAL JOURNAL
	public function index()

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'General Journal';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'generaljournal';
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL AND $to == NULL)
		{
			$this->load->model('Crud_model');
			$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
			$from = date('Y-' . $result[0]->startmonth . '-' . $result[0]->startday);
			$to = date('Y-' . $result[0]->endmonth . '-' . $result[0]->endday);
		}
		$this->load->model('Statement_model');
		$data['transaction_records'] = $this->Statement_model->fetch_transasctions($from, $to);
		$data['from'] = $from;
		$data['to'] = $to;
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	// Statements/bank_reconciliation
	// USED TO BANK RECONCILIATION STATEMENT
	public function bank_reconciliation()

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Bank reconciliation';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'bank_reconciliation';
		$month = html_escape($this->input->post('month'));
		$bank_id = html_escape($this->input->post('bank_id'));
		$this->load->model('Crud_model');
		if ($month == NULL)
		{
			$month = date('m');
			$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		}
		$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
		if ($bank_id == NULL AND $data['bank_list'] != NULL)
		{
			$bank_id = $data['bank_list'][0]->id;
		}
		$datelast = date('Y') . '-' . $month . '-31';
		
		$data['bank_total'] = $this->Crud_model->count_bank_amount(16, $datelast, $bank_id);

		$data['bank_detail'] = $this->Crud_model->fetch_record_by_id('mp_banks', $bank_id);
		// NOT DEPOSITED AMOUNT
		$data['not_deposits'] = $this->Crud_model->fetch_bank_record($month, $bank_id, 'recieved');
		// OUT STANDING CHECKS
		$data['out_standing'] = $this->Crud_model->fetch_bank_record($month, $bank_id, 'paid');
		// BANK EXPENSE DETAILS
		$data['bank_expense'] = $this->Crud_model->fetch_bank_expense($month, $bank_id);
		// BANK PROFIT AND COLLECTIONS DETAILS
		$data['bank_profit'] = $this->Crud_model->fetch_bank_profit($month, $bank_id);
		switch ($month)
		{
		case 1:
			$data['period'] = 'Jan, ' . date('Y');
			break;

		case 2:
			$data['period'] = 'Feb, ' . date('Y');
			break;

		case 3:
			$data['period'] = 'March, ' . date('Y');
			break;

		case 4:
			$data['period'] = 'April, ' . date('Y');
			break;

		case 5:
			$data['period'] = 'May, ' . date('Y');
			break;

		case 6:
			$data['period'] = 'June, ' . date('Y');
			break;

		case 7:
			$data['period'] = 'July, ' . date('Y');
			break;

		case 8:
			$data['period'] = 'Aug, ' . date('Y');
			break;

		case 9:
			$data['period'] = 'Sep, ' . date('Y');
			break;

		case 10:
			$data['period'] = 'Oct, ' . date('Y');
			break;

		case 11:
			$data['period'] = 'Nov, ' . date('Y');
			break;

		case 12:
			$data['period'] = 'Dec, ' . date('Y');
			break;

		default:
			$data['period'] = '';
		}
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE LEDGER ACCOUNTS
	// Statements/general_journal
	function ledger_accounts()
	{
		// $ledger
		$from = html_escape($this->input->post('from'));
		$to = html_escape($this->input->post('to'));
		if ($from == NULL OR $to == NULL)
		{
			$this->load->model('Crud_model');
			$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
			$from = date('Y-' . $result[0]->startmonth . '-' . $result[0]->startday);
			$to = date('Y-' . $result[0]->endmonth . '-' . $result[0]->endday);
		}
		$data['from'] = $from;
		$data['to'] = $to;
		// DEFINES PAGE TITLE
		$data['title'] = 'General Ledger';
		$this->load->model('Crud_model');
		$this->load->model('Statement_model');
		$data['ledger_records'] = $this->Statement_model->the_ledger($from, $to);
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'ledger';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE TRAIL BALANCE
	// Statements/trail_balance
	public function trail_balance()

	{
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$financial_end = '-' . $result[0]->endmonth . '-' . $result[0]->endday;
		$year = html_escape($this->input->post('year'));
		if ($year == NULL)
		{
			$year = date('Y') . $financial_end;
		}
		else
		{
			$year = $year . $financial_end;
		}
		$data['year'] = $year;
		// DEFINES PAGE TITLE
		$data['title'] = 'Trial Balance';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'trail_balance';
		$this->load->model('Statement_model');
		$data['trail_records'] = $this->Statement_model->trail_balance($year);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE INCOME STATEMENT
	public function income_statement()

	{
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$from = '-' . $result[0]->startmonth . '-' . $result[0]->startday;
		$to = '-' . $result[0]->endmonth . '-' . $result[0]->endday;
		$year = html_escape($this->input->post('year'));
		if ($year == NULL)
		{
			$startyear = date('Y') . $from;
			$endyear = date('Y') . $to;
		}
		else
		{
			$startyear = $year . $from;
			$endyear = $year . $to;
		}
		$data['from'] = $startyear;
		$data['to'] = $endyear;
		// DEFINES PAGE TITLE
		$data['title'] = 'Income statement';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'incomestatement';
		$this->load->model('Statement_model');
		$data['income_records'] = $this->Statement_model->income_statement($startyear, $endyear);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// USED TO GENERATE BALANCE SHEET
	public function balancesheet()

	{
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$financial_end = '-' . $result[0]->endmonth . '-' . $result[0]->endday;
		$endyear = html_escape($this->input->post('year'));
		if ($endyear == NULL)
		{
			$endyear = date('Y') . $financial_end;
		}
		else
		{
			$endyear = $endyear . $financial_end;
		}
		$data['to'] = $endyear;
		// DEFINES PAGE TITLE
		$data['title'] = 'Balance sheet';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'balancesheet';
		$this->load->model('Statement_model');
		$data['balance_records'] = $this->Statement_model->balancesheet($endyear);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
}
