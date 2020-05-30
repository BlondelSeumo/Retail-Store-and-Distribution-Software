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
class Layout extends CI_Controller
{
	// Layout
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title1'] = 'Theme Layout Settings';

		// DEFINES PAGE TITLE
		$data['title2'] = 'Website FrontEnd Headings :';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'layout';

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// FETCHING THE RECORD FROM TABLE GIVEN
		$company_record = $this->Crud_model->fetch_record('mp_langingpage', '');
		$data['company_record'] = $company_record;

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	// Layout/logo
	public function logo()

	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$company_logo = $this->Crud_model->do_upload_picture("company_logo", "./uploads/systemimgs/");
		if ($company_logo != "default.jpg")
		{
			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$data = array(
				'logo' => $company_logo,
			);
			// TABLENAME AND ID FOR DATABASE ACTION
			$args = array(
				'table_name' => 'mp_langingpage',
				'id' => 1,
			);
			// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
			$result = $this->Crud_model->edit_record_id($args, $data);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> logo Updated',
					'alert' => 'info',
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty logo cannot be Updated',
				'alert' => 'danger',
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('layout');
	}

	// Layout/banner
	public function banner()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');
		$company_thumbnail = $this->Crud_model->do_upload_picture("company_thumbnail", "./uploads/systemimgs/");
		if ($company_thumbnail != "default.jpg")
		{

			// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
			$data = array(
				'banner' => $company_thumbnail
			);

			// TABLENAME AND ID FOR DATABASE ACTION
			$args = array(
				'table_name' => 'mp_langingpage',
				'id' => 1
			);

			// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
			$result = $this->Crud_model->edit_record_id($args, $data);
			if ($result == 1)
			{
				$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> banner Updated',
					'alert' => 'info'
				);
				$this->session->set_flashdata('status', $array_msg);
			}
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Empty banner cannot be Updated',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('layout');
	}

	// Layout/details
	public function details()
	{
		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// DEFINES READ CONTACT details FORM CONTACT US FORM
		$company_name = html_escape($this->input->post('company_name'));
		$company_description = html_escape($this->input->post('company_description'));
		$company_keywords = html_escape($this->input->post('company_keywords'));
		$companyaddress = html_escape($this->input->post('companyaddress'));
		$companyemail = html_escape($this->input->post('companyemail'));
		$companycontact = html_escape($this->input->post('companycontact'));
		$company_currency = html_escape($this->input->post('company_currency'));
		$company_language = html_escape($this->input->post('company_language'));
		$company_primary_color = html_escape($this->input->post('company_primary_color'));
		$company_primary_hover = html_escape($this->input->post('company_primary_hover'));
		$company_expire_time = html_escape($this->input->post('company_expire_time'));
		$startday = html_escape($this->input->post('startday'));
		$startmonth = html_escape($this->input->post('startmonth'));
		$endday = html_escape($this->input->post('endday'));
		$endmonth = html_escape($this->input->post('endmonth'));

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$data = array(
			'companyname' => $company_name,
			'companydescription' => $company_description,
			'companykeywords' => $company_keywords,
			'address' => $companyaddress,
			'email' => $companyemail,
			'contact' => $companycontact,
			'currency' => $company_currency,
			'language' => $company_language,
			'primarycolor' => $company_primary_color,
			'theme_pri_hover' => $company_primary_hover,
			'expirey' => $company_expire_time,
			'startday' => $startday,
			'startmonth' => $startmonth,
			'endday' => $endday,
			'endmonth' => $endmonth,
		);

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_langingpage',
			'id' => 1
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Company Record Editted',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Company Record cannot be Editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}

		redirect('layout');
	}

		//DEFAULT SETTINGS OF COLOR 
	function default_settings()
	{
		$primary_color = '#4a6984';
		$primary_color_hover = '#1f5788';

		// TABLENAME AND ID FOR DATABASE ACTION
		$args = array(
			'table_name' => 'mp_langingpage',
			'id' => 1
		);

		// DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
		$this->load->model('Crud_model');

		// ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
		$data = array(
			'primarycolor' => $primary_color,
			'theme_pri_hover' => $primary_color_hover
		);

		// CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
		$result = $this->Crud_model->edit_record_id($args, $data);
		if ($result == 1)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"></i> Reset successfully',
				'alert' => 'info'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		else
		{
			$array_msg = array(
				'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Reset cannot be editted',
				'alert' => 'danger'
			);
			$this->session->set_flashdata('status', $array_msg);
		}
		redirect('layout');

	}
}