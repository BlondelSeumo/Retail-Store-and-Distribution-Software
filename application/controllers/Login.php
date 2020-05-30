<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		/* cache control */
		$this->output->set_header('X-Frame-Options: SAMEORIGIN');
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Sun, 14 Aug 1997 05:00:00 GMT");
	}

	// Login
	public function index()
	{
		$user_data= $this->session->userdata('user_id');
		
		//CHECK WEATHER HAS ALREADY SESSION CREATED OR NOT
		if($user_data == NULL)
		{
			// DEFINES PAGE TITLE
			$data['title'] = 'Medicine Login';

			// DEFINES PAGE TITLE
			$data['page_title_model_button_Signin'] = 'Sign in';

			// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
			$data['page_add_button_name'] = 'Add New Login';

			// DEFINES WHICH PAGE TO RENDER
			$this->load->view('login', $data);
		}
		else
		{
			redirect('homepage');
		}
	}

	// Login/authentication
	public function authentication()
	{

		// DEFINES READ CATEROTY NAME FORM Login FORM
			$user_email = html_escape($this->input->post('user_email'));
		    $user_password = html_escape($this->input->post('user_password'));
		if (!empty($user_email) && !empty($user_password))
		{

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			$result = $this->Crud_model->authenticate_user($user_email, $user_password);
			if ($result == NULL)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Incorrect Email or Password',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('login');
			}
			else
			{
				$userdata = array(
					'id' => $result[0]->id,
					'name' => $result[0]->user_name
				);
				$this->session->set_userdata('user_id', $userdata);
				$this->session->userdata('user_id');
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Login  Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('homepage');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Enter Email & Password',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('login');
		}
	}

	// Login/authentication_User
	public function authentication_user()
	{

		// DEFINES READ CATEROTY NAME FORM Login FORM
		$user_email = html_escape($this->input->post('user_email'));
		$user_password = html_escape($this->input->post('user_password'));
		if (!empty($user_email) && !empty($user_password))
		{

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			$result = $this->Crud_model->authenticate_panel_user($user_email, $user_password);
			if ($result === FALSE)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Invalid Credentials',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('main');
			}
			else
			{
				$userdata = array(
					'id' => $result[0]->id,
					'name' => $result[0]->customer_name
				);
				$this->session->set_userdata('userPanel_Id', $userdata);
				$this->session->userdata('userPanel_Id');
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Login  Successfully',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
				redirect('userpanel');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Enter Email & Password',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('main');
		}
	}

	//USED TO RECOVER PASSWORDS
	//Login/recover_password
	function recover_password_user()
	{
		// DEFINES READ CATEROTY NAME FORM Login FORM
		$user_email = html_escape($this->input->post('user_email'));
		$user_code = html_escape($this->input->post('user_code'));	
		$user_password = html_escape($this->input->post('user_password'));	
		$user_cpassword = html_escape($this->input->post('user_cpassword'));
		
		
		if (!empty($user_password) && !empty($user_cpassword))
		{

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			$result_data = $this->Crud_model->fetch_forget_password_user($user_email,$user_code);

			if ($result_data != NULL)
			{
				
				// TABLENAME AND ID FOR DATABASE ACTION
				$args = array(
					'table_name' => 'mp_customer',
					'id' => $result_data[0]->id
				);

				// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
				$data = array(
					'cus_password' =>sha1($user_password)

				);

					// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
					$result = $this->Crud_model->edit_record_id($args, $data);
					if ($result == 1)
					{
						$array_msg = array(
							'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Password Created',
							'alert' => 'info'
						);
						$this->session->set_flashdata('status', $array_msg);
					}
					else
					{
						$array_msg = array(
							'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot changed',
							'alert' => 'danger'
						);
						$this->session->set_flashdata('status', $array_msg);
					}

				
					redirect('main');
			}
			else
			{

				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invalid email or code',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);

				redirect('login/get_password_recover_user');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Confirm password not matched',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('login/get_password_recover');
		}	
	}

	//USED FOR ADMINPANEL
	function get_password_recover()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Recover Password';

		// DEFINES WHICH PAGE TO RENDER
		$this->load->view('forget_password', $data);

	}

	//USED TO USERPANEL
	function get_password_recover_user()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Recover Password';

		// DEFINES WHICH PAGE TO RENDER
		$this->load->view('frontend/forget_password', $data);

	}

	//USED TO RECOVER PASSWORDS
	//Login/recover_password
	function recover_password()
	{
		// DEFINES READ CATEROTY NAME FORM Login FORM
		$user_email = html_escape($this->input->post('user_email'));
		$user_code = html_escape($this->input->post('user_code'));	
		$user_password = html_escape($this->input->post('user_password'));	
		$user_cpassword = html_escape($this->input->post('user_cpassword'));
		
		
		if (!empty($user_password) && !empty($user_cpassword))
		{

			// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
			$this->load->model('Crud_model');
			$result_data = $this->Crud_model->fetch_forget_password($user_email,$user_code);

			if ($result_data != NULL)
			{
				
				// TABLENAME AND ID FOR DATABASE ACTION
				$args = array(
					'table_name' => 'mp_users',
					'id' => $result_data[0]->id
				);

				// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
				$data = array(
					'user_password' =>sha1($user_password)

				);

					// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
					$result = $this->Crud_model->edit_record_id($args, $data);
					if ($result == 1)
					{
						$array_msg = array(
							'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Password Created',
							'alert' => 'info'
						);
						$this->session->set_flashdata('status', $array_msg);
					}
					else
					{
						$array_msg = array(
							'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot changed',
							'alert' => 'danger'
						);
						$this->session->set_flashdata('status', $array_msg);
					}

				
					redirect('login');
			}
			else
			{

				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Invalid email or code',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);

				redirect('login/get_password_recover');
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Confirm password not matched',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
			redirect('login/get_password_recover');
		}	
	}
}