<!--Culmination Project-->
<!DOCTYPE html>
<!--Login Page -->

<html>
    <head>  
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <!--Credit to https://djtechblog.com/php/php-login-form/ for login code -->

    
        <?php session_start();
            if(isset($_SESSION['username'])){
                header('location: index.php');
            }

            $username = "";
            $password = "";

            include "credentials.php";
            //echo $user_name;

            $server_name = "localhost";
            $db = "imacleod";

            $conn = mysqli_connect($server_name, $user_name, $password, $db);

            if(mysqli_connect_errno()){
                echo "Failed to connect";
                exit();
            }
            
            //checks to see if session is set

            if(isset($_POST['login_user'])){
                //$username = mysqli_real_escape_string($db, $_POST['username']);
                //$password = mysqli_real_escape_string($db, $_POST['password']);

                $username = $_POST['username'];
                $password = $_POST['password'];

                $password = md5($password);
                $query = "SELECT * FROM reg_user WHERE username= '" . $username . "' AND '". $password . "'";
                $results = mysqli_query($conn, $query);
                if(mysqli_num_rows($results) == 1){
                    $_SESSION['username'] = $username;
                    header("location: index.php");
                }else {
                    echo "Wrong username or password!";
                }
                //$_SESSION['username'] = $username;
                //header("location: index.php");
            }



        ?>    

    <!-- Login in form -->
    <div class="main">
        <div class="login">
            <h2>Administrator Login</h2>
            <form action="login.php" method="post">
                <div>
                    <input id="username" type="text" placeholder="Username" name="username">
                <div>
                    <input id="password" type="text" placeholder="Password" name="password">
                </div>
                <button name="login_user">Submit</button>
           </form>
        </div>
    </div>
    </body>




</html>
