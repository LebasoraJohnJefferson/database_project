<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/index.php');
    }
    $user_id=$_SESSION['user_id'];
    $movies_transaction=transaction("SELECT","user_account","admin_table","reservation_table",$user_id,null,"details");
    $transaction_details=$movies_transaction->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/database_projects/CSS/header-aside.css">
    <link rel="stylesheet" href="/database_projects/CSS/movie_section.css">
    <script src="/database_projects/JS/drawer-outline.js" defer></script>
    <title>Movies Maniac</title>
</head>
<body>
    <header>
        <h1>Movie Details and Transaction</h1>
    </header>

    <main>
    <?php
            if(isset($transaction_details)){
                do{ ?>
                    <div class="movie_container" style="background-image:url(<?php echo $transaction_details['image']?>);background-size:100% 100%;background-repeat:no-repeat">
                        <?php
                            echo "<div class=details>TITLE: ".$transaction_details['title']."<br/><br/>PRICE: ".$transaction_details['price']."<br/> QUANTITY: ".$transaction_details['sum']."<br/> BILLS: ".($transaction_details['sum']*$transaction_details['price'])."</div>";
                            echo "<span class=content_container>
                                <div>
                                    <a href=./cancel.php?admin_id=".$transaction_details['admin_id']."&&user_id=".$user_id.">
                                        CANCEL TRANSACTION
                                    </a>
                                </div>
                            </span>";
                        ?>
                    </div>
                <?php }while($transaction_details=$movies_transaction->fetch_assoc());
            }else{
                echo "<ol class=err> No Movies Created</ol>";
            }
        ?>
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