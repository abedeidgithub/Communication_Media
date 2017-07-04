<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/27/2017
 * Time: 10:21 PM
 */


require '../DB.php';
$db = DB::getInstance();
$data = json_decode(file_get_contents("php://input"));
$term=2;
if (isset($data->{'year_id'}) && $data->{'year_id'} !="null" && isset($data->{'section_idsection'}) && $data->{'section_idsection'}!="null" && isset($data->{'depart_id'}) && $data->{'depart_id'}!="null") {
    $sql="SELECT
material.createdat,
material.updatedat,
material.`desc`,
material.URL,
`subject`.`name`
from `subject` , scheduale , material
WHERE
`subject`.id=scheduale.subject_id
and 
material.id=`subject`.id
AND
scheduale.year_id={$data->{'year_id'}}
AND
scheduale.section_id={$data->{'section_idsection'}}
AND
scheduale.depart_id={$data->{'depart_id'}}
and scheduale.term_id={$term}
ORDER BY material.updatedat DESC;";
    echo $db->query($sql);


}else if(isset($data->{'doctor_id'})&& ($data->{'doctor_id'} !="null") ){
              $sql=" SELECT
material.createdat,
material.updatedat,
material.`desc`,
material.URL,
`subject`.`name`
from material ,`subject`,subject_doctor
where `subject`.id=material.subject_id
    AND
    subject_doctor.doctor_id={$data->{'doctor_id'}}
    AND
    `subject`.id=subject_doctor.subject_id
ORDER BY material.updatedat DESC;";
    echo $db->query($sql);

}else{
    echo "[]";
}
