<!--Culmination Project-->
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Ian MacLeod"/>
        <title>Teams</title>
        <link rel="stylesheet" href="style.css">
    </head>

    </body>

    <!-- Connect to database -->

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

        <div class="search_bar">
            <form action="team.php" method="post">
                Enter team <span class="format">(ex. Barcelona FC 2010-2011)</span><input type="text" name="team">
                <input type="Submit">
            </form>
        </div>
<!--
        <div class="search_bar">
            <form action="team.php" method="post">
                Show table again <input type="submit" name="table">
            </form>         
        </div>
-->

<!--Inputs for update, insert, etc -->
        <div class="search_bar">
            <form action="team.php" method="post">
                Insert team <span class="format">(ex. "Barcelona FC 2009-2010", 3)</span> <input type="text" name="insert">
                <input type="Submit">
            </form>

        </div>

        <div class="search_bar">
            <form action="team.php" method="post">
                Delete team <span class="format">(ex. Barcelona FC 2009-2010)</span><input type="text" name="delete">
                <input type="Submit">
            </form>
        </div>
        
        <div class="search_bar">
            <form action="team.php" method="post">
                Update team <span class="format">(name, "Barcelona FC 2010-2011", name, "Barcelona FC")</span><input type="text" name="update">
                <input type="Submit">
            </form>
        </div>
                
        <h1 class="title">Teams</h1>
        <nav>
            <center>
                <ul class="tabbar">
                    <li class="home"><a href="index.php">Home</a></li>   
                    <li><a href="managers.php">Managers</a></li>
                    <li><a href="roster.php">Players</a></li>
                    <li><a href="trophies.php">Trophies</a></li>   
                </ul>
            <center>      
        </nav>

    <!--Get POST variables -->

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['team'])){
                    $team = $_POST["team"];
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
            
 
            <div>
              <center>
              <?php
                //Make columns clickable links that sort the rows

                $headers = array("id", "name", "num_of_trophies");
                $select = "SELECT * FROM team";
                $res = mysqli_query($conn, $select);
                if(!isset($_POST['delete']) && !isset($_POST['team']) && !isset($_POST['insert']) && !isset($_POST['update']) || isset($_POST['table'])){
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
                }else if(isset($_POST['team'])){                    
                    if(!empty($team)){
                        $sql_select = "SELECT * FROM team WHERE name = " . "'" . $team . "';";
                        $results = mysqli_query($conn, $sql_select);
                        if(mysqli_num_rows($results) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < COUNT($headers); $i++){
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
                        $trophies = $arr[1];
                        $sql_insert = "INSERT INTO team (name, num_of_trophies) VALUES (" . $name . "," .  $trophies . ");"; 
                        $res = mysqli_query($conn, $sql_insert);
                        echo "Successfully inserted";
                   }
                }else if(isset($_POST['delete'])){
                    if(!empty($delete)){
                        $sql_delete = "DELETE FROM team WHERE name = " . "'" .  $delete . "';";
                        $res = mysqli_query($conn, $sql_delete);
                        echo "Successfully deleted " . $delete . " from database";
                    }
            
                }else if(isset($_POST['update'])){
                    if(!empty($update)){
                        $arr = explode(",", $update);
                        $sql_update = "UPDATE team SET " . $arr[0] . " = " . $arr[1] . " WHERE " . $arr[2] . " = " . $arr[3] . ";";
                        //$sql_update = "UPDATE players SET " . $arr[0] . " = '" . $arr[1] . "' WHERE " . $arr[2] . " = '" . $arr[3] . "';";
                        
                        //echo $sql_update;
                        $res = mysqli_query($conn, $sql_update);
                        echo "Successfully updated table";
                    }


                }
              ?>
            </center>
            </div>
        </main>
        
            <center>
                <div class="footer">
                    <form action="team.php" method="post">
                        Show table again <input type="submit" name="table">
                    </form> 
                </div>        

            </center>
    </body>


</html>
                   





































































                       
