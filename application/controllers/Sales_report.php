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
class Sales_report extends CI_Controller
{
	//Sales_report
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Product and other items sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product and other items sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'sales_report_page';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty/Packs',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		// FECHING VALUES FROM DATE FIELDS
		$first_date = html_escape($this->input->post('date1'));
		$second_date = html_escape($this->input->post('date2'));
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

		$data['date1'] = $first_date;

		$data['date2'] = $second_date;
		

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

			// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
			$data['invoices_record'] = $result_invoices;

			// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
			$data['Sales_collection'] = $collection;

			// print_r($result_invoices);
			// print_r($collection);
			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
		else
		{
			// INCASE OF ERROR OR PAGE NOT FOUND
			// DEFINES WHICH PAGE TO RENDER
			$data['main_view'] = 'main/error_invoices.php';
			$data['actionresult'] = "sales_report/";
			$data['heading1'] = "No sales available. ";
			$data['heading2'] = "Oops! Sorry no sales record available in the given details";
			$data['details'] = "We will work on fixing that right away. Meanwhile, you may return or try using the search form.";

			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
			$this->load->view('main/index.php', $data);
		}
	}

	//Sales_report/brand_sale
	public function brand_sale()
	{	
		$date1 = $this->input->post('date1');

		$date2 = $this->input->post('date2');
		
		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		$data['brand_id'] = html_escape($this->input->post('brand_id'));

		$result_invoices = null;

		// DEFINES PAGE TITLE
		$data['title'] = 'Product with brand wise sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product with brand wise sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'brand_sales';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		$this->load->model('Crud_model');

		
		if ($data['brand_id'] != NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_brandwise('mp_invoices',$data['brand_id'],$date1, $date2);


			$count = 0;
			if($result_invoices != NULL)
			{

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
			}
			
		}
		

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['invoices_record'] = $result_invoices;

		$data['brands_record'] = $this->Crud_model->fetch_record('mp_brand',NULL);

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['Sales_collection'] = $collection;


		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Sales_report/brand_section
	public function brand_section()
	{	

		$date1 = $this->input->post('date1');

		$date2 = $this->input->post('date2');
		
		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		$data['section_id'] = html_escape($this->input->post('section_id'));

		$result_invoices = null;

		// DEFINES PAGE TITLE
		$data['title'] = 'Product with section wise sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product with section wise sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'brand_sections';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		$this->load->model('Crud_model');

		
		if ($data['section_id'] != NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_brandsection('mp_invoices', $data['section_id'],$date1,$date2);


			$count = 0;
			if($result_invoices != NULL)
			{

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
			}
			
		}
		

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['invoices_record'] = $result_invoices;

		$data['brands_record'] = $this->Crud_model->fetch_record('mp_brand_sector',NULL);

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['Sales_collection'] = $collection;


		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	
	//Sales_report/company_wise
	public function company_wise()
	{	
		$date1 = $this->input->post('date1');

		$date2 = $this->input->post('date2');
		

		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		$data['comapany_id'] = html_escape($this->input->post('comapany_id'));

		$result_invoices = null;

		// DEFINES PAGE TITLE
		$data['title'] = 'Product with company wise sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product with company wise sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'company_sales';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		$this->load->model('Crud_model');

		
		if ($data['comapany_id'] != NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_companywise('mp_invoices', $data['comapany_id'],$date1,$date2);

			
		}
		else
		{
			$result_invoices = NULL;
		}
		

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['invoices_record'] = $result_invoices;

		$data['company_record'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee','type','company','');

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['Sales_collection'] = $collection;

		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Sales_report/store_wise
	public function store_wise()
	{	
		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');
	
		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		$data['store_id'] = html_escape($this->input->post('store_id'));

		$result_invoices = null;

		// DEFINES PAGE TITLE
		$data['title'] = 'Product with store wise sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product with store wise sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'store_sales';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		$this->load->model('Crud_model');

		
		if ($data['store_id'] != NULL)
		{

			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_storewise('mp_invoices', $data['store_id'],$date1,$date2);
			

			$count = 0;

			if($result_invoices != NULL)
			{

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
			}
			
		}
		
		

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['invoices_record'] = $result_invoices;

		$data['store_record'] = $this->Crud_model->fetch_record('mp_stores',NULL);

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['Sales_collection'] = $collection;

		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Sales_report/sku_wise
	public function sku_wise()
	{	

		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');
		

		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2; 

		$data['sku_wise'] = html_escape($this->input->post('sku_wise'));

		$result_invoices = null;

		// DEFINES PAGE TITLE
		$data['title'] = 'Product with SKU wise sales report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product with SKU wise sales report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'sku_sales';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Product Name',
			'Weight',
			'Price',
			'Qty',
			'Subtotal'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		$this->load->model('Crud_model');

		
		if ($data['sku_wise'] != NULL)
		{

			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->fetch_record_skuwise('mp_invoices', $data['sku_wise'],$date1,$date2);


			$count = 0;
			
			if($result_invoices != NULL)
			{

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
			}
			
		}
		

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['invoices_record'] = $result_invoices;

		$data['product_record'] = $this->Crud_model->fetch_record('mp_productslist',NULL);

		// ASSIGNING THE FETCHED RECORD OF TABLE TO ARRAY OBJECT TO PRINT IN VIEWS
		$data['Sales_collection'] = $collection;


		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}


	//sales_report/return_item_report
	function return_item_report()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Product and other items return report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Product and other items return report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'product_return';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Invoice ID',
			'Date',
			'Customer Name',
			'Agent',
			'Total Bill',
			'Deduct Disc',
			'Paid Back',
			'Balance',
			'Action'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Accounts_model');

		// FECHING VALUES FROM DATE FIELDS
		$first_date = html_escape($this->input->post('date1'));
		$second_date = html_escape($this->input->post('date2'));

		if ($first_date == NULL OR $second_date == NULL)
		{
			$first_date = date('Y-m-d');
			$second_date = date('Y-m-d');
			
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->return_items_date('mp_return_list', $first_date, $second_date);
		}
		else
		{
			// FETCH SALES RECORD FROM invoices TABLE
			$result_invoices = $this->Accounts_model->return_items_date('mp_return_list', $first_date, $second_date);
		}


		$data['date1'] = $first_date;

		$data['date2'] = $second_date;

		$data['return_data'] = $result_invoices;
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Sales_report/top_customers
	public function top_customers()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Top customers who purchased mostly';

		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');
		

		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Top customers who purchased mostly :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'top_sales_customer';

		

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Customers Name',
			'Contact',
			'Address',
			'Total Purchases',
			'Total Paid'
		);

	
		// DEFINES TO LOAD THE MODEL

		$this->load->model('Crud_model');

		// FETCH SALES RECORD FROM invoices TABLE
		$data['sales_record'] = $this->Crud_model->fetch_top_customers($date1,$date2);
		
		//print_r($data['sales_record']);
		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
		
		
	}

	//Sales_report/top_salesman
	public function top_salesman()
	{
		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');

		if($date1 == NULL OR $date2 == NULL)
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		//DATE 1 
		$data['date1'] = $date1;

		//DATE 2
		$data['date2'] = $date2;

		// DEFINES PAGE TITLE
		$data['title'] = 'Top salesman who sold mostly';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Top salesman who sold mostly :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'top_sales_salesman';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Salesman',
			'Contact',
			'Address',
			'Total Sold'
		);

	
		// DEFINES TO LOAD THE MODEL
		$this->load->model('Crud_model');

		// FETCH SALES RECORD FROM invoices TABLE
		$data['sales_record'] = $this->Crud_model->fetch_top_salesman($date1,$date2);
		
		//print_r($data['sales_record']);
		// print_r($result_invoices);
		// print_r($collection);
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
		
		
	}
}