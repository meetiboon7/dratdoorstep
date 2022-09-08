<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CityMapping_model extends CI_Model
{
    function list_CityMapping()
    {
        $this->db->select('manage_city_map.*,city.city as city_name,zone_master.zone_name,employee_master.first_name,employee_master.last_name');
        $this->db->from('manage_city_map');
        $this->db->join('city','city.city_id = manage_city_map.city_id');
         $this->db->join('zone_master','zone_master.zone_id = manage_city_map.zone_id');
         $this->db->join('employee_master','employee_master.emp_id = manage_city_map.emp_id');
        
        $this->db->order_by('manage_city_map.city_map_id', 'DESC');
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
    function list_employee()
    {
        $this->db->select('employee_master.*');
        $this->db->from('employee_master');
         $this->db->where('emp_status',1);
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
     function add_CityMapping($cityMapping_array)
    {
        $this->db->insert('manage_city_map',$cityMapping_array);
        return $this->db->insert_id();
    }
    function view_single_CityMapping($city_map_id="")
    {
        $this->db->select('*');
        $this->db->from('manage_city_map');
        $this->db->where('city_map_id', $city_map_id);
        $query = $this->db->get();
        

        if($query -> num_rows() > 0)
        {
            $result = $query->result();
            return $result[0]; 
        }
        else
        {
            return false;
        }
    }
    function update_CityMapping_info($update_cityMapping_array,$update_city_map_id="")
    {
        $this->db->where('city_map_id', $update_city_map_id);
        $this->db->update('manage_city_map',$update_cityMapping_array);
    }
    function delete_CityMapping_info($delete_city_map_id="")
    {

        $this->db->where('city_map_id',$delete_city_map_id);
        $this->db->delete('manage_city_map');
    }
    //  function view_city_zone($city_id="")
    // {
    //     $this->db->select('*');
    //     $this->db->from('zone_master');
    //     $this->db->where('city_id', $city_id);
    //     $query = $this->db->get();
        

    //     if($query -> num_rows() > 0)
    //     {
    //         $result = $query->result();
    //         return $result[0]; 
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }
    
}
?>