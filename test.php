<?php
    //echo phpinfo();
    $conn=mysqli_connect('localhost','root','','nakatomi');
   
    $res =mysqli_query($conn,"select * from users");
$responce = array();
$res1=array();
    while($data = mysqli_fetch_assoc($res)){
        $temp['user_id']=$data['user_id'];
        $temp['name']=$data['name'];
        array_push($responce, $temp);
    }

    $res1 =array('succes'=>true,'data'=>$responce,'message'=>'Data send');

    echo json_encode($res1);
?>

