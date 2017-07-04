<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/25/2017
 * Time: 1:53 PM
 */
require '../DB.php';
$db = DB::getInstance();
header('Content-Type: application/json');

$data=json_decode(file_get_contents("php://input"));
        if ((isset($data->{"users_id"})  )) {
             if ($db->insert('post',json_decode(file_get_contents("php://input") ,true))) {

                $success = true;
                $message = "Successfully Uploaded";
            } else {
                $success = false;
                $message = "Error while insertting";

            }
    }else{


            $success = false;
            $message = "Error while inserttingقققققق";
        }



$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);


$url = 'https://fcm.googleapis.com/fcm/send';
$fcmdata =  "{
       \"to\": \"/topics/".$data->{"year_id"}.$data->{"depart_id"}.$data->{"section_id"}."\",
       \"data\": {
       \"message\": \"".$data->{"text"}."\"
   }
}";
//************   rplace this with your api key ***************//
define("GOOGLE_API_KEY", "AAAAowWTcuQ:APA91bH9YvCM1005kaT5SG3eFD35CTIHQavmZltY0JsYTMSbrLwKZxdNPaddfe1iC2elxm74vqXmUiOwd008p613bSFs3Gp-gyZtpwMi90lOBweTuaNHgGuGlPSN0uhTLxZQx02vLorP");
$headers = array(
    'Authorization: key=' . GOOGLE_API_KEY,
    'Content-Type: application/json'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fcmdata);
$result = curl_exec($ch);
if ($result === FALSE) {
    die('Curl failed: ' . curl_error($ch));
}
curl_close($ch);

?>

