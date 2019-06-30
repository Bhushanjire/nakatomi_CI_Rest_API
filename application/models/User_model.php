<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function checkLogin($username,$password){
        $this->db->select('user_id,name,birth_date,theme_color_code,quick_block_id,profile_photo');
        $data = $this->db->get_where("users", ['username' => $username,'password'=>md5($password)])->row_array();
        return $data;
    }

    public function checkEmail($email){
        $this->db->select('user_id');
        $checkEmail = $this->db->get_where("users", ['email' => $email])->row_array();
        return $checkEmail;
    }

    public function Msignup($data){
        return $this->db->insert('users',$data);
    }

    public function Mprofile($data,$user_id){
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }
}

?>