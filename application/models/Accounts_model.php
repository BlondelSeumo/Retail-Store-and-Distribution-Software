<?php
/*
*  @author    : Muhammad Ibrahim
*  @Mail      : aliibrahimroshan@gmail.com
*  @Created   : 14th August, 2017
*  @Developed : Team Gigabyte
*  @URL       : www.gigabyteltd.net
*  @Envato    : https://codecanyon.net/user/gb_developers
*/
class Accounts_model extends CI_Model
{
    public function fetch_record_date($tablename, $first_date, $second_date)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->order_by('id', 'DESC');
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

    //USED TO FIND THE CHEQUES 
    function bank_collection_transaction($date1,$date2)
    {
        $this->db->select('mp_generalentry.id as main_trans_id,mp_generalentry.date,mp_generalentry.naration,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.ref_no,mp_bank_transaction.transaction_status,mp_bank_transaction.id as bank_trans_id,mp_head.name as headname');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = 1 ");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
        $this->db->join('mp_head',  "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
        $this->db->where('mp_generalentry.generated_source','bank_collection');
        $this->db->where('mp_generalentry.date >=', $date1);
        $this->db->where('mp_generalentry.date <=', $date2);
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

    public function fetch_record_brandwise($tablename, $brand_id,$date1, $date2)
    {

        $this->db->select('mp_invoices.*,mp_sales.order_id,mp_productslist.brand_id');
        $this->db->from('mp_invoices');
        $this->db->join(' mp_sales', "mp_invoices.id = mp_sales.order_id");
        $this->db->join(' mp_productslist', "mp_productslist.id = mp_sales.product_id");
        $this->db->where(['mp_productslist.brand_id' => $brand_id]);
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


        /*$this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }*/
    } 

    public function fetch_record_brandsection($tablename, $section_id, $date1, $date2)
    {

        $this->db->select('mp_invoices.*,mp_sales.order_id,mp_productslist.brand_id');
        $this->db->from('mp_invoices');
        $this->db->join(' mp_sales', "mp_invoices.id = mp_sales.order_id");
        $this->db->join(' mp_productslist', "mp_productslist.id = mp_sales.product_id");
        $this->db->where(['mp_productslist.brand_sector_id' => $section_id]);
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


        /*$this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return NULL;
        }*/
    }

    public function fetch_record_companywise($tablename, $comapany_id,$date1,$date2)
    {
        $this->db->select('mp_invoices.id,mp_invoices.discount,mp_invoices.date,mp_sales.*,mp_productslist.brand_id,mp_productslist.unit_type,mp_brand.id,mp_payee.id,mp_payee.customer_name');
        $this->db->from('mp_invoices');
        $this->db->join('mp_sales', "mp_invoices.id = mp_sales.order_id",'LEFT');
        $this->db->join('mp_productslist', "mp_productslist.id = mp_sales.product_id",'LEFT');
        $this->db->join('mp_brand', "mp_brand.id =  mp_productslist.brand_id",'LEFT');
        $this->db->join('mp_payee', "mp_payee.id =  mp_brand.company_id",'LEFT');
        $this->db->where(['mp_payee.id' => $comapany_id]);
        $this->db->where('mp_invoices.date >=' ,$date1);
        $this->db->where('mp_invoices.date <=',$date2);

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

    public function fetch_record_storewise($tablename, $store_id,$date1,$date2)
    {
        $this->db->select('mp_invoices.*');
        $this->db->from('mp_invoices');
        $this->db->join('mp_sales', "mp_invoices.id = mp_sales.order_id");
        $this->db->join('mp_stores', "mp_stores.id = mp_invoices.store_id");
        $this->db->where(['mp_stores.id' => $store_id]);
        $this->db->where('mp_invoices.date >=' ,$date1);
        $this->db->where('mp_invoices.date <=',$date2);

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


    public function fetch_record_skuwise($tablename,$sku,$date1,$date2)
    {

        $this->db->select('mp_invoices.*');
        $this->db->from('mp_invoices');
        $this->db->join('mp_sales', "mp_invoices.id = mp_sales.order_id");
        $this->db->join('mp_productslist',"mp_productslist.id = mp_sales.product_id");
        $this->db->where(['mp_productslist.sku' => $sku]);
        $this->db->where('mp_invoices.date >=' ,$date1);
        $this->db->where('mp_invoices.date <=',$date2);

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

    public function fetch_record_date_temp($tablename, $first_date, $second_date, $status)
    {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->where('status =', $status);
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

    public function fetch_expired_record()
    {
        $this->db->select('*');
        $this->db->from('mp_tempinvoices');
        $this->db->where('status = 4');
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

    public function fetch_record_sales($tablename, $tablefield, $id)
    {

        $this->db->select('mp_sales.*,mp_productslist.unit_type');
        $this->db->from('mp_sales');
        $this->db->join(' mp_productslist', "mp_productslist.id = mp_sales.product_id");
        $this->db->where([$tablefield => $id]);
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

    // adjust_products/id/status
    public function adjust_products($invoice_id)
    {
        $this->db->select('*');
        $this->db->where(['order_id' => $invoice_id]);
        $query = $this->db->get('mp_temp_sales');
        if ($query->num_rows() > 0)
        {
            $feteched_record = $query->result();
            foreach($feteched_record as $obj_result_invoice)
            {
                $this->db->select('quantity');
                $this->db->where(['id' => $obj_result_invoice->product_id]);
                $product_query = $this->db->get('mp_productslist');
                if ($product_query->num_rows() > 0)
                {
                    $feteched_product_record = $product_query->result();

                    // GET THE quantity OF MEDINCE IN STOCK

                    $product_quantity_stock = $feteched_product_record[0]->quantity;

                    // TABLENAME AND ID FOR DATABASE ACTION

                    $args = array(
                        'table_name' => 'mp_productslist',
                        'id' => $obj_result_invoice->product_id
                    );

                    // COMPARE WEATHER THE IN STOCK product IS AVAILBLE IN SUCH quantity OR NOT STOCK MUST
                    // BE GREATER OR EQUAL TO invoice STOCK

                    if ($product_quantity_stock >= $obj_result_invoice->qty)
                    {

                        // NEW product quantity THAT SHOULD BE UPADATED IN STOCK
                        $new_stock_medicne = $product_quantity_stock - $obj_result_invoice->qty;

                        // DATA ARRAY FOR UPDATE QUERY array('abc'=>abc)
                        $data = array(
                            'quantity' => $new_stock_medicne
                        );

                        // LOADING CRUD MODEL FOR UPDATE THE DATA
                        $this->load->model('Crud_model');
                        $model_obj = & get_instance();
                        $model_obj->Crud_model->edit_record_id($args, $data);
                    }
                    else
                    {
                        return FALSE;
                    }
                }
                else
                {
                    return FALSE;
                }
            }

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function fetch_record_product()
    {

        // DEFINES JOIN QUERY WHICH WOULD RETURN THE CATEGORY NAME OF product FROM
        // mp_category TABLE INSTEAD OF JUST RETURNING NUMBERIC ID FORM mp_productslist TABLE.
        // INSEAD OF CATEGORY ID 12 WILL GET THE category_name FROM TABLE.
        // IF 0 MEANS SELECT ONLY THOSE RECORDS WHORE STATUS IS 0 MEANS VISIBLE OR 1 MEANS FETCH ALL
        // WEATHER IT WOULD BE VISIBLE OR HIDDEN MEANS STATUS = 0 OR STATUS = 1

        $this->db->select('*');
        $this->db->from('mp_invoices');
        $this->db->join('mp_sales', "mp_invoices.id = mp_sales.order_id");
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

    public function fetch_record_product_sales_qty()
    {

        // IF 0 MEANS SELECT ONLY THOSE RECORDS WHORE STATUS IS 0 MEANS VISIBLE OR 1 MEANS FETCH ALL
        // WEATHER IT WOULD BE VISIBLE OR HIDDEN MEANS STATUS = 0 OR STATUS = 1
        $sql = "SELECT *, SUM(qty) AS sum_quantity FROM mp_sales  INNER JOIN mp_productslist  ON (mp_sales.product_id = mp_productslist.id) group by mp_sales.product_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return NULL;
        }
    }

    public function get_by_id($table1, $table2, $id)
    {
        $this->db->select("*");
        $this->db->where('mp_invoices.id', $id);
        $this->db->from($table1);
        $this->db->join($table2, "$table1.id = $table2.order_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_cus_id($table1, $table2, $id, $first_date, $second_date)
    {
        $this->db->select("*");
        $this->db->where('cus_id', $id);
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->from($table1);
        $this->db->join($table2, "$table1.id = $table2.order_id ",'left');
        $query = $this->db->get();
        return $query->result();
    }   

    public function get_invoice_by_date($table1, $id, $first_date, $second_date)
    {
        $this->db->select("*");
        $this->db->where('cus_id', $id);
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->from($table1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_invoice_id($table1, $id, $user_id)
    {
        $this->db->select("*");
        $this->db->from($table1);
        $this->db->where('id', $id);
        $this->db->where('cus_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function get_amount_from_product($first_date, $second_date)
    {
        $total_amount = 0;

        // LOADING CRUD MODEL FOR UPDATE THE DATA
        $this->load->model('Crud_model');
        $model_obj = & get_instance();
        $return_data = $model_obj->Crud_model->fetch_record_product_returned($first_date, $second_date);
        if ($return_data != "")
        {
            foreach($return_data as $obj_return_data)
            {
                $total_amount = $total_amount + ($obj_return_data->quantity * $obj_return_data->retail);
            }
        }

        return $total_amount;
    }
      //SALES THIS YEAR 
    public function Statistics_sales_with_date($date1, $date2)
    {
        $mega_arr = array();
        $collection = array();
        $totalrevenue = 0;
        $totalexpense = 0;

            // FETCH SALES RECORD FROM invoices TABLE
            $result_invoice = $this->fetch_record_date('mp_invoices', $date1, $date2);
            if ($result_invoice != null)
            {
                $count = 0;
                foreach($result_invoice as $obj_result_invoice)
                {

                    // FETCH SALES RECORD FROM SALES TABLE
                    $result_sales = $this->Fetch_Record_Sales('mp_sales', 'order_id', $obj_result_invoice->id);
                    if ($result_sales != null)
                    {
                        $collection[$count] = $result_sales;
                        $count++;
                    }
                }

                for ($i = 0; $i < count($collection); $i++)
                {
                    $counter = 0;
                    while ($counter < count($collection[$i]))
                    {
                       
                        $totalrevenue = $totalrevenue+($collection[$i][$counter]->price * $collection[$i][$counter]->qty);

                        $totalexpense = $totalexpense + ($collection[$i][$counter]->purchase * $collection[$i][$counter]->qty);

                        $counter++;
                    }
                } 
            }
            else
            {
                $totalrevenue = 0;
                $totalexpense = 0;
            }

        $mega_arr[0] = $totalrevenue;
        $mega_arr[1] = $totalexpense;

        return $mega_arr;
    }
    
     //SALES THIS YEAR 
    public function Statistics_sales_this_year()
    {
        $mega_arr = array();
        $revenue_arr = array();
        $expense_arr = array();
        $profit_arr = array();
        $discount_arr = array();
        $arr_ctr = 0;
        for ($counteri = 1; $counteri <= 12; $counteri++)
        {
            $date1 = date('Y') . '-' . $counteri . '-1';
            $date2 = date('Y') . '-' . $counteri . '-30';

            // echo $date1.'<br />';
            //  $date1 = date('Y').'-5-1';
            //  $date2 = date('Y').'-5-30';
            // FETCH SALES RECORD FROM invoices TABLE

            $result_invoice = $this->fetch_record_date('mp_invoices', $date1, $date2);
            if ($result_invoice != null)
            {
                $count = 0;
                foreach($result_invoice as $obj_result_invoice)
                {

                    // FETCH SALES RECORD FROM SALES TABLE

                    $result_sales = $this->Fetch_Record_Sales('mp_sales', 'order_id', $obj_result_invoice->id);
                    if ($result_sales != null)
                    {
                        $collection[$count] = $result_sales;
                        $count++;

                        // echo 'Id'.$obj_result_invoice->id.'Discount'.$obj_result_invoice->discount.'<br />';

                    }
                }

                $totalrevenue = 0;
                $totalexpense = 0;
                $discountoffered = 0;
                $newamt = 0;
                for ($i = 0; $i < count($collection); $i++)
                {
                    $counter = 0;
                    while ($counter < count($collection[$i]))
                    {
                        $total = 0;
                        $subtotal = 0;
                        $subtotal = $collection[$i][$counter]->price * $collection[$i][$counter]->qty;
                        $totalexpense = $totalexpense + ($collection[$i][$counter]->purchase * $collection[$i][$counter]->qty);
                        $total = $total + $subtotal;
                        $totalrevenue = $totalrevenue + $total;
                        $totalprofit = $totalrevenue - $totalexpense;
                        $counter++;
                    }
                }

                $revenue_arr[$arr_ctr] = $totalrevenue;
                $Totalexpense[$arr_ctr] = $totalexpense;
                $profit_arr[$arr_ctr] = $totalprofit;
            }
            else
            {
                $revenue_arr[$arr_ctr] = 0;
                $Totalexpense[$arr_ctr] = 0;
                $profit_arr[$arr_ctr] = 0;
            }

            $arr_ctr++;
        }

        $mega_arr[0] = $revenue_arr;
        $mega_arr[1] = $profit_arr;
        $mega_arr[2] = $Totalexpense;
        return $mega_arr;
    }

    public function fetch_customer_ledger($date1,$date2,$cus_id = '')
    {
        $this->db->select('mp_invoices.id,mp_invoices.discount,mp_invoices.cus_id,mp_invoices.total_bill,mp_invoices.bill_paid,mp_invoices.date,mp_payee.customer_name,mp_payee.cus_contact_1,mp_payee.cus_email');
        $this->db->from('mp_invoices');
        $this->db->join('mp_payee', "mp_payee.id = mp_invoices.cus_id");
        $this->db->where('mp_invoices.cus_id',$cus_id);
        $this->db->where('mp_invoices.date >=', $date1);
        $this->db->where('mp_invoices.date <=', $date2);
        $this->db->order_by('mp_invoices.id','DESC');
        
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

    public function fetch_customer_ledger_return($date1,$date2,$cus_id = '')
    {

    
        $this->db->select('mp_invoices.id,mp_invoices.discount,mp_invoices.cus_id,mp_invoices.total_bill,mp_invoices.bill_paid,mp_invoices.date,mp_customer.customer_name,mp_customer.cus_contact_1,mp_customer.cus_email');
        $this->db->from('mp_invoices');
        $this->db->join('mp_customer', "mp_customer.id = mp_invoices.cus_id");
        $this->db->where('mp_invoices.date >=', $date1);
        $this->db->where('mp_invoices.date <=', $date2);
        $this->db->where('mp_invoices.cus_id',$cus_id);
        $this->db->order_by('mp_invoices.id','DESC');
        
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

    public function fetch_supplier_ledger($date1,$date2,$cus_id = '',$status)
    {
        $this->db->select('mp_purchase.id,mp_purchase.total_amount,mp_purchase.cash,mp_purchase.payment_type_id,mp_purchase.description,mp_purchase.payment_date,mp_payee.customer_name,mp_payee.cus_email,mp_payee.cus_contact_1');
        $this->db->from('mp_purchase');
        $this->db->join('mp_payee', "mp_purchase.supplier_id = mp_payee.id");
        $this->db->where('mp_purchase.status',$status);
        $this->db->where('mp_purchase.supplier_id',$cus_id);
        $this->db->where('mp_purchase.payment_date >=', $date1);
        $this->db->where('mp_purchase.payment_date <=', $date2);
        $this->db->order_by('mp_purchase.id','DESC');
        
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

    public function supplier_payment_modes($date1,$date2,$supplier_id = '',$mode)
    {
        $this->db->select('*');
        $this->db->from('mp_supplier_payments');
        $this->db->where('mp_supplier_payments.mode',$mode);
        $this->db->where('mp_supplier_payments.supplier_id',$supplier_id);
        $this->db->where('mp_supplier_payments.date >=', $date1);
        $this->db->where('mp_supplier_payments.date <=', $date2);
        $this->db->order_by('mp_supplier_payments.id','DESC');
        
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

    //USED TO FIND THE CHEQUES 
    function written_cheques($date1,$date2)
    {
        $this->db->select('mp_generalentry.id as main_trans_id,mp_generalentry.date,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.ref_no,mp_bank_transaction.transaction_status,mp_bank_transaction.total_paid,mp_head.name as headname');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = 0 ");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_bank_transaction_payee',"mp_bank_transaction_payee.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_banks',"mp_banks.id = mp_bank_transaction.bank_id");
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->group_by('mp_generalentry.id');
        $this->db->join('mp_payee',"mp_payee.id = mp_bank_transaction_payee.payee_id");
        $this->db->where('mp_bank_transaction.transaction_type','paid');
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
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

    //USED TO FIND THE DEPOSITS 
    function bank_deposits($date1,$date2)
    {
    
        $this->db->select('mp_generalentry.date,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.total_paid,mp_bank_transaction.transaction_id,mp_bank_transaction.ref_no,mp_bank_transaction.transaction_status,mp_head.name as headname');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = 1 ");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead");
        $this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
        $this->db->where('mp_bank_transaction.transaction_type','recieved');
        $this->db->group_by('mp_generalentry.id');
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
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

    //USED TO FIND THE DEPOSITS 
    function bank_book($date1,$date2,$source,$bank_id)
    {
    
        $this->db->select('mp_generalentry.date,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.method,mp_bank_transaction.ref_no');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = 1 ");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
         $this->db->join('mp_bank_transaction_payee', "mp_bank_transaction_payee.transaction_id = mp_generalentry.id");
        $this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction_payee.payee_id");
       
        $this->db->where('mp_generalentry.generated_source',$source);
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
         $this->db->where('mp_bank_transaction.transaction_status',0);
         $this->db->where('mp_bank_transaction.bank_id',$bank_id);
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

    //USED TO COUNT THE OUT OF STOCK ITEMS 
    function out_of_stock()
    {
        $count = 0;
        $this->db->select('mp_productslist.min_stock,mp_productslist.quantity');
        $this->db->from('mp_productslist');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result =  $query->result();
            if($result != NULL)
            {
                foreach ($result as $single_item) 
                {
                   if($single_item->min_stock > $single_item->quantity )
                   {
                        $count++;
                   }
                }
            }
        }

        return $count;
    }

    //USED TO COUNT AMOUNT OF RETURN 
    function amount_return()
    {
        $date1 = date('Y-m').'-1';
        $date2 = date('Y-m').'-31';

        $amount = 0; 

        $this->db->select('mp_return.total_bill,mp_return.discount_given');
        $this->db->from('mp_return');
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result =  $query->result();
            if($result != NULL)
            {
                foreach ($result as $single_item) 
                {
                    $amount = $amount  + ($single_item->total_bill-$single_item->discount_given);
                }
            }
        }

        return $amount;
    }    

    //USED TO COUNT AMOUNT OF EXPENSE 
    function expense_amount()
    {
        $date1 = date('Y-m-').'1';
        $date2 = date('Y-m-').'31';
        $amount = 0; 

        $this->db->select('mp_expense.total_bill');
        $this->db->from('mp_expense');
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result =  $query->result();
            if($result != NULL)
            {
                foreach ($result as $single_item) 
                {
                    $amount = $amount  + $single_item->total_bill;
                }
            }
        }
        return $amount;
    }

    //USED TO COUNT AMOUNT OF PURCHASE 
    function purchase_amount()
    {
        $date1 = date('Y-m-').'1';
        $date2 = date('Y-m-').'31';
        $amount = 0; 

        $this->db->select('mp_purchase.total_bill');
        $this->db->from('mp_purchase');
        $this->db->where('mp_purchase.status',0);
        $this->db->where('date >=', $date1);
        $this->db->where('date <=', $date2);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            $result =  $query->result();
            if($result != NULL)
            {
                foreach ($result as $single_item) 
                {
                    $amount = $amount  + $single_item->total_bill;
                }
            }
        }
        return $amount;
    }


    //RETURN ITEMS LIST 
    function return_items_date($first_date, $second_date)
    {

         $this->db->select('mp_return.*,mp_payee.customer_name');
        $this->db->from('mp_return');
        $this->db->join('mp_payee', "mp_return.cus_id = mp_payee.id");
        $this->db->where('mp_return.date >=', $first_date);
        $this->db->where('mp_return.date <=', $second_date);
        $this->db->order_by('mp_return.id', 'DESC');
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


    //RETURN SINGLE INVOICE 
    function fetch_single_return_item($return_id)
    {

         $this->db->select('mp_return_list.*,mp_payee.customer_name,mp_return.id as return_trans_id,mp_return.date,mp_return.cus_id,mp_return.invoice_id,mp_return.total_paid,mp_return.total_bill,mp_return.agent,mp_return.discount_given, mp_productslist.unit_type');
        $this->db->from('mp_return');
        $this->db->join('mp_return_list',"mp_return.id = mp_return_list.return_id");
        $this->db->join('mp_payee',"mp_payee.id = mp_return.cus_id");
        $this->db->join('mp_productslist',"mp_productslist.id = mp_return_list.product_id");
         $this->db->where('mp_return.id',$return_id);
        $this->db->order_by('mp_return.id','DESC');
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


     //GET SINGLE INVOICE 
    function fetch_single_invoice_items($invoice_id)
    {

         $this->db->select('mp_invoices.*,mp_payee.customer_name,mp_sales.id as sales_trans_id,mp_sales.product_no,mp_sales.product_name,mp_sales.mg,mp_sales.price,mp_sales.qty,mp_sales.tax');
        $this->db->from('mp_invoices');
        $this->db->join('mp_sales',"mp_invoices.id = mp_sales.order_id");
        $this->db->join('mp_payee',"mp_payee.id = mp_invoices.cus_id");
         $this->db->where('mp_invoices.id',$invoice_id);
        $this->db->order_by('mp_invoices.id','DESC');
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


     //USED TO FIND THE CHEQUES USING PAYEE ID
    function payee_written_cheques($payee_id,$date1,$date2)
    {
        $this->db->select('mp_generalentry.date,mp_banks.bankname,mp_payee.customer_name,mp_sub_entry.amount,mp_bank_transaction.id as bank_trans_id,mp_bank_transaction.ref_no,mp_bank_transaction.total_paid,mp_bank_transaction.transaction_status,mp_bank_transaction.transaction_type,mp_head.name as headname');
        $this->db->from('mp_generalentry');
        $this->db->join('mp_sub_entry', "mp_generalentry.id = mp_sub_entry.parent_id AND mp_sub_entry.type = 0");
        $this->db->join('mp_bank_transaction', "mp_bank_transaction.transaction_id = mp_generalentry.id"); 
        $this->db->join('mp_banks', "mp_banks.id = mp_bank_transaction.bank_id");
        $this->db->join('mp_head', "mp_head.id = mp_sub_entry.accounthead ");
        $this->db->join('mp_payee', "mp_payee.id = mp_bank_transaction.payee_id");
        $this->db->where('mp_payee.id',$payee_id);
        $this->db->where('mp_generalentry.date >=', $date1);
        $this->db->where('mp_generalentry.date <=', $date2);
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
  
}