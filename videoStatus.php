<?php
   include("conn.php");
    if(!empty($postdata)){
    $request = json_decode($postdata);
    $user_id = $request->user_id;
    $lesson_id = $request->lesson_id; 
    $video_status = $request->video_status;
    }else{
        $user_id = $_POST['user_id'] ;
        $lesson_id = $_POST['lesson_id']; 
        $video_status = $_POST['video_status'];
    }
   
      // $conn=mysqli_connect('localhost','root','','nakatomi');

       $query5 = "UPDATE user_lessons SET video_status='".$video_status."' 
       WHERE lesson_id='".$lesson_id."' 
       AND user_id='".$user_id."'
       AND last_action='yes'
       AND lesson_status='in' 
       ";
       $res5 = mysqli_query($conn,$query5);
    if($res5){
    $data = mysqli_fetch_assoc($res);
    $res1 =array('success'=>true,'data'=>'','message'=>'Video '.$video_status);
    
}else{
    $res1 =array('succes'=>false,'data'=>'','message'=>'Error');
}

    echo json_encode($res1);
?>

