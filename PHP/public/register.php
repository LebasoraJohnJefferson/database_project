<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    // only trigger when submit button is click;
    if(isset($_POST['submit'])){
        $fname=trim($_POST['fname']);
        $lname=trim($_POST['lname']);
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        //if the input not empty then proceed;
        if(!empty($fname) && !empty($lname) && !empty($username) && !empty($password)){
            //checking if the username is not taken;
            $valid=validation('user_account','SELECT',$username,null,null);
            $details = $valid->fetch_assoc();
            //if username is not taken then proceed;
            if(!isset($details)){
                //saving data into database then redirecting to login page with 3s waiting time;
                save_data('user_account','INSERT',$fname,$lname,$username,$password,null);
                echo "<div class=err>SUCCESSFULLY REGISTERED<br/>Redirecting to Login</div>";
                echo header("Refresh: 1;URL=./login.php");
            }else{
                echo "<div class=err>Email Already Exist</div>";
            }
        }else{
            echo "<div class=err>ERROR: Empty Input</div>";
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
        <h1>Register</h1>
    </header>

    <main>
        <form action="./register.php" method="post">
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" required>
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" required>
            <label for="username">User Name:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="register" name="submit">
        </form>
    </main>

    <aside class="aside" id="aside">
        <div class="c-o-button" id="openCloseButton"></div>
        <li>
            <ol><a href="/database_projects/index.php">Home</a></ol>
            <ol><a href="./login.php">Log In</a></ol>
        </li>
    </aside>
    
</body>
</html>