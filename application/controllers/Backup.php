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
class Backup extends CI_Controller
{
	//Backup
	public function index()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Take backup';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'backup';

		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}

	public function take_backup() 
	{
		$tables  = array(
			'mp_banks',
        	'mp_bank_opening',
			'mp_bank_transaction',
			'mp_bank_transaction_payee',
        	'mp_barcode',
        	'mp_brand',
        	'mp_brand_sector',
        	'mp_category',
			'mp_drivers',
			'mp_estimate',
			'mp_estimate_sales',
        	'mp_expense',
        	'mp_generalentry',
        	'mp_head',
        	'mp_invoices',
        	'mp_langingpage',
        	'mp_productslist',
        	'mp_menu',
        	'mp_menulist',
        	'mp_multipleroles',
			'mp_payee',
			'mp_payment_voucher',
			'mp_printer',
			'mp_product',
			'mp_purchase',
			'mp_purchase_order',
        	'mp_region',
            'mp_return',
        	'mp_return_list',
			'mp_sales',
			'mp_salesman',
			'mp_sales_receipt',
        	'mp_stock',
        	'mp_stores',
			'mp_sub_entry',
			'mp_sub_expense',
			'mp_sub_purchase',
			'mp_sub_receipt',
        	'mp_supply',
			'mp_temp_barcoder_invoice',
			'mp_temp_barcoder_order',
			'mp_temp_purchase',
        	'mp_todolist',
        	'mp_town',
        	'mp_units',
        	'mp_users',
			'mp_vehicle',
			'mp_order_list_total',
			'mp_sales_orderlist'
		);

        $this->load->dbutil();
        	$db_name = $this->db->database . '_' . date('Y-m-d_H-i-s', time()) . '_backup.txt';
           $prefs = array(
            'tables' => $tables, 
            'ignore' => array(),
            'format' => 'txt',
            'filename' => $db_name ,
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n",
            'foreign_key_checks' => FALSE
        );

        $sql = $this->dbutil->backup($prefs);

        $data = $sql;

        $backup_path = './assets/db_backup/'.$prefs['filename'];

        if (write_file($backup_path, $data)) 
        {
        	// Load the download helper and send the file to your desktop
			$this->load->helper('download');
			force_download($db_name,$data);

            return true;  
        } 
        else 
        {
            return false;
        }
    }

    //backup/restore
    public function restore() 
    {
    	
        $this->load->model('Transaction_model');
    	$result = $this->Transaction_model->backup_restore_transaction();
        
        if($result != '')
        {
        	$array_msg = array(
					'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Data restored Successfully',
					'alert' => 'info'
				);
			$this->session->set_flashdata('status', $array_msg);
        }
        else
        {
        	$array_msg = array(
					'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Data restored failed',
					'alert' => 'danger'
				);
			$this->session->set_flashdata('status', $array_msg);
        }
        redirect('homepage');
    }
	

	function upload_restore()
	{
		// DEFINES PAGE TITLE
		$data['title'] = 'Restore backup';

		// DEFINES WHICH PAGE TO RENDER
		$data['main_view'] = 'restore_backup';
		
		// DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
		$this->load->view('main/index.php', $data);
	}
} 