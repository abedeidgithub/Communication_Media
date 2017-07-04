<?php
/**
 * Created by PhpStorm.
 * User: Abed Eid
 * Date: 3/14/2017
 * Time: 10:15 AM
 */
require '../DB.php';
$db=DB::getInstance();
echo $db->table('subject')->get();