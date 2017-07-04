 <?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/22/2017
 * Time: 5:26 PM
 */

// secty yaer depar

require '../DB.php';
$db = DB::getInstance();
$data = json_decode(file_get_contents("php://input"));
if (isset($data->{'Page'})) {
    $page = $data->{'Page'};
      $limit = 20;
    $offset = ($page - 1) * $limit;


    if (isset($data->{'year_id'}) && isset($data->{'section_id'}) && isset($data->{'depart_id'}) )
    {
           $section_id = $data->{'section_id'};
        $depart_id = $data->{'depart_id'};
        $year_id = $data->{'year_id'};
        $sql="SELECT
post.type,
	post.id AS `id_post`,
	post.text,
  IFNULL(post.image,\" \")   AS `post_image`,
  post.createdat,
	post.updatedat,
 	post.section_id,
	post.depart_id,
	post.year_id,
	users.`name`,
	users.image AS `user_image`,
	users.id AS `user_id`,
    users.isAdmin ,
(select COUNT(comments.post_id) from comments where comments.post_id=post.id)as `comments`
FROM
	post,
	users
WHERE
	 post.users_id = users.id  
 and 
post.type=0
   and 
     post.section_id = {$section_id}  
   and 
     post.year_id = {$year_id}   
   and 
     post.depart_id={$depart_id}  
 ORDER BY
	post.updatedat DESC
LIMIT   {$limit} OFFSET {$offset}	";
        echo $db->query($sql);
    } else  {

            echo $db->query("SELECT
post.type ,

	post.id AS `id_post`,
	post.text,
  IFNULL(post.image,\" \")   AS `post_image`,
  post.createdat,
	post.updatedat,
	post.section_id,
	post.depart_id,
	post.year_id,
	users.`name`,
	users.image AS `user_image`,
	users.id AS `user_id`,
users.isAdmin ,
(select COUNT(comments.post_id) from comments where comments.post_id=post.id)as `comments`
FROM
	post,
	users
WHERE
	post.users_id = users.id
 
and 
 ISNULL(post.section_id)
and 
ISNULL(post.year_id  )
and 
post.type=0
 ORDER BY
	post.updatedat DESC
   
 
LIMIT   {$limit} OFFSET {$offset}");


    }


} else {
    echo "[]";
}
