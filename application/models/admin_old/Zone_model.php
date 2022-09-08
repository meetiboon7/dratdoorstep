<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zone_model extends CI_Model
{
    function list_zone()
    {
        $this->db->select('zone_master.*,city.city as city_name');
        $this->db->from('zone_master');
        $this->db->join('city','city.city_id = zone_master.city_id');
        
        $this->db->order_by('zone_master.zone_id', 'DESC');
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
        $this->db->where('city_status',1);
       
        
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
     function add_zone($zone_array)
    {
        $this->db->insert('zone_master',$zone_array);
        return $this->db->insert_id();
    }
    function view_single_zone($zone_id="")
    {
        $this->db->select('*');
        $this->db->from('zone_master');
        $this->db->where('zone_id', $zone_id);
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
    function update_zone_info($updateZone_array,$update_zone_id="")
    {
        $this->db->where('zone_id', $update_zone_id);
        $this->db->update('zone_master',$updateZone_array);
    }
    function delete_zone_info($delete_zone_id="")
    {

        $this->db->where('zone_id',$delete_zone_id);
        $this->db->delete('zone_master');
    }
    
}
?>