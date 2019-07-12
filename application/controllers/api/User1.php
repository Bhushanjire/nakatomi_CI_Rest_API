<?php
class User1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        //$this->output->set_content_type('Content-Type: application/json; charset=utf-8');
        header('Content-Type: application/json');
        $this->postdata = file_get_contents("php://input");
        $this->load->model('user_model');
    }
    public function login()
    {
        error_reporting(E_ALL);
        /*  $responce =array();
        if(!empty($this->postdata)){
        $this->request = json_decode($this->postdata);
        $username = $this->request->username;
        $password = $this->request->password; 
        }else{
        $username = $_POST['username'];
        $password = $_POST['password'];
        }
        
        if(!empty($username)&&!empty($password)){
        $data['userData'] = $this->user_model->checkLogin($username, $password);
        
        foreach($data['userData'] as $row){
        array_push($responce,$row);
        }
        if(!(empty($data))){
        $response=array('success' => true,'data' => $responce,'message'=>'Login successfully');
        }else{
        $response=array('success' => false,'data' =>'','message'=>'Invalid username/password');
        }
        }else{
        $response=array('success' => false,'data' =>'','message'=>'Invalid data');
        }
        */
        echo json_encode(array(
            'user_id' => 1,
            'user_name' => 'bhushan jire'
        ));
        exit;
    }
    public function test()
    {
        echo json_encode(array(
            'user_id' => 1,
            'user_name' => 'bhushan jire'
        ));
        exit;
    }
}