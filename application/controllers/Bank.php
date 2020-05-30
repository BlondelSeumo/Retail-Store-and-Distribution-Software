<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  @author    : Muhammad Ibrahim
 *  @Mail      : aliibrahimroshan@gmail.com
 *  @Created   : 11th December, 2018
 *  @Developed : Team Spantik Lab
 *  @URL       : www.spantiklab.com
 *  @Envato    : https://codecanyon.net/user/spantiklab
 */
class Bank extends CI_Controller
{
    
    //Bank
    public function index()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Banks';
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name'] = 'Available Banks:';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'bank';
        
        // DEFINES THE TABLE HEAD
        $data['table_heading_names_of_coloums'] = array(
            'Name',
            'Branch',
            'Branch code',
            'Account Title',
            'Account Number',
            'Status',
            'Action'
        );
        
        $this->load->model('Crud_model');
        $result            = $this->Crud_model->fetch_record('mp_banks', NULL);
        $data['bank_list'] = $result;
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/add_bank
    function add_bank()
    {
        $this->load->model('Crud_model');
        // DEFINES READ MEDICINE details FORM MEDICINE FORM
        $bankname       = html_escape($this->input->post('bankname'));
        $branch         = html_escape($this->input->post('branch'));
        $branchcode     = html_escape($this->input->post('branchcode'));
        $title          = html_escape($this->input->post('title'));
        $accountno      = html_escape($this->input->post('accountno'));
        $account_type   = html_escape($this->input->post('account_type'));
        $ending_date    = html_escape($this->input->post('ending_date'));
        $ending_balance = html_escape($this->input->post('ending_balance'));
        
        $result = $this->Crud_model->fetch_attr_record_by_id('mp_banks', 'accountno', $accountno);
        
        if ($result == '')
        {
            
            if ($account_type == 1)
            {
                $this->load->model('Transaction_model');
                // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
                $args = array(
                    'bankname' => $bankname,
                    'branch' => $branch,
                    'branchcode' => $branchcode,
                    'title' => $title,
                    'accountno' => $accountno,
                    'end_date' => $ending_date,
                    'end_balance' => $ending_balance
                );
                
                $result = $this->Transaction_model->bank_transaction($args);
                
            }
            else
            {
                // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
                $args = array(
                    'bankname' => $bankname,
                    'branch' => $branch,
                    'branchcode' => $branchcode,
                    'title' => $title,
                    'accountno' => $accountno
                );
                
                // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
                $result = $this->Crud_model->insert_data('mp_banks', $args);
                
                if ($result != NULL)
                {
                    $array_msg = array(
                        'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
                        'alert' => 'info'
                    );
                    $this->session->set_flashdata('status', $array_msg);
                }
                else
                {
                    $array_msg = array(
                        'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
                        'alert' => 'danger'
                    );
                    $this->session->set_flashdata('status', $array_msg);
                }
            }
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Account already exisits',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank');
    }
    
    //bank/edit
    public function edit()
    {
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $bank_id    = html_escape($this->input->post('bank_id'));
        $bankname   = html_escape($this->input->post('bankname'));
        $branch     = html_escape($this->input->post('branch'));
        $branchcode = html_escape($this->input->post('branchcode'));
        $title      = html_escape($this->input->post('title'));
        $accountno  = html_escape($this->input->post('accountno'));
        
        
        
        $data = array(
            'bankname' => $bankname,
            'branch' => $branch,
            'branchcode' => $branchcode,
            'title' => $title,
            'accountno' => $accountno
        );
        
        // TABLENAME AND ID FOR DATABASE ACTION
        $args = array(
            'table_name' => 'mp_banks',
            'id' => $bank_id
        );
        
        // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
        $result = $this->Crud_model->edit_record_id($args, $data);
        if ($result == 1)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-pencil-square-o" aria-hidden="true"/> Bank Editted',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be editted',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank');
    }
    
    // Bank/change_status/id/status
    public function change_status($id, $status)
    {
        
        // TABLENAME AND ID FOR DATABASE ACTION
        $args = array(
            'table_name' => 'mp_banks',
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
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank');
    }
    
    //Bank/change_cheque_status
    //USED TO CHANGE BANK CHEQUE STATUS
    function change_cheque_status($trans_id, $status)
    {
        // TABLENAME AND ID FOR DATABASE ACTION
        $args = array(
            'table_name' => 'mp_bank_transaction',
            'id' => $trans_id
        );
        
        // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
        $data = array(
            'transaction_status' => $status,
            'cleared_date' => date('Y-m-d')
        );
        
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');
        
        // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
        $result = $this->Crud_model->edit_record_id($args, $data);
        if ($result == 1)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/written_cheque');
    }
    
    //Bank/popup
    //DEFINES A POPUP MODEL OG GIVEN PARAMETER
    function popup($page_name = '', $param = '')
    {
        if ($page_name == 'add_bank_model')
        {
            //model name available in admin models folder
            $this->load->view('admin_models/add_models/add_bank_model.php');
        }
        else if ($page_name == 'edit_bank_model')
        {
            $this->load->model('Crud_model');
            $data['bank_list'] = $this->Crud_model->fetch_record_by_id('mp_banks', $param);
            
            $this->load->view('admin_models/edit_models/edit_bank_model.php', $data);
        }
        
    }
    
    //Bank/cheque
    //USED TO CREATE A CHEQUE 
    function cheque()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Cheque';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'cheque';
        
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_account_heads('yes','yes','yes','','');
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    
    //Bank/create_collection
    //USED TO CREATE A COLLECTION 
    function create_collection()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Collection';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'collection';
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_account_heads('yes','yes','yes','','');
       
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/edit_cheque
    //USED TO view CREATE A CHEQUE 
    function edit_cheque($trans_id)
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Cheque';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'edit_cheque';
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH BANK TRANSACTION 
        $data['trans_data'] = $this->Crud_model->get_single_bank_trans($trans_id, 0);
        
        //USED TO FETCH BANK TRANSACTION 
        $data['available_balance'] = $this->Crud_model->check_available_balance($data['trans_data'][0]->bank_id);
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_record('mp_head', NULL);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    
    //Bank/add_cheque
    //USED TO CREATE A CHEQUE 
    function add_cheque()
    {
        $this->load->model('Transaction_model');
        $this->load->model('Crud_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date         = html_escape($this->input->post('deposit_date'));
        $cheque_id    = html_escape($this->input->post('cheque_id'));
        $bank_id      = html_escape($this->input->post('bank_id'));
        $payee_id     = html_escape($this->input->post('payee_id'));
        $account_head = html_escape($this->input->post('account_head'));
        $amount       = html_escape($this->input->post('amount'));
        $description  = html_escape($this->input->post('description'));
        $attachment   = $this->Crud_model->do_upload_picture("attachment", "./uploads/cheque/");
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/written_cheque'));
		}
		
        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'date' => $date,
            'cheque_id' => $cheque_id,
            'bank_id' => $bank_id,
            'payee_id' => $payee_id,
            'account_head' => $account_head,
            'amount' => $amount,
            'description' => $description,
            'attachment' => $attachment
        );
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->create_cheque($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/written_cheque');
    }
    
    
    //Bank/add_payment_transaction
    //USED TO CREATE A PAYMENT 
    function add_payment_transaction()
    {
        $this->load->model('Transaction_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date         = html_escape($this->input->post('deposit_date'));
        $bank_id      = html_escape($this->input->post('bank_id'));
        $payee_id     = html_escape($this->input->post('payee_id'));
        $account_head = html_escape($this->input->post('account_head'));
        $amount       = html_escape($this->input->post('amount'));
        $description  = html_escape($this->input->post('description'));
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/payment_collection'));
		}

        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'date' => $date,
            'cheque_id' => '',
            'bank_id' => $bank_id,
            'payee_id' => $payee_id,
            'account_head' => $account_head,
            'amount' => $amount,
            'description' => $description
        );
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->create_collection($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/payment_collection');
    }
    
    
    //Bank/update_cheque
    //USED TO UPDATE A CHEQUE 
    function update_cheque()
    {
        $this->load->model('Transaction_model');
        $this->load->model('Crud_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date       = html_escape($this->input->post('deposit_date'));
        $cheque_id  = html_escape($this->input->post('cheque_id'));
        $che_pri_id = html_escape($this->input->post('che_pri_id'));
        
        $bank_id        = html_escape($this->input->post('bank_id'));
        $payee_id       = html_escape($this->input->post('payee_id'));
        $account_head   = html_escape($this->input->post('account_head'));
        $amount         = html_escape($this->input->post('amount'));
        $description    = html_escape($this->input->post('description'));
        $transaction_id = html_escape($this->input->post('transaction_id'));
        $attachment     = $this->Crud_model->do_upload_picture("attachment", "./uploads/cheque/");
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/written_cheque'));
		}
        
        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        if ($attachment != "default.jpg")
        {
            // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
            $this->Crud_model->delete_image_custom('./uploads/cheque/', $che_pri_id, 'attachment', 'mp_bank_transaction');
            
            // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
            $args = array(
                'date' => $date,
                'cheque_id' => $cheque_id,
                'che_pri_id' => $che_pri_id,
                'bank_id' => $bank_id,
                'payee_id' => $payee_id,
                'account_head' => $account_head,
                'amount' => $amount,
                'description' => $description,
                'transaction_id' => $transaction_id,
                'attachment' => $attachment
            );
        }
        else
        {
            // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
            $args = array(
                'date' => $date,
                'cheque_id' => $cheque_id,
                'che_pri_id' => $che_pri_id,
                'bank_id' => $bank_id,
                'payee_id' => $payee_id,
                'account_head' => $account_head,
                'amount' => $amount,
                'description' => $description,
                'transaction_id' => $transaction_id,
                'attachment' => ''
            );
        }
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->update_cheque($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Update successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be update',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/written_cheque');
    }
    
    //Bank/update_deposit
    //USED TO UPDATE A DEPOSIT 
    function update_deposit()
    {
        $this->load->model('Transaction_model');
        $this->load->model('Crud_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        
        $date           = html_escape($this->input->post('deposit_date'));
        $refno          = html_escape($this->input->post('refno'));
        $bank_id        = html_escape($this->input->post('bank_id'));
        $payee_id       = html_escape($this->input->post('payee_id'));
        $account_head   = html_escape($this->input->post('account_head'));
        $amount         = html_escape($this->input->post('amount'));
        $description    = html_escape($this->input->post('description'));
        $transaction_id = html_escape($this->input->post('transaction_id'));
        $attachment     = $this->Crud_model->do_upload_picture("attachment", "./uploads/deposit/");
        $che_pri_id = html_escape($this->input->post('che_pri_id'));
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/deposit_list'));
		}
        
        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        if ($attachment != "default.jpg")
        {
            // DEFINES TO DELETE IMAGE FROM FOLDER PARAMETER REQIURES ARRAY OF IMAGE PATH AND ID
            $this->Crud_model->delete_image_custom('./uploads/deposit/', $che_pri_id, 'attachment', 'mp_bank_transaction');
        }
        
        
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'date' => $date,
            'refno' => $refno,
            'bank_id' => $bank_id,
            'payee_id' => $payee_id,
            'account_head' => $account_head,
            'amount' => $amount,
            'description' => $description,
            'transaction_id' => $transaction_id,
            'attachment' => $attachment
        );
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->update_deposit($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Update successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be update',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/deposit_list');
    }
    
    //Bank/update_collection
    //USED TO UPDATE A COLLECTION 
    function update_collection()
    {
        $this->load->model('Transaction_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date           = html_escape($this->input->post('deposit_date'));
        $refno          = html_escape($this->input->post('refno'));
        $bank_id        = html_escape($this->input->post('bank_id'));
        $payee_id       = html_escape($this->input->post('payee_id'));
        $account_head   = html_escape($this->input->post('account_head'));
        $amount         = html_escape($this->input->post('amount'));
        $description    = html_escape($this->input->post('description'));
        $transaction_id = html_escape($this->input->post('transaction_id'));
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/payment_collection'));
		}

        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'date' => $date,
            'refno' => $refno,
            'bank_id' => $bank_id,
            'payee_id' => $payee_id,
            'account_head' => $account_head,
            'amount' => $amount,
            'description' => $description,
            'transaction_id' => $transaction_id
        );
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->update_collection($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Update successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be update',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/payment_collection');
    }
    
    //Bank/written_cheque
    //USED TO LIST THE WRITTEN CHECKS 
    function written_cheque($period = '')
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Written Cheques';
        
        if ($period != '')
        {
            
            if ($period == 'month')
            {
                
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'three')
            {
                $month = date('m') - 2;
                
                $date1 = date('Y') . '-' . $month . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'year')
            {
                $year = date('Y');
                
                $date1 = $year . '-1-1';
                $date2 = $year . '-12-31';
            }
            else
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        else
        {
            $date1 = html_escape($this->input->post('date1'));
            $date2 = html_escape($this->input->post('date2'));
            
            if ($date1 == "" OR $date2 == "")
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name'] = 'Written Cheques ' . $date1 . ' to ' . $date2;
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'written_cheques';
        
        // DEFINES THE TABLE HEAD
        $data['table_heading_names_of_coloums'] = array(
            'Date',
            'Bank',
            'Account',
            'Payee',
            'Amount',
            'Cheque No',
            'Status',
            'Action'
        );
        
        
        $this->load->model('Accounts_model');
        $data['cheque_list'] = $this->Accounts_model->written_cheques($date1, $date2);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/payment_collection
    //USED TO LIST THE PAYMNET COLLECTION THROUGH BANK 
    function payment_collection($period = '')
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Payment collection';
        
        if ($period != '')
        {
            
            if ($period == 'month')
            {
                
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'three')
            {
                $month = date('m') - 2;
                
                $date1 = date('Y') . '-' . $month . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'year')
            {
                $year = date('Y');
                
                $date1 = $year . '-1-1';
                $date2 = $year . '-12-31';
            }
            else
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        else
        {
            $date1 = html_escape($this->input->post('date1'));
            $date2 = html_escape($this->input->post('date2'));
            
            if ($date1 == "" OR $date2 == "")
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name'] = 'Payment collection through banks ' . $date1 . ' to ' . $date2;
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'payment_collections';
        
        // DEFINES THE TABLE HEAD
        $data['table_heading_names_of_coloums'] = array(
            'Date',
            'Bank',
            'Account',
            'Amount',
            'Description',
            'Action'
        );
        
        $this->load->model('Accounts_model');
        $data['collect_list'] = $this->Accounts_model->bank_collection_transaction($date1, $date2);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/edit_collection
    //USED TO view EDIT DEPOSIT 
    function edit_collection($trans_id)
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Edit collection';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'edit_collection';
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH BANK TRANSACTION 
        $data['trans_data'] = $this->Crud_model->get_single_bank_trans($trans_id, 1);
        
        //USED TO FETCH BANK TRANSACTION 
        $data['available_balance'] = $this->Crud_model->check_available_balance($data['trans_data'][0]->bank_id);
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_record('mp_head', NULL);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    
    //Bank/cheque
    //USED TO CREATE A DEPOSIT IN BANK 
    function deposit()
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Deposit';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'deposit';
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_account_heads('yes','yes','yes','','');
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    
    //Bank/add_deposit
    //USED TO CREATE A DEPOSIT 
    function add_deposit()
    {
        $this->load->model('Transaction_model');
        $this->load->model('Crud_model');
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date         = html_escape($this->input->post('deposit_date'));
        $bank_id      = html_escape($this->input->post('bank_id'));
        $customer_id  = html_escape($this->input->post('customer_id'));
        $account_head = html_escape($this->input->post('account_head'));
        $amount       = html_escape($this->input->post('amount'));
        $method       = html_escape($this->input->post('method'));
        $refno        = html_escape($this->input->post('refno'));
        $memo         = html_escape($this->input->post('memo'));
        $attachment   = $this->Crud_model->do_upload_picture("attachment", "./uploads/deposit/");
        
        if($bank_id == 0)
		{
			$array_msg = array(
				'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"></i> Please select bank acccount',
				'alert' => 'danger'
			);

			$this->session->set_flashdata('status', $array_msg);

			redirect(base_url('bank/deposit_list'));
		}

        if ($date == NULL)
        {
            $date = date('Y-m-d');
        }
        
        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'date' => $date,
            'bank_id' => $bank_id,
            'payee_id' => $customer_id,
            'account_head' => $account_head,
            'amount' => $amount,
            'method' => $method,
            'refno' => $refno,
            'memo' => $memo,
            'attachment' => $attachment
        );
        
        // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
        $result = $this->Transaction_model->create_deposit($args);
        if ($result != NULL)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/> Added successfully',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be added',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/deposit_list');
    }
    
    //Bank/deposit_list
    //USED TO LIST THE WRITTEN CHECKS 
    function deposit_list($period = '')
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Deposit List';
        
        
        if ($period != '')
        {
            
            if ($period == 'month')
            {
                
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'three')
            {
                $month = date('m') - 2;
                
                $date1 = date('Y') . '-' . $month . '-1';
                $date2 = date('Y-m') . '-31';
            }
            else if ($period == 'year')
            {
                $year = date('Y');
                
                $date1 = $year . '-1-1';
                $date2 = $year . '-12-31';
            }
            else
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        else
        {
            $date1 = html_escape($this->input->post('date1'));
            $date2 = html_escape($this->input->post('date2'));
            
            if ($date1 == "" OR $date2 == "")
            {
                $date1 = date('Y-m') . '-1';
                $date2 = date('Y-m') . '-31';
            }
        }
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name'] = 'Deposits ' . $date1 . ' to ' . $date2;
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'depositedlist';
        
        // DEFINES THE TABLE HEAD
        $data['table_heading_names_of_coloums'] = array(
            'Date',
            'Bank',
            'Account',
            'Recieved',
            'Amount',
            'Ref No',
            'Status',
            'Action'
        );
        
        $this->load->model('Accounts_model');
        $data['deposit_list'] = $this->Accounts_model->bank_deposits($date1, $date2);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/edit_deposit
    //USED TO view EDIT DEPOSIT 
    function edit_deposit($trans_id)
    {
        // DEFINES PAGE TITLE
        $data['title'] = 'Edit depsoit';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'edit_deposit';
        
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANKS
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', NULL);
        
        //USED TO FETCH PAYEE
        $data['customer_list'] = $this->Crud_model->fetch_attr_record_by_id('mp_payee', 'cus_status', '0');
        
        //USED TO FETCH BANK TRANSACTION 
        $data['trans_data'] = $this->Crud_model->get_single_bank_trans($trans_id, 1);
        
        //USED TO FETCH BANK TRANSACTION 
        $data['available_balance'] = $this->Crud_model->check_available_balance($data['trans_data'][0]->bank_id);
        
        //USED TO FETCH ACCOUNT HEADS
        $data['head_list'] = $this->Crud_model->fetch_record('mp_head', NULL);
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    //Bank/change_deposit_status
    //USED TO CHANGE DEPOSIT CHEQUE STATUS
    function change_deposit_status($trans_id, $status)
    {
        // TABLENAME AND ID FOR DATABASE ACTION
        $args = array(
            'table_name' => 'mp_bank_transaction',
            'id' => $trans_id
        );
        
        // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
        $data = array(
            'transaction_status' => $status,
            'cleared_date' => date('Y-m-d')
        );
        
        // DEFINES LOAD CRUDS_MODEL FORM MODELS FOLDERS
        $this->load->model('Crud_model');
        
        // CALL THE METHOD FROM Crud_model CLASS FIRST ARG CONTAINES TABLENAME AND OTHER CONTAINS DATA
        $result = $this->Crud_model->edit_record_id($args, $data);
        if ($result == 1)
        {
            $array_msg = array(
                'msg' => '<i style="color:#fff" class="fa fa-check-circle-o" aria-hidden="true"/>  Changed Successfully!',
                'alert' => 'info'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        else
        {
            $array_msg = array(
                'msg' => '<i style="color:#c00" class="fa fa-exclamation-triangle" aria-hidden="true"/> Cannot be changed',
                'alert' => 'danger'
            );
            $this->session->set_flashdata('status', $array_msg);
        }
        
        redirect('bank/deposit_list');
    }
    
    //Bank/bank_book
    //USED TO GENERATE BANK BOOK
    function bank_book()
    {
        
        // RETRIEVING UPDATED VALUES FROM FORM MEDICINE FORM
        $date1   = html_escape($this->input->post('date1'));
        $date2   = html_escape($this->input->post('date2'));
        $bank_id = html_escape($this->input->post('bank_id'));
        
        // DEFINES PAGE TITLE
        $data['title'] = 'Bank Book';
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name'] = 'Deposits:';
        
        // DEFINES NAME OF TABLE HEADING
        $data['table_name2'] = 'Cheques Written:';
        
        // DEFINES WHICH PAGE TO RENDER
        $data['main_view'] = 'bankbook';
        
        // DEFINES THE TABLE HEAD
        $data['table_heading_names_of_coloums'] = array(
            'Date',
            'Type',
            'No',
            'Name',
            'Amount'
        );
        
        if ($date1 == '' AND $date2 == '')
        {
            $this->load->model('Crud_model');
            $result = $this->Crud_model->fetch_record_by_id('mp_langingpage', 1);
            $from   = '-' . $result[0]->startmonth . '-' . $result[0]->startday;
            $to     = '-' . $result[0]->endmonth . '-' . $result[0]->endday;
            
            $date1 = date('Y') . $from;
            $date2 = date('Y') . $to;
        }
        
        
        $data['to'] = $date1 . ' -to- ' . $date2;
        $this->load->model('Crud_model');
        
        $data['bank'] = $bank_id;
        
        //FETCH BANK NAME BY BANK ID
        $data['bankname'] = $this->Crud_model->fetch_record_by_id('mp_banks', $bank_id);
        
        $this->load->model('Accounts_model');
        
        $data['deposit_list'] = $this->Accounts_model->bank_book($date1, $date2, 'deposit', $bank_id);
        
        $data['cheque_list'] = $this->Accounts_model->bank_book($date1, $date2, 'cheque', $bank_id);
        
        $data['bank_list'] = $this->Crud_model->fetch_record('mp_banks', 'status');
        
        // DEFINES GO TO MAIN FOLDER FOND INDEX.PHP  AND PASS THE ARRAY OF DATA TO THIS PAGE
        $this->load->view('main/index.php', $data);
    }
    
    
    //USED TO FIND CURRENT AVAILABLE BALANCE IN BANK 
    function check_available_balance($bank_id)
    {
        $this->load->model('Crud_model');
        
        //USED TO FETCH BANK TRANSACTION 
        echo $data['available_balance'] = $this->Crud_model->check_available_balance($bank_id);
    }
}