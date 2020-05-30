<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Todolist extends CI_Controller
{
	// Todolist
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Requested items';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Requested items :';

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add Request';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add New Request';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Request';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'todolist';

		// DIFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'No',
			'Title',
			'Date',
			'Added By',
			'Status',
			'Action'
		);

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model_edit'] = 'Update Request';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_edit'] = 'Update Request';

		// DEFINES TO LOAD THE CATEGORY RECORD FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record('mp_todolist', NULL);
		$data['todo_records'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	//Todolist/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_todolist_model')
		{
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_todolist_model.php');
		}
		else if($page_name  == 'edit_todolist_model')
		{
			$data['single_todo'] = $this->Crud_model->fetch_record_by_id('mp_todolist',$param);
			//model name available in admin models folder
			$this->load->view( 'admin_models/edit_models/edit_todolist_model.php',$data);
		}
		
	}

	//Todolist/Add
	public function add_todo()
	{
		// DEFINES READ CATEROTY NAME FORM Todolist FORM
		$todolist_name = html_escape($this->input->post('todolist_name'));

		// DEFINES READ CATEROTY NAME FORM Todolist FORM
		$date = html_escape($this->input->post('Todolist_Date'));
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'title' => $todolist_name,
			'date' => $date,
			'addedby' => $added_by
		);

		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Crud_model->insert_data('mp_todolist', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Todolist added Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Todolist cannot be added',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('todolist');
	}

	// Todolist/delete
	public function delete($args)
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_todolist', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Todolist record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Todolist record cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('todolist');
	}

	// todolist/edit
	public function edit()
	{
		// RETRIEVING UPDATED VALUES FROM TEXTBOX
		$edit_todo_name = html_escape($this->input->post('edit_todo_name'));
		$date = html_escape($this->input->post('edit_todolist_date'));
		$edit_todo_id = html_escape($this->input->post('edit_todo_id'));
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_todolist',
			'id' => $edit_todo_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'title' => $edit_todo_name,
			'date' => $date,
			'addedby' => $added_by
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Todolist Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Todolist cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('todolist');
	}

	// Todolist/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_todolist',
			'id' => $id
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
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Status changed Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Status cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('todolist');
	}
}