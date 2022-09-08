<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model
{
    function list_managerole()
    {
        $this->db->select('*');
        $this->db->from('manage_roles');
        $this->db->order_by('role_id', 'DESC');
        $query = $this->db-> get();
 // echo $this->db->last_query();
 // exit;
         if($query -> num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }
    
     function add_managerole($manageRole_array)
    {
        $this->db->insert('manage_roles',$manageRole_array);
        return $this->db->insert_id();
    }
    function view_single_managerole($role_id="")
    {
        $this->db->select('*');
        $this->db->from('manage_roles');
        $this->db->where('role_id', $role_id);
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
    function update_managerole_info($updatemanagerole_array,$update_role_id="")
    {
        $this->db->where('role_id', $update_role_id);
        $this->db->update('manage_roles',$updatemanagerole_array);
    }
    function delete_managerole_info($delete_role_id="")
    {

        $this->db->where('role_id',$delete_role_id);
        $this->db->delete('manage_roles');
    }
    
}
?>