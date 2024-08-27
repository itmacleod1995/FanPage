<!--Culmination Project-->

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>


    <?php
        session_start();
        if(isset($_SESSION['username'])){
            session_destroy();
            header('location: login.php');
        }
        else{
            header('location: index.php');
        }

    ?>

    </body>



</html>

