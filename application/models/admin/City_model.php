<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
    
    function list_city()
    {
        $this->db->select('city.*');
        $this->db->from('city');
      
        
        $this->db->order_by('city.city_id', 'desc');
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
     function add_city($city_array)
    {
        // echo "<pre>";
        // print_r($city_array);
        // exit;
        $this->db->select('city.*');
        $this->db->from('city');
         $this->db->where('city',$city_array['city']);
      //   $rows = $this->db-> get();
        
         $rows = $this->db->get()->result_array();
        if(count($rows) > 0)
        {
            $this->session->set_flashdata('message','City Already Exists.');
              return false;
        }
        else
        {
          
            $this->db->insert('city',$city_array);
            $this->session->set_flashdata('message','City added successfully.');
            return $this->db->insert_id();

        }

        
    }
    function view_single_city($city_id="")
    {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->where('city_id', $city_id);
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
    function update_city_info($updateCity_array,$update_city_id="")
    {
        $this->db->where('city_id', $update_city_id);
        $this->db->update('city',$updateCity_array);
    }
    function delete_city_info($delete_city_id="")
    {

        $this->db->where('city_id',$delete_city_id);
        $this->db->delete('city');
    }
    
}
?>