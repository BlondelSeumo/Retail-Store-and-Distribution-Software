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
class Multiple_roles extends CI_Controller
{
	// MultipleRoles
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Multiple Roles';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Assign Roles :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'multiple_roles';

		// DIFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'User Name',
			'Email',
			'Description',
			'Privileges',
			'Action'
		);

		// DEFINES TO LOAD THE CATEGORY LIST FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');

		$privileges = $this->Crud_model->get_user_details_menus();
		$data['privileges'] = $privileges;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//	MultipleRoles/Add
	public function add_role()
	{

		// DEFINES READ CATEROTY NAME FORM Multiple FORM
		$user_id = html_escape($this->input->post('user_id'));
		$menu_id = html_escape($this->input->post('menu_id'));
		$role_id = html_escape($this->input->post('role_id'));
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['id'];

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		if ($user_id != 0)
		{
			$i = 0;
			while ($i < count($menu_id))
			{

				// GETTING THE VALUES FROM TEXTFIELD .THE ARRAYS OF VALUES WHICH WE CREATED
				// BY USING DOM
				if ($role_id[$i] != 0)
				{
					$result_duplication = $this->Crud_model->check_role_duplication($user_id, $menu_id[$i]);
					if ($result_duplication != TRUE)
					{

						// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY FOR EVERY ITERATION
						$args = array(
							'user_id' => $user_id,
							'menu_Id' => $menu_id[$i],
							'role' => $role_id[$i],
							'agentid' => $added_by
						);

						// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS

						$result = $this->Crud_model->insert_data('mp_multipleroles', $args);
					}
				}

				$i++;
			}

			if ($result_duplication == TRUE)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="TRUE"></i> privileges already assigned',
					'alert' => 'danger'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
			else
			{
				if ($result == 1)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="TRUE"></i> Roles added Successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="TRUE"></i> Error Roles cannot be added',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="TRUE"></i> Error No user is selected',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('multiple_roles');
	}

	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_multipleroles_model')
		{
			$result_roles = $this->Crud_model->fetch_record('mp_menu', NULL);
			$data['result_roles'] = $result_roles;

			$data['user_list'] =  $this->Crud_model->fetch_record('mp_users','status');
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_multipleroles_model.php',$data);
		}
	}

	//Multiple_roles/Delete
	public function delete($args)
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_multipleroles', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="TRUE"></i> Privilege removed Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="TRUE"></i> Error Privilege record cannot be romved',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('multiple_roles');
	}
}