<?php
//require APPPATH . 'libraries/REST_Controller.php';

class User1 extends CI_Controller {

    public $userData =array();
    public function login()
	{

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $username = $request->username;
        $password = $request->password;
        if(!empty($username)&&!empty($password)){
                $this->db->select('user_id,name,birth_date');
            $data = $this->db->get_where("users", ['username' => $username,'password'=>md5($password)])->row_array();
            
            if(!(empty($data))){
                $this->userData['success']=true;
                $this->userData['data']=$data;
                $this->userData['message']='Login successfully';
            }else{
                $this->userData['success']=true;
                $this->userData['data']=$data;
                $this->userData['message']='Invalid username/password';
            }
            
        }else{
        $this->userData['success']=false;
        $this->userData['data']='';
        $this->userData['message']='Invalid data';
        }
        echo json_encode($this->userData);
    }

    public function signup()
    {
        $input = $this->input->post();
        $data = $this->db->insert('users',$input);
        if($data){
            $this->userData['success']=true;
                $this->userData['data']=$data;
                $this->userData['message']='Signup successfully';
        }else{
                $this->userData['success']=false;
                $this->userData['data']=$data;
                $this->userData['message']='Error';
        }
        echo json_encode($this->userData);
    } 
}





