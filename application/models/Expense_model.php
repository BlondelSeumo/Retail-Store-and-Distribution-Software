<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 11th December, 2018
*  @Developed : Team Spantik Lab
*  @URL       : www.spantiklab.com
*  @Envato    : https://codecanyon.net/user/spantiklab
*/
class Expense_model extends CI_Model
{
    //USED TO ADD EXPENSES TRANSACTIONS 
    function add_expense_transaction($data_fields)
    {
        $this->db->trans_start();
        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => $data_fields['memo'], 
        'generated_source'     => 'expense'
        );

        $this->db->insert('mp_generalentry',$data1);
        $data_fields['transaction_id'] = $this->db->insert_id();

         $data1  = array(
          'transaction_id' => $data_fields['transaction_id'], 
          'total_bill'     => $data_fields['total_bill'], 
          'total_paid'     => $data_fields['total_paid'], 
          'date'           => $data_fields['date'],
          'user'           => $data_fields['user'],
          'method'         => $data_fields['payment_method'],
          'description'    => $data_fields['memo'],
          'payee_id'       => $data_fields['payee_id'],
          'ref_no'         => $data_fields['ref_no'],
          'attachment'     => $data_fields['attachment']
         );

        $this->db->insert('mp_expense',$data1);
        $data_fields['expense_id'] = $this->db->insert_id();

        $count_items = count($data_fields['account_head']);

        if($count_items  > 0)
        {
            for ($i = 0; $i < $count_items; $i++) 
            {

               //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $data_fields['transaction_id'], 
                'accounthead' => $data_fields['account_head'][$i], 
                'amount'      => $data_fields['amount'][$i], 
                'type'        => 0
                );
                $this->db->insert('mp_sub_entry',$sub_data); 

                //1ST ENTRY
                $sub_data  = array(
                'expense_id'   => $data_fields['expense_id'] , 
                'head_id'      => $data_fields['account_head'][$i], 
                'description'  => $data_fields['description_arr'][$i], 
                'price'        => $data_fields['amount'][$i]
                );

                $this->db->insert('mp_sub_expense',$sub_data);
            }
        }

        if($data_fields['total_bill'] == $data_fields['total_paid'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['credithead'], 
            'amount'      => $data_fields['total_bill'], 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 
        }
        else if($data_fields['total_bill'] > $data_fields['total_paid'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['credithead'], 
            'amount'      => $data_fields['total_paid'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => 5, //AP 
            'amount'      => $data_fields['total_bill']-$data_fields['total_paid'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }
        


        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'bank_id'             => $data_fields['bank_id'], 
            'method'              => $data_fields['payment_method'],
            'total_bill'          => $data_fields['total_bill'],
            'total_paid'          => $data_fields['total_paid'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 0,
            'transaction_type'    => 'paid'
            );
            $this->db->insert('mp_bank_transaction',$sub_data);

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'payee_id'            => $data_fields['payee_id']

            );
            $this->db->insert('mp_bank_transaction_payee',$sub_data); 
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


    //USED TO ADD BANK EXPENSES TRANSACTIONS 
    function add_bank_expense_transaction($data_fields)
    {
        $this->db->trans_start();
        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => $data_fields['memo'], 
        'generated_source'     => 'expense'
        );

        $this->db->insert('mp_generalentry',$data1);
        $data_fields['transaction_id'] = $this->db->insert_id();

        
        $data1  = array(
          'transaction_id' => $data_fields['transaction_id'], 
          'total_bill'     => $data_fields['total_bill'], 
          'date'           => $data_fields['date'],
          'payee_id'       => $data_fields['payee_id'],
          'user'           => $data_fields['user'],
          'description'    => $data_fields['memo'],
          'attachment'      => $data_fields['attachment']
         );
        

         

        $this->db->insert('mp_expense',$data1);
        $data_fields['expense_id'] = $this->db->insert_id();


        $count_items = count($data_fields['account_head']);

        if($count_items  > 0)
        {
            for ($i = 0; $i < $count_items; $i++) 
            {

               //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $data_fields['transaction_id'], 
                'accounthead' => $data_fields['account_head'][$i], 
                'amount'      => $data_fields['amount'][$i], 
                'type'        => 0
                );
                $this->db->insert('mp_sub_entry',$sub_data); 

                //1ST ENTRY
                $sub_data  = array(
                'expense_id'   => $data_fields['expense_id'] , 
                'head_id'      => $data_fields['account_head'][$i], 
                'description'  => $data_fields['description_arr'][$i], 
                'price'        => $data_fields['amount'][$i]
                );

                $this->db->insert('mp_sub_expense',$sub_data);
            }
        }

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $data_fields['transaction_id'], 
        'accounthead' => $data_fields['credithead'], 
        'amount'      => $data_fields['total_bill'], 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data); 


        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'bank_id'             => $data_fields['bank_id'], 
            'method'              => 'Cash',
            'total_bill'          => $data_fields['total_bill'],
            'total_paid'          => $data_fields['total_bill'],
            'ref_no'              => '',
            'transaction_status'  => 0,
            'transaction_type'    => 'paid'
            );

            $this->db->insert('mp_bank_transaction',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'payee_id'            => $data_fields['payee_id']
            );

            $this->db->insert('mp_bank_transaction_payee',$sub_data); 
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

    //USED TO UPDATE EXPENSES TRANSACTIONS 
    function update_expense_transaction($data_fields)
    {
        $this->db->trans_start();

        $data  = array(
            'naration' => $data_fields['memo']
        );

        $this->db->where('id',$data_fields['transaction_id']);
        $this->db->update('mp_generalentry',$data);

        if($data_fields['attachment'] == 'default.jpg')
        {
             $data  = array(
              'transaction_id' => $data_fields['transaction_id'], 
              'total_bill'     => $data_fields['total_bill'], 
              'total_paid'     => $data_fields['total_paid'], 
              'method'         => $data_fields['payment_method'],
              'description'    => $data_fields['memo'],
              'payee_id'       => $data_fields['payee_id'],
              'ref_no'         => $data_fields['ref_no']
             ); 
        }
        else
        {
             $data  = array(
              'transaction_id' => $data_fields['transaction_id'], 
              'total_bill'     => $data_fields['total_bill'], 
              'total_paid'     => $data_fields['total_paid'], 
              'method'         => $data_fields['payment_method'],
              'description'    => $data_fields['memo'],
              'payee_id'       => $data_fields['payee_id'],
              'ref_no'         => $data_fields['ref_no'],
              'attachment'      => $data_fields['attachment']
             );
        }

        

        $this->db->where('id',$data_fields['expense_id']);
        $this->db->update('mp_expense',$data);

        //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
        $this->db->where(['parent_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_sub_entry');

        //DELETEING THE PREVIOUS ACCOUNTS BANK TRANSACTION
        $this->db->where(['transaction_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_bank_transaction');


        //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        $this->db->where(['expense_id' => $data_fields['expense_id']]);
        $this->db->delete('mp_sub_expense');

        $count_items = count($data_fields['account_head']);

        if($count_items  > 0)
        {
            for ($i = 0; $i < $count_items; $i++) 
            {

               //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $data_fields['transaction_id'], 
                'accounthead' => $data_fields['account_head'][$i], 
                'amount'      => $data_fields['amount'][$i], 
                'type'        => 0
                );
                $this->db->insert('mp_sub_entry',$sub_data); 

                //1ST ENTRY
                $sub_data  = array(
                'expense_id'   => $data_fields['expense_id'] , 
                'head_id'      => $data_fields['account_head'][$i], 
                'description'  => $data_fields['description_arr'][$i], 
                'price'        => $data_fields['amount'][$i]
                );

                $this->db->insert('mp_sub_expense',$sub_data);
            }
        }

        if($data_fields['total_bill'] == $data_fields['total_paid'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['credithead'], 
            'amount'      => $data_fields['total_bill'], 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 
        }
        else if($data_fields['total_bill'] > $data_fields['total_paid'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['credithead'], 
            'amount'      => $data_fields['total_paid'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => 5, //AP 
            'amount'      => $data_fields['total_bill']-$data_fields['total_paid'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }


        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'bank_id'             => $data_fields['bank_id'], 
            'method'              => $data_fields['payment_method'],
            'total_bill'       =>  $data_fields['total_bill'],
            'total_paid'       =>  $data_fields['total_paid'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 0,
            'transaction_type'    => 'paid'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'payee_id'            => $data_fields['payee_id']
            
            );
            $this->db->insert('mp_bank_transaction_payee',$sub_data); 
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

    //USED TO UPDATE BANK EXPENSES TRANSACTIONS 
    function update_bank_expense_transaction($data_fields)
    {
        $this->db->trans_start();

        $data  = array(
            'naration' => $data_fields['memo']
        );

        $this->db->where('id',$data_fields['transaction_id']);
        $this->db->update('mp_generalentry',$data);

         if($data_fields['attachment'] == 'default.jpg')
        {
             
            $data  = array(
              'transaction_id' => $data_fields['transaction_id'], 
              'total_bill'     => $data_fields['total_bill'], 
              'description'    => $data_fields['memo'],
              'payee_id'       => $data_fields['payee_id']
            );
        }
        else
        {
             $data  = array(
              'transaction_id' => $data_fields['transaction_id'], 
              'total_bill'     => $data_fields['total_bill'], 
              'description'    => $data_fields['memo'],
              'payee_id'       => $data_fields['payee_id'],
              'attachment'     => $data_fields['attachment']
             );
        }


        $this->db->where('id',$data_fields['expense_id']);
        $this->db->update('mp_expense',$data); 


        //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
        $this->db->where(['parent_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_sub_entry');

        //DELETEING THE PREVIOUS ACCOUNTS BANK TRANSACTION
        $this->db->where(['transaction_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_bank_transaction'); 

        //DELETEING THE PREVIOUS ACCOUNTS BANK TRANSACTION
        $this->db->where(['transaction_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_bank_transaction_payee');

        //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        $this->db->where(['expense_id' => $data_fields['expense_id']]);
        $this->db->delete('mp_sub_expense');

        $count_items = count($data_fields['account_head']);

        if($count_items  > 0)
        {
            for ($i = 0; $i < $count_items; $i++) 
            {

               //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $data_fields['transaction_id'], 
                'accounthead' => $data_fields['account_head'][$i], 
                'amount'      => $data_fields['amount'][$i], 
                'type'        => 0
                );
                $this->db->insert('mp_sub_entry',$sub_data); 

                //1ST ENTRY
                $sub_data  = array(
                'expense_id'   => $data_fields['expense_id'] , 
                'head_id'      => $data_fields['account_head'][$i], 
                'description'  => $data_fields['description_arr'][$i], 
                'price'        => $data_fields['amount'][$i]
                );

                $this->db->insert('mp_sub_expense',$sub_data);
            }
        }

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $data_fields['transaction_id'], 
        'accounthead' => $data_fields['credithead'], 
        'amount'      => $data_fields['total_bill'], 
        'type'        => 1
        );
        $this->db->insert('mp_sub_entry',$sub_data); 


        if($data_fields['credithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'bank_id'             => $data_fields['bank_id'], 
            'method'              => 'Cash',
            'total_bill'          =>  $data_fields['total_bill'],
            'total_paid'          =>  $data_fields['total_bill'],
            'ref_no'              => '',
            'transaction_status'  => 0,
            'transaction_type'    => 'paid'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 

            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $data_fields['transaction_id'], 
            'payee_id'            => $data_fields['payee_id']
            );
            $this->db->insert('mp_bank_transaction_payee',$sub_data); 
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
}