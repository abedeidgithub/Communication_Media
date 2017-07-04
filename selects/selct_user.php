<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/16/2017
 * Time: 11:51 AM
 *
 *  json file
 *   {
 * "email":"ghada@gmail.com",
 * "password":"ghada"
 * }
 */

require '../DB.php';
$db = DB::getInstance();
$data = json_decode(file_get_contents("php://input"));
$response = array();
 

if (isset($data->{'email'}) && isset($data->{'password'})) {    // check email  && password   to login

    $email = $data->{'email'};  // get email
    $password = $data->{'password'}; // get password
    $userINFO = $db->table('users')->where('email', '=', $email)->where('password', '=', $password)->get()->toArray();

    if ($userINFO) { // check data
        if ($userINFO[0]['verify'] == 'true') {  // check verify email
            $id_person = $userINFO[0]['id'];
            if ($userINFO[0]['isAdmin'] != 0) {  // is doctor

                $sql="SELECT
doctor.id AS `doctor_id`,
doctor.person_id_person,
doctor.site,
doctor.about_doctor,
depart.id AS `depart_id`,
depart.dept_name,
users.id as `users_id`,
users.`name`,
users.image,
users.isAdmin,
users.email,
users.`password`,
users.verify
FROM
doctor ,
depart ,users
where users.depart_id = depart.id AND doctor.person_id_person = users.id
and person_id_person = ".$id_person;
                $response=$db->query($sql)->toArray();

            } else if ($userINFO[0]['isAdmin'] == 0) { // is student
                 $sql="SELECT
student.id as `idstudent`,
student.year_id,
student.section_idsection,
student.person_id_person,
depart.id AS depart_id,
depart.dept_name,
`year`.id AS year_id,
`year`.year_name,
section.id AS section_id,
section.section_name,
users.id as `users_id`,
users.`name`,
users.image,
users.isAdmin,
users.email,
users.`password`,
users.verify
FROM
users
INNER JOIN student ON student.person_id_person = users.id
INNER JOIN depart ON users.depart_id = depart.id
INNER JOIN `year` ON student.year_id = `year`.id
INNER JOIN section ON student.section_idsection = section.id
Where student.person_id_person=".$id_person;
                $response = $db->query($sql)->toArray();

            }
            $status = "true";
            $message = "found";
            $response[0]['status'] = $status;
            $response[0]['message'] = $message;
            echo json_encode($response);

        } else {
           echo '[{"status":"false" , "message":"vrefiy your account "}]';
        }

    } else {
       echo '[{"status":"false" , "message":"Not match Email or Password"}]';
    }


} else {
   echo '[{"status":"false" , "message":"Require inputs messing !!! "}]';

}