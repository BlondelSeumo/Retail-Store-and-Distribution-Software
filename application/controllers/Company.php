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
class Company extends CI_Controller
{
	// Company
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Company List';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Company List :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'company';

		// DEFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Name',
			'Email',
			'Address',
			'Contact',
			'Logo',
			'Status',
			'Action'
		);
		
		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_attr_record_by_id('mp_payee','type','company');
		$data['comapny_list'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	

	//	Company/add_company
	public function add_company()
	{
			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// DEFINES READ MEDICINE details FORM MEDICINE FORM
			$customer_name = html_escape($this->input->post('customer_name'));
			$customer_email = html_escape($this->input->post('customer_email'));
			$customer_cnic = html_escape($this->input->post('customer_cnic'));
			$customer_address = html_escape($this->input->post('customer_address'));
			$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
			$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
			$customer_description = html_escape($this->input->post('customer_description'));
			$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/company/");

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$args = array(
				'customer_name' => $customer_name,
				'cus_email' => $customer_email,
				'cus_address' => $customer_address,
				'cus_contact_1' => $customer_contatc1,
				'cus_contact_2' => $customer_contact_two,
				'cus_description' => $customer_description,
				'cus_date' => date('Y-m-d'),
				'cus_picture' => $picture,
				'customer_nationalid' => $customer_cnic,
				'type' => 'company'
			);

			// CHECK WEATHER EMAIL ADLREADY EXISTS OR NOT IN THE TABLE
			$email_record_data = $this->Crud_model->check_email_address('mp_payee', 'cus_email', $customer_email);

			if ($email_record_data == NULL)
			{
				// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
				$result = $this->Crud_model->insert_data('mp_payee',$args);
				if ($result != NULL)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Company added Successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error company cannot be added',
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
		redirect('company');
	}

	// Company/delete
	public function delete($args)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
		$this->Crud_model->delete_image('./uploads/supplier/', $args, 'mp_payee');
		$result = $this->Crud_model->delete_record('mp_payee', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"/> company record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Error company record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('company');
	}

	// Company/edit
	public function edit()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');

			// DEFINES READ MEDICINE details FORM MEDICINE FORM
			echo $edit_company_id = html_escape($this->input->post('edit_company_id'));
			$customer_name = html_escape($this->input->post('customer_name'));
			$customer_email = html_escape($this->input->post('customer_email'));
			$customer_cnic = html_escape($this->input->post('customer_cnic'));
			$customer_type = html_escape($this->input->post('customer_type'));
			$customer_address = html_escape($this->input->post('customer_address'));
			$customer_contatc1 = html_escape($this->input->post('customer_contatc1'));
			$customer_contact_two = html_escape($this->input->post('customer_contact_two'));
			$customer_company = html_escape($this->input->post('customer_company'));
			$customer_region = html_escape($this->input->post('customer_region'));
			$customer_town = html_escape($this->input->post('customer_town'));
			$customer_description = html_escape($this->input->post('customer_description'));
			$picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/company/");

			$upload_data = $this->upload->data();
	  		$file_name =   $upload_data['file_name'];

			// TABLENAME AND ID FOR DATABASE ACTION
			$args = array(
				'table_name' => 'mp_payee',
				'id' => $edit_company_id
			);

			// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
			// DEFINES IF NO IMAGES IS SELECTED SO PRIVIOUS PICTURE REMAINS SAME
			if ($picture == "default.jpg")
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$data = array(
					'customer_name' => $customer_name,
					'cus_email' => $customer_email,
					'customer_nationalid' => $customer_cnic,
					'cus_address' => $customer_address,
					'cus_contact_1' => $customer_contatc1,
					'cus_contact_2' => $customer_contact_two,
					'cus_company' => $customer_company,
					'cus_region' => $customer_region,
					'cus_town' => $customer_town,
					'cus_description' => $customer_description,
					'cus_type' => $customer_type,
					'cus_date' => date('Y-m-d'),
					'type' => 'company'
				);
			}
			else
			{
				// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
				$data = array(
					'customer_name' => $customer_name,
					'cus_email' => $customer_email,
					'customer_nationalid' => $customer_cnic,
					'cus_address' => $customer_address,
					'cus_contact_1' => $customer_contatc1,
					'cus_contact_2' => $customer_contact_two,
					'cus_company' => $customer_company,
					'cus_region' => $customer_region,
					'cus_town' => $customer_town,
					'cus_description' => $customer_description,
					'cus_type' => $customer_type,
					'cus_date' => date('Y-m-d'),
					'cus_picture' => $picture,
					'type' => 'company'
				);

				// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
				$this->Crud_model->delete_image('./uploads/company/', $edit_customer_id, 'mp_payee');
			}

			// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
			$result = $this->Crud_model->edit_record_id($args, $data);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Company Editted',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Company cannot be editted',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}

		redirect('company');
	}

	// company/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_payee',	
			'id' => $id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'cus_status' => $status
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

		redirect('company');
	}

	//supplier/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_company_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_company_model.php');
		}
		else if($page_name  == 'edit_company_model')
		{
			$data['single_company'] = $this->Crud_model->fetch_record_by_id('mp_payee',$param);

			//model name available in admin models folder
			$this->load->view( 'admin_models/edit_models/edit_company_model.php',$data);
		}		
		else if($page_name  == 'add_supplier_payment_model')
		{
			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier',NULL);
			
			$this->load->view( 'admin_models/add_models/add_supplier_payment_model.php',$data);
		}		
		else if($page_name  == 'edit_supplier_payment')
		{
			//DEFINES TO FETCH THE LIST OF BANK ACCOUNTS 
			$data['bank_list'] = $this->Crud_model->fetch_record('mp_banks','status');

			$data['supplier_list'] = $this->Crud_model->fetch_payee_record('supplier',NULL);

			$data['supplier_payments'] = $this->Crud_model->fetch_record_by_id('mp_supplier_payments',$param );
			
			$this->load->view( 'admin_models/edit_models/edit_supplier_payment.php',$data);
		} 
		
	}

	
}