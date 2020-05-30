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
class Printer_settings extends CI_Controller
{
	//INDEX 
	public function index()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES PAGE TITLE
		$data['title'] = 'Printer settings';

		$data['main_view'] = 'printers';

		// DEFINES THE TABLE HEAD
	    $data['table_heading_names_of_coloums'] = array(
	     'Printer Name',
	     'Font size',
	     'Default',
	     'Action'
	    );

		//FETCHING THE LIST OF CUSTOMERS
		$data['print_record'] = $this->Crud_model->fetch_record('mp_printer',NULL);

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	} 


   //USED TO ADD PRINTER INTO DATABASE
   //Printer_settings/add_printer
   function add_printer()
   {
    	// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
	    $this->load->model('Crud_model');

      // DEFINES READ CATEROTY NAME FORM CATEGORY FORM
      $printer_name = html_escape($this->input->post('printer_name'));
      $font_size = html_escape($this->input->post('font_size'));

      // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
      $args = array(
        'printer_name' => $printer_name, 
        'fontsize'	 => $font_size
      );

      // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
      $result = $this->Crud_model->insert_data('mp_printer', $args);
      if ($result == 1)
      {
        $array_msg = array(
          'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Added Successfully',
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

      redirect('printer_settings');
   } 

    //Printer_settings/delete
	public function delete($args)
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$result = $this->Crud_model->delete_record('mp_printer', $args);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-trash-o" aria-hidden="true"></i> Record removed',
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

		redirect('printer_settings');
	}

	// Printer_settings/edit
	public function edit()
	{

		// RETRIEVING UPDATED VALUES FROM TEXTBOX
		$printer_name = html_escape($this->input->post('printer_name'));
		$font_size = html_escape($this->input->post('font_size'));
		$edit_id = html_escape($this->input->post('edit_id'));
		

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_printer',
			'id' => $edit_id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'printer_name' => $printer_name,
			'fontsize' => $font_size
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Printer Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('printer_settings');
	}

	// Printer_settings/change_status/id/status
	public function change_status($id, $status)
	{

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_printer',
			'set_default' => 1
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'set_default' => 0
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$this->Crud_model->edit_record_attr($args, $data);

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_printer',
			'id' => $id
		);

		// DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
		$data = array(
			'set_default' => $status
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Set default Successfully!',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error cannot be changed',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('printer_settings');
	}

	//Printer_settings/popup
	//DEFINES A POPUP MODEL OG GIVEN PARAMETER
	function popup($page_name = '',$param = '')
	{
		$this->load->model('Crud_model');

		if($page_name  == 'add_new_printer_model')
		{
		
			//model name available in admin models folder
			$this->load->view('admin_models/add_models/add_new_printer_model.php');
		}
		else if($page_name  == 'edit_printer_model')
		{

			$data['single_printer'] = $this->Crud_model->fetch_record_by_id('mp_printer',$param);
			//model name available in admin models folder
			$this->load->view( 'admin_models/edit_models/edit_printer_model.php',$data);
		}
	
	}

}