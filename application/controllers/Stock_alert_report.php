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
class Stock_alert_report extends CI_Controller
{
	// Stock_alert_report
	public function index()
	{

		// DEFINES PAGE TITLE
		$data['title'] = 'Out of stock report';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Out of stock report :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'stock_alert_report';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Sno',
			'Product Name',
			'Weight',
			'Quantity',
			'Min level',
			'Retail',
			'Pending'
		);
		$collection = array();

		// DEFINES TO LOAD THE MODEL
		$this->load->model('Crud_model');

	   // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$product_record = $this->Crud_model->fetch_record_product_alert();

		$data['product_record_list'] = $product_record;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
		
	}

	//Stock_alert_report/popup
	 //DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');
		if($page_name  == 'add_stock_model')
		{
		   // PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		   $product_record = $this->Crud_model->fetch_record_product(0);
		   $data['product_record_list'] = $product_record;
		   //model name available in admin models folder
		   $this->load->view( 'admin_models/add_models/add_stock_model.php',$data);
		} 
	 }
}