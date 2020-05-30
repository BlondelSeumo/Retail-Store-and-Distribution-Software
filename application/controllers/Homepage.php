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
class Homepage extends CI_Controller
{
	// Homepage
	public function index()
	{
		// DEFINES TO LOAD THE CATEGORY RECORD FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$this->load->model('Statement_model');
		$this->load->model('Accounts_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Dashboard';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'product Category List :';

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add New Category';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add New Category';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Category Name';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'dashboard';

		// DIFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Category Name',
			'description',
			'Date',
			'Added By',
			'Status',
			'Action'
		);

		// DEFINES FETCH THE productS RECORD FROM TABLE mp_productslist WITH LIMIT OF ONLY 6 RECORD
		$data['productList_records'] = $this->Crud_model->fetch_limit_record('mp_productslist', 6);

		// DEFINES FETCH THE CUSTOMER RECORD FROM TABLE MP_CUSTOMER WITH LIMIT OF ONLY 8 RECORD
		$data['total_retial_cost'] = $this->Crud_model->result_retail_cost();

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$data['product_Count'] = $this->Crud_model->count_product('mp_productslist', 'status', 0);

		//USED TO SHOW THE LIST OF STOCK SHORTAGE ITEMS DEFINED BY USER
		$data['product_alert_limit'] = $this->Crud_model->fetch_record_product_alert_limit(8);

		//CASH IN HAND
		$data['cash_in_hand'] = $this->Statement_model->count_head_amount_by_id(2);		

		//ACCOUNT RECEIVABLE
		$data['account_recieveble'] = $this->Statement_model->count_head_amount_by_id(4);		

		//CASH IN BANK
		$data['cash_in_bank'] = $this->Statement_model->count_head_amount_by_id(16);		

		//PAYABLES
		$data['payables'] = $this->Statement_model->count_head_amount_by_id(5);		

		//STOCK ALERT
		$data['out_of_stock'] = $this->Accounts_model->out_of_stock();		

		//RETURN AMOUNT 
		$data['amount_return'] = $this->Accounts_model->amount_return();

		//EXPENSE AMOUNT 
		$data['expense_amount'] = $this->Accounts_model->expense_amount();		

		//EXPENSE AMOUNT 
		$data['purchase_amount'] = $this->Accounts_model->purchase_amount();

		$data['recent_accounts'] = $this->Crud_model->recent_accounts();

		//CUSTOMER
		$data['result_customer'] = $this->Crud_model->fetch_payee_record('customer','status');
		
		//CURRENCY 
		$data['currency'] = '( '.$this->Crud_model->fetch_record_by_id('mp_langingpage',1)[0]->currency.' )';

		$data['Sales_today_count'] = $this->Crud_model->count_sales('mp_invoices', date('Y-m-d') , date('Y-m-d'));
		$data['Sales_month_count'] = $this->Crud_model->count_sales('mp_invoices', date('Y-m') . '-1', date('Y-m') . '-30');

		// COUNTING THE TODO LIST FOR THIS MONTH IN Todolist TABLE
		$data['Todos_count'] = $this->Crud_model->count_sales('mp_todolist', date('Y-m') . '-1', date('Y-m') . '-30');

		// AFTER COUNTING FETCHING THE TODO RECORED FROM GIVEN DATE
		$data['result_todo'] = $this->Crud_model->fetch_todo_record('mp_todolist', date('Y-m') . '-1', date('Y-m') . '-30');

		$this->load->model('Accounts_model');
		//COUNT AMOUNT OF SALES TODAY AND EXPENSE
		$data['sales_today_amount'] =  $this->Accounts_model->Statistics_sales_with_date(date('Y-m-d'),date('Y-m-d'));

		$data['sales_month_amount'] = $this->Accounts_model->Statistics_sales_with_date(date('Y-m'.'-1'),date('Y-m'.'-31'));


		// DEFINES TO LOAD THE MODEL Accounts_model
		$this->load->model('Accounts_model');

		// FETCHING THE EXPENSE AND REVENUE FOR GRAPH
		$result_sales_this_year_and_total_profit = $this->Accounts_model->statistics_sales_this_year();
		$data['result_sales_arr'] = json_encode($result_sales_this_year_and_total_profit[0]);
		
		$data['result_profit_this_year'] = json_encode($result_sales_this_year_and_total_profit[1]);
		
		$data['result_expense_this_year'] = json_encode($result_sales_this_year_and_total_profit[2]);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Homepage/sign_out
	public function sign_out()
	{
		$this->session->unset_userdata('user_id');
		redirect('Login');
	}
}