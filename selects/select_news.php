<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/27/2017
 * Time: 10:30 AM
 *
 *
 * {
 * "Page":1
 * }
 */
require '../DB.php';
$db = DB::getInstance();

$data = json_decode(file_get_contents("php://input"));
if (isset($data->{'Page'})) {
    $page = $data->{'Page'};
    $responce = $db->table('news')->orderBy('updated_at', 'DESC')->paginate($page, 20);
    if ($db->getCount() > 0) {
        echo $responce;
    } else {
        echo "[]";
    }
} else {


    echo "[]";
}