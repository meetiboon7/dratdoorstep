<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    
    function list_employee()
    {
        $this->db->select('employee_master.*');
        $this->db->from('employee_master');
        $this->db->order_by('employee_master.emp_id', 'DESC');
        $query = $this->db-> get();



        if($query -> num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }
     
}
?>