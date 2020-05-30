<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/
class Pos_transaction_model extends CI_Model
{
    //USED TO UPDATE QUANTITY IN INOIVCE TRANSACTION
    function general_pos_transaction($new_args, $new_data ,$temp_args ,$temp_data)
    {
        $this->db->trans_start();

        extract($new_args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $new_data);


        extract($temp_args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $temp_data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
             $data = true; 
        }

        return $data;
    }  

    //USED TO UPDATE QUANTITY IN RETURN INOIVCE TRANSACTION
    function general_whole_transaction($new_args, $new_data ,$temp_args ,$temp_data)
    {
        $this->db->trans_start();

        extract($new_args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $new_data);


        extract($temp_args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $temp_data);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $data = NULL;    
        }
        else
        {
            $this->db->trans_commit();
             $data = true; 
        }

        return $data;
    } 
 

}