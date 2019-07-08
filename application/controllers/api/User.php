<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
//require_once APPPATH . '/libraries/JWT.php';

//use \Firebase\JWT\JWT;

class User extends REST_Controller {

    public $userData =array() ;
    public $success;
    public $responceData =array();
    public $message;
    public $postdata =array();
    public $post;
    public $pushData =array();

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['profile_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['login_post']['limit'] = 100; // 100 requests per hour per user/key
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
            // print_r($data);
            // foreach($data as $tempData){
            //     //$this->postdata['birth_date'] = date('d M Y', strtotime($tempData['birth_date']));
            //     $this->postdata['user_id']=$tempData['user_id'];
            //     $this->postdata['name']=$tempData['name'];
            //     array_push($this->pushData, $this->postdata);
            // }
            
        
            
            /*
            $key = "example_key";
            $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
            );
            $data['id_token'] = $jwt = JWT::encode($token, $key);
            */
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
        
        // $this->userData = [
        //     'success' => $this->success,
        //     'data' => $this->responceData,
        //     'message' => $this->message
        // ];

        // $this->userData['success']=$this->success;
        // $this->userData['data']=$this->responceData;
        // $this->userData['message']=$this->message;

        $this->userData = [
            'success' => $this->success,
            'data' => $this->responceData,
            'message' => $this->message
        ];

        //echo json_encode($this->userData);
       
        $this->response($this->userData, REST_Controller::HTTP_OK);
    }

    public function signup_post()
    {
        $data = $this->post(); 

        if(!empty($data)){
            $email = $this->post('email');
            $username = $this->post('username');
            $password = $this->post('password');
            $birth_date = $this->post('birth_date');
            $checkUsername =   $this->user_model->checkUserName($username);
            $checkEmail =   $this->user_model->checkEmail($email);

            if(!$checkUsername){
                if(!$checkEmail){
                    //$birth_date =  explode(" ",trim($birth_date));
                    //$data['birth_date']=$birth_date[2]."-".$birth_date[1]."-".$birth_date[0];
			if($birth_date!=''){
				    $data['birth_date'] =date('Y-m-d', strtotime($birth_date));
			}
                    $data['profile_photo'] = $this->uploadPhoto($user_id=0);
                    $data['password']=md5($password);
                    $resData =  $this->user_model->Msignup($data);
		$resData['birth_date'] = date('d M Y', strtotime($resData['birth_date']));
            if($resData){
                $this->success = true;
                $this->responceData=$resData;
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
            $this->message = 'Username already exists';
            }

            
    }else{
        $this->success = false;
        $this->responceData='';
        $this->message = 'Invalid data';
    }

        $this->userData['success']=$this->success;
        $this->userData['data']=$this->responceData;
        $this->userData['message']=$this->message;


        // $this->userData = [
        //     'success' => $this->success,
        //     'data' => $this->responceData,
        //     'message' => $this->message
        // ];

        $this->response($this->userData, REST_Controller::HTTP_CREATED);
    } 


    public function profile_post(){
        $user_id = $this->post('user_id') ?? 0;
  


if($this->post('user_id')>0){

// $data['name'] = $this->post('name');
// $data['birth_date'] = $this->post('birth_date');
// $data['gender'] = $this->post('gender');
// $data['theme_color_code']= $this->post('theme_color_code');
$data['quick_blox_id']= $this->post('quick_blox_id');

//$data['profile_photo'] = $this->uploadPhoto($user_id);
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
    $this->response($this->userData, REST_Controller::HTTP_CREATED);

}

public function uploadPhoto($user_id){

    /*
    $config['upload_path']          = 'assets/images/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['encrypt_name'] = TRUE;

    //$config['max_size']             = 100;
    //$config['max_width']            = 1024;
    //$config['max_height']           = 768;
    //$config['file_ext']           = $fileData['file_ext'];    
    
     //$file_name=$this->post('name')."_".$user_id;
    //$config['file_name']=$file_name;
   // print_r($config);
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('profile_photo'))
                    {
                            $error = array('error' => $this->upload->display_errors());
                            return false;
                    }
                    else
                    {
                            $data1 = array('upload_data' => $this->upload->data());
                            //print_r($data1);
                            //$file_ext = $data1['upload_data']['file_ext'];
                            $data['profile_photo'] = base_url()."assets/images/".$data1['upload_data']['file_name'];
                            return $data['profile_photo'];
                          
                           
                    }
}
*/


      $image = base64_decode($this->post("profile_photo"));
      $image_name = md5(uniqid(rand(), true));
        //$filename = $image_name . '.' . 'png';
        $filename = $image_name . '.' . 'png';
        //rename file name with random number
        $path = "assets/images/";
        
        //image uploading folder path
        file_put_contents($path . $filename, $image);
        // image is bind and upload to respective folde
    return base_url()."assets/images/".$filename;

}
}





