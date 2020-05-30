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
class Purchase_order extends CI_Controller
{
	// Purchase_order
	function index()
	{

		$date1 = html_escape($this->input->post('date1'));
		$date2 = html_escape($this->input->post('date2'));

		if($date1 == "" OR $date2 == "")
		{
			$date1 = date('Y-m').'-1';
			$date2 = date('Y-m').'-31';
		}

		// DEFINES PAGE TITLE
		$data['title'] = 'PO List';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'PO  from '.$date1.' to '.$date2;

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Create PO';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Create PO';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save PO';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'polist';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'PO Id',
			'Date',
			'Expire',
			'Type',
			'Customer',
			'Total',
			'Created',
			'Status',
			''
		);

		// PARAMETER 0 MEANS ONLY FETCH THAT RECORD WHICH IS VISIBLE 1 MEANS FETCH ALL
		$this->load->model('Crud_model');
		$data['estimate_record'] = $this->Crud_model->fetch_record_po($date1,$date2);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Prints/estimate 
	//USED TO PRINT INVOICE DETAILS 
	function estimate($estimate_id)
	{	
		$this->load->model('Crud_model');
		$data['default_data'] = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$data['estimate_data'] = $this->Crud_model->fetch_record_by_id('mp_purchase_order',$estimate_id); 

		$data['sales_data'] = $this->Crud_model->fetch_product_estimate($estimate_id); 		
		
		$data['user_data'] = $this->Crud_model->fetch_record_by_id('mp_payee',$data['estimate_data'][0]->payee_id); 

		// DEFINES PAGE TITLE
		$data['title'] = 'Purchase Order print';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'print/estimate';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Purchase_order/add_invoice_form
	function add_estimate_form()
	{
		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Create purchase order';

		//DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_record('mp_payee',NULL);

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'create_purchase_order';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Purchase_order/add_estimate
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
			$parent_id = $this->Crud_model->insert_data_last_id('mp_purchase_order',$args);

			for($i= 0; $i < count($product); $i++)
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
					'estimate_id' => $parent_id,
					'product_id' => $product[$i],
					'description' => $descriptionarr[$i],
					'qty' => $qty[$i],
					'price' => $price[$i]
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_subpo_details',$args);
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
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty PO !!',
					'alert' => 'danger'
				);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('Purchase_order');
	}

	//USED TO CHANGE STATUS 
	//Estimate/change_status
	function change_status($status, $estimate_id)
	{
		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_purchase_order',
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

		redirect('purchase_order');
	}

	// Purchase_order/edit_purchase_order
	function edit_purchase_order($order_id)
	{

		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Edit purchase order';

		//PARENT DATA OF REFUND	
		$data['parent_row'] = $this->Crud_model->fetch_record_by_id('mp_purchase_order',$order_id);
		
		//CHILD DATA OF REFUND	
		$data['child_row'] = $this->Crud_model->fetch_attr_record_by_id('mp_subpo_details','estimate_id',$order_id);

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_supplier
		$data['estiamte_record'] = $this->Crud_model->fetch_record_by_id('mp_purchase_order',$order_id);

		//DEFINE TO FETCH THE LIST OF SUPPLIER
		$data['payee_list'] = $this->Crud_model->fetch_record('mp_payee',NULL);

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'edit_po';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Estimate/update_po
	//USED TO UPDATE PURCHASE ORDER INTO THE TABLE 
	function update_po()
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
        	$this->db->update('mp_purchase_order',$data);

        	 //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        	$this->db->where(['estimate_id' => $estimate_id]);
        	$this->db->delete('mp_subpo_details');

			for($i= 0; $i < count($product); $i++)
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$args = array(
				'estimate_id' => $estimate_id,
				'product_id'  => $product[$i],
				'description' => $descriptionarr[$i],
				'qty' 		  => $qty[$i],
				'price'		  => $price[$i]
				
				);

				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_subpo_details',$args);
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
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty purchase_order !!',
					'alert' => 'danger'
				);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('purchase_order');
	}

	//USED TO SEND EMAIL 
	function sendmail($estimate_id,$avoid = '')
	{
		$this->load->model('Crud_model');
		
		$this->load->model('Email_model');

		$default_data = $this->Crud_model->fetch_record_by_id('mp_langingpage',1); 

		$estimate_data = $this->Crud_model->fetch_record_by_id('mp_purchase_order',$estimate_id); 

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
			redirect('purchase_order');
		}
		
	}
}