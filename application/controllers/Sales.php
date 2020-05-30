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
class Sales extends CI_Controller
{
	// invoice
	public function index()
	{
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_productslist
		$this->load->model('Crud_model');

		// DEFINES PAGE invoice NUMBER
		$invoice = $this->Crud_model->fetch_last_record("mp_invoices");
		$value = $invoice[0]->id;
		$data['invoice'] = $value + 1;

		// DEFINES BUTTON NAME TO generate PDF FILE invoice
		// DEFINES THE TITLE NAME OF THE SUBMIT BUTTON
		$data['page_submit_button_name'] = 'Submit Payment';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'sales_invoices';
		$medicine_record = $this->Crud_model->fetch_record_medicine(0);
		$data['medicine_record_list'] = $medicine_record;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//	invoice/add_invoice
	public function add_invoice()
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$todays_date = date('Y-m-d');
		$args = array(
			'date' => $todays_date
		);

		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$last_id = $this->Crud_model->insert_data_last_id('mp_invoices', $args);
		if ($last_id == "error")
		{
		}
		else
		{

			// DEFINES TO CALCULATE THAT HOW MUCH THE LOOP SHOULD ITERATE
			$medicine_name = html_escape($this->input->post('medicine_name'));
			$medicine_category = html_escape($this->input->post('medicine_category'));
			$medicine_weight = html_escape($this->input->post('medicine_weight'));
			$medicine_price = html_escape($this->input->post('medicine_price'));
			$medicine_quantity = html_escape($this->input->post('medicine_quantity'));
			$discountfield = html_escape($this->input->post('discountfield'));
			$i = 0;
			while ($i < count($medicine_name))
			{

				// GETTING THE VALUES FROM TEXTFIELD .THE ARRAYS OF VALUES WHICH WE CREATED
				// BY USING DOM
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
				$args = array(
					'order_id' => $last_id,
					'product_name' => $medicine_name[$i],
					'product_category' => $medicine_category[$i],
					'mg' => $medicine_weight[$i],
					'price' => $medicine_price[$i],
					'qty' => $medicine_quantity[$i],
					'discount' => $discountfield
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_sales', $args);
				$i++;
			}

			if ($result == TRUE)
			{

				// PASSING ARRAY OF VALUES RECIEVED FROM TEXTBOX TO generate PRINT
				$data['medicine_name'] = $medicine_name;
				$data['medicine_category'] = $medicine_category;
				$data['medicine_price'] = $medicine_price;
				$data['medicine_quantity'] = $medicine_quantity;
				$data['discountfield'] = $discountfield;
				$data['medicine_weight'] = $medicine_weight;

				// DEFINES WHICH PAGE TO RENDER
				$data['main_view'] = 'invoice_print';

				// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
				$this->load->view('main/index.php', $data);

				// redirect('invoice/');
			}
			else
			{
				echo "Error";
			}
		}
	}
}