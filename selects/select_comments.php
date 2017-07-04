<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/27/2017
 * Time: 12:34 AM
 */

/*
 {
"Page":1,
"post_id":1
}
 */
require '../DB.php';
$db = DB::getInstance();
$data = json_decode(file_get_contents("php://input"));


    if (isset($data->{'post_id'})) {
        $Post_id = $data->{'post_id'};
        echo $db->query("SELECT
comments.id,
comments.post_id,
comments.txt,
comments.image,
comments.createdat,
comments.updatedat,
comments.user_id,
users.id,
users.`name`,
users.image as `user_image`,
users.isAdmin
FROM
comments
INNER JOIN users ON comments.user_id = users.id
WHERE
comments.post_id = {$data->{'post_id'}}
ORDER BY
comments.updatedat DESC
;");


} else {
    echo "[]";
}
