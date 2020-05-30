<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 11th December, 2018
*  @Developed : Team Spantik Lab
*  @URL       : www.spantiklab.com
*  @Envato    : https://codecanyon.net/user/spantiklab
*/
class Sales_model extends CI_Model
{
    //USED TO ADD SALES TRANSACTIONS 
    function add_sales_receipt_transaction($data_fields)
    {
        $this->db->trans_start();
        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => $data_fields['memo'], 
        'generated_source'     => 'sales_receipt'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

         $data1  = array(
          'transaction_id'  => $transaction_id, 
          'date'            => $data_fields['date'], 
          'user'            => $data_fields['user'],
          'payee_id'        => $data_fields['payee_id'],
          'method'          => $data_fields['payment_method'],
          'ref_no'          => $data_fields['ref_no'],
          'billing_address' => $data_fields['billing_address'],
          'total_bill'      => $data_fields['total_bill'],
          'total_paid'      => $data_fields['received'],
          'invoicemessage'  => $data_fields['invoicemessage'],
          'memo'            => $data_fields['memo'],
          'attachment'      => $data_fields['attachment']
         );

        $this->db->insert('mp_sales_receipt',$data1);
        $data_fields['sales_id'] = $this->db->insert_id();


        if($data_fields['total_bill'] == $data_fields['received'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $data_fields['debithead'], 
            'amount'      => $data_fields['received'], 
            'type'        => 0
            );

            $this->db->insert('mp_sub_entry',$sub_data);  
        }
        else if($data_fields['total_bill'] > $data_fields['received'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $data_fields['debithead'], 
            'amount'      => $data_fields['received'], 
            'type'        => 0
            ); 

            $this->db->insert('mp_sub_entry',$sub_data);

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => 4, //AR 
            'amount'      => $data_fields['total_bill']-$data_fields['received'], 
            'type'        => 0
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }

        //FOR IDENTIFYING ANY FINISHED ITEM IN PRODUCTS TO FIND COST
        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

            //CHECKING OF ANY NOT SERVICE
            if($result[0]->type == 1)
            {
                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $transaction_id, 
                    'accounthead' => 26,//COST OF GOODS 
                    'amount'      => $result[0]->cost * $data_fields['qty'][$i], 
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
            } 
        }
        

        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

           //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => $result[0]->head_id, 
            'amount'      => $data_fields['price'][$i]*$data_fields['qty'][$i], 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 


            //CHECKING OF ANY NOT SERVICE
            if($result[0]->type == 1)
            {
                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $transaction_id, 
                    'accounthead' => 3,//INVENTORY 
                    'amount'      => $result[0]->cost * $data_fields['qty'][$i], 
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
            }

            //1ST ENTRY
            $sub_data  = array(
            'sales_id'    => $data_fields['sales_id'], 
            'product_id'  => $data_fields['product'][$i], 
            'description' => $data_fields['descriptionarr'][$i], 
            'qty'         => $data_fields['qty'][$i],
            'price'       => $data_fields['price'][$i],
            'tax'         => $data_fields['single_tax'][$i]
            );

            $this->db->insert('mp_sub_receipt',$sub_data);
        }

        if($data_fields['total_tax'] > 0)
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $transaction_id, 
            'accounthead' => 20, 
            'amount'      => $data_fields['total_tax'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }

        if($data_fields['debithead'] == 16)
        {
           //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'bank_id'             => $data_fields['bank_id'],  
            'method'              => $data_fields['payment_method'],
            'total_bill'          => $data_fields['total_bill'],
            'total_paid'          => $data_fields['received'],
            'ref_no'              => $data_fields['ref_no'],
            'transaction_status'  => 1,
            'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 


            //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      => $transaction_id, 
            'payee_id'            => $data_fields['payee_id'],  
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

    //USED TO ADD SALES TRANSACTIONS 
    function update_sales_receipt_transaction($data_fields)
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
              'transaction_id'  => $data_fields['transaction_id'], 
              'payee_id'        => $data_fields['payee_id'],
              'method'          => $data_fields['payment_method'],
              'ref_no'          => $data_fields['ref_no'],
              'billing_address' => $data_fields['billing_address'],
              'total_bill'      => $data_fields['total_bill'],
              'total_paid'      => $data_fields['received'],
              'invoicemessage'  => $data_fields['invoicemessage'],
              'memo'            => $data_fields['memo']
             );
        }
        else
        {   
            $data  = array(
              'transaction_id'  => $data_fields['transaction_id'], 
              'payee_id'        => $data_fields['payee_id'],
              'method'          => $data_fields['payment_method'],
              'ref_no'          => $data_fields['ref_no'],
              'billing_address' => $data_fields['billing_address'],
              'total_bill'      => $data_fields['total_bill'],
              'total_paid'      => $data_fields['received'],
              'invoicemessage'  => $data_fields['invoicemessage'],
              'memo'            => $data_fields['memo'],
              'attachment'      => $data_fields['attachment']
             );
        }

         

        $this->db->where('id',$data_fields['receipt_id']);
        $this->db->update('mp_sales_receipt',$data);

        //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
        $this->db->where(['parent_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_sub_entry');

        //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        $this->db->where(['sales_id' => $data_fields['receipt_id']]);
        $this->db->delete('mp_sub_receipt');

       if($data_fields['total_bill'] == $data_fields['received'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['debithead'], 
            'amount'      => $data_fields['received'], 
            'type'        => 0
            );

            $this->db->insert('mp_sub_entry',$sub_data);  
        }
        else if($data_fields['total_bill'] > $data_fields['received'])
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $data_fields['debithead'], 
            'amount'      => $data_fields['received'], 
            'type'        => 0
            ); 

            $this->db->insert('mp_sub_entry',$sub_data);

            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => 4, //AR 
            'amount'      => $data_fields['total_bill']-$data_fields['received'], 
            'type'        => 0
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }

        //FOR IDENTIFYING ANY FINISHED ITEM IN PRODUCTS TO FIND COST
        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

            //CHECKING OF ANY NOT SERVICE
            if($result[0]->type == 1)
            {
                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $data_fields['transaction_id'], 
                    'accounthead' => 26,//COST OF GOODS 
                    'amount'      => $result[0]->cost * $data_fields['qty'][$i], 
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
            } 
        }

        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

           //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $result[0]->head_id, 
            'amount'      => $data_fields['price'][$i]*$data_fields['qty'][$i], 
            'type'        => 1
            );
            $this->db->insert('mp_sub_entry',$sub_data); 

            //CHECKING OF ANY NOT SERVICE
            if($result[0]->type == 1)
            {
                //1ST ENTRY
                $sub_data  = array(
                    'parent_id'   => $data_fields['transaction_id'], 
                    'accounthead' => 3,//INVENTORY 
                    'amount'      => $result[0]->cost * $data_fields['qty'][$i], 
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
            }

            //1ST ENTRY
            $sub_data  = array(
            'sales_id'    => $data_fields['receipt_id'], 
            'product_id'  => $data_fields['product'][$i], 
            'description' => $data_fields['descriptionarr'][$i], 
            'qty'         => $data_fields['qty'][$i],
            'price'       => $data_fields['price'][$i],
            'tax'         => $data_fields['single_tax'][$i]
            );

            $this->db->insert('mp_sub_receipt',$sub_data);
        }

        if($data_fields['total_tax'] > 0)
        {
            //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => 20, 
            'amount'      => $data_fields['total_tax'], 
            'type'        => 1
            );

            $this->db->insert('mp_sub_entry',$sub_data); 
        }


        if($data_fields['debithead'] == 16)
        {
             //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
            $this->db->where(['transaction_id' => $data_fields['transaction_id']]);
            $this->db->delete('mp_bank_transaction');
            
           //TRANSACTION DETAILS 
            $sub_data  = array(
                'transaction_id'      => $data_fields['transaction_id'], 
                'bank_id'             => $data_fields['bank_id'], 
                'method'              => $data_fields['payment_method'],
                'total_bill'          => $data_fields['total_bill'],
                'total_paid'          => $data_fields['received'],
                'ref_no'              => $data_fields['ref_no'],
                'transaction_status'  => 1,
                'transaction_type'    => 'recieved'
            );
            $this->db->insert('mp_bank_transaction',$sub_data); 

             //TRANSACTION DETAILS 
            $sub_data  = array(
            'transaction_id'      =>$data_fields['transaction_id'], 
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