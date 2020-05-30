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
class Estimate extends CI_Controller
{

	// Estimate
	function index($period = '')
	{

		if($period != '')
		{	
			
			if($period == 'month')
			{

				$date1 = date('Y-m').'-1';
				$date2 = date('Y-m').'-31';
			}
			else if($period == 'three')
			{
				$month = date('m')-2;

				$date1 = date('Y').'-'.$month.'-1';
				$date2 = date('Y-m').'-31';
			}
			else if($period == 'year')
			{
				$year = date('Y');
				
				$date1 = $year.'-1-1';
				$date2 = $year.'-12-31';
			}
			else
			{
				$date1 = date('Y-m').'-1';
				$date2 = date('Y-m').'-31';
			}
		}
		else
		{
			$date1 = html_escape($this->input->post('date1'));
			$date2 = html_escape($this->input->post('date2'));

			if($date1 == "" OR $date2 == "")
			{
				$date1 = date('Y-m').'-1';
				$date2 = date('Y-m').'-31';
			}
		}

		// DEFINES PAGE TITLE
		$data['title'] = 'Estimate List';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Estimate  from '.$date1.' to '.$date2;

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Create Estimate';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Create Estimate';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Estimate';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'estimatelist';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Estimate Id',
			'Date',
			'Expire',
			'Type',
			'Account',
			'Total',
			'Created',
			'Status',
			''
		);

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$data['estimate_record'] = $this->Crud_model->fetch_record_estimate($date1,$date2);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//invoice/add_invoice_form
	function add_estimate_form()
	{
		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Create estimate';

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['product_list'] = $this->Crud_model->fetch_record('mp_product',NULL);

		//DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_payee_record('customer','status');

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'create_estimate';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Estimate/add_estimate
	//USED TO ADD ESTIMATE INTO THE TABLE 
	function add_estimate()
	{
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM

		$payee_id = html_escape($this->input->post('payee_id'));
		$billing_address = html_escape($this->input->post('billing_address'));
		$date = html_escape($this->input->post('date'));
		$expire_date = html_escape($this->input->post('expire_date'));
		$product = html_escape($this->input->post('product'));
		$descriptionarr = html_escape($this->input->post('descriptionarr'));
		$qty = html_escape($this->input->post('qty'));
		$price = html_escape($this->input->post('price'));
		$single_tax = html_escape($this->input->post('single_tax'));
		$total_bill = html_escape($this->input->post('total_bill'));
		$invoicemessage = html_escape($this->input->post('invoicemessage'));
		$memo = html_escape($this->input->post('memo'));
		$status = 0;
		$send_mail 		 = html_escape($this->input->post('send_mail'));

		if(count($product) > 0 AND $total_bill > 0)
		{
			// $picture = html_escape($this->input->post('picture'));
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'payee_id' => $payee_id,
				'billing' => $billing_address,
				'date' => ($date == NULL ? date('Y-m-d') : $date ),
				'expire_date' => ($expire_date == NULL ? date('Y-m-d') : $expire_date ),
				'user' => $added_by,
				'total_bill' => $total_bill,
				'invoicemessage' => $invoicemessage,
				'memo' => $memo
			);

			// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
			$parent_id = $this->Crud_model->insert_data_last_id('mp_estimate',$args);

			for($i= 0; $i < count($product); $i++)
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'estimate_id' => $parent_id,
					'product_id' => $product[$i],
					'description' => $descriptionarr[$i],
					'qty' => $qty[$i],
					'price' => $price[$i],
					'tax' => $single_tax[$i]
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_estimate_sales',$args);
			}

			if ($result != NULL)
			{	
				//SEND EMAIL
				if(isset($send_mail) == 1)
				{		
					$this->sendmail($parent_id,'avoid');
				}
				
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Created Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry cannot created',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty estimate !!',
					'alert' => 'danger'
				);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('estimate');
	}

	//USED TO CHANGE STATUS 
	//Estimate/change_status
	function change_status($status, $estimate_id)
	{
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_estimate',
			'id' => $estimate_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'status' => $status
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Status changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error Status cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('estimate');
	}

	// Estimate/edit_estimate
	function edit_estimate($estiamte_id)
	{

		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Edit estimate';

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['product_list'] = $this->Crud_model->fetch_record('mp_product',NULL);

		//PARENT DATA OF REFUND	
		$data['parent_row'] = $this->Crud_model->fetch_record_by_id('mp_estimate',$estiamte_id);
		
		//CHILD DATA OF REFUND	
		$data['child_row'] = $this->Crud_model->fetch_attr_record_by_id('mp_estimate_sales','estimate_id',$estiamte_id);

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['estiamte_record'] = $this->Crud_model->fetch_record_by_id('mp_estimate',$estiamte_id);

		//DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_payee_record('customer','status');

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_estimate';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Estimate/update_estimate
	//USED TO UPDATE ESTIMATE INTO THE TABLE 
	function update_estimate()
	{
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];
		// DEFINES READ medicine details FORM medicine FORM

		$payee_id 		 = html_escape($this->input->post('payee_id'));
		$billing_address = html_escape($this->input->post('billing_address'));
		$date 			 = html_escape($this->input->post('date'));
		$expire_date	 = html_escape($this->input->post('expire_date'));
		$product 		 = html_escape($this->input->post('product'));
		$descriptionarr  = html_escape($this->input->post('descriptionarr'));
		$qty 			 = html_escape($this->input->post('qty'));
		$price 			 = html_escape($this->input->post('price'));
		$single_tax 	 = html_escape($this->input->post('single_tax'));
		$total_bill 	 = html_escape($this->input->post('total_bill'));
		$invoicemessage  = html_escape($this->input->post('invoicemessage'));
		$memo 			 = html_escape($this->input->post('memo'));
		$estimate_id 	 = html_escape($this->input->post('estimate_id'));
		$status = 0;
		$send_mail 		 = html_escape($this->input->post('send_mail'));


		if(count($product) > 0 AND $total_bill > 0)
		{
			// $picture = html_escape($this->input->post('picture'));
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$data = array(
				'payee_id' => $payee_id,
				'billing' => $billing_address,
				'date' => ($date == NULL ? date('Y-m-d') : $date ),
				'expire_date' => ($expire_date == NULL ? date('Y-m-d') : $expire_date ),
				'total_bill' => $total_bill,
				'invoicemessage' => $invoicemessage,
				'memo' => $memo
			);

			$this->db->where('id',$estimate_id );
        	$this->db->update('mp_estimate',$data);

        	 //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        	$this->db->where(['estimate_id' => $estimate_id]);
        	$this->db->delete('mp_estimate_sales');

			for($i= 0; $i < count($product); $i++)
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
				'estimate_id' => $estimate_id,
				'product_id'  => $product[$i],
				'description' => $descriptionarr[$i],
				'qty' 		  => $qty[$i],
				'price'		  => $price[$i],
				'tax' 		  => $single_tax[$i]
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_estimate_sales',$args);
			}

			if ($result != NULL)
			{
				//SEND EMAIL
				if(isset($send_mail) == 1)
				{		
					$this->sendmail($estimate_id,'avoid');
				}

				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Updated Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Sorry cannot updated',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty estimate !!',
					'alert' => 'danger'
				);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('estimate');
	}

	//USED TO SEND EMAIL 
	function sendmail($estimate_id,$avoid = '')
	{
		$this->load->model('Crud_model');
		
		$this->load->model('Email_model');

		$default_data = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$estimate_data = $this->Crud_model->fetch_record_by_id('mp_estimate',$estimate_id); 

		$user_data = $this->Crud_model->fetch_record_by_id('mp_payee',$estimate_data[0]->payee_id); 

		//MAILING INFO
		$mail_data = array(
	 	'company' 			=> $default_data[0]->companyname, 
	 	'customer_email' 	=> $user_data[0]->cus_email, 
	 	'sender_email' 		=> $default_data[0]->email, 
	 	'title' 			=> 'ESTIMATE NO '.$estimate_id.' '.$default_data[0]->companyname, 
	 	'customer_name' 	=> $user_data[0]->customer_name, 
	 	'title1' 			=> 'TOTAL', 
	 	'balance' 			=> $default_data[0]->currency.' '.$estimate_data[0]->total_bill, 
	 	'title2' 			=> 'EXPIRATION', 
	 	'due_date' 			=> $estimate_data[0]->expire_date, 
	 	'request_no' 		=> $estimate_id, 
	 	'logo' 				=> base_url().'uploads/systemimgs/'.$default_data[0]->logo,
		'button_text' 		=> 'View Estimate',
	 	'type' 				=> 'ESTIMATE NO',
	 	'source' 			=> 'estimate',
	 	'color' 			=> $default_data[0]->primarycolor,
	 	'payee_id' 			=> $estimate_data[0]->payee_id
		);

		$result = $this->Email_model->email_request($mail_data);

		if ($result)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Send successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be Sent',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		if($avoid == '')
		{
			redirect('estimate');
		}
		
	}

	//Estimate/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_product_model')
		{
			$data['redirect_link'] = 'estimate/add_estimate_form';

			$data['income_heads'] = $this->Crud_model->fetch_attr_record_by_id('mp_head','nature','Revenue');

			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_product_model.php',$data);
		}	
		else if ($page_name == 'new_invoice_row')
		{
			$this->load->model('Crud_model');
			// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
			$data['product_list'] = $this->Crud_model->fetch_record('mp_product', NULL);
			// DEFINE TO FETCH THE LIST OF SUPPLIER
			$data['payee_list'] = $this->Crud_model->fetch_payee_record('customer', 'status');
			
			// model name available in admin models folder
			$this->load->view('admin_models/accounts/new_invoice_row.php', $data);
		}	
	}
}