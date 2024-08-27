<!--Culmination Project-->
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Ian MacLeod"/>
        <title>Managers</title>
        <link rel="stylesheet" href="style.css">
    </head>

    </body>

    <!--connecting to database -->

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

        <!--input fields for inserting, deleting, etc -->
        <div class="search_bar">
            <form action="managers.php" method="post">
                Enter manager <span class="format">(ex. Pep Guardiola)<input type="text" name="manager">
                <input type="Submit">
            </form>
        </div>
<!--
        <div class="search_bar">
            <form action="managers.php" method="post">
                Show table again <input type="submit" name="table">
            </form>         
        </div>
-->
        <div class="search_bar">
            <form action="managers.php" method="post">
                Insert Manager <span class="format">(ex: "Pep Guardiola", "Spain")</span> <input type="text" name="insert">
                <input type="Submit">
            </form>

        </div>

        <div class="search_bar">
            <form action="managers.php" method="post">
                Delete manager <span class="format">(ex. "Pep Guardiola")</span><input type="text" name="delete">
                <input type="Submit">
            </form>
        </div>
        
        <div class="search_bar">
            <form action="managers.php" method="post">
                Update manager <span class="format">(nationality, "Spain", nationality, "spain")</span><input type="text" name="update">
                <input type="Submit">
            </form>
        </div>
                
        <h1 class="title">Managers</h1>
        <nav>
            <center>
                <ul class="tabbar">
                    <li class="home"><a href="index.php">Home</a></li>   
                    <li><a href="roster.php">Players</a></li>
                    <li><a href="team.php">Team</a></li>
                    <li><a href="trophies.php">Trophies</a></li>   
                </ul>
            <center>      
        </nav>

        <!--Retrieve $_POST variables -->

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['manager'])){
                    $manager = $_POST["manager"];
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

        <!-- Show table depending on $_POST value -->
         
            <div>
              <center>
              <?php
                //Make columns clickable links that sort the rows

                $headers = array("id", "manager_name", "nationality");
                $select = "SELECT * FROM manager";
                $res = mysqli_query($conn, $select);
                if(!isset($_POST['delete']) && !isset($_POST['manager']) && !isset($_POST['insert']) && !isset($_POST['update']) || isset($_POST['table'])){
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
                }else if(isset($_POST['manager'])){                    
                    if(!empty($manager)){
                        $headers2 = array("Manager", "Team");
                        //$sql_select = "SELECT * FROM manager WHERE name = " . "'" . $manager . "';";
                        $sql_select = "SELECT manager.manager_name, team.name FROM manager INNER JOIN manager_team ON manager.id = manager_team.manager_id INNER JOIN team ON team.id = manager_team.team_id
                        WHERE manager.manager_name = '" . $manager . "';";  
                        $results = mysqli_query($conn, $sql_select);
                        if(mysqli_num_rows($results) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < COUNT($headers2); $i++){
                                echo "<th>" . $headers2[$i] . "</th>";
                            }
                            echo "</tr>";

                            while($row = mysqli_fetch_assoc($results)){
                                echo "<tr>";    
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";

                            }
                        }else {
                            echo "<p>" . "Manager not found" . "</p>";
                        }
                    }
                   
                }else if(isset($_POST['insert'])){
                   if(!empty($insert)){
                        $arr = explode(',', $insert);
                        //print_r($arr);
                        $name = $arr[0];
                        $nationality = $arr[1];
                        //echo $nationality;
                        $sql_insert = "INSERT INTO manager (manager_name, nationality) VALUES (" . $name . "," . $nationality . ");"; 
                        $res = mysqli_query($conn, $sql_insert);
                        echo "Successfully inserted";
                   }
                }else if(isset($_POST['delete'])){
                    if(!empty($delete)){
                        $sql_delete = "DELETE FROM manager WHERE manager_name = " .  $delete . ";";
                        $res = mysqli_query($conn, $sql_delete);
                        echo "Successfully deleted " . $delete . " from database";
                    }
            
                }else if(isset($_POST['update'])){
                    if(!empty($update)){
                        $arr = explode(",", $update);
                        $sql_update = "UPDATE manager SET " . $arr[0] . " = " . $arr[1] . " WHERE " . $arr[2] . " = " . $arr[3] . ";";
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
        <!--Button that shows table in its entirety-->
            <center>
                <div class="footer">
                    <form action="managers.php" method="post">
                        Show table again <input type="submit" name="table">
                    </form> 
                </div>        

            </center>
    </body>


</html>
                   





































































                       
