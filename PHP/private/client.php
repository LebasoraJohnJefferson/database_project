<?php
    include $_SERVER['DOCUMENT_ROOT']."/database_projects/PHP/auth.php";
    $con=authentication();
    if(!isset($_SESSION['user_id'])){
        echo header('location:/database_projects/index.php');
    }
    $user_id=$_SESSION['user_id'];
    if(isset($_GET['admin_id'])){
        $_SESSION['admin_id']=$_GET['admin_id'];
        $admin_id=$_SESSION['admin_id'];
        $movies_transaction=transaction("SELECT","user_account","admin_table","reservation_table",$user_id,$admin_id,null);
        $movie_details=$movies_transaction->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/database_projects/CSS/header-aside.css">
    <link rel="stylesheet" href="/database_projects/CSS/table.css">
    <script src="/database_projects/JS/drawer-outline.js" defer></script>
    <title>Movies Maniac</title>
</head>
<body>
    <header>
        <h1>CLIENTS TRANSACTION</h1>
    </header>

    <main>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Ticket Reserve</th>
                <th>Total Sell</th>
            </tr>
            <?php
                if(isset($movie_details)){
                    do{ ?>
                        <tr>
                            <td>
                                <?php echo $movie_details['first_name']; ?>
                            </td>
                            <td>
                                <?php echo $movie_details['last_name']; ?>
                            </td>
                            <td>
                                <?php echo $movie_details['quantity']; ?>
                            </td>
                            <td>
                                <?php echo $movie_details['price']*$movie_details['quantity']; ?>
                            </td>
                        </tr>
                    <?php }while($movie_details=$movies_transaction->fetch_assoc());
                }else{
                    echo "<ol class=err> No Client</ol>";
                }
            ?>
        </table>
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