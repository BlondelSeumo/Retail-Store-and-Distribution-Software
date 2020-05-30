<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prints extends CI_Controller
{
	//Prints
	public function index()
	{
		redirect('homepage');
	}


	//Prints/purchase_order 
	//USED TO PRINT PURCHASE DETAILS 
	function purchase_order($order_id)
	{	
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$data['order_data'] = $this->Crud_model->fetch_record_by_id('mp_purchase_order',$order_id); 

		$data['sales_data'] = $this->Crud_model->fetch_attr_record_by_id('mp_subpo_details','estimate_id',$data['order_data'][0]->id); 

		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee',$data['order_data'][0]->payee_id); 

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase order';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/po';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Prints/purchase_receipt 
	//USED TO PRINT PURCHASE DETAILS 
	function purchase_receipt($purchase_id)
	{	
		$this->load->model('Crud_model');

		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$data['single_purchase'] = $this->Crud_model->fetch_record_by_id('mp_purchase',$purchase_id);

		$data['purchase_list'] = $this->Crud_model->fetch_purchase_list($purchase_id);	

		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee',$data['single_purchase'][0]->supplier_id); 

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase receipt';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/purchase_receipt.php';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Prints/purchase_return 
	//USED TO PRINT PURCHASE DETAILS 
	function purchase_return($purchase_id)
	{	
		$this->load->model('Crud_model');

		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$data['single_purchase'] = $this->Crud_model->fetch_record_by_id('mp_purchase',$purchase_id);

		$data['purchase_list'] = $this->Crud_model->fetch_purchase_list($purchase_id);	

		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee',$data['single_purchase'][0]->supplier_id); 

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase return';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/purchase_return.php';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/debit_voucher
	// USED TO PRINT DEBIT VOUCHER DETAILS
	function debit_voucher($transaction_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['receipt_data'] = $this->Crud_model->fetch_single_voucher($transaction_id, 0);
		$data['trans_data'] = $this->Crud_model->get_single_child_trans($data['receipt_data'][0]->transaction_id,0);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['receipt_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Debit Voucher';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/debit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/estimate
	// USED TO PRINT INVOICE DETAILS
	function estimate($estimate_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['estimate_data'] = $this->Crud_model->fetch_record_by_id('mp_estimate', $estimate_id);
		$data['sales_data'] = $this->Crud_model->fetch_product_estimate($estimate_id);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['estimate_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Estimate print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/estimate';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	// USED TO PRINT CHEQUE
	public function cheque($trans_id)
	{
		$this->load->model('Crud_model');
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_cheque($trans_id, 0);
		// DEFINES PAGE TITLE
		$data['title'] = 'Print cheque';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/cheque';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/sales
	// USED TO PRINT SALES DETAILS
	function sales($sales_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['receipt_data'] = $this->Crud_model->fetch_record_by_id('mp_sales_receipt', $sales_id);
		$data['sales_data'] = $this->Crud_model->fetch_product_sales($sales_id);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['receipt_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Sales print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/sales';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	// Prints/creditnote
	// USED TO PRINT CREDIT NOTE DETAILS
	function creditnote($credit_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['credit_data'] = $this->Crud_model->fetch_record_by_id('mp_credit_note', $credit_id);
		$data['sales_data'] = $this->Crud_model->fetch_product_credit($credit_id);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['credit_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Credit print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/credit_note';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	
	// USED TO PRINT DEPOSIT
	public function deposit($trans_id)
	{
		$this->load->model('Crud_model');
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_cheque($trans_id, 1);
		// DEFINES PAGE TITLE
		$data['title'] = 'Deposit';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/deposit';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/journal_voucher
	// USED TO PRINT JOURNAL VOUCHER DETAILS
	function journal_voucher($transaction_id,$v_id = 2)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['receipt_data'] = $this->Crud_model->fetch_single_voucher($transaction_id, $v_id);
		
		$data['trans_data'] = $this->Crud_model->get_single_child_trans($data['receipt_data'][0]->transaction_id,'');
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['receipt_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Journal Voucher';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/journal_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// USED TO PRINT CREDIT VOUCHER DETAILS
	function credit_voucher($transaction_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['receipt_data'] = $this->Crud_model->fetch_single_voucher($transaction_id, 1);
		$data['trans_data'] = $this->Crud_model->get_single_child_trans($data['receipt_data'][0]->transaction_id, 1);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['receipt_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Credit Voucher';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/credit_voucher';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// USED TO PRINT DEPOSIT
	public function bank_collection($trans_id)

	{
		$this->load->model('Crud_model');
		// USED TO FETCH BANK TRANSACTION
		$data['trans_data'] = $this->Crud_model->get_single_bank_collection($trans_id, 1);
		// DEFINES PAGE TITLE
		$data['title'] = 'Bank Collection';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/bank_collection';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/expense
	// USED TO PRINT EXPENSE DETAILS
	function expense($expense_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['expense_data'] = $this->Crud_model->fetch_record_by_id('mp_expense', $expense_id);
		$data['sales_data'] = $this->Crud_model->fetch_product_expense($expense_id);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['expense_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Expense print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Prints/invoice
	// USED TO PRINT INVOICE DETAILS
	function invoice_print($invoice_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		
		$data['invoice_data'] = $this->Crud_model->fetch_record_by_id('mp_invoices', $invoice_id);
		
		$data['sales_data'] = $this->Crud_model->fetch_product_invoice($invoice_id);


		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['invoice_data'][0]->cus_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Sales print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/invoice';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	// Prints/bank_expense
	// USED TO PRINT BANK EXPENSE DETAILS
	function bank_expense($expense_id)
	{
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
		$data['expense_data'] = $this->Crud_model->fetch_record_by_id('mp_expense', $expense_id);
		$data['transaction'] = $this->Crud_model->fetch_attr_record_by_id('mp_bank_transaction', 'transaction_id', $data['expense_data'][0]->transaction_id);
		$data['bank_data'] = $this->Crud_model->fetch_record_by_id('mp_banks', $data['transaction'][0]->bank_id);
		$data['sales_data'] = $this->Crud_model->fetch_product_expense($expense_id);
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee', $data['expense_data'][0]->payee_id);
		// DEFINES PAGE TITLE
		$data['title'] = 'Expense print';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/bank_expense';
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	public function transaction($tran_id)

	{
		$this->load->model('Crud_model');
		$transa_data = $this->Crud_model->fetch_record_by_id('mp_generalentry', $tran_id);
		$source = $transa_data[0]->generated_source;
		// FIND THE SOURCE AND GETTING THE ID
		if ($source == 'sales_receipt')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_sales_receipt', 'transaction_id', $tran_id);
			$this->sales($result[0]->id);
		}
		else if ($source == 'refund_receipt')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_refund', 'transaction_id', $tran_id);
			$this->refund($result[0]->id);
		}
		else if ($source == 'credit_note')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_credit_note', 'transaction_id', $tran_id);
			$this->creditnote($result[0]->id);
		}
		else if ($source == 'expense')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_expense', 'transaction_id', $tran_id);
			$this->expense($result[0]->id);
		}
		else if ($source == 'bank_expense')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_expense', 'transaction_id', $tran_id);
			$this->bank_expense($result[0]->id);
		}
		else if ($source == 'received_payments')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_payee_payments', 'transaction_id', $tran_id);
			$this->receive_receipt($result[0]->id);
		}
		else if ($source == 'pos')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_invoices', 'transaction_id', $tran_id);
			$this->invoice_print($result[0]->id);
		}
		else if ($source == 'cheque')
		{
			$this->cheque($tran_id);
		}
		else if ($source == 'deposit')
		{
			$this->deposit($tran_id);
		}
		else if ($source == 'journal_voucher')
		{
			$this->journal_voucher($tran_id,2);
		}
		else if ($source == 'Opening_balance'  )
		{
			$this->journal_voucher($tran_id,3);
		}
		else if ($source == 'credit_voucher')
		{
			$this->credit_voucher($tran_id);
		}
		else if ($source == 'debit_voucher')
		{
			$this->debit_voucher($tran_id);
		}
		else if ($source == 'create_purchases')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_purchase', 'transaction_id', $tran_id);
			$this->purchase_receipt($result[0]->id);
		}
		else if ($source == 'purchases_return')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_purchase', 'transaction_id', $tran_id);
			$this->purchase_return($result[0]->id);
		}
		else if ($source == 'bank_collection')
		{
			$this->bank_collection($tran_id);
		}
		else if ($source == 'return_pos')
		{
			$result = $this->Crud_model->fetch_attr_record_by_id('mp_return', 'transaction_id', $tran_id);
			
			redirect(base_url('return_items/return_single_invoice/').$result[0]->id);
		}
	}
}	