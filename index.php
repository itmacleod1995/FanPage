<!--Culmination Project-->
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Ian MacLeod"/>
        <title>Barcelona FC</title>
        <link rel="stylesheet" href="style.css"> 
    </head>
     
    <body>
        
        <?php
            //sets up credentials to be used in connecting to database

            include "credentials.php";
            //echo $user_name;

            //connect to database

            $server_name = "localhost";
            $db = "imacleod";

            $conn = mysqli_connect($server_name, $user_name, $password, $db);

            if(mysqli_connect_errno()){
                echo "Failed to connect";
                exit();
            }else {
                echo "Successfully connected to the database";
            }


        ?>

        <!--start session -->

        <?php session_start();
            if(!isset($_SESSION['username'])){
                header('location: login.php');
            }

            $username = "";
            $password = "";

            if(isset($_POST['login_user'])){
                if($_POST['username'] == 'imacleod'){
                    header('location: index.php');
                }
            }
            

        ?>
        
        <?php
            
            //from class
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $player = $_POST["player"];
                //$p = $_POST["number"];
                //echo $p;
                //echo $player;
                if(!empty($player)){
                    $sql_select = "SELECT * FROM players WHERE name = '" . $player . "';";
                    $results = mysqli_query($conn, $sql_select);
                    if(mysqli_num_rows($results) > 0){
                        while($row = mysqli_fetch_assoc($results)){
                            echo "<p>" . $row["name"] . "</p>" . "<br>";
                            echo "<p>" . $row["player_id"] . "</p>";
                        }
                    } 
                }
            }
           
           
        ?>

        
       <?php 
        //Use GET superglobal to obtain background color from URL

        if(isset($_GET['bg'])){
            $bg_color = $_GET['bg']; 
        }else {
            $bg_color = "white";
        }
        ?>

        <?php 
            include 'inc/time.php';
        ?>

       <?php     
        
        //Create list associate array and function to print list items out

        $arr = array("General information about the club" => ["Managers", "Trophies", "Past teams"], "Roster Data" => ["Info on different players throughout the years"]);
        ?>
        
        <?php function printList($arr){ 
            foreach($arr as $key => $item){ ?>
                <li><?php echo $key?></li>
                <ul>
                    <?php for($i = 0; $i < count($arr[$key]); $i++){?>
                        <li><?php echo $arr[$key][$i]; ?></li>
                    <?php } ?>
                </ul> 
           <?php  }

        }?>


        <nav>
            <img src="./images/badge.jpeg">
            <ul class="navbar">
                <li class="home">Home</li>
                <li><a href="roster.php">Players</a></li>
                <li><a href="managers.php">Managers</a></li>
                <li><a href="team.php">Teams</a></li>
                <li><a href="trophies.php">Trophies</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <main>
            <h1 class="title"> FC Barcelona Fan Page</h1>
            <p>Mas que un club!</p>
            <div class="main-content">
                <p class="content">The best unofficial website about the football club Barcelona! Includes the following:</p>
                <ol class="content-list">
                    <?php printList($arr)?>
                </ol>
            </div>
            <div>
             <!--
              <center>
              <?php
                /**
                $headers = array("player_id", "name", "jersey_num", "position", "nationality");
                $select = "SELECT * FROM players";
                $res = mysqli_query($conn, $select);
                if(!isset($_GET['order'])){
                    if(mysqli_num_rows($res) > 0){
                        echo "<table style=background-color:" . $bg_color . ">";
                        echo "<tr>";
                        for($i = 0; $i < count($headers); $i++){
                            echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                        }
                        echo "</tr>";   
                        while($row = mysqli_fetch_assoc($res)){
                            echo "<tr>";
                            foreach($row as $key => $val){
                                echo "<td>" . $val . "</td>";
                            }
                            echo "</tr>";
                        }
                       echo "</table>";

                    }
                }else{
                    $var = $_GET['order'];
                    if($var == 'name'){
                        $sort_name = "SELECT * FROM players ORDER BY name";
                        $res = mysqli_query($conn, $sort_name);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < count($headers); $i++){
                                echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                            }
                            echo "</tr>";   
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }else if($var == 'jersey_num'){
                        $sort_num = "SELECT * FROM players ORDER BY jersey_num";
                        $res = mysqli_query($conn, $sort_num);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < count($headers); $i++){
                                echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                            }
                            echo "</tr>";
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }

                    }else if($var == 'player_id'){
                        $sort_id = "SELECT * FROM players ORDER BY player_id";
                        $res = mysqli_query($conn, $sort_id);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < count($headers); $i++){
                                echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                            }
                            echo "</tr>";
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";

                        }

                    }else if($var == 'position'){
                        $sort_pos = "SELECT * FROM players ORDER BY position";
                        $res = mysqli_query($conn, $sort_pos);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < count($headers); $i++){
                                echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                            }
                            echo "</tr>";
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }else if($var == 'nationality'){
                        $sort_nation = "SELECT * FROM players ORDER BY nationality";
                        $res = mysqli_query($conn, $sort_nation);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0;$i < count($headers); $i++){
                                echo "<th>" . "<a href='?order=" . $headers[$i] . "'>" . $headers[$i] . "</a>" . "</th>";
                            }
                            echo "</tr>";
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }

                }

            */
              ?>
            </center>
            </div>
        </main>
    </body>


</html>
