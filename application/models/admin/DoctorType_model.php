<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DoctorType_model extends CI_Model
{
    
    function list_doctor_type()
    {
        $this->db->select('doctor_type.*');
        $this->db->from('doctor_type');
       
        
        $this->db->order_by('doctor_type.d_type_id', 'desc');
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
     function add_doctor_type($doctor_type_array)
    {
        $this->db->insert('doctor_type',$doctor_type_array);
        return $this->db->insert_id();
    }
    function view_single_doctor_type($doctor_type_id="")
    {
        $this->db->select('*');
        $this->db->from('doctor_type');
        $this->db->where('d_type_id', $doctor_type_id);
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
    function update_doctor_type_info($doctor_type_array,$update_doctor_type_id="")
    {
        $this->db->where('d_type_id', $update_doctor_type_id);
        $this->db->update('doctor_type',$doctor_type_array);
    }
    function delete_doctor_type_info($delete_doctor_type_id="")
    {

        $this->db->where('d_type_id',$delete_doctor_type_id);
        $this->db->delete('doctor_type');
    }
    
}
?>