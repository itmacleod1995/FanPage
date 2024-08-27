<!--Culmination Project-->
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Ian MacLeod"/>
        <title>Rosters</title>
        <link rel="stylesheet" href="style.css">
    </head>

    </body>


        <?php
            include "credentials.php";
            $server_name = "localhost";
            $db = "imacleod";
            $conn = mysqli_connect($server_name, $user_name, $password, $db);
            
            if(mysqli_connect_errno()){
                echo "Failed to connect";
                exit();

            }else{
                echo "Successfully connected to the database";
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
       <center>
        <?php
            //Show system time
            #1
            echo "Time: " . date("h : i a");
        ?>
        </center>

        <div class="search_bar">
            <form action="roster.php" method="post">
                Enter player <span class="format">(ex. Pedri)</span><input type="text" name="player">
                <input type="Submit">
            </form>
        </div>
<!--
        <div class="search_bar">
            <form action="roster.php" method="post">
                Show table again <input type="submit" name="table">
            </form>         
        </div>
-->
        <div class="search_bar">
            <form action="roster.php" method="post">
                Insert player <span class="format">("player_name",jersey_num,"position","nationality")</span> <input type="text" name="insert">
                <input type="Submit">
            </form>

        </div>

        <div class="search_bar">
            <form action="roster.php" method="post">
                Delete player <span class="format">(ex. Joules Kounde)</span><input type="text" name="delete">
                <input type="Submit">
            </form>
        </div>
        
        <div class="search_bar">
            <form action="roster.php" method="post">
                Update player <span class="format">(ex. player_name, "Dani", player_name, "Dani Alves"</span><input type="text" name="update">
                <input type="Submit">
            </form>
        </div>
                
        <h1 class="title">Players</h1>
        <nav>
            <center>
                <ul class="tabbar">
                    <li class="home"><a href="index.php">Home</a></li>   
                    <li><a href="managers.php">Managers</a></li>
                    <li><a href="team.php">Team</a></li>
                    <li><a href="trophies.php">Trophies</a></li>   
                </ul>
            <center>      
        </nav>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['player'])){
                    $player = $_POST["player"];
                }
                if(isset($_POST['insert'])){
                    $insert = $_POST['insert'];
                }
                
                if(isset($_POST["delete"])){
                    $delete = $_POST['delete'];
                }

                if(isset($_POST['update'])){
                    $update = $_POST['update'];
                }
            }

        ?>

        <!-- Table goes here -->
         
            <div>
              <center>
              <?php
                //Make columns clickable links that sort the rows

                $headers = array("player_id", "player_name", "jersey_num", "position", "nationality");
                $select = "SELECT * FROM players";
                $res = mysqli_query($conn, $select);
                if(!isset($_POST['delete']) && !isset($_POST['player']) && !isset($_POST['insert']) && !isset($_POST['update']) || isset($_POST['table'])){
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
                }else if(isset($_POST['player'])){                    
                    if(!empty($player)){
                        //$sql_select = "SELECT * FROM players WHERE name = " . "'" . $player . "';";
                        $sql_select = "SELECT players.player_name, team.name FROM players INNER JOIN player_team ON players.player_id = player_team.player_id INNER JOIN team ON team.id = player_team.team_id WHERE player_name = '" . $player ."';";
                        $headers2 = array("player_name", "team");
                        $results = mysqli_query($conn, $sql_select);
                        if(mysqli_num_rows($results) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < COUNT($headers2); $i++){
                                echo "<th>" . $headers[$i] . "</th>";
                            }
                            echo "</tr>";

                            while($row = mysqli_fetch_assoc($results)){
                                echo "<tr>";    
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }

                            }
                        }else {
                            echo "<p>" . "Player not found" . "</p>";
                        }
                    }
                   
                }else if(isset($_POST['insert'])){
                   if(!empty($insert)){
                        $arr = explode(',', $insert);
                        //print_r($arr);
                        $name = $arr[0];
                        $jersey_num = $arr[1];
                        $position = $arr[2];
                        $nationality = $arr[3];
                        //echo $nationality;
                        $sql_insert = "INSERT INTO players (player_name, jersey_num, position, nationality) VALUES (" . $name . "," .  $jersey_num . "," . $position . "," . $nationality . ");"; 
                        $res = mysqli_query($conn, $sql_insert);
                        echo "Successfully inserted";
                   }
                }else if(isset($_POST['delete'])){
                    if(!empty($delete)){
                        $sql_delete = "DELETE FROM players WHERE player_name = " . "'" .  $delete . "';";
                        $res = mysqli_query($conn, $sql_delete);
                        echo "Successfully deleted " . $delete . " from database";
                    }
            
                }else if(isset($_POST['update'])){
                    if(!empty($update)){
                        $arr = explode(",", $update);
                        $sql_update = "UPDATE players SET " . $arr[0] . " = " . $arr[1] . " WHERE " . $arr[2] . " = " . $arr[3] . ";";
                        //$sql_update = "UPDATE players SET " . $arr[0] . " = '" . $arr[1] . "' WHERE " . $arr[2] . " = '" . $arr[3] . "';";
                        
                        //echo $sql_update;
                        $res = mysqli_query($conn, $sql_update);
                        echo "Successfully updated table";
                    }


                }
              ?>
            </center>
            </div>

            <center>
                <div class="footer">
                    <form action="roster.php" method="post">
                        Show table again <input type="submit" name="table">
                    </form> 
                </div>        

            </center>
    </body>


</html>
                   





































































                       
