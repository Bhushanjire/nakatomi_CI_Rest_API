<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
//require_once APPPATH . '/libraries/JWT.php';

//use \Firebase\JWT\JWT;

class Test_user extends REST_Controller {

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
            $this->db->select('user_id,name,username,birth_date,theme_color_code,quick_blox_id,profile_photo,user_type,token');
            $data = $this->db->get_where("users", ['username' => $username,'password'=>md5($password)])->result_array();
           
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

  


   
}





