<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/index.php');
    }
    $table="user_account";
    $mode="SELECT";
    $user_id=$_SESSION['user_id'];
    $data = validation($table,$mode,null,null,$user_id);
    $details = $data->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/database_projects/CSS/header-aside.css">
    <link rel="stylesheet" href="/database_projects/CSS/main.css">
    <script src="/database_projects/JS/drawer-outline.js" defer></script>
    <title>Movies Maniac</title>
</head>
<body>
    <header>
        <h1 style="align-text:center"><?php echo strtoupper("HI! ".$details['first_name']." ".$details['last_name']); ?></h1>
    </header>

    <main>
        <div class="content">
            <div>
                <div>View Your Movies</div>
            </div>
            <div>
                <a href="./movie_created.php"><img src="/database_projects/ICON/view.png" alt="view"/></a>
            </div>
        </div>
        <div class="content">
            <div>
                <div>Create Your Movies</div>
            </div>
            <div>
                <a href="create_movie.php"><img src="/database_projects/ICON/resume.png" alt="Create"/></a>
            </div>
        </div>
        <div class="content">
            <div>
                <div>Movies Available</div>
            </div>
            <div>
                <a href="./movie_available.php"><img src="/database_projects/ICON/file.png" alt="available"/></a>
            </div>
        </div>
        <div class="content">
            <div>
                <div>Movie Details and Transaction</div>
            </div>
            <div>
                <a href="./reservation_details.php"><img src="/database_projects/ICON/pen.png" alt="reserve"/></a>
            </div>
        </div>
    </main>

    <aside class="aside" id="aside">
        <div class="c-o-button" id="openCloseButton"></div>
        <li>
            <ol><a href="./logout.php">Log Out</a></ol>
            <ol><a href="./update.php">Settings</a></ol>
        </li>
    </aside>
    
</body>
</html>