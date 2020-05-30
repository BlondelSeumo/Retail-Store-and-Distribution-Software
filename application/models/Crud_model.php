<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/
class Crud_model extends CI_Model
{
    public function insert_data($tablename, $arg1)
    {
        $this->db->insert($tablename, $arg1);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function insert_data_last_id($tablename, $arg1)
    {
        $this->db->insert($tablename, $arg1);
        if ($this->db->affected_rows() > 0)
        {
            return $last_insert_id = $this->db->insert_id();
        }
        else
        {
            return NULL;
        }
    }

    // USED TO FETCH THE RECORD OF ESTIMATE USING PRODUCT ID
	function fetch_product_po($order_id)
	{
        echo $order_id;
        die();

		$this->db->select("mp_subpo_details.*,mp_product.product_name");
		$this->db->from('mp_subpo_details');
		$this->db->join('mp_product', "mp_subpo_details.product_id = mp_product.id");
		$this->db->where(['mp_subpo_details.estimate_id' => $order_id]);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    public function fetch_record_credit($date1, $date2)
	{
		$this->db->select("mp_credit_note.*,mp_payee.id as invoice_payee_id , mp_payee.customer_name");
		$this->db->where(' mp_credit_note.credit_date >=', $date1);
		$this->db->where(' mp_credit_note.credit_date <=', $date2);
		$this->db->from(' mp_credit_note');
		$this->db->join('mp_payee', "mp_payee.id =  mp_credit_note.payee_id");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    public function fetch_record_sales($date1, $date2)
	{
		$this->db->select("mp_sales_receipt.*,mp_payee.id as receipt_payee_id , mp_payee.customer_name");
		$this->db->where('mp_sales_receipt.date >=', $date1);
		$this->db->where('mp_sales_receipt.date <=', $date2);
		$this->db->from('mp_sales_receipt');
		$this->db->join('mp_payee', "mp_payee.id = mp_sales_receipt.payee_id");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}

    public function fetch_last_record($table)
    {
        $this->db->select("id");
        $this->db->from($table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

     public function fetch_record_estimate($date1,$date2)
    {
        $this->db->select(" mp_estimate.*,mp_payee.id as invoice_payee_id , mp_payee.customer_name");
        $this->db->where(' mp_estimate.date >=', $date1);
        $this->db->where(' mp_estimate.date <=', $date2);
        $this->db->from(' mp_estimate');
        $this->db->join('mp_payee', "mp_payee.id =  mp_estimate.payee_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }
    
    public function fetch_record_po($date1,$date2)
    {
        $this->db->select("mp_purchase_order.*,mp_payee.id as invoice_payee_id , mp_payee.customer_name");
        $this->db->where('mp_purchase_order.date >=', $date1);
        $this->db->where('mp_purchase_order.date <=', $date2);
        $this->db->from('mp_purchase_order');
        $this->db->join('mp_payee', "mp_payee.id =  mp_purchase_order.payee_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    // DEFINES TO AVOID MULTIPLE EMAILS IN DATABASE
    public function check_email_address($table_name, $tbl_attribute, $email)
    {
        $this->db->select("id");
        $this->db->from($table_name);
        $this->db->where([$tbl_attribute => $email]);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    function add_return_item_stock($product_id,$quantity)
    {
       $product_fetch = $this->fetch_record_by_id('mp_productslist',$product_id);
       $fetched_qty = $product_fetch[0]->quantity;
       $fetched_qty = $fetched_qty + $quantity;

       $data_edit = array(
            'quantity' => $fetched_qty,
            'status'   => 0
        );

       $args_edit = array(
            'table_name' => 'mp_productslist',
            'id' => $product_id
        );

       $result_edit = $this->edit_record_id($args_edit,$data_edit);
       return $result_edit; 
    }
    
    public function fetch_limit_record($table, $limit)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_top_customers($date1,$date2)
    {
        $total_customer_top = array();
        $total = 0;
        $paid = 0;

        $this->db->select('*');
        $this->db->from('mp_payee');
         $this->db->where(['type' => 'customer']);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
              $customers = $query->result();
             // $invoices = this->fetch
              foreach ($customers as $single) 
              {

                 $total = 0;
                 $paid = 0;

                  $this->db->select('*');
                  $this->db->from('mp_invoices');
                  $this->db->where(['cus_id' => $single->id]);
                  $this->db->where('date >= ',$date1);
                  $this->db->where('date <= ',$date2);
                  $query = $this->db->get();
                  $all_record = $query->result();

                 if($all_record != NULL)
                 {
                    foreach ($all_record as $single_record_sale) 
                    {
                            $total = $total + $single_record_sale->total_bill;

                            $paid = $paid + $single_record_sale->bill_paid; 
                    }


                 }

                 $total_customer_top [] = array('customer_name'=> $single->customer_name, 'contact'=>$single->cus_contact_1,'address'=> $single->cus_address,'total_purchase'=>$total,'total_paid'=>$paid);
              }
        }

        usort($total_customer_top, function($a, $b) 
        {
            return  $b['total_purchase']  <=> $a['total_purchase'];
        });

        return $total_customer_top;
    }  
    

    public function fetch_top_salesman($date1,$date2)
    {
        $total_sales_top = array();
        

        $this->db->select('*');
        $this->db->from('mp_salesman');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
              $salesman = $query->result();
             // $invoices = this->fetch
              foreach ($salesman as $single) 
              {
                 
                $total = 0;

                $this->db->select('*');
                $this->db->from('mp_invoices');
                $this->db->where(['sales_man_id' => $single->id]);
                $this->db->where('date >= ',$date1);
                $this->db->where('date <= ',$date2);
                $query = $this->db->get();
                $all_record = $query->result();
                 
                 if($all_record != NULL)
                 {
                    foreach ($all_record as $single_record_sale) 
                    {
                        $total = $total + $single_record_sale->total_bill;
                    }

                 }

                 $total_sales_top [] = array('name'=> $single->name, 'contact'=>$single->contact,'address'=> $single->address,'total_sold'=>$total);
              }
        }


        usort($total_sales_top, function($a, $b) 
        {
            return  $b['total_sold']  <=> $a['total_sold'];
        });
     
        return $total_sales_top;
    }

    public function fetch_record($tablename, $args)
    {
        if ($args != NULL)
        {
            $this->db->where(['status' => 0]);
            $query = $this->db->get($tablename);
        }
        else
        {
            $query = $this->db->get($tablename);
        }

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    } 

    public function fetch_record_brand()
    {
 
        $this->db->select("mp_brand.*,mp_payee.customer_name");
        $this->db->from('mp_brand');
         $this->db->join('mp_payee', "mp_brand.company_id = mp_payee.id");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }
    
    public function fetch_payee_record($type,$status = '')
    {
        
        if($status != '')
        {
            $this->db->where(['cus_status' => 0]);
        }

        $query = $this->db->get('mp_payee');

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function recover_password($tablename, $email, $attribute)
    {
        $this->db->where([$attribute => $email]);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_by_id($tablename, $id)
    {
        $this->db->where(['id' => $id]);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_id($table_name,$attr,$val,$status = '')
    {
        if($status != '')
        {
            $this->db->where(['status ='=>$status]);    
        }
        $this->db->where([$attr => $val]);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table_name);
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }    

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND DATES
    public function fetch_record_with_date($table_name,$attr,$val,$date1,$date2)
    {
        $this->db->where([$attr => $val]);
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table_name);
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }    

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_userid($table_name,$attr,$val,$id)
    {

        $this->db->where([$attr => $val]);
        $this->db->where('id', $id);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }   

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME
    public function fetch_attr_record_by_userid_source($table_name,$attr,$val,$id,$source)
    {
        $this->db->where([$attr => $val]);
        $this->db->where('agentid', $id);
        $this->db->where('source',$source);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

   
    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME AND SOURCE
    public function fetch_userid_source($table_name,$source,$agentid)
    {
        $this->db->select('mp_temp_barcoder_invoice.*,mp_productslist.unit_type,mp_productslist.packsize');
        $this->db->join('mp_productslist','mp_productslist.id = mp_temp_barcoder_invoice.product_id');
        $this->db->where(['agentid' => $agentid]);
        $this->db->where('source',$source);
        $query = $this->db->get('mp_temp_barcoder_invoice');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

     //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME AND SOURCE
     public function fetch_userid_purchase($source,$agentid)
     {

         $this->db->select('mp_temp_purchase.*,mp_productslist.unit_type');
         $this->db->join('mp_productslist','mp_productslist.id = mp_temp_purchase.product_id');
         $this->db->where(['agentid' => $agentid]);
         $this->db->where('source',$source);
         $query = $this->db->get('mp_temp_purchase');
         if ($query->num_rows() > 0)
         {
             return $query->result();
         }
         else
         {
             return NULL;
         }
     }

     // USED TO FETCH THE RECORD OF INVOICE SALES USING PRODUCT ID
	function fetch_product_invoice($invoice_id)
	{
		$this->db->select("mp_invoices.*,mp_sales.product_name,mp_sales.mg,mp_sales.price,mp_sales.discount,mp_sales.qty,mp_sales.tax");
		$this->db->from('mp_invoices');
		$this->db->join('mp_sales', "mp_sales.order_id = mp_invoices.id");
		$this->db->where(['mp_invoices.id' => $invoice_id]);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
     //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME AND SOURCE
     public function fetch_userid_order_source($source,$agentid)
     {
         $this->db->select('mp_temp_barcoder_order.*,mp_productslist.unit_type');
         $this->db->join('mp_productslist','mp_productslist.id = mp_temp_barcoder_order.product_id');
         $this->db->where(['agentid' => $agentid]);
         $this->db->where('source',$source);
         $this->db->where('mp_temp_barcoder_order.status','temp');
         $query = $this->db->get('mp_temp_barcoder_order');
         if ($query->num_rows() > 0)
         {
             return $query->result();
         }
         else
         {
             return NULL;
         }
     }

    public function fetch_temp_invoice_by_id($tablename, $id)
    {
        $this->db->select("cus_picture,discount,shippingcharges,status,cus_id,delivered_to,delivered_by,delivered_date,delivered_description,prescription_id,agentname");
        $this->db->where(['id' => $id]);
        $this->db->from($tablename);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_temp_sales_by_id($tablename, $id)
    {
        $this->db->select("product_id,order_id,product_name,product_category,mg,price,purchase,qty");
        $this->db->where(['order_id' => $id]);
        $this->db->from($tablename);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_orders($tablename, $id, $first_date, $second_date)
    {
        $this->db->where(['cus_id' => $id]);
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_customer_orders($arg)
    {
        $this->db->select("mp_payee.customer_name , mp_payee.cus_email , mp_payee.cus_contact_1 , mp_orders.id , mp_orders.cus_id , mp_orders.cus_picture , mp_orders.date , mp_orders.status");
        $this->db->from('mp_payee');
        $this->db->join('mp_orders', "mp_payee.id = mp_orders.cus_id and mp_orders.status = $arg ");
        $this->db->where('mp_payee.type','customer');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }


    //USED TO FETCH STOCK RECORD
    public function fetch_stock_list()
    {
        $this->db->select("mp_stock.*,mp_productslist.id as product_id, mp_productslist.product_name,mp_productslist.mg,mp_productslist.unit_type");
        $this->db->from('mp_stock');
         $this->db->join('mp_productslist', "mp_productslist.id = mp_stock.mid");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_expense($date1, $date2)
	{
		$this->db->select("mp_expense.*,mp_payee.customer_name");
		$this->db->where('mp_expense.date >=', $date1);
		$this->db->where('mp_expense.date <=', $date2);
		$this->db->from('mp_expense');
		$this->db->join('mp_payee', "mp_payee.id = mp_expense.payee_id");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}   

    public function expense_through_user($date1, $date2, $method, $payee_id)
	{
        $this->db->select("mp_expense.*,mp_payee.customer_name, mp_head.name as head_name,mp_head.nature");
        $this->db->from('mp_expense');
        $this->db->join('mp_head', "mp_expense.head_id = mp_head.id");
        $this->db->join('mp_payee', "mp_payee.id = mp_expense.payee_id");
        $this->db->where('mp_expense.date <=', $date2);
        $this->db->where('mp_expense.date >=', $date1);
        $this->db->where('mp_expense.payee_id', $payee_id);
        $this->db->where('mp_expense.method', $method);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    // USED TO FETCH THE BANK EXPENSES
	public function fetch_record_bankexpense($date1, $date2)
	{
		$this->db->select("mp_expense.*,mp_bank_transaction.bank_id,mp_banks.bankname");
		$this->db->where('mp_expense.date >=', $date1);
		$this->db->where('mp_expense.date <=', $date2);
		$this->db->from('mp_expense');
		$this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_expense.transaction_id");
		$this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    } 
    

    public function fetch_record_product($arg )
    {

        // DEFINES JOIN QUERY WHICH WOULD RETURN THE CATEGORY NAME OF product FROM
        // mp_category TABLE INSTEAD OF JUST RETURNING NUMBERIC ID FORM mp_productslist TABLE.
        // INSEAD OF CATEGORY ID 12 WILL GET THE category_name FROM TABLE.
        // IF 0 MEANS SELECT ONLY THOSE RECORDS WHORE STATUS IS 0 MEANS VISIBLE OR 1 MEANS FETCH ALL
        // WEATHER IT WOULD BE VISIBLE OR HIDDEN MEANS STATUS = 0 OR STATUS = 1
        if ($arg == 'all')
        {
              $this->db->select('mp_productslist.*,mp_category.category_name,mp_brand.name');
            $this->db->from('mp_category');
            $this->db->join('mp_productslist', 'mp_category.id = mp_productslist.category_id and mp_productslist.status != 2');
            $this->db->join('mp_brand', "mp_brand.id = mp_productslist.brand_id");
            $query = $this->db->get();   
        }
        else
        {  
          $this->db->select('mp_productslist.*,mp_category.category_name,');
            $this->db->from('mp_category');
            $this->db->join('mp_productslist', "mp_category.id = mp_productslist.category_id and mp_productslist.status = $arg ");
            $this->db->join('mp_brand', "mp_brand.id = mp_productslist.brand_id");
            $query = $this->db->get();
        }

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_alert()
    {
        //FETCHING THE STOCK LIMIT FROM DATABASE
        $this->db->select('*');
        $this->db->from('mp_productslist');
        $this->db->where('mp_productslist.quantity < mp_productslist.min_stock');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_alert_limit($limit)
    {
        $this->db->select('*');
        $this->db->from('mp_productslist');
        $this->db->where('mp_productslist.quantity < mp_productslist.min_stock');
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function fetch_record_product_returned($first_date, $second_date)
    {
        $this->db->select('mp_productslist.product_name,mp_productslist.retail');
        $this->db->from('mp_productslist');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function delete_record($tablename, $arg)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['id' => $arg]);
        $this->db->delete($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

    public function delete_record_by_userid($tablename, $source, $userid)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['source' => $source]);
        $this->db->where(['agentid' => $userid]);
        $this->db->delete($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

    public function delete_order_record_by_userid($tablename, $source, $userid)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->where(['source' => $source]);
        $this->db->where(['status' => 'temp']);
        $this->db->where(['agentid' => $userid]);
        $this->db->delete($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }


    public function delete_all($tablename)
    {
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->truncate($tablename);
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        $this->db->db_debug = $db_debug;
    }

    public function delete_image($path, $id, $tablename)
    {
        // IMAGE FOLDER PATH
        $image_path = $path;

        // TABLE ID TO DELETE ROW
        $args = $id;

        // DEFINES TO RETREVE DATA ROW FROM TABLE AGINST GIVEN ID
        $data = $this->get_by_id($tablename, $id);

        // WE WILL NOT DELETE THE DEAFULT PICTURE BECAUSE WE USED THIS PICTURE MANY TIMES FOR OTHER PROFILE
        // IF WE DID SO THEM THIS COULD CAUSE AN ERROR IN PROFILE IMAGES OF PEOPLE IN TABLES
        if ($data->cus_picture != "default.jpg")
        {

            // TO DELETE IMAGE FROM FOLDER TO GIVEN PATH
            @@unlink($image_path . $data->cus_picture);
        }
    }

    public function edit_record_id($args, $data)
    {
        extract($args);
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }
    
     public function edit_order_list($args,$data)
    {
        extract($args);

        $this->db->where('agentid', $agentid);
        $this->db->where('add_date', $add_date);
        $this->db->where('status', $status);
        $this->db->update($table_name, $data);
        return TRUE;
    } 

     public function edit_record_attr($args, $data)
    {
        extract($args);
        $this->db->where('set_default', $set_default);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function edit_record_transac($args, $data)
    {
        extract($args);
        $this->db->where('parent_id', $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function edit_prescription_id($args, $data)
    {
        extract($args);
        $fetched_record = $this->fetch_record_by_id($table_name, $id);
        $prescription_id = $fetched_record[0]->prescription_id;
        $this->db->where('id', $prescription_id);
        $this->db->update('mp_orders', $data);
        return TRUE;
    }

    public function edit_record_given_field($fieldname, $args, $data)
    {
        extract($args);
        $this->db->where($fieldname, $id);
        $this->db->update($table_name, $data);
        return TRUE;
    }

    public function get_by_id($table, $id)
    {
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

        //USED TO COUNT SINGLE HEAD 
    public function count_bank_amount($head_id,$date,$bank_id)
    {
        $count_total_amt = 0;
        $this->db->select("mp_generalentry.id as transaction_id,mp_generalentry.date,mp_generalentry.naration,mp_sub_entry.*");
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_generalentry', 'mp_generalentry.id = mp_sub_entry.parent_id');
        $this->db->join('mp_bank_transaction', 'mp_bank_transaction.transaction_id = mp_generalentry.id');
        $this->db->where('mp_sub_entry.accounthead', $head_id);
        $this->db->where('mp_bank_transaction.bank_id', $bank_id);
        $this->db->where('mp_generalentry.date <=', $date);

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $ledger_data =  $query->result();
            $count_total_amt = 0;
            if($ledger_data != NULL)
            {
                foreach ($ledger_data as $single_ledger) 
                {   
                   // if($this->check_condition_allowed($single_ledger->parent_id))
                   // {

                        if($single_ledger->type == 0)
                        {
                           $count_total_amt = $count_total_amt + $single_ledger->amount;
                        }
                        else 
                        {
                            $count_total_amt = $count_total_amt - $single_ledger->amount;   
                        } 
                   // }      
                }
            }
            
        }

        if($count_total_amt == 0)
        {
            $count_total_amt  = NULL;
        }
        else
        {
            $count_total_amt = number_format($count_total_amt,'3','.','');
        }
        
        return $count_total_amt;
        
    }

    // USED TO FETCH THE RECORD OF NOT DESPOSITED AND OUTSTANDING CHECKS
	public function fetch_bank_record($month, $bank_id, $type)
	{
		$date1 = date('Y') . '-' . $month . '-1';
		$date2 = date('Y') . '-' . $month . '-31';
		$this->db->select("mp_bank_transaction.*,mp_payee.customer_name,mp_bank_transaction.total_paid,mp_bank_transaction.total_bill");
		$this->db->from('mp_bank_transaction');
		$this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_bank_transaction.transaction_id");
		$this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
		$this->db->where('mp_bank_transaction.bank_id', $bank_id);
		$this->db->where('mp_bank_transaction.transaction_status', 1);
		$this->db->where('mp_bank_transaction.transaction_type', $type);
		$this->db->where('mp_bank_transaction.cleared_date >=', $date1);
		$this->db->where('mp_bank_transaction.cleared_date <=', $date2);
		$this->db->order_by('mp_bank_transaction.id', 'DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}   

    //USED TO FETCH THE BANK EXPENSES
    public function fetch_bank_expense_heads()
    {
        $this->db->select("*");
        $this->db->where('nature', 'Expense');
        $this->db->where('expense_type','Bank Expense');
        $this->db->from('mp_head');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }     

    public function fetch_bank_profit($month,$bank_id)
    {

        $date1 = date('Y').'-'.$month.'-1';
        $date2 = date('Y').'-'.$month.'-31';

        $this->db->select("mp_generalentry.id as trans_id,mp_head.name,mp_bank_transaction.bank_id,mp_bank_transaction.transaction_type,mp_banks.bankname,mp_sub_entry.accounthead,mp_sub_entry.amount");
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry',"mp_sub_entry.parent_id = mp_generalentry.id");
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id");
        $this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
        $this->db->where('mp_generalentry.date >=',$date1);
        $this->db->where('mp_generalentry.date <=',$date2);
        $this->db->where('mp_bank_transaction.bank_id',$bank_id);
        $this->db->where('mp_bank_transaction.transaction_type','bank_collection');
        $this->db->where('mp_sub_entry.type',1);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }   

    public function fetch_bank_expense($month, $bank_id)
	{
		$date1 = date('Y') . '-' . $month . '-1';
		$date2 = date('Y') . '-' . $month . '-31';
		$this->db->select("mp_generalentry.id as trans_id,mp_expense.id,mp_expense.date,mp_sub_expense.head_id,mp_sub_expense.price,mp_sub_expense.expense_id,mp_head.name,mp_bank_transaction.bank_id,mp_banks.bankname");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_expense', "mp_expense.transaction_id = mp_generalentry.id");
		$this->db->join('mp_sub_expense', "mp_sub_expense.expense_id = mp_expense.id");
		$this->db->join('mp_head', "mp_head.id = mp_sub_expense.head_id");
		$this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_expense.transaction_id");
		$this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
		$this->db->where('mp_generalentry.date >=', $date1);
		$this->db->where('mp_generalentry.date <=', $date2);
		$this->db->where('mp_bank_transaction.bank_id', $bank_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}   

    // USED TO FIND THE CHEQUES FOR PRINT OR PREVIEW
	function get_single_cheque($trans_id, $entry_type)
	{
		$this->db->select('mp_generalentry.id as main_trans_id,mp_generalentry.date,mp_generalentry.naration,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.ref_no,mp_bank_transaction.total_paid,mp_bank_transaction.total_bill,mp_bank_transaction.transaction_status,mp_head.name as headname');
		$this->db->from('mp_generalentry');
		$this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = $entry_type ");
		$this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id");
		$this->db->join('mp_banks', "mp_bank_transaction.bank_id = mp_banks.id");
		$this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id");
		$this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
		$this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
		$this->db->where('mp_generalentry.id', $trans_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO FIND THE CHEQUES
	function get_single_bank_trans($trans_id, $entry_type)
	{
		$this->db->select('mp_generalentry.date,mp_generalentry.naration,mp_sub_entry.accounthead,mp_bank_transaction.*,mp_bank_transaction_payee.payee_id');
		$this->db->from('mp_generalentry');
		$this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = $entry_type ");
		$this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id");
		$this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id");
		$this->db->where('mp_generalentry.id', $trans_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}

    //USED TO FIND CURRENT AVAILABLE BALANCE IN BANK 
    function check_available_balance($bank_id)
    {
        $total_available = 0;

        $opening = $this->fetch_attr_record_by_id('mp_bank_opening','bank_id',$bank_id);  

        if($opening != NULL)
        {
             $total_available = $total_available + $opening[0]->amount;
        }

        $result = $this->fetch_attr_record_by_id('mp_bank_transaction','bank_id',$bank_id);

        if($result != NULL)
        {
            foreach ($result as $single_transaction) 
            {
                $result = $this->fetch_attr_record_by_id('mp_sub_entry','parent_id',$single_transaction->transaction_id);

                //1 DEPOSIT //0 CHEQUE
                if($single_transaction->transaction_type == 'recieved')
                {
                    $total_available = $total_available + $single_transaction->total_paid; 
                }
                else if($single_transaction->transaction_type == 'paid')
                {
                    $total_available = $total_available - $single_transaction->total_paid;
                }
                else if ($single_transaction->transaction_type == 'bank_collection')
				{
					$total_available = $total_available + $single_transaction->total_paid;
				}
				else if($single_transaction->transaction_type == 'opening_account')
                {
                    $total_available = $total_available + $single_transaction->total_paid;
                }
                else
                {

                }
            }
        } 
        
        return $total_available;
    }

    // DEFINES TO UPLOAD PICTURE
    public function do_upload_picture($picture, $path)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;

        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($picture))
        {
            $error = array(
                'error' => $this->upload->display_errors()
            );
            return "default.jpg";
        }
        else
        {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            return $data['upload_data']['file_name'];
        }
    }

    public function count_product($table_name, $tbl_attr, $status)
    {
        $this->db->where($tbl_attr, $status);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    public function recent_accounts()
    {
        $this->db->where('type !=', 'company');
        $this->db->from('mp_payee');
        return $this->db->count_all_results();
    }

    public function count_sales($table_name, $first_date, $second_date)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    public function count_expire_products($table_name, $first_date, $second_date)
    {
        $this->db->where('expire >=', $first_date);
        $this->db->where('expire <=', $second_date);
        $this->db->from($table_name);
        return $this->db->count_all_results();
    }

    function result_retail_cost()
    {
        $sum_amt = 0;
        $result_parts = $this->fetch_record('mp_productslist','status');
            if($result_parts != "")
            {

            $sum_amt = 0;

            foreach ($result_parts as $single_part) 
            {
               $sum_amt += $single_part->quantity*$single_part->purchase;
            }
        }
        return $sum_amt;
    }

    public function fetch_todo_record($table_name, $first_date, $second_date)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->where('status = 0');
        $this->db->limit(6);
        $this->db->from($table_name);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return "";
        }
    }

    public function authenticate_user($Email, $password)
    {
        $this->db->where('user_email =', $Email);
        $this->db->where('user_password =', sha1($password));
        $this->db->where('status = 0');
        $query = $this->db->get('mp_users');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function authenticate_panel_user($Email, $password)
    {
        $this->db->where('cus_email =', $Email);
        $this->db->where('cus_password =', sha1($password));
        $this->db->where('cus_status = 0');
        $this->db->where(['type' => 'customer']);
        $query = $this->db->get('mp_payee');
        if ($query->num_rows() > 0)
        {

           return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_user_details_menus()
    {
        $this->db->select("mp_users.id as user_id , mp_users.user_name , mp_users.user_email , mp_users.user_description ,mp_menu.name,mp_multipleroles.id as rolesid");
        $this->db->from('mp_users');
        $this->db->from('mp_multipleroles');
        $this->db->join('mp_menu', "mp_users.id = mp_multipleroles.user_id and mp_multipleroles.menu_Id = mp_menu.id ");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    public function delete_image_custom($path, $id,$attr,$tablename)
    {

        // IMAGE FOLDER PATH
        $image_path = $path;

        // TABLE ID TO DELETE ROW
        $args = $id;

        // DEFINES TO RETREVE DATA ROW FROM TABLE AGINST GIVEN ID
        $data = $this->get_by_id($tablename, $id);

        // WE WILL NOT DELETE THE DEAFULT PICTURE BECAUSE WE USED THIS PICTURE MANY TIMES FOR OTHER PROFILE
        // IF WE DID SO THEM THIS COULD CAUSE AN ERROR IN PROFILE IMAGES OF PEOPLE IN TABLES
        if ($data->$attr != "default.jpg")
        {
            // TO DELETE IMAGE FROM FOLDER TO GIVEN PATH
            @@unlink($image_path . $data->$attr);
        }
    }

    public function check_role_duplication($user_id, $menu_id)
    {
        $this->db->where('user_id =', $user_id);
        $this->db->where('menu_Id =', $menu_id);
        $query = $this->db->get('mp_multipleroles');
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return NULL;
        }
    }

    // /CHECK THE STATUS OF VERIFIED invoiceS
    public function verified_expiry_time_checks()
    {
        $this->db->select('mp_tempinvoices.id as invoice_id,mp_tempinvoices.date,');
        $this->db->from('mp_tempinvoices');
        $this->db->where('status =', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $fetched_invoices = $query->result();

            // FETCHING THE EXPIRY TIME FROM TABLE mp_langingpage
            $set_expirey = $this->fetch_record_by_id('mp_langingpage', 1);
            $retrieve_val = $set_expirey[0]->expirey;
            $todays_date = Date('Y-m-d');
            foreach($fetched_invoices as $obj_fetched_invoices)
            {

                // invoice DATE FROM TABLE OF TMP TABLE
                $invoice_date = $obj_fetched_invoices->date;
                $invoice_days = date_diff(date_create($invoice_date) , date_create($todays_date));
                $invoice_days->format("%a");
                if ($retrieve_val >= $invoice_days)
                {

                    // TABLENAME AND ID FOR DATABASE ACTION
                    $args = array(
                        'table_name' => 'mp_tempinvoices',
                        'id' => $obj_fetched_invoices->invoice_id
                    );

                    // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
                    $data = array(
                        'status' => 4
                    );
                    $this->edit_record_id($args, $data);
                }
            }
        }
    }

    //USED TO RECOVER FORGET PASSWORD
    function fetch_forget_password($user_email,$user_code)
    {
        $this->db->select("mp_users.id");
        $this->db->from('mp_users');
        $this->db->where(['user_email'=>$user_email]);  
        $this->db->where(['user_password'=>$user_code]);    
        $this->db->where(['status' =>'0']);    

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }  
    }

    //USED TO RECOVER FORGET PASSWORD
    function fetch_forget_password_user($user_email,$user_code)
    {
        $this->db->select("mp_customer.id");
        $this->db->from('mp_customer');
        $this->db->where(['cus_email'=>$user_email]);  
        $this->db->where(['cus_password'=>$user_code]);    
        $this->db->where(['cus_status' =>'0']);    

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }  
    }

    //FOR SHOWING COST IN POS
    function check_pos_cost()
    {
        $user_name = $this->session->userdata('user_id');
        $user_id = $user_name['id'];

        $this->db->select("id");
        $this->db->from('mp_multipleroles');
        $this->db->where(['menu_Id' => 19]);  
        $this->db->where(['agentid' => $user_id]);  

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return NULL;
        }
    }

    //USED TO SEARCH ATTR
    function search_items_stock($data)
    {
        $this->db->select("*");
        $this->db->from('mp_productslist');
        $this->db->or_like(['product_name' => $data]);   

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        } 
    }

    //USED TO LIST THE EXPIRED ITEMS 
    function fetch_expired_record()
    {
        $this->db->select("*");
        $this->db->from('mp_productslist');
        $this->db->where(['mp_productslist.expire < ' => date('Y-m-d')]);  

        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE PURCHASED STOCK 
    //Invoice/fetch_record_purchased
    function fetch_record_purchased($status = 0,$date1,$date2)
    {
        $this->db->select("mp_purchase.*,mp_payee.customer_name");
        $this->db->from('mp_purchase');
        $this->db->join('mp_payee', "mp_purchase.supplier_id = mp_payee.id");
        $this->db->where(['mp_purchase.status' =>$status]); 
        $this->db->where('mp_purchase.date >=', $date1);
        $this->db->where('mp_purchase.date <=', $date2); 
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }


    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME FOR SUPPLY LIST
    public function fetch_supply($date1,$date2)
    {
        $this->db->select("mp_invoices.*,mp_drivers.name as drivername,mp_vehicle.name as vehiclename,mp_town.name as townname,mp_town.region as townregion,mp_payee.customer_name");
        $this->db->from('mp_invoices');
        $this->db->join('mp_drivers', "mp_invoices.driver_id = mp_drivers.id");
        $this->db->join('mp_vehicle', "mp_invoices.vehicle_id = mp_vehicle.id");
        $this->db->join('mp_town', "mp_invoices.region_id = mp_town.id");
        $this->db->join('mp_payee', "mp_invoices.cus_id = mp_payee.id");
        $this->db->where(['source' => '1']);
        $this->db->where('mp_invoices.date >=', $date1);
        $this->db->where('mp_invoices.date <=', $date2);
         $query = $this->db->get();
  
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME FOR ORDERS LIST
    public function fetch_single_salesmen_orders($id)
    {
        $this->db->select("mp_order_list_total.date,mp_order_list_total.id as main_order_id,mp_order_list_total.agentid,mp_order_list_total.salesman_id,mp_order_list_total.total_amount,mp_order_list_total.cash,mp_order_list_total.credit_amount,mp_order_list_total.cheque_amount,mp_order_list_total.schemes,mp_order_list_total.bank_deposit,mp_order_list_total.return_stock_val,mp_salesman.name as salesman_name,mp_users.user_name as agent_name");
        $this->db->from('mp_order_list_total');
        //$this->db->join('mp_sales_orderlist', "mp_sales_orderlist.order_id = mp_order_list_total.id");
        $this->db->join('mp_salesman', "mp_order_list_total.salesman_id = mp_salesman.id");
        $this->db->join('mp_users', "mp_order_list_total.agentid = mp_users.id");
        $this->db->where('mp_order_list_total.id', $id);

         $query = $this->db->get();
  
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //USED TO FETCH THE RECORD THROUGH PROVIDED ID AND ATTTRIBUTE NAME FOR ORDERS LIST
    public function fetch_verified_orders($date1,$date2)
    {
        $this->db->select("mp_order_list_total.date,mp_order_list_total.id as main_order_id,mp_order_list_total.agentid,mp_order_list_total.salesman_id,mp_order_list_total.total_amount,mp_order_list_total.cash,mp_order_list_total.credit_amount,mp_order_list_total.cheque_amount,mp_order_list_total.schemes,mp_order_list_total.bank_deposit,mp_order_list_total.return_stock_val,mp_salesman.name as salesman_name,mp_users.user_name as agent_name");
        $this->db->from('mp_order_list_total');
        //$this->db->join('mp_sales_orderlist', "mp_sales_orderlist.order_id = mp_order_list_total.id");
        $this->db->join('mp_salesman', "mp_order_list_total.salesman_id = mp_salesman.id");
        $this->db->join('mp_users', "mp_order_list_total.agentid = mp_users.id");
        $this->db->where('mp_order_list_total.date >=', $date1);
        $this->db->where('mp_order_list_total.date <=', $date2);
        $this->db->order_by('mp_order_list_total.id','DESC');

         $query = $this->db->get();
  
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }
    }

    //FETCHING THE PURCHAING LIST 
    function fetch_purchase_list($purchase_id)
    {
        
        $this->db->select("mp_sub_purchase.*,mp_productslist.product_name,mp_productslist.mg,mp_productslist.unit_type");
        $this->db->from('mp_sub_purchase');
        $this->db->join('mp_productslist', "mp_sub_purchase.mid = mp_productslist.id");
        $this->db->where('mp_sub_purchase.purchase_id',$purchase_id);
        $this->db->order_by('mp_sub_purchase.id','DESC');

         $query = $this->db->get();
  
        if($query->num_rows() > 0)
        {
            
            return $query->result();
        }
        else
        {
            return NULL;
        } 
    }

    function fetch_store_picklist($date1,$date2,$salesman_id)
    {
        $picklist = array();
        

        if($date1 != NULL AND $date2 != NULL AND $salesman_id != NULL)
        {

            $this->db->select("mp_invoices.*,mp_productslist.packsize,mp_productslist.unit_type,mp_sales.product_id, mp_sales.product_no,mp_sales.product_name,mp_sales.mg,mp_sales.price,mp_sales.purchase,mp_sales.qty,mp_sales.tax");
            $this->db->from('mp_invoices');
            $this->db->join('mp_sales', "mp_invoices.id = mp_sales.order_id");
            $this->db->join('mp_productslist', "mp_productslist.id = mp_sales.product_id");
            $this->db->where(['mp_invoices.sales_man_id ' => $salesman_id]); 
            $this->db->where('mp_invoices.date >=', $date1);
            $this->db->where('mp_invoices.date <=', $date2); 
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
                $salesmandata =  $query->result();
                foreach ($salesmandata as $single_sale) 
                {
                    //print_r($project); die();
                   // $obj = new Filter_array_values();
                   // $obj->setVal($single_sale->product_id,'product_id');
                  //  $val = array_map(array($obj, "filter_array"), $picklist);
                    $check = TRUE;
                    $check = $this->check_existence_id($picklist,4);
                    if($check)
                    {
                        $quantity = 0;
                        foreach ($salesmandata as $inner_sale) 
                        {
                            if($single_sale->product_id == $inner_sale->product_id )
                            {
                                $quantity = $quantity + $inner_sale->qty;
                            }
                        }

                        $picklist [] = array('product_id'=>$single_sale->product_id,'product_name'=>$single_sale->product_name,'sku'=>$single_sale->product_no,'retial_price'=>$single_sale->price,'pack_price'=>$single_sale->price*$single_sale->qty,'qty'=>$quantity,'weight'=>$single_sale->mg.' '.$single_sale->unit_type);    
                    }  
                }

                return $picklist;
            }
            else
            {
                return NULL;
            }

            }
        else
        {
            return NULL;
        }
    }

    function fetch_order_picklist($order_id)
    {
        
        $this->db->select("mp_sales_orderlist.*,mp_payee.customer_name");
        $this->db->from('mp_sales_orderlist');
        $this->db->join('mp_brand',"mp_brand.id = mp_sales_orderlist.brand_id");
        $this->db->join('mp_payee',"mp_payee.id =  mp_brand.company_id",'RIGHT');
        $this->db->where('mp_sales_orderlist.order_id',$order_id); 
        $this->db->order_by('mp_sales_orderlist.id','DESC'); 
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }   
    }

    //USED TO CHECK THE AVAILABLE INDEX()
    function check_existence_id($arr,$index)
    {
        foreach ($arr as $single_index) 
        {
            
           if($single_index['product_id'] == $index)
           {
                return FALSE;
           }

        }
        return TRUE;
    }

   /* //USED TO FETCH THE SALESMAN LIST 
    function fetch_salesman($date1,$date2,$store_id)
    {
        $salesman = NULL;

        $this->db->select("*");
        $this->db->from('mp_invoices'); 
        $this->db->where(['mp_invoices.store_id ' => $store_id]); 
        $this->db->where('mp_invoices.date >=', $date1);
        $this->db->where('mp_invoices.date <=', $date2); 
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $store_data =  $query->result();
            
            if($store_data != NULL)
            {
                $salesman = $store_data[0]->sales_man_id;
                
                foreach ($store_data as $single_trans) 
                {
                    if($single_trans->sales_man_id == $salesman)
                    {
                        $salesman = $single_trans->sales_man_id;
                    }
                    else
                    {
                        $salesman =  'Multiple';
                        break;
                    }
                }

                if($salesman !=  'Multiple' AND $salesman != NULL)
                {
                    $this->db->select("*");
                    $this->db->from('mp_salesman'); 
                    $this->db->where(['mp_salesman.id ' => $salesman]); 
                    $query = $this->db->get();
                    if ($query->num_rows() > 0)
                    {
                        
                        $store_data =  $query->result();
                        print_r($store_data);
                        die();
                        $salesman = $store_data[0]->name;
                    }

                }

                return $salesman;
            }
            else
            {
                return NULL;
            }
        }
        else
        {
            return NULL;
        }

    }*/

    public function fetch_payment_vouchers($date1, $date2, $type)
	{
		$this->db->select("mp_payment_voucher.*,mp_payee.customer_name");
		$this->db->from('mp_payment_voucher');
		$this->db->join('mp_payee', "mp_payee.id = mp_payment_voucher.payee_id");
		
		if($type == 2)
		{
			$this->db->or_where('mp_payment_voucher.type', 3);
			$this->db->or_where('mp_payment_voucher.type', $type);
        }
        else
        {
            $this->db->where('mp_payment_voucher.type', $type);
        }

		
		$this->db->where('mp_payment_voucher.receipt_date >=', $date1);
		$this->db->where('mp_payment_voucher.receipt_date <=', $date2);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }

    // USED TO GET THE SINGLE TRANSACTION
	function get_single_trans_all($trans_id)
	{
		$this->db->select('mp_generalentry.date,mp_generalentry.naration,mp_sub_entry.*,mp_head.name');
		$this->db->from('mp_generalentry');
		$this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id");
		$this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
		$this->db->where('mp_generalentry.id', $trans_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO FETCH ACCOUNTS RECORD
    function fetch_single_voucher($v_id, $type)
    {
        $this->db->select('*');
        $this->db->from('mp_payment_voucher');
        if($type != 2)
        {
             $this->db->where('type', $type);
        }
       
        $this->db->where('transaction_id', $v_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        } 
        else 
        {
            return null;
        }
    }

    // USED TO FETCH THE RECORD OF CREDIT USING PRODUCT ID
	function fetch_product_sales($sales_id)
	{
		$this->db->select("mp_sub_receipt.*,mp_product.product_name");
		$this->db->from(' mp_sub_receipt');
		$this->db->join('mp_product', "  mp_sub_receipt.product_id = mp_product.id");
		$this->db->where(['mp_sub_receipt.sales_id' => $sales_id]);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO FETCH THE RECORD OF CREDIT USING PRODUCT ID
	function fetch_product_expense($expense_id)
	{
		$this->db->select(" mp_sub_expense.*, mp_head.name");
		$this->db->from(' mp_sub_expense');
		$this->db->join('mp_head', "  mp_sub_expense.head_id = mp_head.id");
		$this->db->where(['mp_sub_expense.expense_id' => $expense_id]);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO CREATE ACCOUNT STATEMENT
	function fetch_account_statement($account_id, $date1, $date2, $period)
	{
		$trans_arr = array();
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_bank_transaction.*,
        ");
        
		$this->db->from('mp_generalentry');
		$this->db->join('mp_bank_transaction', 'mp_bank_transaction.transaction_id = mp_generalentry.id');
		$this->db->join('mp_bank_transaction_payee', 'mp_bank_transaction_payee.transaction_id = mp_generalentry.id');
        $this->db->where('mp_bank_transaction_payee.payee_id', $account_id);
       // $this->db->where('mp_generalentry.generated_source = "bank_collection" OR mp_generalentry.generated_source = "deposit" OR mp_generalentry.generated_source = "cheque" ');

		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
        }
        
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_expense.*
        ");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_expense', 'mp_expense.transaction_id = mp_generalentry.id');
        $this->db->where('mp_expense.payee_id', $account_id);
        $this->db->where('mp_expense.method != ','Cheque');
       // $this->db->where('mp_generalentry.generated_source','expense');
		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
        }
        
		// $this->db->select("
        // mp_generalentry.id as transaction_id,
        // mp_generalentry.date,
        // mp_generalentry.naration,
        // mp_generalentry.generated_source,
        // mp_invoices.*
        // ");
		// $this->db->from('mp_generalentry');
		// $this->db->join('mp_invoices', 'mp_invoices.transaction_id = mp_generalentry.id');
		// $this->db->where('mp_invoices.payee_id', $account_id);
		// if ($period != 'all')
		// {
		// 	$this->db->where('mp_generalentry.date >=', $date1);
		// 	$this->db->where('mp_generalentry.date <=', $date2);
		// }
		// $query = $this->db->get();
		// if ($query->num_rows() > 0)
		// {
		// 	$result = $query->result();
		// 	foreach($result as $single_transaction)
		// 	{
		// 		$trans_arr[] = $single_transaction;
		// 	}
        // }
        
		$this->db->select("
            mp_generalentry.id as transaction_id,
            mp_generalentry.date,
            mp_generalentry.naration,
            mp_generalentry.generated_source,
            mp_sales_receipt.*
        ");
        
		$this->db->from('mp_generalentry');
		$this->db->join('mp_sales_receipt', 'mp_sales_receipt.transaction_id = mp_generalentry.id');
        $this->db->where('mp_sales_receipt.payee_id', $account_id);
        $this->db->where('mp_sales_receipt.method != ','Cheque');
		if($period != 'all')
		{
            $this->db->where('mp_generalentry.date >=', $date1);
            $this->db->where('mp_generalentry.date <=', $date2);
        }
        
		$query = $this->db->get();
        if ($query->num_rows() > 0) 
        {
            $result  =  $query->result();
            foreach ($result as $single_transaction) 
            {
                $trans_arr [] = $single_transaction;
            }
        }    
        
        
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_purchase.*
        ");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_purchase', 'mp_purchase.transaction_id = mp_generalentry.id');
        $this->db->where('mp_purchase.supplier_id', $account_id);
        $this->db->where('mp_purchase.status', 0);
        $this->db->where('mp_purchase.payment_type_id !=','Cheque');
        $this->db->where('mp_generalentry.generated_source','create_purchases');
     
		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
            $result = $query->result();
           
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
		}
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_purchase.*
        ");

		$this->db->from('mp_generalentry');
		$this->db->join('mp_purchase', 'mp_purchase.transaction_id = mp_generalentry.id');
        $this->db->where('mp_purchase.supplier_id', $account_id);
        $this->db->where('mp_purchase.status', 1);
        $this->db->where('mp_generalentry.generated_source','purchases_return');
        $this->db->where('mp_purchase.payment_type_id !=','Cheque');
		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
        }
        
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_return.*
        ");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_return', 'mp_return.transaction_id = mp_generalentry.id');
        $this->db->where('mp_return.cus_id', $account_id);
        $this->db->where('mp_generalentry.generated_source','return_pos');
        
		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
		}
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_invoices.*
        ");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_invoices', 'mp_invoices.transaction_id = mp_generalentry.id');
        $this->db->where('mp_invoices.cus_id', $account_id);
        $this->db->where('mp_generalentry.generated_source','pos');
        $this->db->where('mp_invoices.payment_method != ',1);
		if ($period != 'all')
		{
			$this->db->where('mp_generalentry.date >=', $date1);
			$this->db->where('mp_generalentry.date <=', $date2);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
		}
		$this->db->select("
        mp_generalentry.id as transaction_id,
        mp_generalentry.date,
        mp_generalentry.naration,
        mp_generalentry.generated_source,
        mp_payment_voucher.*
        ");
		$this->db->from('mp_generalentry');
		$this->db->join('mp_payment_voucher', 'mp_payment_voucher.transaction_id = mp_generalentry.id');
		$this->db->where('mp_generalentry.date >=', $date1);
		$this->db->where('mp_generalentry.date <=', $date2);
		$this->db->where('mp_payment_voucher.payee_id', $account_id);
        $this->db->where('mp_payment_voucher.type !=', 2);
       // $this->db->where('mp_generalentry.generated_source = "credit_voucher" OR mp_generalentry.generated_source = "debit_voucher" OR mp_generalentry.generated_source = "Opening_balance" ');

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $single_transaction)
			{
				$trans_arr[] = $single_transaction;
			}
		}
		usort($trans_arr, function ($a, $b)
		{
			// return $a->transaction_id <=> $b->transaction_id;
			return $a->transaction_id - $b->transaction_id;
		});
		return $trans_arr;
	}

    //USED MULTIPLE HEADS
    function fetch_account_heads($assets,$libility,$equity,$revenue,$expense)
    {
        $this->db->select("*");
        $this->db->from('mp_head');
        
        if($assets != '')
        {
            $this->db->or_where('nature','Assets');
        }

        if($libility != '')
        {
            $this->db->or_where('nature','Libility');
        }

        if($equity != '')
        {
            $this->db->or_where('nature','Equity');
        }

        if($revenue != '')
        {
            $this->db->or_where('nature','Revenue');
        }

        if($expense != '')
        {
            $this->db->or_where('nature','Expense');
        }

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    // USED TO FETCH THE RECORD OF PRODUCTS/SERVICES
	function fetch_product_records()
	{
		$this->db->select("mp_product.*,mp_head.name");
		$this->db->from(' mp_product');
		$this->db->join('mp_head', "mp_product.head_id = mp_head.id");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
	}
    
    // USED TO FETCH ACCOUNTS RECORD
    function get_single_child_trans($tran_id, $type = '')
    {
        $this->db->select('mp_sub_entry.*,mp_head.name');
        $this->db->from('mp_sub_entry');
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->where('mp_sub_entry.parent_id', $tran_id);
        if ($type != '') {
            $this->db->where('mp_sub_entry.type', $type);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    // USED TO FIND PAYMENT VOUCHERS
	function fetch_record_payment_voucher($trans_id)
	{
		$this->db->select('mp_payment_voucher.*,mp_payee.customer_name');
		$this->db->from('mp_payment_voucher');
		$this->db->join('mp_payee', "mp_payee.id = mp_payment_voucher.payee_id");
		$this->db->where('mp_payment_voucher.transaction_id', $trans_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO GET THE SINGLE TRANSACTION
	function get_single_trans($trans_id, $entry_type)
	{
		$this->db->select('mp_generalentry.date,mp_generalentry.naration,mp_sub_entry.*,mp_head.name');
		$this->db->from('mp_generalentry');
		$this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = $entry_type ");
		$this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
		$this->db->where('mp_generalentry.id', $trans_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return NULL;
		}
    }
    
    // USED TO FIND THE SINGLE BANK COLLECTION
    function get_single_bank_collection($trans_id, $entry_type)
    {
        $this->db->select('mp_generalentry.id as main_trans_id,mp_generalentry.date,mp_generalentry.naration,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.ref_no,mp_bank_transaction.total_paid,mp_bank_transaction.total_bill,mp_bank_transaction.transaction_status,mp_head.name as headname');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = $entry_type ");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id");
        $this->db->join('mp_banks', "mp_bank_transaction.bank_id = mp_banks.id");
        $this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id");
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
        $this->db->where('mp_generalentry.id', $trans_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
}