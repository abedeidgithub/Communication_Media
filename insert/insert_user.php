<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/16/2017
 * Time: 3:08 PM
 */
require '../DB.php';
$db = DB::getInstance();
//input
$data = json_decode(file_get_contents("php://input"));

$response = array();
$in_put = array();

if (isset($data->{"email"}) && isset($data->{"password"}) && isset($data->{'name'}) && isset($data->{'dept_name'}) && isset($data->{'year_name'}) && isset($data->{'section_name'})) {
    if (($db->table('users')->where('email', $data->{"email"})->get()->toArray())) {
        $success = false;
        $message = "error email address is already founded  ";
    } else {
        $email = $data->{"email"};
        $password = $data->{"password"};
        $name = $data->{'name'};
        $dept_name = $data->{'dept_name'};
        $year_name = $data->{'year_name'};
        $section_name = $data->{'section_name'};
        $verify = md5(rand(0, 1000));

        $in_put = null;

        $in_put['name'] = $name;
        $in_put['image'] = 'default.png';
        $in_put['email'] = $email;
        $in_put['password'] = $password;
        $in_put['verify'] = $verify;
        $in_put['depart_id'] = $db->table("depart")->select("id")->where("dept_name","=",$dept_name)->get()->toArray()["0"]["id"];

        $id_user = $db->insert('users', $in_put);
        if ($id_user) {

            $in_put = null;
            $in_put['year_id'] =  $db->table("year")->select("id")->where("year_name","=",$year_name)->get()->toArray()["0"]["id"];
            $in_put['section_idsection'] = $db->table("section")->select("id")->where("section_name","=",$section_name)->get()->toArray()["0"]["id"];
            $in_put['person_id_person'] = $id_user;

            $id_student = $db->insert('student', $in_put);
            if ($id_student) {

                $subject = 'Verify account ';
                $headers = "From: g.project.final@gmail.com \r\n";
                $headers .= "CC: " . $email . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $message = '<div  background-color: #ffffff  ;">';
                $message .= '<center>';
                $message .= '<div style="background-color: #ff9f00 ;border-radius:5px">';
                $message .= '<center>';
                $message .= '<h1> <p style="color: white; font-size: x-large ;">Welecome To FCI_SUEZ Community</p></h1>';
                $message .= '</center>';
                $message .= '</div>';
                $message .= '</center>';

                $message .= '    <div style="text-align: left;">';
                $message .= '<br>';

                $message .= 'You have acount  free';
                $message .= '<strong> FCI-SUEZ CANAL UNIVERSITY</strong><br><br>';
                $message .= 'Welcome : <strong> ' . $email . '</strong>';

                $message .= '<br>  Please Verify Your Account';
                $message .= '</div>';

                $message .= '<br><br><br>';
                $message .= '<table style="border: 1px solid black;">';
                $message .= '<tr style="border: 1px solid black;">';
                $message .= '<td style="border: 1px solid black;" >UserName </td>';
                $message .= '<td style="border: 1px solid black;">' . $name . ' </td>';
                $message .= '</tr>';

                $message .= '<tr style="border: 1px solid black;">';
                $message .= '<td  style="border: 1px solid black;">password </td>';
                $message .= '<td style="border: 1px solid black;">' . $password . ' </td>';
                $message .= '</tr>';
                $message .= '</table>';
                $message .= '<br><br><div >';
                $url = "http://eventfacebook.esy.es/API/verify/verify.php?email=" . $email . "&verify=" . $verify;

                $message .= '   <a style=" float:left;color: #ffffff;font-size: large;text-align: center;border: solid #348eda ; background-color: #348eda ;width: 186px ; height: 43px ; border-radius:5px" href="' . $url . '">Upgrade  account</a>';
                $message .= '</div>';
                $message .= '<br>';
                $message .= '<br>';
                $message .= '<br>';
                $message .= '<div style="text-align: left;">Thanks in advance</div>';
                $message .= '</div>';


                mail($email, $subject, $message, $headers);

                $success = true;
                $message = "Your account has been created, go to your email , you can Verify email ";
            } else {
                $success = false;
                $message = "server error insert try again ...";

            }
        } else {
            $success = false;
            $message = "server error insert try again ..";
        }

    }
} else {
    $success = false;
    $message = "Required Field Missing";
}

$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);