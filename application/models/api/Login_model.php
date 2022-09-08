<?php
class Login_model extends CI_Model{
    public function __construct()
    {
            parent::__construct();

            $this->load->database();
    }

// code for login api

// public function login_api($email,$password){
    
//     $query = $this->db->query("SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'");
//     return $query->result_array();
// }

public function generate_token() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < 40; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
?>