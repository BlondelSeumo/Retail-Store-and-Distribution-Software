<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('Authenticate_Url'))
{
	function Authenticate_Url($user_id,$curr_Controller) 
	{
        
		if($curr_Controller != 'profile' && $curr_Controller != 'homepage'  && $curr_Controller != 'prints' && $curr_Controller != 'invoice_print' )
		{
			 $user_id = $user_id; 
			$CI	=&	get_instance();
			$CI->load->database();
			$CI->db->select("mp_menulist.id");
			$CI->db->from('mp_menulist');
			$CI->db->join('mp_multipleroles', "mp_menulist.menu_id = mp_multipleroles.menu_Id and mp_menulist.link = '$curr_Controller' and mp_multipleroles.user_id = '$user_id' ");
			$query = $CI->db->get();
			if($query->num_rows()>0)
			{
				return $query->result(); 
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return "profile";
		}
	}
}

if ( !function_exists('export_csv'))
{
     function export_csv($file_name,$args_fileheader,$args_table_attr,$table_name)
    {
        $newfilename = "CSV_".$file_name.date("YmdH_i_s").'.csv';
        header('Content-type:text/csv');
        header('Content-Disposition:attachment; filename='.$newfilename);
        header('Cache-Control:no-store,no-cache,must-revalidate');
        header('Cache-Control:post-check=0,pre-check=0');
        header('Pragma:no-cache');
        header('Expires:0');
        header('Content-type:text/csv');
         $handle = fopen("php://output", "w");
         fputcsv($handle,$args_fileheader);
         $CI =& get_instance();
         $CI->load->database();
         $CI->db->select($args_table_attr);
         $CI->db->from($table_name);
         $query = $CI->db->get();
         $data['tasks'] = $query->result_array();
         foreach ($data['tasks'] as $key => $row) 
         {
             fputcsv($handle,$row);
         }
         fclose($handle);
         exit;
    } 
}  
// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Authenticate_Url_helper.php */