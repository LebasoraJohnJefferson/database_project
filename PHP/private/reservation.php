<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/PHP/public/login.php');
    }
    
    $user_id=$_SESSION['user_id'];

    if(isset($_GET['admin_id'])){
        $_SESSION['admin_id']=$_GET['admin_id'];
        $admin_id=$_SESSION['admin_id'];    
        $admin_data=validation("admin_table","SELECT",null,null,$admin_id);
        $admin_details=$admin_data->fetch_assoc();
        $reserve_quantity=transaction('SELECT','user_account','admin_table','reservation_table',$user_id,$admin_id,'quantity');
        $reserve=$reserve_quantity->fetch_assoc();
    }

    if(isset($_POST['reserve'])){
        $quantity = $_POST['quantity'];
        if($quantity > 0){
            if($quantity<=($admin_details['max_ticket']-$reserve['reserve'])){
            save_data("reservation_table","INSERT",$user_id,$admin_id,$quantity,null,null);
            echo "<div class=err>TRANSACTION SUCCESS<br/>Redirecting to your wall</div>";
            echo header('Refresh:1;url=./reservation_details.php');
            }else{
                echo "<div class=err>insufficient ticket</div>";   
            }
        }else{
            echo "<div class=err>INPUT THE TICKET YOU WANT TO RESERVE</div>";
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
        <h1>
            RESERVATION DETAILS
        </h1>
    </header>

    <main>
        <?php if($admin_details['user_id']!=$user_id){ ?>
        <form  method="post" style="background-image:url(<?php echo $admin_details['image'] ?>);background-size:100% 100%;background-repeat:no-repeat;background-position:center top;">
            <label style="align-text:center;color:white;text-shadow:1px 1px 3px black;font-size:1.5rem" for="quantity">
                Available Ticket:<?php
                    if(0<$admin_details['max_ticket']-$reserve['reserve']){
                        echo $admin_details['max_ticket']-$reserve['reserve'];
                    }else{
                        echo "<span style=color:red;text-shadow:1px 1px 3px black,1px 1px 3px black,1px 1px 3px black;>Sold out</span>";
                    }?>
                <br/>
            </label>
            <label style="color:white;text-shadow:3px 3px 10px black,0px 0px 1px black,0px 0px 1px black,0px 0px 1px black;" for="quantity">Quantity of ticket:</label>
            <br/>
            <input type="number" name="quantity" id="quantity">
            <input type="submit" value="Reserve" name="reserve">
        </form>
            <?php }else{
                echo "No movies Available";
            } ?>
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