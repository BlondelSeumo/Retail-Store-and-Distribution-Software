<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( !function_exists('fetch_single_qty_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN STOCK
	function fetch_single_qty_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_sales');
		$CI->db->where(['mp_sales.product_id'=> $item_id]);

		$query = $CI->db->get();
		$result = NULL;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if ( !function_exists('fetch_single_pending_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN PENDING STOCK
	function fetch_single_pending_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_stock');
		$CI->db->where(['mp_stock.mid'=> $item_id]);

		$query = $CI->db->get();
		$result = 0;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if ( !function_exists('fetch_single_return_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function fetch_single_return_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_return_list');
		$CI->db->where(['mp_return_list.product_id'=> $item_id]);
		$query = $CI->db->get();
		$result = 0;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if (!function_exists('color_options'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function color_options()
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$color_arr = $CI->db->get_where('mp_langingpage', array('id' =>1))->result_array()[0];
		return  array('primary' =>$color_arr['primarycolor'],'hover' =>$color_arr['theme_pri_hover']);
	}
}


if (!function_exists('balance_identifier'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function balance_identifier($source,$current_balance,$total_bill,$total_paid)
	{
		$balance = 0;
		
		switch($source)
		{	

			case  'Opening_balance':
			{
				$balance = $current_balance + $total_bill;
				$balance = $balance - $total_paid;
				break;
			}

			case  'bank_collection':
			{
				$balance = $current_balance - $total_paid;
				break;
			}

			case  'debit_voucher':
			{
				$balance = $current_balance + $total_paid;	
				break;
			}
			case  'expense':
			{
			
				$balance = $current_balance - ($total_bill - $total_paid);
				break;
			}
			case  'create_purchases':
			{

				$balance = $current_balance - ($total_bill - $total_paid);
				break;

			}
			case  'cheque':
			{

				$balance = $current_balance + $total_paid;
				break;
			}
			case  'refund_receipt':
			{
				
				$balance = $current_balance - $total_paid;
				break;
			}
			case  'credit_note':
			{

				$balance = $current_balance -  $total_paid;
				break;
			}
			case  'deposit':
			{
				$balance = $current_balance -  $total_paid;
				break;
			}
			case  'sales_receipt':
			{

				$balance = $current_balance +  ($total_bill - $total_paid);
				break;
			}	
			case  'purchases_return':
			{

				$balance = $current_balance + ($total_bill - $total_paid);
				break;
			}	

			case  'credit_voucher':
			{

				$balance = $current_balance -  $total_paid;
				break;
			}	

			case  'purchase_return':
			{
				$balance = $current_balance +  $total_paid;
				break;
			}
			
			case  'pos':
			{

				$balance = $current_balance +  ($total_bill - $total_paid);
				break;
			}
			case  'return_pos':
			{

				$balance = $current_balance -  ($total_bill - $total_paid);
				break;
			}

			default :
			{

			}
		}

		return $balance;
	}
}


if (!function_exists('source_identifier'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function source_identifier($source)
	{
		if($source == 'debit_voucher' OR $source == 'expense' OR $source == 'purchase_receipt' OR $source == 'cheque' OR $source == 'create_purchases' OR $source == 'return_pos')
		{
			$data = 'yes';
		}
		else
		{
			$data = 'no';
		}	

		return $data;
	}
}


if (!function_exists('get_phrase'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function get_phrase($phrase)
	{
		return str_replace('_',' ',$phrase);
	}
}



// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */