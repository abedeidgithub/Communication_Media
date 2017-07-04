<?php

//include Class 
require '../DB.php';
$db=DB::getInstance();
$id="";
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['verify']) && !empty($_GET['verify'])){
    $arr= $db->table('users' )->where('email','=', $_GET['email'])->where('verify','=',$_GET['verify'])->get()->toArray();
    foreach ($arr as $key => $value) {
        $id= $value['id'] ;
    }
    $_POST= ['verify'=>'true'];
    if($db->update('users', $_POST  )->where('id','=',$id)->exec()){
        echo "Done !!";
        echo "<script>window.close();</script>";
    }else{
        echo "Something went Error ";
    }

}else{
    // Invalid approach
    echo "Error  IN the URL ";
}
