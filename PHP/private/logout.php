<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    $_SESSION['user_id']=null;
    echo header('location:/database_projects/index.php')
?>