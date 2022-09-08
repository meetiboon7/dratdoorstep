<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holiday_model extends CI_Model
{
    function list_holiday()
    {
        $this->db->select('holidays.*,city.city as city_name');
        $this->db->from('holidays');
        $this->db->join('city','city.city_id = holidays.city_id');
        
        $this->db->order_by('holidays.hid', 'DESC');
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
    function list_city()
    {
        $this->db->select('city.*');
        $this->db->from('city');
       
        
        $this->db->order_by('city.city', 'asc');
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
     function add_holiday($holiday_array)
    {
        $this->db->insert('holidays',$holiday_array);
        return $this->db->insert_id();
    }
    function view_single_holiday($holiday_id="")
    {
        $this->db->select('*');
        $this->db->from('holidays');
        $this->db->where('hid', $holiday_id);
        $query = $this->db->get();
        
        if($query -> num_rows() > 0)
        {
            $result = $query->result();
            //print_r($result);
            return $result[0]; 
        }
        else
        {
            return false;
        }
    }
    function update_holiday_info($updateHoliday_array,$update_holiday_id="")
    {
        $this->db->where('hid', $update_holiday_id);
        $this->db->update('holidays',$updateHoliday_array);
    }
    function delete_holiday_info($delete_holiday_id="")
    {

        $this->db->where('hid',$delete_holiday_id);
        $this->db->delete('holidays');
    }
    
}
?>