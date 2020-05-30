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
class Return_items extends CI_Controller
{
	//Return
	public function index()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES WHICH PAGE TO RENDER
		$data['title'] = 'Return items';

		//CURRENT USER ID
		$user_name = $this->session->userdata('user_id');

		$data['main_view'] = 'return_barcode';

		//FETCHING THE LIST OF CUSTOMERS
		$customer_record = $this->Crud_model->fetch_payee_record('customer','status');

		$data['customer_record'] = $customer_record;

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);

		$data['temp_view'] = 'invoice_return_template';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Return_items/delete_item_temporary
	//USED TO DELETE AN ITEM FROM TEMPORARY TABLE OF BARCODE ITEMS
	function delete_item_temporary($item_id)
	{	

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES TO DELETE THE ROW FROM TABLE AGAINST ID
		$this->Crud_model->delete_record('mp_temp_barcoder_invoice', $item_id);

		//USER ID
		$user_name = $this->session->userdata('user_id');

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE	
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);

		$this->load->view('invoice_return_template.php',$data);
	}

	//Return_items/clear_temp_invoice
	//USED TO CLEAR TEMP INVOICE
	function clear_temp_invoice()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		//GET THE CURRENT USER
		$user_name = $this->session->userdata('user_id');

		$this->Crud_model->delete_record_by_userid('mp_temp_barcoder_invoice','return',$user_name['id']);

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);

		$this->load->view('invoice_return_template.php',$data);
	}

	//Return_items/add_barcode_item
	//USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
	function add_barcode_item($barcode)
	{
		//CURRENT USER ID
		$user_name = $this->session->userdata('user_id');

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

			$result = $this->Crud_model->fetch_attr_record_by_id('mp_productslist','barcode',$barcode);
			if($result != NULL)
			{
				$check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','barcode',$barcode,$user_name['id'],'return');

					if($check_item_in_temp != NULL)
					{
						$qty = '';

						$qty = $check_item_in_temp[0]->qty+1;

						$args = array(
							'table_name' => 'mp_temp_barcoder_invoice',
							'id' => $check_item_in_temp[0]->id
						);

						$data = array(
							'qty' => $qty
						);

						$this->Crud_model->edit_record_id($args, $data);
					}
					else
					{
						$tax_amount = ($result[0]->tax/100)*$result[0]->retail;

						// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
							$args = array(
								'barcode' => $result[0]->barcode,
								'product_no' => $result[0]->sku,
								'product_id' => $result[0]->id,
								'product_name' => $result[0]->product_name,
								'mg' => $result[0]->mg,
								'price' => $result[0]->retail,
								'purchase' => $result[0]->purchase,
								'qty' => 1,
								'tax' => $tax_amount,
								'agentid' => $user_name['id'],
								'source' => 'return'
							);

							// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
							$result = $this->Crud_model->insert_data('mp_temp_barcoder_invoice', $args);
			}

		}

		//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
		$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);

		$this->load->view('invoice_return_template.php',$data);
		//redirect('invoice/pos2');	
	}

	//invoice/add_selected_item
	//USED TO ADD ITEM INTO TEMP INVOICE TABLE USING BARCODE
	function add_selected_item($id,$mode)
	{
		//CURRENT USER ID
		$user_name = $this->session->userdata('user_id');

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		$result = $this->Crud_model->fetch_record_by_id('mp_productslist',$id);

		if($mode == 'single')
		{
			$retail = $result[0]->retail;
			$cost	= $result[0]->purchase;
		}
		else
		{
			$retail = $result[0]->whole_sale;
			$cost	= $result[0]->pack_cost	;
		}

		if($id != '')
		{
			$check_item_in_temp = $this->Crud_model->fetch_attr_record_by_userid_source('mp_temp_barcoder_invoice','product_id',$id,$user_name['id'],'return');

					if($check_item_in_temp != NULL)
					{
						

						$qty = $check_item_in_temp[0]->qty+1;

						$args = array(
							'table_name' => 'mp_temp_barcoder_invoice',
							'id' => $check_item_in_temp[0]->id
						);

						$data = array(
							'qty' => $qty
						);

						$this->Crud_model->edit_record_id($args, $data);
					}
					else
					{
						if($result != NULL)
						{

							$tax_amount = ($result[0]->tax/100)*$result[0]->retail;

							// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
								$args = array(
									'barcode' => $result[0]->barcode,
									'product_no' => $result[0]->sku,
									'product_id' => $result[0]->id,
									'product_name' => $result[0]->product_name,
									'mg' => $result[0]->mg,
									'price' => $retail,
									'purchase' => $cost,
									'qty' => 1,
									'tax' => $tax_amount,
									'agentid' => $user_name['id'],
									'source' => 'return'
								);

								// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
								$result = $this->Crud_model->insert_data('mp_temp_barcoder_invoice', $args);
						}
				}

			//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
			$data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);

			$this->load->view('invoice_return_template.php',$data);
		}
	}

	//invoice/search_result_manual
	//USED TO SEARCH MANUAL ITEMS
	function search_result_manual($search_result)
	{
		if($search_result != NULL)
		{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			$result = $this->Crud_model->search_items_stock($search_result);
			//LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
			$data['search_result'] = $result;
			$this->load->view('search_list.php',$data);
		}
	}

	//invoice/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_customer_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_customer_model.php');
		}
		else if($page_name  == 'edit_invoice_model')
		{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Accounts_model');

			// GET THE ROW FROM DATABASE FROM TABLE ID
			$data['invoice_data'] = $this->Accounts_model->get_by_id("mp_invoices","mp_sales",$param);

			//model name available in admin models folder
			$this->load->view('admin_models/edit_models/edit_invoice_model.php',$data);
		}
	}

	public function add_customer()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES READ MEDICINE details FORM MEDICINE FORM
		$customer_name = html_escape($this->input->post('customer_name'));
		$customer_email = html_escape($this->input->post('customer_email'));
		$customer_address = html_escape($this->input->post('customer_address'));
		$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
		$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
		$customer_company = html_escape($this->input->post('customer_company'));
		$customer_city = html_escape($this->input->post('customer_city'));
		$customer_country = html_escape($this->input->post('customer_country'));
		$customer_description = html_escape($this->input->post('customer_description'));
		$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/customers/");

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'customer_name' => $customer_name,
			'cus_email' => $customer_email,
			'cus_address' => $customer_address,
			'cus_contact_1' => $customer_contatc1,
			'cus_contact_2' => $customer_contact_two,
			'cus_company' => $customer_company,
			'cus_city' => $customer_city,
			'cus_country' => $customer_country,
			'cus_description' => $customer_description,
			'cus_picture' => $picture
		);

		// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
		$email_record_data = $this->Crud_model->check_email_address('mp_customer', 'cus_email', $customer_email);
		if ($email_record_data == NULL)
		{

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$result = $this->Crud_model->insert_data('mp_customer', $args);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Customer added Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Customer cannot be added',
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

		redirect('return_items');
	}
	
	
	//USED TO RETURN ITEMS
	//invoice/return_auto_invoice
	function return_auto_invoice()
	{
		$this->load->model('Transaction_model');
	    $customer_id = html_escape($this->input->post('customer_id'));
		$invoice_id = html_escape($this->input->post('invoice_id'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$bill_cost = html_escape($this->input->post('bill_cost'));
		$bill_paid = html_escape($this->input->post('bill_paid'));
		$mode = html_escape($this->input->post('mode'));
		$discountfield = html_escape($this->input->post('discountfield'));
		$date = date('Y-m-d');
		$user_name = $this->session->userdata('user_id');
		$agent = $user_name['name'];

		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_attr_record_by_id('mp_temp_barcoder_invoice','agentid',$user_name['id']);

		if($result != NULL)
		{

			$data = array(
				'customer_id' 	=> $customer_id,
				'invoice_id' 	=> $invoice_id,
				'return_amount' => $bill_paid,
				'total_bill' 	=> $total_bill,
				'net_cost' 		=> $bill_cost,
				'discount' 		=> $discountfield,
				'date' 			=> $date,
				'agent' 		=> $agent,
				'mode' 			=> $mode
			);

			//LOADING TRASACTION FUNCTION FROM MODEL
			$result = $this->Transaction_model->add_return_items_transaction($data);

			if($result != NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Returned successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be added',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be returned or empty bill no',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
		}

		redirect('return_items');
	}

	//USED TO UPDATE QUANTITY 
    //Return_items/update_qty
    function update_qty($val = '' , $id = '')
    {
      $val = intval($val);
      $this->load->model('Crud_model'); 
      $user_name = $this->session->userdata('user_id');
      if($val != '' AND $id != '' AND  $val > -1)
      {

        $result = $this->Crud_model->fetch_attr_record_by_userid('mp_temp_barcoder_invoice','agentid',$user_name['id'],$id); 
       
        $bal = 0;

        if($result[0]->qty > $val)
        {
          $bal = $result[0]->qty-$val;
         
        }
        else if($result[0]->qty < $val)
        {
           $bal = $val-$result[0]->qty;
        }

        if($result[0]->qty != $val )
        {

              $args = array(
                  'table_name' => 'mp_temp_barcoder_invoice',
                  'id' => $id
                );

              $data = array(
                'qty' => $val
              );

              $this->Crud_model->edit_record_id($args, $data);
        }

      }

       //LOAD FRESH CONTENT AVAILABLE IN TEMP TABLE
        $data['temp_data'] = $this->Crud_model->fetch_userid_source('mp_temp_barcoder_invoice','return',$user_name['id']);
        
        $this->load->view('invoice_return_template.php',$data);
    }

    //USED TO SHOW THE DETAIL OF  RETURN INVOICE 
    //Return_items/return_single_invoice/ID
    function return_single_invoice($return_id)
    {
    	// DEFINES PAGE TITLE
		$data['title'] = 'Return invoice';

		$this->load->model('Accounts_model');
		 
		$data['return_data'] = $this->Accounts_model->fetch_single_return_item($return_id);

    	// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'return_single_invoice';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);


    }

}