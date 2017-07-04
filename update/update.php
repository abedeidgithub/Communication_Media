<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 6/22/2017
 * Time: 4:57 AM
 */
require '../DB.php';
$db=DB::getInstance();

$response = array();
$data = json_decode(file_get_contents("php://input"));
$_POST  = array();
if($data->{'users_id'}){


    if(isset($data->{'password'} )){
        $_POST['password']=$data->{'password'};
    }if(isset($data->{'name'} )){
        $_POST['name']=$data->{'name'};
    }
    if(isset($data->{'image'} )){
        $_POST['image']=$data->{'image'};
    }
    if(isset($data->{'email'} )){
        $_POST['email']=$data->{'email'};
    }

    if($db->update('users', $_POST  )->where('id','=',$data->{'users_id'})->exec()){
         $success=true;
        $message="data getted";

    }else{
        $message= "No update ";
        $success=false;
    }


}else{
    $message= "No id to Update ";
    $success=false;
}

$response ["success"] = $success;
$response ["message"] = $message;

echo json_encode($response);
