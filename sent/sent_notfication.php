<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 6/26/2017
 * Time: 7:01 PM
 */

require '../DB.php';
$db=DB::getInstance();
$message=$_POST['message'];
$title=$_POST['title'];
$path_to_fcm='https://fcm.googleapis.com/fcm/send';
$serverkey="AAAAttNCmuk:APA91bFw8W8WMSfkPZl_njX0HAfMYt4-bzOx6UfqDrs6218SY1x4yconBNfwHhqbag3e3hZl4hjOapalX1ja-SnB4slFBj7q9xhlPrOdotLHSPWVfV4h8izmbyOAB_vZAzOodfne--w0";
$key=$db->table('users')->select('users_token')->get()->toArray()[0];
$headers = array('Authorization: key=AIzaSyCEJKbkGtQV79QtygPTz3Y8KmPbgYAZz14'.$serverkey,'Content-Type: application/json');
$fields=array('to'=>$key,'notification'=>array('title'=>$title,'body'=>$message));
$payload=json_decode($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$path_to_fcm);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$result = curl_exec($ch);
if ($result === FALSE) {
    die('Curl failed: ' . curl_error($ch));
}
curl_close($ch);

