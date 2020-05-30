<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/
class Transaction_model extends CI_Model
{
    //USED TO INSERT SALE AND ACCOUNTS TRANSACTION
    function single_pos_transaction($data)
    {
        $user_name = $this->session->userdata('user_id');

        $this->db->trans_start();

        // PASSING ARRAY OF VALUES RECIEVED FROM TEXTBOX TO generate PRINT
        $data['discountfield'] = $data['discount'];
        $data['customer_id'] = $data['cus_id'];

        $credithead  = 0;
        $debithead   = 0;

        $anothercredithead = 0;
        $anotherdebithead = 0;

        if($data['total_bill'] == $data['bill_paid'])
        {
            $debithead = 2; // CASH
            $credithead = 19; // SALES
            
            $anotherdebithead = 18; //COG
            $anothercredithead = 3; // INVENTORY


            $debitamount = $data['total_bill'];
            $creditamount = $data['bill_paid'];
            $cost         = $data['net_cost'];
        }
        else if($data['total_bill'] != $data['bill_paid'] AND $data['bill_paid'] > 0)
        {
            $debithead = 2;
            $debithead2 = 4; //AR
            $credithead  = 19;

            $anotherdebithead = 18; //COG
            $anothercredithead = 3; // INVENTORY
            $cost         = $data['net_cost'];

            $debitamount = $data['bill_paid'];
            $debitamount2 = $data['total_bill']-$data['bill_paid'];
            $creditamount = $data['total_bill'];
           
        }
        else if( $data['bill_paid'] == 0)
        {
            $debithead = 4;
            $credithead = 19;

            $anotherdebithead = 18; //COG
            $anothercredithead = 3; // INVENTORY
            $cost         = $data['net_cost'];

            $debitamount = $data['total_bill'];
            $creditamount = $data['total_bill'];
        }
        else
        {

        }

        $data1  = array(
            'date'                 => date('Y-m-d'), 
            'naration'             => 'Transaction occured from POS', 
            'generated_source'     => 'pos'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $debithead, 
            'amount'      => $debitamount, 
            'type'        => 0
        );

        $this->db->insert('mp_sub_entry',$sub_data);

        //COST OF GOODS
        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $anotherdebithead, 
            'amount'      => $cost, 
            'type'        => 0
        );

        $this->db->insert('mp_sub_entry',$sub_data);

        if($data['total_bill'] != $data['bill_paid'] AND $data['bill_paid'] > 0)
        {
            //3RD ENRTY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $debithead2, 
            'amount'      => $debitamount2, 
            'type'        => 0
            );

           $this->db->insert('mp_sub_entry',$sub_data);

        }
        
            //2ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $anothercredithead, 
            'amount'      => $cost, 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data);

            //SALES
            //2ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $credithead, 
                'amount'      => $creditamount, 
                'type'        => 1
                );

            $this->db->insert('mp_sub_entry',$sub_data);


            //ASSIGNING DATA TO ARRAY
            $insert_data  = array(
                'transaction_id' => $transaction_id, 
                'discount' =>  $data['discount'], 
                'date' =>  $data['date'], 
                'status' =>  $data['status'], 
                'agentname' =>  $data['agentname'], 
                'cus_id' =>  $data['cus_id'],
                'total_bill' =>  $data['total_bill'],
                'total_paid' =>  $data['bill_paid']
            );

            // $this->db->trans_strict(FALSE);
            //INSERT AND GET LAST ID
            $this->db->insert('mp_invoices',$insert_data);
            $order_id = $this->db->insert_id();

            //FETCHING THE RECORD FROM TEMPORARY TABLE
            $result = $this->db->get('mp_temp_barcoder_invoice');
            $result = $result->result();

            foreach ($result as $single_item) 
            {
                $data1  = array(
                'order_id'     => $order_id, 
                'product_no'   => $single_item->product_no, 
                'product_id'  => $single_item->product_id, 
                'product_name' => $single_item->product_name, 
                'mg'           => $single_item->mg, 
                'price'        => $single_item->price, 
                'discount'     => $single_item->discount, 
                'purchase'     => $single_item->purchase, 
                'qty'          => $single_item->qty, 
                'tax'          => $single_item->tax 
                );

                $this->db->insert('mp_sales',$data1);
            }


            $this->load->model('Accounts_model');
           // $data['cus_previous'] = $this->Accounts_model->previous_balance($data['cus_id']);
            $data['item_data']    = $result;
            $data['invoice_id']   = $order_id;
        
            //USED TO CLEAR TEMP INVOICE
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            $this->db->where(['source' => 'pos']);
            $this->db->where(['agentid' => $user_name['id']]);
            $this->db->delete('mp_temp_barcoder_invoice');
            $this->db->db_debug = $db_debug;
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    }    

    //USED TO UPDATE CHEQUE
    public function update_cheque($data_fields)
    {
        $this->db->trans_start();
        
        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if($data_fields['amount'] >= 0)
        {
            $debithead    = $data_fields['account_head']; //ACCOUNT HEAD 
            $credithead   = 16; //CASH IN BANK

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];


            $data  = array(
            'date'                 => $data_fields['date'], 
            'naration'             => $data_fields['description'], 
            'generated_source'     => 'cheque'
            );

            $this->db->where('id', $data_fields['transaction_id']);
            $this->db->update('mp_generalentry', $data);

            //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
            $this->db->where(['parent_id' => $data_fields['transaction_id']]);
            $this->db->delete('mp_sub_entry');

            if($data_fields['attachment'] != '')
            {
                //TRANSACTION DETAILS 
                $data  = array(
                'bank_id'             => $data_fields['bank_id'], 
                'ref_no'              => $data_fields['cheque_id'],
                'total_paid'          => $data_fields['amount'],
                'attachment'          => $data_fields['attachment']
                );
            }
            else
            {
                //TRANSACTION DETAILS 
                $data  = array(
                'bank_id'             => $data_fields['bank_id'], 
                'ref_no'              => $data_fields['cheque_id'],
                'total_paid'          => $data_fields['amount']
                );
            }
            

            $this->db->where('transaction_id', $data_fields['transaction_id']);
            $this->db->update('mp_bank_transaction', $data);

            //TRANSACTION DETAILS 
            $data  = array(
                'payee_id'   => $data_fields['payee_id']
            );

            $this->db->where('transaction_id', $data_fields['transaction_id']);
            $this->db->update('mp_bank_transaction_payee', $data);

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $debithead, 
            'amount'      => $debitamount, 
            'type'        => 0
            );
            $this->db->insert('mp_sub_entry',$sub_data);  

            //2ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $credithead, 
            'amount'      => $creditamount, 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $data_fields = NULL;    
            }
            else
            {
                $this->db->trans_commit();
            }

            return $data_fields;
        }        
    } 

    //USED TO UPDATE DEPOSIT
    public function update_deposit($data_fields)
    {
        $this->db->trans_start();
       
        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if($data_fields['amount'] >= 0)
        {
            $debithead    =  16; //CASH IN BANK 
            $credithead   = $data_fields['account_head']; //ACCOUNT HEAD
            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];


            $data  = array(
            'date'                 => $data_fields['date'], 
            'naration'             => $data_fields['description'], 
            'generated_source'     => 'deposit'
            );

            $this->db->where('id', $data_fields['transaction_id']);
            $this->db->update('mp_generalentry', $data);

            //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
            $this->db->where(['parent_id' => $data_fields['transaction_id']]);
            $this->db->delete('mp_sub_entry');

          
            

             if($data_fields['attachment'] != '')
            {
                //TRANSACTION DETAILS 
                $data  = array(
                'bank_id'             => $data_fields['bank_id'], 
                'ref_no'              => $data_fields['refno'],
                'total_bill'          => $data_fields['amount'],
                'attachment'          => $data_fields['attachment']
                );
            }
            else
            {
                //TRANSACTION DETAILS 
                $data  = array(
                'bank_id'             => $data_fields['bank_id'], 
                'ref_no'              => $data_fields['cheque_id'],
                'total_bill'          => $data_fields['amount']
                );
            }

            $this->db->where('transaction_id', $data_fields['transaction_id']);
            $this->db->update('mp_bank_transaction', $data);

            //TRANSACTION DETAILS 
            $data  = array(
                'payee_id' => $data_fields['payee_id']
            );

            $this->db->where('transaction_id', $data_fields['transaction_id']);
            $this->db->update('mp_bank_transaction_payee', $data);

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $debithead, 
            'amount'      => $debitamount, 
            'type'        => 0
            );
            $this->db->insert('mp_sub_entry',$sub_data);  

            //2ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $credithead, 
            'amount'      => $creditamount, 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $data_fields = NULL;    
            }
            else
            {
                $this->db->trans_commit();
            }

            return $data_fields;
        }        
    }   

    public function create_collection($data_fields)
    {
        $this->db->trans_start();
       
        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if($data_fields['amount'] >= 0)
        {
            $debithead    = $data_fields['account_head']; //ACCOUNT HEAD 
            $credithead   = 16; //CASH IN BANK

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];


            $data1  = array(
            'date'                 => $data_fields['date'], 
            'naration'             => $data_fields['description'], 
            'generated_source'     => 'bank_collection'
            );

            $this->db->insert('mp_generalentry',$data1);
            $transaction_id = $this->db->insert_id();


            //1ST ENTRY
             $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $credithead, 
            'amount'      => $creditamount, 
            'type'        => 0
            );
            $this->db->insert('mp_sub_entry',$sub_data); 

            //2ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $debithead, 
            'amount'      => $debitamount, 
            'type'        => 1
            );
            
            $this->db->insert('mp_sub_entry',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data_fields['bank_id'], 
            'method'              => 'Collection',
            'ref_no'              => $data_fields['cheque_id'],
            'total_paid'          => $data_fields['amount'],
            'total_bill'          => $data_fields['amount'],
            'transaction_status'  => 0,
            'transaction_type'    => 'recieved',
            'cleared_date'        => date('Y-m-d')
            );

            $this->db->insert('mp_bank_transaction',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'payee_id'            => $data_fields['payee_id'] 
            
            );

            $this->db->insert('mp_bank_transaction_payee',$sub_data); 

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $data_fields = NULL;    
            }
            else
            {
                $this->db->trans_commit();
            }

            return $data_fields;
        }        
    }  

    //USED TO ADD RETURN ITEMS BACK TO STOCK 
    function add_return_items_transaction($data_fields)
    {
        $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID

        $credithead  = 0;
        $debithead   = 0;
        $credithead2 = 0;

        $anothercredithead = 0;
        $anotherdebithead = 0;

        $debitamount  = 0;
        $creditamount  = 0;
        $creditamount2 = 0;

        if($data_fields['total_bill'] == $data_fields['return_amount'])
        {
            $debithead = 19; // SALES
            $credithead = 2; // CASH 

            $anotherdebithead = 3; // INVENTORY
            $anothercredithead = 18; // COG

            $debitamount = $data_fields['return_amount'];
            $creditamount = $data_fields['total_bill'];
            $cost         = $data_fields['net_cost'];
        }
        else if($data_fields['total_bill'] != $data_fields['return_amount'] AND $data_fields['return_amount'] > 0)
        {
            $debithead = 3;
            $credithead2 = 5; //AP
            $credithead  = 2;

            $anotherdebithead = 19; // SALES
            $anothercredithead = 18; //  COG
            $cost         = $data_fields['net_cost'];

            $debitamount = $data_fields['total_bill'] ;
            $creditamount2 = $data_fields['total_bill']-$data_fields['return_amount'];
            $creditamount = $data_fields['return_amount'];
           
        }
        else if( $data_fields['return_amount'] == 0)
        {
            $debithead  = 3;
            $credithead = 5;

            $anotherdebithead  = 19; // SALES
            $anothercredithead = 18; // COG 
            $cost              = $data_fields['net_cost'];

            $debitamount       = $data_fields['total_bill'];
            $creditamount      = $data_fields['total_bill'];
        }
        else
        {

        }

        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => 'Transaction occured from return inventory.', 
        'generated_source'     => 'return_pos'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $debithead, 
        'amount'      => $debitamount, 
        'type'        => 0
        );
        $this->db->insert('mp_sub_entry',$sub_data); 

        //INVENTORY
        //2ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $anotherdebithead, 
        'amount'      => $cost, 
        'type'        => 0
        );

        $this->db->insert('mp_sub_entry',$sub_data);

        //2ST ENTRY
         $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $credithead, 
        'amount'      => $creditamount, 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data);

        //COST OF GOODS
        //1ST ENTRY
        $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $anothercredithead, 
            'amount'      => $cost, 
            'type'        => 1
        );

        $this->db->insert('mp_sub_entry',$sub_data);

        if($data_fields['total_bill'] != $data_fields['return_amount'] AND $data_fields['return_amount'] > 0)
        {
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $credithead2, 
            'amount'      => $creditamount2, 
            'type'        => 1
            );

           $this->db->insert('mp_sub_entry',$sub_data);
        }

        $data  = array( 
            'transaction_id' => $transaction_id,
            'date' => $data_fields['date'], 
            'agent' => $data_fields['agent'], 
            'invoice_id' => $data_fields['invoice_id'], 
            'cus_id' => $data_fields['customer_id'],
            'total_paid' => $data_fields['return_amount'],
            'total_bill' => $data_fields['total_bill'],
            'discount_given' => $data_fields['discount']
        );

        $this->db->insert('mp_return',$data);
        $return_id = $this->db->insert_id();

        //FETCHING THE RECORD FROM TEMPORARY TABLE
        $result = $this->db->get('mp_temp_barcoder_invoice');
        $result = $result->result();
        foreach ($result as $single_item) 
        {
            $this->db->where(['id' =>$single_item->product_id]);
            $query = $this->db->get('mp_productslist');
            $stock_med = $query->result();
            
           

            if($data_fields['mode'] == 'single')
            {
                $cal_qty = $stock_med[0]->quantity+$single_item->qty;
               
            }
            else
            {
                $cal_qty = $stock_med[0]->quantity+($single_item->qty*$stock_med[0]->packsize);
            }

            $data2  = array(
                'quantity' => $cal_qty
            );

            $this->db->where('id', $single_item->product_id);
            $this->db->update('mp_productslist', $data2);

            //ADDING ITEMS TO RETURN STOCK
            $sub_data  = array( 
                'return_id' => $return_id,
                'barcode' => $single_item->barcode,
                'product_no' => $single_item->product_no,
                'product_id' => $single_item->product_id,
                'product_name' => $single_item->product_name,
                'mg' => $single_item->mg,
                'price' => $single_item->price,
                'purchase' => $single_item->purchase,
                'qty' => $single_item->qty,
                'tax' => $single_item->tax,
                'mode' => $data_fields['mode']
            );

            $this->db->insert('mp_return_list',$sub_data);
                
        }

        $user_name = $this->session->userdata('user_id');

        //USED TO CLEAR TEMP INVOICE
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['source' => 'return']);
        $this->db->where(['agentid' => $user_name['id']]);
        $this->db->delete('mp_temp_barcoder_invoice');
        $this->db->db_debug = $db_debug;
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data_fields = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    //USED TO BANK COLLECTION
    public function update_collection($data_fields)
    {
         $this->db->trans_start();
        
         $credithead  = 0;
         $debithead   = 0;
         $debitamount  = 0;
         $creditamount  = 0;
 
         if($data_fields['amount'] >= 0)
         {
             $debithead    =  16; //CASH IN BANK 
             $credithead   = $data_fields['account_head']; //ACCOUNT HEAD
             $debitamount  = $data_fields['amount'];
             $creditamount = $data_fields['amount'];
 
 
             $data  = array(
             'date'                 => $data_fields['date'], 
             'naration'             => $data_fields['description'], 
             'generated_source'     => 'bank_collection'
             );
 
             $this->db->where('id', $data_fields['transaction_id']);
             $this->db->update('mp_generalentry', $data);
 
             //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
             $this->db->where(['parent_id' => $data_fields['transaction_id']]);
             $this->db->delete('mp_sub_entry');
 
             //TRANSACTION DETAILS 
             $data  = array(
             'bank_id'             => $data_fields['bank_id'], 
             'ref_no'              => $data_fields['refno'],
             'total_bill'          => $data_fields['amount']
             );
 
             $this->db->where('transaction_id', $data_fields['transaction_id']);
             $this->db->update('mp_bank_transaction', $data);
 
             //TRANSACTION DETAILS 
             $data  = array( 
                 'payee_id'  => $data_fields['payee_id'] 
             );
 
             $this->db->where('transaction_id', $data_fields['transaction_id']);
             $this->db->update('mp_bank_transaction_payee', $data);
 
             //1ST ENTRY
             $sub_data  = array(
             'parent_id'   => $data_fields['transaction_id'], 
             'accounthead' => $debithead, 
             'amount'      => $debitamount, 
             'type'        => 0
             );
             $this->db->insert('mp_sub_entry',$sub_data);  
 
             //2ST ENTRY
             $sub_data  = array(
             'parent_id'   => $data_fields['transaction_id'], 
             'accounthead' => $credithead, 
             'amount'      => $creditamount, 
             'type'        => 1
             );
             $this->db->insert('mp_sub_entry',$sub_data); 
 
             $this->db->trans_complete();
 
             if ($this->db->trans_status() === FALSE)
             {
                 $this->db->trans_rollback();
                 $data_fields = NULL;    
             }
             else
             {
                 $this->db->trans_commit();
             }
 
             return $data_fields;
        }        
    }   

    
    //USED TO ADD EXPENSES TRANSACTIONS 
    function add_expense_transaction($data_fields)
    {
        $this->db->trans_start();


        $credithead  = 0;
        $debithead   = 0;
        $credithead2 = 0;

        $debitamount  = 0;
        $creditamount  = 0;
        $creditamount2 = 0;

        if($data_fields['total_bill'] == $data_fields['total_paid'])
        {
            $debithead    = $data_fields['head_id']; // EXPENSE
            $credithead   = $data_fields['credithead'];  

            $debitamount  = $data_fields['total_bill'];
            $creditamount = $data_fields['total_paid'];
        }
        else if($data_fields['total_bill'] != $data_fields['total_paid'] AND $data_fields['total_paid'] > 0)
        {
            $debithead = $data_fields['head_id'];;
            $credithead2 = 5; //AP
            $credithead  = $data_fields['credithead'];

            $debitamount = $data_fields['total_bill'] ;
            $creditamount2 = $data_fields['total_bill']-$data_fields['total_paid'];
            $creditamount = $data_fields['total_paid'];
           
        }
        else if( $data_fields['total_paid'] == 0)
        {
            $debithead = $data_fields['head_id'];
            $credithead = 5;

            $debitamount = $data_fields['total_bill'];
            $creditamount = $data_fields['total_bill'];
        }
        else
        {

        }

        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => 'Transaction occured from expense', 
        'generated_source'     => 'expense'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();


        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $debithead, 
        'amount'      => $debitamount, 
        'type'        => 0
        );
        $this->db->insert('mp_sub_entry',$sub_data);  


        //2ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $credithead, 
        'amount'      => $creditamount, 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data); 

        if($data_fields['total_bill'] != $data_fields['total_paid'] AND $data_fields['total_paid'] > 0)
        {
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $credithead2, 
            'amount'      => $creditamount2, 
            'type'        => 1
            );

           $this->db->insert('mp_sub_entry',$sub_data);
        }

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'head_id'        => $data_fields['head_id'],
            'method'         => $data_fields['method'],
            'total_bill'     => $data_fields['total_bill'],
            'total_paid'     => $data_fields['total_paid'],
            'date'           => $data_fields['date'],
            'description'    => $data_fields['description'],
            'user'           => $data_fields['user'],
            'payee_id'       => $data_fields['payee_id']
        );

        $this->db->insert('mp_expense',$args);

        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data_fields['bank_id'], 
            'payee_id'            => $data_fields['payee_id'], 
            'method'              => $data_fields['method'],
            'total_paid'       =>  $data_fields['total_paid'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 1,
            'transaction_type'    => 'paid'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data_fields = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    public function customer_payment_collection($data_fields)
    {
        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;

        $debitamount  = 0;
        $creditamount  = 0;

        if($data_fields['amount'] >= 0)
        {
            $debithead    = $data_fields['credithead']; //CASH 
            $credithead   = 4; //ACCOUNT RECIEVABLE 

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        }

        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => 'Transaction occured from customer payments',
        'generated_source'     => 'customer_payment'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $debithead, 
        'amount'      => $debitamount, 
        'type'        => 0
        );
        $this->db->insert('mp_sub_entry',$sub_data);  

        //2ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $credithead, 
        'amount'      => $creditamount, 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data); 

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'customer_id' => $data_fields['customer_id'],
            'date' =>        $data_fields['date'],
            'amount' =>      $data_fields['amount'],
            'method' =>      $data_fields['method'],
            'description' => $data_fields['description'],
            'agentname' =>   $data_fields['agentname']
        );

        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data_fields['bank_id'], 
            'payee_id'            => $data_fields['customer_id'], 
            'method'              => $data_fields['method'],
            'total_paid'       =>  $data_fields['amount'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 1,
            'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 
        }

        //ADD TRANSACTION TO PAYMENTS
        $this->db->insert('mp_customer_payments',$args);
        $customer_payment_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data_fields = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data_fields;
    }    

    public function supplier_payment_collection($data_fields)
    {

        $this->db->trans_start();

        $credithead  = 0;
        $debithead   = 0;

        $debitamount  = 0;
        $creditamount  = 0;

        if($data_fields['amount'] >= 0 AND $data_fields['mode'] == 0)
        {
            $debithead    = 5; 
            $credithead   = $data_fields['credithead'];  

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        }
        else if($data_fields['amount'] >= 0 AND $data_fields['mode'] == 1)
        {   
            $debithead    = $data_fields['credithead']; 
            $credithead   = 4;  

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];
        }

        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => 'Transaction occured from Supplier payments', 
        'generated_source'     => 'supplier_payment'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

         //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $debithead, 
        'amount'      => $debitamount, 
        'type'        => 0
        );
        $this->db->insert('mp_sub_entry',$sub_data); 

        //2ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $credithead, 
        'amount'      => $creditamount, 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data);  

        // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
        $args = array(
            'transaction_id' => $transaction_id,
            'supplier_id' =>  $data_fields['supplier_id'],
            'amount' => $data_fields['amount'],
            'method' => $data_fields['method'],
            'date' => $data_fields['date'],
            'description' => $data_fields['description'],
            'agentname' => $data_fields['agentname'],
            'mode' => $data_fields['mode']
        );

        $this->db->insert('mp_supplier_payments',$args);

        if($data_fields['credithead'] == 16 AND $data_fields['mode'] == 0)
        {
            $mode = 'paid';
        }
        else
        {
            $mode = 'recieved';
        }

        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data_fields['bank_id'], 
            'payee_id'            => $data_fields['supplier_id'], 
            'method'              => $data_fields['method'],
            'total_paid'       =>  $data_fields['amount'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 1,
            'transaction_type'    => $mode
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 
        }
        //$supplier_payment_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data_fields = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    public function purchase_transaction($data_fields)
    {
        
        $this->db->trans_start();
    
        if($data_fields['status'] == 0)
        { 
            $data1  = array(
                'date'             => date('Y-m-d'), 
                'naration'         => 'Transaction occured from create purchases', 
                'generated_source'     => 'create_purchases'
                );

            $this->db->insert('mp_generalentry',$data1);
            $tran_id = $this->db->insert_id();

            if($data_fields['total_amount'] == $data_fields['cash'])
            {    
                $debithead    = 3; 
                $credithead   = $data_fields['credithead'];  

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $debithead, 
                    'amount'      => $debitamount, 
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data);

                //2ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $credithead, 
                    'amount'      => $creditamount, 
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data);
            }
            else if($data_fields['total_amount'] > $data_fields['cash'])
            {   
                $debithead     = 3; 
                $credithead    =  $data_fields['credithead'];  
                $credithead2   = 5;  

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];
                $creditamount2 = $data_fields['total_amount']-$data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $debithead, 
                    'amount'      => $debitamount, 
                    'type'        => 0
                );

                 $this->db->insert('mp_sub_entry',$sub_data);

                //2ND ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $credithead, 
                    'amount'      => $creditamount, 
                    'type'        => 1
                    );

                $this->db->insert('mp_sub_entry',$sub_data);

                //3RD ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $credithead2, 
                    'amount'      => $creditamount2, 
                    'type'        => 1
                    );

                $this->db->insert('mp_sub_entry',$sub_data);
            }

            

            // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
            $args = array(
                'transaction_id'  => $tran_id,
                'date'            => $data_fields['date'],
                'supplier_id'     => $data_fields['supplier_id'],
                'store'           => $data_fields['store'],
                'invoice_id'      => $data_fields['invoice_id'],
                'total_bill'      => $data_fields['total_amount'],
                'total_paid	'     => $data_fields['cash'],
                'payment_type_id' => $data_fields['payment_type_id'],
                'payment_date'    => $data_fields['payment_date'],
                'discount'        => $data_fields['offered_discount'],
                //'cash'            => $data_fields['cash'],
                'description'     => $data_fields['description'],
                'cus_picture'     => $data_fields['cus_picture'],
                'status'          => $data_fields['status']
            );  

        
            $this->db->insert('mp_purchase',$args);
            $purchase_id = $this->db->insert_id();


            //USER ID
            $user_name = $this->session->userdata('user_id');
        
            $this->db->select("*");
            $this->db->from('mp_temp_purchase');
            $this->db->where(['source' => 'purchase']);
            $this->db->where(['agentid' => $user_name['id']]);
        
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
                $result = $query->result();

                foreach($result as $single_item)
                {   
                    $data = array(

                        'purchase_id' => $purchase_id,
                        'mid'         => $single_item->product_id,
                        'cost'        => $single_item->cost,
                        'retail'      => $single_item->retail,
                        'pack_cost'   => $single_item->pack_cost,
                        'pack_retail' => $single_item->pack_retail,
                        'qty'         => $single_item->qty,
                        'manu_date'   => $single_item->manu_date,
                        'expiry_date' => $single_item->expire_date,
                        'source'      => 'purchase'	
                    );

                    $this->db->insert('mp_sub_purchase',$data);

                    $data = array(

                        'purchase_id'           => $purchase_id,
                        'mid'                   => $single_item->product_id,
                        'purchase'              => $single_item->cost,
                        'selling'               => $single_item->retail,
                        'pack_purchase_price'   => $single_item->pack_cost,
                        'pack_retail_price'     => $single_item->pack_retail,
                        'qty'                   => $single_item->qty,
                        'date'                  => $data_fields['date'],
                        'added'                 => $user_name['name'],
                        'manufacturing'         => $single_item->manu_date,
                        'expiry'                => $single_item->expire_date
                    );

                    $this->db->insert('mp_stock',$data);

                    $db_debug = $this->db->db_debug;
                    $this->db->db_debug = FALSE;
                    $this->db->where(['source' => 'purchase']);
                    $this->db->where(['agentid' => $user_name['id']]);
                    $this->db->delete('mp_temp_purchase');
                }  
                
                if($data_fields['credithead'] == 16)
                {

                    //TRANSACTION DETAILS 
                    $sub_data  = array(
                    'transaction_id'      => $tran_id, 
                    'bank_id'             => $data_fields['bank_id'], 
                    'method'              => $data_fields['payment_type_id'],
                    'total_bill'          => $data_fields['total_amount'],
                    'total_paid'          => $data_fields['cash'],
                    'ref_no'              => $data_fields['ref_no'],
                    'transaction_status'  => 0,
                    'transaction_type'    => 'paid',
                    'attachment'          => 'default.jpg'
                    );

                    $this->db->insert('mp_bank_transaction',$sub_data); 
                    
                    
                    //TRANSACTION DETAILS 
                    $sub_data_trans  = array(
                        'transaction_id'      => $tran_id, 
                        'payee_id'            => $data_fields['supplier_id']
                    );

                    $this->db->insert('mp_bank_transaction_payee',$sub_data_trans); 
                }
            }
            else
            {
                $this->db->trans_rollback();
                $data_fields = NULL;    
            }
                
        }
        else if($data_fields['status'] == 1)
        {
            

            $data1  = array(
                'date'             => date('Y-m-d'), 
                'naration'         => 'Transaction occured from purchases return', 
                'generated_source'     => 'purchases_return'
                );

            $this->db->insert('mp_generalentry',$data1);
            $tran_id = $this->db->insert_id();

            if($data_fields['total_amount'] == $data_fields['cash'])
            {    
                $debithead    = $data_fields['credithead']; 
                $credithead   = 3;  

                $debitamount  = $data_fields['total_amount'];
                $creditamount = $data_fields['cash'];

                 //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $debithead, 
                    'amount'      => $debitamount, 
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data);

                //2ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $credithead, 
                    'amount'      => $creditamount, 
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data);

            }
            else if($data_fields['total_amount'] > $data_fields['cash'])
            {   
                $debithead     = $data_fields['credithead']; 
                $debithead2    = 4; 
                $credithead    = 3;  

                $debitamount  = $data_fields['cash'];
                $creditamount = $data_fields['total_amount'];
                $debitamount2 = $data_fields['total_amount']-$data_fields['cash'];

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $debithead, 
                    'amount'      => $debitamount, 
                    'type'        => 0
                );
                 $this->db->insert('mp_sub_entry',$sub_data);
                 
                //2ND ENTRY
                 $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $debithead2, 
                    'amount'      => $debitamount2, 
                    'type'        => 0
                    );

                $this->db->insert('mp_sub_entry',$sub_data);
                

                //3RD ENTRY
                $sub_data  = array(
                    'parent_id'   => $tran_id, 
                    'accounthead' => $credithead, 
                    'amount'      => $creditamount, 
                    'type'        => 1
                    );

                $this->db->insert('mp_sub_entry',$sub_data);
            }

            

            // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
            $args = array(
                'transaction_id' => $tran_id,
                'date' => $data_fields['date'],
                'supplier_id' => $data_fields['supplier_id'],
                'store' => $data_fields['store'],
                'invoice_id' => $data_fields['invoice_id'],
                'total_bill' => $data_fields['total_amount'],
                'payment_type_id' => $data_fields['payment_type_id'],
                'payment_date' => $data_fields['payment_date'],
                'total_paid' => $data_fields['cash'],
                'description' => $data_fields['description'],
                'cus_picture' => $data_fields['cus_picture'],
                'status' => $data_fields['status']
            );  

        
            $this->db->insert('mp_purchase',$args);
            $purchase_id = $this->db->insert_id();


            //USER ID
            $user_name = $this->session->userdata('user_id');
        
            $this->db->select("*");
            $this->db->from('mp_temp_purchase');
            $this->db->where(['source' => 'preturn']);
            $this->db->where(['agentid' => $user_name['id']]);
        
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
                $result = $query->result();

                foreach($result as $single_item)
                {   
                    $data = array(

                        'purchase_id' => $purchase_id,
                        'mid'         => $single_item->product_id,
                        'cost'        => $single_item->cost,
                        'retail'      => $single_item->retail,
                        'pack_cost'   => $single_item->pack_cost,
                        'pack_retail' => $single_item->pack_retail,
                        'qty'         => $single_item->qty,
                        'manu_date'   => $single_item->manu_date,
                        'expiry_date' => $single_item->expire_date,
                        'source'      => 'preturn'	
                    );

                    $this->db->insert('mp_sub_purchase',$data);

                   

                    $db_debug = $this->db->db_debug;
                    $this->db->db_debug = FALSE;
                    $this->db->where(['source' => 'preturn']);
                    $this->db->where(['agentid' => $user_name['id']]);
                    $this->db->delete('mp_temp_purchase');
                }  
                
                if($data_fields['credithead'] == 16)
                {

                    //TRANSACTION DETAILS 
                    $sub_data  = array(
                    'transaction_id'      => $tran_id, 
                    'bank_id'             => $data_fields['bank_id'], 
                    'method'              => $data_fields['payment_type_id'],
                    'total_bill'          => $data_fields['total_amount'],
                    'total_paid'          => $data_fields['cash'],
                    'ref_no'              => $data_fields['ref_no'],
                    'transaction_status'  => 1,
                    'transaction_type'    => 'recieved',
                    'attachment'          => 'default.jpg'
                    );

                    $this->db->insert('mp_bank_transaction',$sub_data); 
                    
                    //TRANSACTION DETAILS 
                    $sub_data  = array(
                        'transaction_id'      => $tran_id, 
                        'payee_id'            => $data_fields['supplier_id']
                    );

                    $this->db->insert('mp_bank_transaction_payee',$sub_data); 

                }
            }
            else
            {
                $this->db->trans_rollback();
                $data_fields = NULL;    
            }

        }
        
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data_fields = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data_fields;
    }

    //USED TO INSERT SALE AND ACCOUNTS TRANSACTION
    function single_supply_transaction($data)
    {
        $this->db->trans_start();
      
        // PASSING ARRAY OF VALUES RECIEVED FROM TEXTBOX TO generate PRINT
        $credithead  = 0;
        $debithead   = 0;
        $debithead2 = 0;

        $debitamount  = 0;
        $debitamount2  = 0;
        $creditamount = 0;

        
        $anothercredithead = 0;
        $anotherdebithead = 0;

        if($data['total_bill'] == $data['bill_paid'])
        {
            $debithead = $data['credithead']; // CASH
            $credithead = 3; //  INVENTORY

            $anotherdebithead = 18; //COG
            $anothercredithead = 19; // SALES 

            $debitamount = $data['total_bill'];
            $creditamount = $data['bill_paid'];
            $cost         = $data['net_cost'];
            
        }
        else if(($data['total_bill'] != $data['bill_paid']) AND $data['bill_paid'] > 0)
        {
           
            $debithead = $data['credithead'];
            $debithead2 = 4; //AR
            $credithead  = 3;

            $anotherdebithead = 18; //COG
            $anothercredithead = 19; // SALES
            $cost         = $data['net_cost'];

            
            $debitamount = $data['bill_paid'];
            $debitamount2 = $data['total_bill']-$data['bill_paid'];
            $creditamount = $data['total_bill'];
           
        }
        else if( $data['bill_paid'] == 0)
        {
            $debithead = 4;
            $credithead = 3;

            $anotherdebithead = 18; //COG
            $anothercredithead = 19; // SALES
            $cost         = $data['net_cost'];
            
            $debitamount = $data['total_bill'];
            $creditamount = $data['total_bill'];
        }
        else
        {

        }

        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => 'Transaction occured from supply POS', 
        'generated_source'     => 'pos'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

        if($debithead != 0)
        {
            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $debithead, 
                'amount'      => $debitamount, 
                'type'        => 0
                );

            $this->db->insert('mp_sub_entry',$sub_data);

            //COST OF GOODS
            //1ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $anotherdebithead, 
                'amount'      => $cost, 
                'type'        => 0
            );

            $this->db->insert('mp_sub_entry',$sub_data);
        }

        if($debithead2 != 0)
        {
            //2ND ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $debithead2, 
            'amount'      => $debitamount2, 
            'type'        => 0
            );

           $this->db->insert('mp_sub_entry',$sub_data);
        }

        if($credithead != 0)
        {
            //3RD ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $credithead, 
                'amount'      => $cost, 
                'type'        => 1
                );
            $this->db->insert('mp_sub_entry',$sub_data);

             //SALES
            //2ST ENTRY
            $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $anothercredithead, 
                'amount'      => $data['total_bill'], 
                'type'        => 1
                );

            $this->db->insert('mp_sub_entry',$sub_data);
        }

        $data_invoice  = array(
          'transaction_id' => $transaction_id, 
          'discount'       => $data['discount'], 
          'date'           => $data['date'], 
          'status'         => $data['status'], 
          'agentname'      => $data['agentname'], 
          'driver_id'      => $data['driver_id'], 
          'sales_man_id'   => $data['salesman_id'], 
          'store_id'       => $data['store_id'], 
          'vehicle_id'     => $data['vehicle_id'], 
          'region_id'      => $data['region_id'], 
          'payment_method' => $data['payment_method'], 
          'total_bill'     => $data['total_bill'],  
          'total_paid'      => $data['bill_paid'], 
          'description'    => $data['description'], 
          'source'         => $data['source'], 
          'cus_id'         => $data['cus_id']
        );

         // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_invoices',$data_invoice);
        $order_id = $this->db->insert_id();

        //FETCHING THE RECORD FROM TEMPORARY TABLE
        $result = $this->db->get('mp_temp_barcoder_invoice');
        $result = $result->result();
        foreach ($result as $single_item) 
        {

            $this->db->where(['id' => $single_item->product_id]);
            $query = $this->db->get('mp_productslist');

            if ($query->num_rows() > 0)
            {
                $result = $query->result();
                $packsize = $result[0]->packsize;
            }
            else
            {
                $packsize = 0 ;
            }

            $data1  = array(
            'order_id'     => $order_id, 
            'product_no'   => $single_item->product_no, 
            'product_id'  => $single_item->product_id, 
            'product_name' => $single_item->product_name, 
            'mg'           => $single_item->mg, 
            'price'        => ($single_item->price), 
            'purchase'     => $single_item->purchase, 
            'qty'          => $single_item->qty/ $packsize, 
            'discount'          => $single_item->discount, 
            'tax'          => $single_item->tax 
            );

            $this->db->insert('mp_sales',$data1);
        }

        $pay_method = NULL;

        if($data['payment_method'] == 0)
        {
            $pay_method = 'Cash';
        }
        else
        {
           $pay_method = 'Cheque';
        }

        if($data['credithead'] == 16)
        {
            
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data['bank_id'], 
            'method'              => $pay_method,
            'total_bill'          => $data['total_bill'],
            'total_paid'          => $data['bill_paid'],
            'ref_no'              => $data['ref_no'],
            'transaction_status'  => 1,
            'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id' => $transaction_id, 
                'payee_id'       => $data['cus_id']
                );

            $this->db->insert('mp_bank_transaction_payee',$sub_data); 
        }


        //USED TO CLEAR TEMP INVOICE
        $this->db->truncate('mp_temp_barcoder_invoice');  
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    }

    //USED TO CREATE A JOURNAL VOUCHER ENTRY
    function journal_voucher_entry($data)
    {
        $trans_data = array(
            'date'              => $data['date'],
            'naration'          => $data['description'],
            'generated_source'  => 'journal_voucher'
        );

        $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_generalentry',$trans_data);
        $order_id = $this->db->insert_id();

        $total_heads = count($data['account_head']);

        for($i = 0; $i < $total_heads; $i++)
        {
            if($data['account_head'] != 0)
            {
                if($data['debitamount'][$i] != 0)
                {
                    $sub_data  = array(
                    'parent_id'   => $order_id, 
                    'accounthead' => $data['account_head'][$i], 
                    'amount'      => $data['debitamount'][$i],  
                    'type'        => 0
                    );
                }
                else if($data['creditamount'][$i] != 0)
                {
                    $sub_data  = array(
                    'parent_id'   => $order_id, 
                    'accounthead' => $data['account_head'][$i], 
                    'amount'      => $data['creditamount'][$i],  
                    'type'        => 1
                    );
                }

                $this->db->insert('mp_sub_entry',$sub_data);

            }
        }

        //TRANSACTION DETAILS 
        $sub_data  = array(
            'transaction_id' => $order_id, 
            'payee_id'       => $data['payee_id'], 
            'receipt_date'   => $data['date'],
            'memo'           => $data['description'],
            'total_bill'     => $data['total_debit_amount'],
            'type'           => $data['voucher_type']
        );

        $this->db->insert('mp_payment_voucher',$sub_data); 

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    } 

     //USED TO UPDATE A JOURNAL VOUCHER ENTRY
     function update_journal_voucher_entry($data)
     {
         $this->db->trans_start();
         
         $data_main  = array(
             'naration' => $data['description']
         );
 
         $this->db->where('id',$data['transaction_id']);
         $this->db->update('mp_generalentry',$data_main);
 
         //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
         $this->db->where(['parent_id' => $data['transaction_id']]);
         $this->db->delete('mp_sub_entry');
 
         //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
         $this->db->where(['transaction_id' => $data['transaction_id']]);
         $this->db->delete('mp_payment_voucher');
 
       
 
         $total_heads = count($data['account_head']);
 
 
         for($i = 0; $i < $total_heads; $i++)
         {
             if($data['account_head'] != 0)
             {
 
                 if($data['debitamount'][$i] >= 0 AND $data['creditamount'][$i] == 0)
                 {
                     
                     $sub_data  = array(
                     'parent_id'   => $data['transaction_id'], 
                     'accounthead' => $data['account_head'][$i], 
                     'amount'      => $data['debitamount'][$i],  
                     'type'        => 0
                     );
 
                    
                 }
                 else if($data['creditamount'][$i] >= 0 AND $data['debitamount'][$i] == 0)
                 {
 
                     $sub_data  = array(
                     'parent_id'   => $data['transaction_id'], 
                     'accounthead' => $data['account_head'][$i], 
                     'amount'      => $data['creditamount'][$i],  
                     'type'        => 1
                     );
                 }
 
                 $this->db->insert('mp_sub_entry',$sub_data);
 
             }
         }
 
         //TRANSACTION DETAILS 
         $sub_data  = array(
             'transaction_id' => $data['transaction_id'], 
             'payee_id'       => $data['payee_id'], 
             'receipt_date'   => $data['date'],
             'memo'           => $data['description'],
             'total_bill'     => $data['total_debit_amount'],
             'type'           => $data['voucher_type']
         );
 
         $this->db->insert('mp_payment_voucher',$sub_data); 
 
         $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE)
         {
             $this->db->trans_rollback();
             $data = NULL;    
         }
         else
         {
             $this->db->trans_commit();
         }
 
         return $data;
     }
    
     //USED TO CREATE A OPENING BALANCE OF ACCOUNT HOLDERS
    function new_opening_account_balance($data)
    {
    
        $this->db->trans_start();
       // $this->db->trans_strict(FALSE);

        //DEBIT = 0  AND CREDIT = 1
        if($data['nature'] == 0)
        {
            $trans_data = array(
                'date'=> $data['date'],
                'naration'=>'Opening balance adjustment for debit account holder',
                'generated_source'=> 'Opening_balance'
            );

             //INSERT AND GET LAST ID
             $this->db->insert('mp_generalentry',$trans_data);
             $order_id = $this->db->insert_id();

            //DEDUCTING CASH ACCOUNT FOR BALANCING NEW CASH RECIEVABLE
            $sub_data  = array(
                'parent_id'   => $order_id, 
                'accounthead' => 2, 
                'amount'      => $data['amount'],  
                'type'        => $data['nature']
            );
            
            $this->db->insert('mp_sub_entry',$sub_data);

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW RECEIVABLE
            $sub_data  = array(
                'parent_id'   => $order_id, 
                'accounthead' => 4, 
                'amount'      => $data['amount'],  
                'type'        => 1
            );
            
            $this->db->insert('mp_sub_entry',$sub_data);

            $trans_data = array(
                'date'=> $data['date'],
                'naration'=>$data['description'],
                'generated_source'=> 'Opening_balance'
            );

             //INSERT AND GET LAST ID
             $this->db->insert('mp_generalentry',$trans_data);
             $new_order_id = $this->db->insert_id();

            //NOW ADDING THE SAME AMOUNT OF RECEIVABLE TO ADUSTMENT

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW RECEIVABLE
             $sub_data  = array(
                'parent_id'   => $new_order_id, 
                'accounthead' => 4, 
                'amount'      => $data['amount'],  
                'type'        => 0
            );
            
            $this->db->insert('mp_sub_entry',$sub_data);

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW RECEIVABLE
            $sub_data  = array(
                'parent_id'   => $new_order_id, 
                'accounthead' => 2, 
                'amount'      => $data['amount'],  
                'type'        => 1
            );
            
            $this->db->insert('mp_sub_entry',$sub_data);


            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id' => $new_order_id, 
                'payee_id'       => $data['payee_id'], 
                'receipt_date'   => $data['date'],
                'memo'           => $data['description'],
                'total_bill'     => $data['amount'],
                'type'           => 3
            );
        }
        else
        {

            $trans_data = array(
                'date'=> $data['date'],
                'naration'=>'Opening balance adjustment for credit  account holder',
                'generated_source'=> 'Opening_balance'
            );

             //INSERT AND GET LAST ID
             $this->db->insert('mp_generalentry',$trans_data);
             $credit_order_id = $this->db->insert_id();

            //DEDUCTING CASH ACCOUNT FOR BALANCING NEW CASH PAYABLE
            $sub_data  = array(
                'parent_id'   => $credit_order_id, 
                'accounthead' => 5, 
                'amount'      => $data['amount'],  
                'type'        => 0
            );
            
            $this->db->insert('mp_sub_entry',$sub_data);

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW PAYABLE
            $sub_data  = array(
                'parent_id'   => $credit_order_id, 
                'accounthead' => 2, 
                'amount'      => $data['amount'],  
                'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data);


            $trans_data = array(
                'date'=> $data['date'],
                'naration'=>$data['description'],
                'generated_source'=> 'Opening_balance'
            );

            $this->db->insert('mp_generalentry',$trans_data);
            $credit_new_order_id = $this->db->insert_id();

           //NOW ADDING THE SAME AMOUNT OF RECEIVABLE TO ADUSTMENT

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW RECEIVABLE
            $sub_data  = array(
               'parent_id'   => $credit_new_order_id, 
               'accounthead' => 2, 
               'amount'      => $data['amount'],  
               'type'        => 0
            );
            $this->db->insert('mp_sub_entry',$sub_data);

            //ADJUSITING RECEIVABLE ACCOUNT FRO MANAGING NEW RECEIVABLE
            $sub_data  = array(
               'parent_id'   => $credit_new_order_id, 
               'accounthead' => 5, 
               'amount'      => $data['amount'],  
               'type'        => 1
            );
           
           $this->db->insert('mp_sub_entry',$sub_data);


            //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id' => $credit_new_order_id, 
                'payee_id'       => $data['payee_id'], 
                'receipt_date'   => $data['date'],
                'memo'           => $data['description'],
                'total_paid'     => $data['amount'],
                'type'           => 3
            );
        }
       

        $this->db->insert('mp_payment_voucher',$sub_data); 

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    }

    //USED TO CREATE A PAYMENT VOUCHER ENTRY
    function payment_voucher_entry($data)
    {
        

        $trans_data = array(
            'date'              =>  $data['date'],
            'naration'          =>  $data['description'],
            'generated_source'  => 'debit_voucher'
        );

            $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_generalentry',$trans_data);
        $order_id = $this->db->insert_id();

        $total_heads = count($data['account_head']);

        for($i = 0; $i < $total_heads; $i++)
        {
            if($data['account_head'] != 0)
            {
                if($data['debitamount'][$i] != 0)
                {
                    $sub_data  = array(
                    'parent_id'   => $order_id, 
                    'accounthead' => $data['account_head'][$i], 
                    'amount'      => $data['debitamount'][$i],  
                    'type'        => 0
                    );
                }
                
                $this->db->insert('mp_sub_entry',$sub_data);

            }
        }

        $sub_data  = array(
        'parent_id'   => $order_id, 
        'accounthead' => 2, //CASH 
        'amount'      => $data['creditamount'],  
        'type'        => 1
        );

        $this->db->insert('mp_sub_entry',$sub_data);


        //TRANSACTION DETAILS 
        $sub_data  = array(
        'transaction_id'      => $order_id, 
        'payee_id'            => $data['payee_id'], 
        'receipt_date'        => $data['date'],
        'memo'                => $data['description'],
        'total_paid'          => $data['creditamount'],
        'type'                => $data['voucher_type']
        );

        $this->db->insert('mp_payment_voucher',$sub_data); 
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    }

     //USED TO CREATE A OPENING BALANCE
    function opening_balance($data)
    {
        
        $trans_data = array(
            'date'=> $data['date'],
            'naration'=>$data['description'],
            'generated_source'=> 'Opening balance'
        );

        $this->db->trans_start();
       // $this->db->trans_strict(FALSE);
        //INSERT AND GET LAST ID
        $this->db->insert('mp_generalentry',$trans_data);
        $order_id = $this->db->insert_id();

        $sub_data  = array(
        'parent_id'   => $order_id, 
        'accounthead' => $data['head'], 
        'amount'      => $data['amount'],  
        'type'        => $data['nature']
        );
            
        $this->db->insert('mp_sub_entry',$sub_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $data;
    }

    public function create_cheque($data_fields)
    {
        $this->db->trans_start();
       
        $credithead  = 0;
        $debithead   = 0;
        $debitamount  = 0;
        $creditamount  = 0;

        if ($data_fields['amount'] >= 0) {
            $debithead    = $data_fields['account_head']; //ACCOUNT HEAD
            $credithead   = 16; //CASH IN BANK

            $debitamount  = $data_fields['amount'];
            $creditamount = $data_fields['amount'];


            $data1  = array(
            'date'                 => $data_fields['date'],
            'naration'             => $data_fields['description'],
            'generated_source'     => 'cheque'
            );

            $this->db->insert('mp_generalentry', $data1);
            $transaction_id = $this->db->insert_id();


            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $debithead,
            'amount'      => $debitamount,
            'type'        => 0
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //2ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id,
            'accounthead' => $credithead,
            'amount'      => $creditamount,
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry', $sub_data);

            //TRANSACTION DETAILS
            $sub_data  = array(
            'transaction_id'      => $transaction_id,
            'bank_id'             => $data_fields['bank_id'],
            'method'              => 'Cheque',
            'ref_no'              => $data_fields['cheque_id'],
            'total_bill'          => $data_fields['amount'],
            'total_paid'          => $data_fields['amount'],
            'transaction_status'  => 1,
            'transaction_type'    => 'paid',
            'cleared_date'        => date('Y-m-d'),
            'attachment'          => $data_fields['attachment']
            );

            $this->db->insert('mp_bank_transaction', $sub_data);



            //TRANSACTION DETAILS PAYEE
            $sub_data  = array(
            'transaction_id'      => $transaction_id,
            'payee_id'            => $data_fields['payee_id'],
            );

            $this->db->insert('mp_bank_transaction_payee', $sub_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $data_fields = null;
            } else {
                $this->db->trans_commit();
            }

            return $data_fields;
        }
    }   

    //TRANSACTION USED TO CREATE A BANK DEPOSIT 
    public function create_deposit($data_fields)
    {
         $this->db->trans_start();
        
         $credithead    = 0;
         $debithead     = 0;
         $debitamount   = 0;
         $creditamount  = 0;
 
         if($data_fields['amount'] >= 0)
         {
             $debithead    =  16; //CASH IN BANK 
             $credithead   = $data_fields['account_head']; //ACCOUNT HEAD
             $debitamount  = $data_fields['amount'];
             $creditamount = $data_fields['amount'];
 
             $data1  = array(
             'date'                 => $data_fields['date'], 
             'naration'             => $data_fields['memo'],  
             'generated_source'     => 'deposit'
             );
 
             $this->db->insert('mp_generalentry',$data1);
             $transaction_id = $this->db->insert_id();
 
             //1ST ENTRY
             $sub_data  = array(
             'parent_id'   => $transaction_id, 
             'accounthead' => $debithead, 
             'amount'      => $debitamount, 
             'type'        => 0
             );
             $this->db->insert('mp_sub_entry',$sub_data);  
 
             //2ST ENTRY
             $sub_data  = array(
             'parent_id'   => $transaction_id, 
             'accounthead' => $credithead, 
             'amount'      => $creditamount, 
             'type'        => 1
             );
             $this->db->insert('mp_sub_entry',$sub_data); 
 
             //TRANSACTION DETAILS 
             $sub_data  = array(
             'transaction_id'      => $transaction_id, 
             'bank_id'             => $data_fields['bank_id'], 
             'method'              => $data_fields['method'],
             'total_bill'          => $data_fields['amount'],
             'total_paid'          => $data_fields['amount'],
             'ref_no'              => $data_fields['refno'],
             'transaction_status'  => 1,
             'transaction_type'    => 'recieved',
             'cleared_date'        => date('Y-m-d'),
             'attachment'          => $data_fields['attachment']
             );
 
             $this->db->insert('mp_bank_transaction',$sub_data); 
 
             //TRANSACTION DETAILS PAYEE
             $sub_data  = array(
             'transaction_id'      => $transaction_id, 
             'payee_id'            => $data_fields['payee_id'], 
             
             );
 
             $this->db->insert('mp_bank_transaction_payee',$sub_data); 
 
             $this->db->trans_complete();
 
             if ($this->db->trans_status() === FALSE)
             {
                 $this->db->trans_rollback();
                 $data_fields = NULL;    
             }
             else
             {
                 $this->db->trans_commit();
             }
 
             return $data_fields;
         }        
    }

     //USED TO CREATE A TRANSACTION WHEN CREATE NEW BANK 
     function bank_transaction($data_fields)
     {
         $this->db->trans_start();
        
         $credithead  = 0;
         $debithead   = 0;
         $debitamount  = 0;
         $creditamount  = 0;
 
         if ($data_fields['end_balance'] >= 0) {
 
             // ASSIGN THE VALUES OF TEXTBOX TO ASSOCIATIVE ARRAY
             $args = array(
                 'bankname' => $data_fields['bankname'],
                 'branch' => $data_fields['branch'],
                 'branchcode' => $data_fields['branchcode'],
                 'title' => $data_fields['title'],
                 'accountno' =>$data_fields['accountno']
             );
 
             // DEFINES CALL THE FUNCTION OF insert_data FORM Crud_model CLASS
             $this->db->insert('mp_banks', $args);
             $bank_id = $this->db->insert_id();
 
             $debithead    =  16; //CASH IN BANK
             //$credithead   = $data_fields['account_head']; //ACCOUNT HEAD
 
             $debitamount  = $data_fields['end_balance'];
             // $creditamount = $data_fields['amount'];
 
             $data1  = array(
             'date'                 => $data_fields['end_date'],
             'naration'             => 'Transaction occurecd from adding new bank account',
             'generated_source'     => 'add_bank'
             );
 
             $this->db->insert('mp_generalentry', $data1);
             $transaction_id = $this->db->insert_id();
 
             //1ST ENTRY
             $sub_data  = array(
             'parent_id'   => $transaction_id,
             'accounthead' => $debithead,
             'amount'      => $debitamount,
             'type'        => 0
             );
             $this->db->insert('mp_sub_entry', $sub_data);

             $data1  = array(
                'date'                 => $data_fields['end_date'],
                'naration'             => 'Adjusting new bank account',
                'generated_source'     => 'add_bank'
             );
    
                $this->db->insert('mp_generalentry', $data1);
                $adjust_id = $this->db->insert_id();

                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $adjust_id,
                    'accounthead' => $debithead,
                    'amount'      => $debitamount,
                    'type'        => 1
                );
                
                $this->db->insert('mp_sub_entry', $sub_data);
 
             //TRANSACTION DETAILS
             $sub_data  = array(
                 'transaction_id'      => $transaction_id,
                 'cleared_date'        => $data_fields['end_date'],
                 'bank_id'             => $bank_id,
                 'total_bill'          => $data_fields['end_balance'],
                 'total_paid'          => $data_fields['end_balance'],
                 'transaction_status'  => 0,
                 'transaction_type'    => 'opening_account'
             );
 
             $this->db->insert('mp_bank_transaction', $sub_data);
 
             $this->db->trans_complete();
 
             if ($this->db->trans_status() === false) {
                 $this->db->trans_rollback();
                 $data_fields = null;
             } else {
                 $this->db->trans_commit();
             }
 
             return $data_fields;
         }
     } 

    //USED TO EDIT INVOICE 
    function edit_invoice_transaction($data, $invoice_id)
    {
        $this->db->trans_start();

        $this->db->where(['id' => $invoice_id]);
        $query = $this->db->get('mp_invoices');
        $result = $query->result();
        $transaction_id = $result[0]->transaction_id;

        $credithead  = 0;
        $creditamount  = 0;

        $debithead   = 0;
        $debitamount  = 0;

        if($transaction_id != 0)
        {
            $db_debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            $this->db->where(['parent_id' => $transaction_id]);
            $this->db->delete('mp_sub_entry');
            if ($this->db->affected_rows() > 0)
            {
                
                $credithead  = 0;
                $debithead   = 0;

                if($data['total_bill'] == $data['bill_paid'])
                {
                    $debithead = 2; // CASH
                    $credithead = 3; // INVENTORY
                    
                    $debitamount = $data['total_bill'];
                    $creditamount = $data['bill_paid'];
                }
                else if($data['total_bill'] != $data['bill_paid'] AND $data['bill_paid'] > 0)
                {
                    $debithead = 2;
                    $debithead2 = 4; //AR
                    $credithead  = 3;

                    $debitamount = $data['bill_paid'];
                    $debitamount2 = $data['total_bill']-$data['bill_paid'];
                    $creditamount = $data['total_bill'];
                   
                }
                else if( $data['bill_paid'] == 0)
                {
                    $debithead = 4;
                    $credithead = 3;

                    $debitamount = $data['total_bill'];
                    $creditamount = $data['total_bill'];
                }
                else
                {

                }

                //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $debithead, 
                'amount'      => $debitamount, 
                'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data);

                if($data['total_bill'] != $data['bill_paid'] AND $data['bill_paid'] > 0)
                {
                    //3RD ENRTY
                    $sub_data  = array(
                    'parent_id'   => $transaction_id, 
                    'accounthead' => $debithead2, 
                    'amount'      => $debitamount2, 
                    'type'        => 0
                    );

                    $this->db->insert('mp_sub_entry',$sub_data);
                }

                //2ST ENTRY
                $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $credithead, 
                'amount'      => $creditamount, 
                'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data);
            }

            $this->db->db_debug = $db_debug;

           
            //UPDATE invoices
            $this->db->where('id',$invoice_id);
            $this->db->update('mp_invoices', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $data = NULL;    
            }
            else
            {
                $this->db->trans_commit();
            }

            return $data;
        }        
    }


    //USED TO RESTORE BACKUP
    function backup_restore_transaction()
    {
        $this->db->trans_start();
        $config['upload_path'] = './uploads/files';
        $config['allowed_types'] = 'txt';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $this->load->library('upload',$config);
        if (!$this->upload->do_upload('backup_file'))
        {
             $result = '';
        }
        else
        {
            $data = $this->upload->data();
            // $data will contain full inforation
            $result = $data['full_path'];
        }

        $isi_file = file_get_contents($result);
        foreach (explode(";\n", $isi_file) as $sql) 
        {
            $sql = trim($sql);

            if ($sql) 
            {
               $this->db->query($sql);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $result = NULL;    
        }
        else
        {
            $this->db->trans_commit();
        }

        return $result;        
    }

     //USED TO UPDATE A PAYMENT VOUCHER ENTRY
     function update_payment_voucher_entry($data_fields)
     {
         
         $data  = array( 
             'naration'   => $data_fields['description']
         );
 
        
          $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
         //INSERT AND GET LAST ID
 
         $this->db->where('id', $data_fields['transaction_id']);
         $this->db->update('mp_generalentry', $data);
 
 
         //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
         $this->db->where(['parent_id' => $data_fields['transaction_id']]);
         $this->db->delete('mp_sub_entry');
 
         //TRANSACTION DETAILS 
         $data  = array( 
             'payee_id'        => $data_fields['payee_id'], 
             'receipt_date'    => $data_fields['date'],
             'memo'            => $data_fields['description'],
             'total_paid'      => $data_fields['creditamount']
         );
 
         $this->db->where('transaction_id', $data_fields['transaction_id']);
         $this->db->update('mp_payment_voucher', $data);
 
         $total_heads = count($data_fields['account_head']);
 
         for($i = 0; $i < $total_heads; $i++)
         {
             if($data_fields['account_head'] != 0)
             {
                 if($data_fields['debitamount'][$i] >= 0)
                 {
                     $sub_data  = array(
                     'parent_id'   => $data_fields['transaction_id'], 
                     'accounthead' => $data_fields['account_head'][$i], 
                     'amount'      => $data_fields['debitamount'][$i],  
                     'type'        => 0
                     );
                 }
                 
                 $this->db->insert('mp_sub_entry',$sub_data);
 
             }
         }
 
         $sub_data  = array(
         'parent_id'   => $data_fields['transaction_id'], 
         'accounthead' => 2, //CASH 
         'amount'      => $data_fields['creditamount'],  
         'type'        => 1
         );
 
         $this->db->insert('mp_sub_entry',$sub_data);
 
         
         $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE)
         {
             $this->db->trans_rollback();
             $data = NULL;    
         }
         else
         {
             $this->db->trans_commit();
         }
 
         return $data;
     } 
     
    //USED TO CREATE A DEBIT VOUCHER ENTRY
    function credit_voucher_entry($data)
    {
        $trans_data = array(
             'date'              =>  $data['date'],
             'naration'          =>  $data['description'],
             'generated_source'  => 'credit_voucher'
        );
 
        $this->db->trans_start();
 
         // $this->db->trans_strict(FALSE);
         //INSERT AND GET LAST ID
         $this->db->insert('mp_generalentry',$trans_data);
         $order_id = $this->db->insert_id();
         $total_heads = count($data['account_head']);
         
         $sub_data  = array(
         'parent_id'   => $order_id, 
         'accounthead' => 2, //CASH 
         'amount'      => $data['creditamount'],  
         'type'        => 0
         );
 
         $this->db->insert('mp_sub_entry',$sub_data);
         for($i = 0; $i < $total_heads; $i++)
         {
             if($data['account_head'] != 0)
             {
                 if($data['debitamount'][$i] != 0)
                 {
                     $sub_data  = array(
                     'parent_id'   => $order_id, 
                     'accounthead' => $data['account_head'][$i], 
                     'amount'      => $data['debitamount'][$i],  
                     'type'        => 1
                     );
                 }
                 
                 $this->db->insert('mp_sub_entry',$sub_data);
             }
         }
 
        
         //TRANSACTION DETAILS 
         $sub_data  = array(
         'transaction_id'      => $order_id, 
         'payee_id'            => $data['payee_id'], 
         'receipt_date'        => $data['date'],
         'memo'                => $data['description'],
         'total_paid'          => $data['creditamount'],
         'type'                => $data['voucher_type']
         );
 
         $this->db->insert('mp_payment_voucher',$sub_data); 
         
         $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE)
         {
             $this->db->trans_rollback();
             $data = NULL;    
         }
         else
         {
             $this->db->trans_commit();
         }
 
         return $data;
    } 

     //USED TO UPDATE A CREDIT VOUCHER ENTRY
     function update_credit_voucher_entry($data_fields)
     {
         
 
         $data  = array(
             'naration'  => $data_fields['description']
         );
 
        
          $this->db->trans_start();
        // $this->db->trans_strict(FALSE);
         //INSERT AND GET LAST ID
 
         $this->db->where('id', $data_fields['transaction_id']);
         $this->db->update('mp_generalentry', $data);
 
 
         //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
         $this->db->where(['parent_id' => $data_fields['transaction_id']]);
         $this->db->delete('mp_sub_entry');
 
         //TRANSACTION DETAILS 
         $data  = array( 
             'payee_id'        => $data_fields['payee_id'], 
             'receipt_date'    => $data_fields['date'],
             'memo'            => $data_fields['description'],
             'total_paid'      => $data_fields['creditamount']
         );
 
         $this->db->where('transaction_id', $data_fields['transaction_id']);
         $this->db->update('mp_payment_voucher', $data);
 
         $total_heads = count($data_fields['account_head']);
 
         $sub_data  = array(
         'parent_id'   => $data_fields['transaction_id'], 
         'accounthead' => 2, //CASH 
         'amount'      => $data_fields['creditamount'],  
         'type'        => 0
         );
 
 
         $this->db->insert('mp_sub_entry',$sub_data);
         for($i = 0; $i < $total_heads; $i++)
         {
             if($data_fields['account_head'] != 0)
             {
                 if($data_fields['debitamount'][$i] >= 0)
                 {
                     $sub_data  = array(
                     'parent_id'   => $data_fields['transaction_id'], 
                     'accounthead' => $data_fields['account_head'][$i], 
                     'amount'      => $data_fields['debitamount'][$i],  
                     'type'        => 1
                     );
                 }
                 
                 $this->db->insert('mp_sub_entry',$sub_data);
 
             }
         }
 
         
         $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE)
         {
             $this->db->trans_rollback();
             $data = NULL;    
         }
         else
         {
             $this->db->trans_commit();
         }
 
         return $data;
     } 
}