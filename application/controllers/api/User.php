<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller {

    public $userData =array();
    public $success;
    public $responceData;
    public $message;
    public $postdata;
    public $post;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['profile_post']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['login_post']['limit'] = 100; // 100 requests per hour per user/key
        //$this->methods['signup_post']['limit'] = 100; // 50 requests per hour per user/key
        //$this->methods['usersList_get']['limit'] = 500; // 50 requests per hour per user/key
        //$this->post=$_REQUEST;
        $this->load->model('user_model');
       
       
    }


    public function login_post()
	{
        
       // $this->postdata = file_get_contents("php://input");
        //$this->request = json_decode($this->postdata);
        //$username = $this->input->post('username');
        //$password = $this->input->post('password');
       // $postdata = file_get_contents("php://input");
        //print_r($postdata);
        //$temp ='{ "username":bhushanjire,"password":12345}';
        //$json = '{"Peter":65,"Harry":80,"John":78,"Clark":90}';
       // var_dump(json_decode($temp, true));

     // echo  $this->request->username;

//exit;
       $username = $this->post('username') ?? null;
        $password = $this->post('password') ?? null;

        if(!empty($username)&&!empty($password)){
            $data = $this->user_model->checkLogin($username, $password);
            if(!(empty($data))){
                $this->success = true;
                $this->responceData=$data;
                $this->message = 'Login successfully';
            }else{
                $this->success = false;
                $this->responceData='';
                $this->message = 'Invalid username/password';
            }
            
        }else{
            $this->success = false;
            $this->responceData='';
            $this->message = 'Invalid data';
        }

        $this->userData['success']=$this->success;
        $this->userData['data']=$this->responceData;
        $this->userData['message']=$this->message;

        $this->response($this->userData, REST_Controller::HTTP_OK);
    }

    public function signup_post()
    {
        $data = $this->post(); 

        if(!empty($data)){
            $email = $this->post('email');
            $checkEmail =   $this->user_model->checkEmail($email);
            if(!$checkEmail){
                $data =  $this->user_model->Msignup($data);
        if($data){
            $this->success = true;
            $this->responceData=$data;
            $this->message = 'Signup successfully';
        }else{
            $this->success = false;
            $this->responceData='';
            $this->message = 'Error';
        }

    }else{
        $this->success = false;
        $this->responceData='';
        $this->message = 'Email-ID already exists';
               
    }
    }else{
        $this->success = false;
        $this->responceData='';
        $this->message = 'Invalid data';
    }

        $this->userData['success']=$this->success;
        $this->userData['data']=$this->responceData;
        $this->userData['message']=$this->message;
        $this->response($this->userData, REST_Controller::HTTP_OK);
    } 


    public function profile_post(){
        $user_id = $this->post('user_id') ?? 0;
      /*  $image = base64_decode($this->post("profile_photo"));
        $image_name = $this->post('name').$user_id;
        $filename = $image_name . '.' . 'png';
        //rename file name with random number
        $path = "assets/images/".$filename;
        
        //image uploading folder path
        file_put_contents($path . $filename, $image);
        // image is bind and upload to respective folde
*/




$config['upload_path']          = 'assets/images/';
$config['allowed_types']        = 'gif|jpg|png';
//$config['max_size']             = 100;
//$config['max_width']            = 1024;
//$config['max_height']           = 768;
//$config['file_ext']           = $fileData['file_ext'];    




$file_name=$this->post('name').$user_id;
$config['file_name']=$file_name;
$this->load->library('upload', $config);
if ( ! $this->upload->do_upload('profile_photo'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                }
                else
                {
                        $data1 = array('upload_data' => $this->upload->data());
                        $file_ext = $data1['upload_data']['file_ext'];
                        $data['profile_photo'] = base_url()."assets/images/".$file_name.$file_ext;
                      
                       
                }

if($this->post('user_id')>0){

$data['name'] = $this->post('name');
$data['birth_date'] = $this->post('birth_date');
$data['gender'] = $this->post('gender');
$data['theme_color_code']= $this->post('theme_color_code');

//print_r($data);
$this->user_model->Mprofile($data,$user_id);

$this->success = true;
$this->responceData='';
$this->message = 'Profile updated successfully';

    }else{
        $this->success = false;
$this->responceData='';
$this->message = 'Error';
    }

    $this->userData['success']=$this->success;
    $this->userData['data']=$this->responceData;
    $this->userData['message']=$this->message;
    $this->response($this->userData, REST_Controller::HTTP_OK);

}

}





