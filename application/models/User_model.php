<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function checkLogin($username,$password){
        $this->db->select('user_id,name,birth_date,theme_color_code,quick_block_id,profile_photo,token');
        $data = $this->db->get_where("users", ['username' => $username,'password'=>md5($password)])->row_array();
        return $data;
    }

    public function checkEmail($email){
        $this->db->select('user_id');
        $checkEmail = $this->db->get_where("users", ['email' => $email])->row_array();
        return $checkEmail;
    }

    public function Msignup($data){
        $this->db->select_max('user_id');
        $res1 = $this->db->get('users');
        if ($res1->num_rows() > 0)
        {
            $res2 = $res1->result_array();
            $last_id = MD5($res2[0]['user_id']);
            $data['token']=$last_id;
        }

        if($this->db->insert('users',$data)){
            $insert_id = $this->db->insert_id(); //last inserted id
            $this->db->select('user_id,name,birth_date,theme_color_code,quick_block_id,profile_photo,token');
           return $this->db->get_where("users", ['user_id' => $insert_id])->row_array();
        }
    }

    public function Mprofile($data,$user_id){
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }
}

?>