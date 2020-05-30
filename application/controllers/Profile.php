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
class Profile extends CI_Controller

{

	// profile
	public function index()
	{

		// SESSION DATA

		$user_data = $this->session->userdata('user_id');

		// DEFINES WHICH PAGE TO RENDER

		$data['main_view'] = 'profile';

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS

		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record_by_id('mp_users', $user_data['id']);
		if ($result != "")
		{
			$data['User_profile'] = $result;

			// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		
			$this->load->view('main/index.php', $data);
		}
		else
		{
			echo "error";
		}
	}

	// Userpanel/change_profile_picture

	public function change_profile_picture()
	{
		$user_data = $this->session->userdata('user_id');

		// RETRIEVING UPDATED VALUES FROM FORM userPanel FORM

		$customer_sess_id = $user_data['id'];

		// TABLENAME AND ID FOR DATABASE ACTION

		$args = array(
			'table_name' => 'mp_users',
			'id' => $customer_sess_id
		);
		$this->load->model('Crud_model');
		$edit_picture = $this->Crud_model->do_upload_picture("customer_picture", "./uploads/users/");
		$data = array(
			'cus_picture' => $edit_picture
		);

		// DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID

		$this->Crud_model->delete_image('./uploads/users/', $customer_sess_id, 'mp_users');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA

		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> Picture Updated ',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Updated Failed ',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('profile/');
	}

	// UserPanal/change_password

	public function change_password()
	{
		$this->load->model('Crud_model');
		$user_data = $this->session->userdata('user_id');
		$edit_customer_id = $user_data['id'];
		$old_password = html_escape($this->input->post('old_password'));
		$new_login_customer = html_escape($this->input->post('new_password'));
		$confirm_password = html_escape($this->input->post('confirm_password'));

	
		if ($new_login_customer == $confirm_password)
		{
			$customer_record = $this->Crud_model->fetch_record_by_id('mp_users', $edit_customer_id);
			$saved_password = $customer_record[0]->user_password;
		
			
			if(sha1($old_password) == $saved_password){

				// TABLENAME AND ID FOR DATABASE ACTION

				$args = array(
					'table_name' => 'mp_users',
					'id' => $edit_customer_id
				);

				// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)

				$data = array(
					'user_password' => sha1($new_login_customer)
				);

				// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
				// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA

				$result = $this->Crud_model->edit_record_id($args, $data);

				if ($result == 1)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Updated  Successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"/> Updated Failed',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
			else
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"/> Invalid old Password',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-exclamation-triangle" aria-hidden="true"/> Password not matched',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('profile');
	}

	//profile/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		
		if($page_name  == 'password_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/password_model.php');
		}
		else if($page_name  == 'picture_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/picture_model.php');
		}
		
	}
}