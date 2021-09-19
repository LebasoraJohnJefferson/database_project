<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/index.php');
    }
    // only trigger when submit button is click;
    if(isset($_POST['submit'])){
        $user_id=$_SESSION['user_id'];
        $title=$_POST['title'];
        $price=$_POST['price'];
        $max_ticket=$_POST['max_ticket'];
        //setting the path of the storage of the images;
        $img_path=$_SERVER['DOCUMENT_ROOT']."/database_projects/images/";
        $img="/database_projects/images/".$_FILES['img']['name'];
        //check if file is an image;
        if(exif_imagetype($_FILES['img']['tmp_name'])){
            upload_file($img_path,$_FILES['img']['size']);
            //save from database and redirecting to movie_created;
            echo '<div class="err"> SUCCESSFULLY CREATE<br/>Redirecting to your Movie`s Wall</div>';
            save_data("admin_table","INSERT",$user_id,$title,$price,$max_ticket,$img);
            echo header("Refresh: 3;URL=./movie_created.php");
        }else{
            echo '<div class="err"> File upload Error For Thumb Nail </div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/database_projects/CSS/header-aside.css">
    <link rel="stylesheet" href="/database_projects/CSS/form.css">
    <script src="/database_projects/JS/drawer-outline.js" defer></script>
    <title>Movies Maniac</title>
</head>
<body>
    <header>
        <h1>CREATE YOUR OWN MOVIES</h1>
    </header>

    <main>
        <form action="create_movie.php" method="post" enctype="multipart/form-data">
            <label for="title">Movie Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required>
            <label for="max_ticket">Maximum Ticket</label>
            <input type="number" name="max_ticket" id="max_ticket" required>
            <input type="file" name="img" id="img">
            <input type="submit" value="Create" name="submit" required>
        </form>
    </main>

    <aside class="aside" id="aside">
        <div class="c-o-button" id="openCloseButton"></div>
        <li>
            <ol><a href="./userIndex.php">Home</a></ol>
            <ol><a href="./logout.php">Log Out</a></ol>
        </li>
    </aside>
    
</body>
</html>