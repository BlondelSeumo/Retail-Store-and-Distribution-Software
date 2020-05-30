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
class Services extends CI_Controller
{	
	// Product
	public function index()

	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Service List';
		// DEFINES NAME OF TABLE HEADING

		$data['table_name'] = 'Services :';
		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'service';
		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Name',
			'Price / Rate',
			'Tax',
			'Account',
			'Type',
			'',
		);
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_product_records();
		$data['productlist'] = $result;
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
	// Product/add_product
	public function add_product()

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$product_name = $this->input->post('product_name');
		$description = html_escape($this->input->post('description'));
		$product_type = html_escape($this->input->post('product_type'));
		$price = html_escape($this->input->post('price'));
		$income_account = html_escape($this->input->post('income_account'));
		$sales_tax = html_escape($this->input->post('sales_tax'));
		$redirect_link = html_escape($this->input->post('redirect_link'));
		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'product_name' => $product_name,
			'description' => $description,
			'type' => $product_type,
			'price' => $price,
			'cost' => 0,
			'head_id' => $income_account,
			'sale_tax' => $sales_tax,
		);
		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Crud_model->insert_data('mp_product', $args);
		if ($result != NULL)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot be added',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect($redirect_link);
	}
	// services/delete
	public function delete($args)

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_product', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"/> Record removed',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('services');
	}
	// product/edit_product
	public function edit_product()

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$product_id = $this->input->post('product_id');
		$product_name = $this->input->post('product_name');
		$description = html_escape($this->input->post('description'));
		$product_type = html_escape($this->input->post('product_type'));
		$price = html_escape($this->input->post('price'));
		$cost_price = html_escape($this->input->post('cost_price'));
		$income_account = html_escape($this->input->post('income_account'));
		$sales_tax = html_escape($this->input->post('sales_tax'));
		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$data = array(
			'product_name' => $product_name,
			'description' => $description,
			'price' => $price,
			'cost' => $cost_price,
			'type' => $product_type,
			'head_id' => $income_account,
			'sale_tax' => $sales_tax,
		);
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_product',
			'id' => $product_id,
		);
		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Service editted',
				'alert' => 'info',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Service cannot be Editted',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('services');
	}
	// Product/popup
	// DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '', $param = '')
	{
		$this->load->model('Crud_model');
		if ($page_name == 'add_product_model')
		{
			$data['redirect_link'] = 'services';

			$data['income_heads'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Revenue');
			// model name available in admin models folder
			$this->load->view('admin_models/add_models/add_product_model.php', $data);
		}
		else if ($page_name == 'edit_product_model')
		{
			$data['single_product'] = $this->Crud_model->fetch_record_by_id('mp_product', $param);
			
			$data['income_heads'] = $this->Crud_model->fetch_attr_record_by_id('mp_head', 'nature', 'Revenue');
			// model name available in admin models folder
			$this->load->view('admin_models/edit_models/edit_product_model.php', $data);
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
}
