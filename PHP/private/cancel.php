<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/index.php');
    }

    if(isset($_GET['user_id']) && isset($_GET['admin_id'])){
        echo $user_id=$_GET['user_id'];
        $admin_id=$_GET['admin_id'];
        $sql = "DELETE FROM reservation_table where admin_id='$admin_id' and user_id='$user_id'";
        $data = $con->query($sql) or die($con->error);
        echo header('location:./reservation_details.php');
    }


?>