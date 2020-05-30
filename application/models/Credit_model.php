<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 11th December, 2018
*  @Developed : Team Spantik Lab
*  @URL       : www.spantiklab.com
*  @Envato    : https://codecanyon.net/user/spantiklab
*/
class Credit_model extends CI_Model
{
    //USED TO ADD REFUND TRANSACTIONS 
    function add_credit_transaction($data_fields)
    {
        $this->db->trans_start();
        $data1  = array(
        'date'                 => date('Y-m-d'), 
        'naration'             => $data_fields['memo'], 
        'generated_source'     => 'credit_note'
        );

        $this->db->insert('mp_generalentry',$data1);
        $transaction_id = $this->db->insert_id();

         $data1  = array(
          'transaction_id'  => $transaction_id, 
          'payee_id'        => $data_fields['payee_id'], 
          'billing'         => $data_fields['billing_address'],
          'credit_date'     => $data_fields['date'],
          'message'         => $data_fields['invoicemessage'],
          'memo'            => $data_fields['memo'],
          'total_bill'      => $data_fields['total_bill'],
          'user'            => $data_fields['user'],
          'attachment'      => $data_fields['attachment']
         );

        $this->db->insert('mp_credit_note',$data1);
        $data_fields['credit_id'] = $this->db->insert_id();

        

        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

            if($data_fields['qty'][$i] >= 0 AND $data_fields['qty'][$i] != "")
            {
               //1ST ENTRY
                $sub_data  = array(
                'parent_id'   => $transaction_id, 
                'accounthead' => $result[0]->head_id, 
                'amount'      => ($data_fields['price'][$i]*$data_fields['qty'][$i]) +
                                 ($data_fields['qty'][$i]*$data_fields['single_tax'][$i]), 
                'type'        => 0
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
                        'type'        => 0
                    );

                    $this->db->insert('mp_sub_entry',$sub_data); 
                }

                //1ST ENTRY
                $sub_data  = array(
                'credit_id'   => $data_fields['credit_id'], 
                'product_id'  => $data_fields['product'][$i], 
                'description' => $data_fields['descriptionarr'][$i], 
                'qty'         => $data_fields['qty'][$i],
                'price'       => $data_fields['price'][$i],
                'tax'         => $data_fields['single_tax'][$i]
                );

                $this->db->insert('mp_credit_sales',$sub_data);

            }
        }

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $transaction_id, 
        'accounthead' => $data_fields['credithead'], 
        'amount'      => $data_fields['total_bill'], 
        'type'        => 1
        );

        $this->db->insert('mp_sub_entry',$sub_data); 

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
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
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

    //USED TO UPDATE CREDIT NOTE TRANSACTIONS 
    function update_credit_transaction($data_fields)
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
              'payee_id'        => $data_fields['payee_id'], 
              'billing'         => $data_fields['billing_address'],
              'message'         => $data_fields['invoicemessage'],
              'memo'            => $data_fields['memo'],
              'total_bill'      => $data_fields['total_bill']
             );
        }
        else
        {
            $data  = array(
              'payee_id'        => $data_fields['payee_id'], 
              'billing'         => $data_fields['billing_address'],
              'message'         => $data_fields['invoicemessage'],
              'memo'            => $data_fields['memo'],
              'total_bill'      => $data_fields['total_bill'],
              'attachment'      => $data_fields['attachment']
            );
        }

        $this->db->where('id',$data_fields['credit_id']);
        $this->db->update('mp_credit_note',$data);

        //DELETEING THE PREVIOUS ACCOUNTS TRANSACTION
        $this->db->where(['parent_id' => $data_fields['transaction_id']]);
        $this->db->delete('mp_sub_entry');

        //DELETEING THE PREVIOUS SUB CREDIT ENTRY
        $this->db->where(['credit_id' => $data_fields['credit_id']]);
        $this->db->delete('mp_credit_sales');

        for ($i = 0; $i < count($data_fields['product']); $i++) 
        {

            $this->db->where(['id' => $data_fields['product'][$i]]);
            $query = $this->db->get('mp_product');
            $result = $query->result();

           //1ST ENTRY
            $sub_data  = array(
            'parent_id'   => $data_fields['transaction_id'], 
            'accounthead' => $result[0]->head_id, 
            'amount'      => ($data_fields['price'][$i]*$data_fields['qty'][$i]) +
                             ($data_fields['qty'][$i]*$data_fields['single_tax'][$i]), 
            'type'        => 0
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
                    'type'        => 0
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
            }
            
            //1ST ENTRY
            $sub_data  = array(
            'credit_id'   => $data_fields['credit_id'], 
            'product_id'  => $data_fields['product'][$i], 
            'description' => $data_fields['descriptionarr'][$i], 
            'qty'         => $data_fields['qty'][$i],
            'price'       => $data_fields['price'][$i],
            'tax'         => $data_fields['single_tax'][$i]
            );

            $this->db->insert('mp_credit_sales',$sub_data);
        }

        //1ST ENTRY
        $sub_data  = array(
        'parent_id'   => $data_fields['transaction_id'], 
        'accounthead' => $data_fields['credithead'], 
        'amount'      => $data_fields['total_bill'], 
        'type'        => 1
        );

        $this->db->insert('mp_sub_entry',$sub_data); 

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
                    'type'        => 1
                );

                $this->db->insert('mp_sub_entry',$sub_data); 
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
}