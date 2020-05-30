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
class Category extends CI_Controller
{
	//Category
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Medicine Category';

		// DEFINES NAME OF TABLE HEADING
		$data['table_name'] = 'Medicine Category List :';

		// DEFINES BUTTON NAME ON THE TOP OF THE TABLE
		$data['page_add_button_name'] = 'Add New Category';

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model'] = 'Add New Category';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_save'] = 'Save Category Name';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'categories';

		// DIFINES THE TABLE HEAD
		$data['table_heading_names_of_coloums'] = array(
			'Id',
			'Category Name',
			'Description',
			'Date',
			'Added By',
			'Status',
			'Action'
		);

		// DEFINES THE TITLE NAME OF THE POPUP
		$data['page_title_model_edit'] = 'Update Category';

		// DEFINES THE NAME OF THE BUTTON OF POPUP MODEL
		$data['page_title_model_button_edit'] = 'Update Category';

		// DEFINES TO LOAD THE CATEGORY RECORD FROM DATABSE TABLE mp_Categoty
		$this->load->model('Crud_model');
		$result = $this->Crud_model->fetch_record('mp_category', NULL);
		$data['catagory_records'] = $result;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Category/Add
	public function add_catagory()
	{
		// DEFINES READ CATEROTY NAME FORM CATEGORY FORM
		$category_name = html_escape($this->input->post('category_name'));
		$category_description = html_escape($this->input->post('category_description'));
		$date = date('Y-m-d');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$args = array(
			'category_name' => $category_name,
			'description' => $category_description,
			'register_date' => $date,
			'added_by' => $added_by
		);

		// DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
		$result = $this->Crud_model->insert_data('mp_category', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Category added Successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be added',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('category');
	}

	//category/delete
	public function delete($args)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_category', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Category record removed',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cannot delete, it may exist in another records',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('category');
	}

	// Category/edit
	public function edit()
	{

		// RETRIEVING UPDATED VALUES FROM TEXTBOX
		$category_name = html_escape($this->input->post('edit_category_name'));
		$edit_category_description = html_escape($this->input->post('edit_category_description'));
		$edit_category_id = html_escape($this->input->post('edit_category_id'));
		$date = date('Y-m-d');
		$user_name = $this->session->userdata('user_id');
		$added_by = $user_name['name'];

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_category',
			'id' => $edit_category_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'category_name' => $category_name,
			'description' => $edit_category_description,
			'register_date' => $date,
			'added_by' => $added_by
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Category Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error Category cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('category');
	}

	// Category/change_status/id/status
	public function change_status($id, $status)
	{

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_category',
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

		redirect('category');
	}

	//Category/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_category_model')
		{
			//USED TO REDIRECT LINK
      		$data['link'] = 'category/add_catagory';

			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_category_model.php',$data);
		}
		else if($page_name  == 'edit_category_model')
		{

			$data['single_category'] = $this->Crud_model->fetch_record_by_id('mp_category',$param);
			//model name available in admin models folder
			$this->load->view( 'admin_models/edit_models/edit_category_model.php',$data);
		}
		else if($page_name  == 'add_csv_model')
		{
			$data['path'] = 'category/upload_csv';
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_csv_model.php',$data);
		}
		
	}

	//USE FOR UPLOADING CSV FILE
	//Category/upload_csv
	function upload_csv()
	{
			$this->load->model('Crud_model');

			$user_name = $this->session->userdata('user_id');
			$added_by = $user_name['name'];

			//FETCHING THE CSV FILE TO UPLOAD RECORD INTO DATABASE TABLE
			$filename = $_FILES['upload_file']['tmp_name'];

		if($_FILES["upload_file"]["size"] > 0)
		{
			$file = fopen($filename, "r");
			while (($importdata = fgetcsv($file)))
			{
				$data = array(
					'category_name' => $importdata[0],
					'description'	=> $importdata[1],
					'register_date'	=> date('Y-m-d'),
					'added_by'		=> $added_by
				);

			$insert_result =  $this->Crud_model->insert_data('mp_category',$data);

				}
				fclose($file);

				if ($insert_result == 1)
				{
					$array_msg = array(
						'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> '.'uploaded_successfully',
						'alert' => 'info'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
				else
				{
					$array_msg = array(
						'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'error_in_uploading',
						'alert' => 'danger'
					);
					$this->session->set_flashdata('status', $array_msg);
				}
			}
			else
			{
				$array_msg = array(
									'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> '.'empty_file',
									'alert' => 'danger'
								);			
				$this->session->set_flashdata('status', $array_msg);
			}
			redirect('category');
	}

	// Category/export
	//USED FOR EXPORTING DATA INTO CSV FORMAT
	public function export()
	{
		$args_fileheader  = array(
			'Category name',
			'Description'
		);
		$args_table_header  = array(
			'category_name',
			'description'
		);
		//DEFINED IN HELPER FOLDER
		export_csv('category_list',$args_fileheader,$args_table_header,'mp_category');
		redirect('category');
	}
}