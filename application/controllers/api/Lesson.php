<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Lesson extends REST_Controller {

    public $userData =array();
    public $success;
    public $responceData;
    public $message;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //$this->methods['lessonList_get']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['login_post']['limit'] = 100; // 100 requests per hour per user/key
        //$this->methods['signup_post']['limit'] = 100; // 50 requests per hour per user/key
        //$this->methods['usersList_get']['limit'] = 500; // 50 requests per hour per user/key
        //$this->post=$_REQUEST;
        $this->load->model('lesson_model');
    }


    public function lessonList_get()
	{
       $data =  $this->lesson_model->Mlist();
       
if($data){
    $this->success = true;
    $this->responceData=$data;
    $this->message = 'Sesson List With User Count';
        }else{
        $this->success = false;
        $this->responceData='';
        $this->message = 'Record not found';
        }
        $this->userData['success']=$this->success;
        $this->userData['data']= $this->responceData;
        $this->userData['message']=$this->message;
        $this->response($this->userData, REST_Controller::HTTP_OK);
    }

    public function lessonInOut_post()
    {
        $data = $this->post(); 
        if(!empty($data)){
            $lesson_status = $this->post('lesson_status');
           $data =  $this->lesson_model->MlessonInOut($data,$lesson_status);
            $lesson_id= $this->post('lesson_id') ?? 0;
        if($data){            
            $this->success = true;
                //update the user count
                if($lesson_status=='in'){
                    $resData['user_count'] = $this->lesson_model->MupdateUserCount($lesson_status,$lesson_id);
                    $this->message = 'Lesson in successfully';
                }else if($lesson_status=='out'){
                    $resData['user_count'] = $this->lesson_model->MupdateUserCount($lesson_status,$lesson_id);     
                    $this->message = 'Lesson out successfully';
                }
                $this->responceData=$resData;
               
        }else{
            $this->success = false;
            $this->responceData='';
            $this->message = 'Error in query';
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

   

}





