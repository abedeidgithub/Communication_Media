<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/27/2017
 * Time: 11:37 AM
 */

require '../DB.php';
$db = DB::getInstance();
$data = json_decode(file_get_contents("php://input"));
$term=2;


    if (isset($data->{'year_id'}) && isset($data->{'section_id'}) && isset($data->{'depart_id'}) && isset($data->{'day_id'})) {
        $sql = "SELECT
scheduale.id,
scheduale.from_time,
scheduale.to_time ,
`day`.`name` as `day_name`,
place.`name` as `place`,
`subject`.image as `subject_image`,
`subject`.`name` as`subject_name` ,
users.name as`Doctor name `
FROM
scheduale ,
`day`,
place,
`subject`,
users
WHERE
users.id=scheduale.doctor_id AND
scheduale.day_id={$data->{'day_id'}}
and
scheduale.subject_id=`subject`.id
AND
scheduale.day_id=`day`.id
and 
scheduale.place_id=place.id
and 
scheduale.year_id={$data->{'year_id'}}
and 
scheduale.section_id={$data->{'section_id'}}
and 
scheduale.depart_id={$data->{'depart_id'}}
and scheduale.term_id={$term}

ORDER BY
 scheduale.from_time ASC;";
        echo $db->query($sql);

    }

    else if(isset($data->{'doctor_id'}) && isset($data->{'day_id'})) {

        $sql="SELECT
scheduale.id,
scheduale.doctor_id,
scheduale.from_time,
scheduale.to_time,
`subject`.`name` as `subject_name`,
`subject`.`desc`,
`subject`.image,
`year`.year_name,
place.`name` as`place`,
section.section_name,
depart.dept_name
FROM
	scheduale,
	`subject`,
	`day`,
	section,
	`year`,
	depart,`place`
WHERE
	scheduale.doctor_id = {$data->{'doctor_id'}}
AND scheduale.day_id = {$data->{'day_id'}}
AND scheduale.subject_id = `subject`.id
AND scheduale.day_id = `day`.id
AND scheduale.section_id = section.id
AND scheduale.year_id = `year`.id
AND scheduale.depart_id = depart.id
AND place.id = scheduale.place_id
and scheduale.term_id={$term}
ORDER BY scheduale.from_time ASC";
        echo $db->query($sql);

    }else{
        echo "[]";
    }



