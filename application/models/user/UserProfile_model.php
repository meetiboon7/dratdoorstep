<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserProfile_model extends CI_Model
{
	
	
	
    public function get_user($id)
    {
        $this->db->where('user_id', $id);
        $query = $this->db->get('user');

						
        return $query->row();
    }

    public function update_user($id, $userdata)
    {
        $this->db->where('user_id', $id);
        $this->db->update('user', $userdata);
        //$str = $this->db->last_query($query);
   
   
    }
   
 
}