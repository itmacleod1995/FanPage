<!--Culmination Project-->
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="Ian MacLeod"/>
        <title>Trophies</title>
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

            }
        ?>

        <!--<img class="trophy_pic" src="./images/trophies.jpeg">-->
 
       <?php 
        //Use GET superglobal to obtain background color from URL

        if(isset($_GET['bg'])){
            $bg_color = $_GET['bg']; 
        }else {
            $bg_color = "white";
        }
        ?>

        <div class="search_bar">
            <form action="trophies.php" method="post">
                Enter Competition<span class="format">(ex. UEFA Champions League)<input type="text" name="competition">
                <input type="Submit">
            </form>
        </div>
<!--
        <div class="search_bar">
            <form action="trophies.php" method="post">
                Show table again <input type="submit" name="table">
            </form>         
        </div>
-->
        <div class="search_bar">
            <form action="trophies.php" method="post">
                Insert Competition <span class="format">("competition", year, team_id)</span> <input type="text" name="insert">
                <input type="Submit">
            </form>

        </div>

        <div class="search_bar">
            <form action="trophies.php" method="post">
                Delete Trophy <span class="format">(ex. UEFA Champions League)</span><input type="text" name="delete">
                <input type="Submit">
            </form>
        </div>
        
        <div class="search_bar">
            <form action="trophies.php" method="post">
                Update trophy <span class="format">(competition, "Copa Del Rey", competition, "Copa del Rey")</span><input type="text" name="update">
                <input type="Submit">
            </form>
        </div>
                
        <h1 class="title">Trophies</h1>
        <nav>
            <center>
                <ul class="tabbar">
                    <li class="home"><a href="index.php">Home</a></li>   
                    <li><a href="managers.php">Managers</a></li>
                    <li><a href="team.php">Team</a></li>
                    <li><a href="roster.php">Players</a></li>   
                </ul>
            <center>      
        </nav>

            <!-- Select Section -->
            <center>       
            <div class="select_section">
               <form action="trophies.php" method="post">
                    <label for="yr">Select Year</label>
                    <select id="id" name="year">
                        <option>Select Season</option>
                        <option>2010-2011</option>
                        <option>2011-2012</option>
                        <option>2012-2013</option>
                        <option>2013-2014</option>
                        <option>2014-2015</option>
                        <option>2015-2016</option>
                        <option>2016-2017</option>
                        <option>2017-2018</option>
                        <option>2018-2019</option>
                        <option>2019-2020</option>
                        <option>2020-2021</option>
                        <option>2021-2022</option>
                        <option>2022-2023</option>
                    </select>
                    <input type="Submit">
              </form> 
              
                
            </div>
            </center>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['competition'])){
                    $competition = $_POST["competition"];
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

                if(isset($_POST['year'])){
                    $yr = $_POST['year'];
                }
            }

        ?>
        
         
        
              <center>
              <?php
                //Make columns clickable links that sort the rows

                $headers = array("id", "competition", "year", "team_id");
                $select = "SELECT * FROM trophies";
                $res = mysqli_query($conn, $select);
                if(!isset($_POST['delete']) && !isset($_POST['competition']) && !isset($_POST['insert']) && !isset($_POST['update']) && !isset($_POST['year']) || isset($_POST['table'])){
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
                }else if(isset($_POST['competition'])){                    
                    if(!empty($competition)){
                        $headers2 = array("compeititon", "team");
                        //$sql_select = "SELECT * FROM trophies WHERE competition = " . "'" . $competition . "';";
                        $sql_select = "SELECT trophies.competition, team.name FROM trophies INNER JOIN team ON trophies.team_id = team.id WHERE trophies.competition = '" . $_POST['competition'] . "';";
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

                            }
                        }else {
                            echo "<p>" . "Competition not found" . "</p>";
                        }
                    }
                   
                }else if(isset($_POST['insert'])){
                   if(!empty($insert)){
                        $arr = explode(',', $insert);
                        //print_r($arr);
                        $comp = $arr[0];
                        $yr = $arr[1];
                        $team_id = $arr[2];
                        $sql_insert = "INSERT INTO trophies (competition, year, team_id) VALUES (" . $comp . "," . $yr . "," . $team_id . ");";
                        //ex. "Europa League", 2020, 4
                        $res = mysqli_query($conn, $sql_insert);
                        echo "Successfully inserted";
                   }
                }else if(isset($_POST['delete'])){
                    if(!empty($delete)){
                        $sql_delete = "DELETE FROM trophies WHERE competition = " . "'" .  $delete . "';";
                        //ex. Europa League
                        $res = mysqli_query($conn, $sql_delete);
                        echo "Successfully deleted " . $delete . " from database";
                    }
            
                }else if(isset($_POST['update'])){
                    if(!empty($update)){
                        $arr = explode(",", $update);
                        $sql_update = "UPDATE trophies SET " . $arr[0] . " = " . $arr[1] . " WHERE " . $arr[2] . " = " . $arr[3] . ";";
                        //$sql_update = "UPDATE players SET " . $arr[0] . " = '" . $arr[1] . "' WHERE " . $arr[2] . " = '" . $arr[3] . "';";
                        //ex. competition, "League Title", competition, "La Liga"
                        //echo $sql_update;
                        $res = mysqli_query($conn, $sql_update);
                        echo "Successfully updated table";
                    }


                }else if(isset($_POST['year'])){
                    if(!empty($yr)){
                        $var = "'Barcelona FC";
                        $sql_select = "SELECT team.name, trophies.competition, year FROM team INNER JOIN trophies ON team.id = trophies.team_id WHERE team.name = " . $var . " " . $yr . " ';";
                        $headers = array("name", "competition", "year");
                        //echo $sql_select;
                        $res = mysqli_query($conn, $sql_select);
                        if(mysqli_num_rows($res) > 0){
                            echo "<table style=background-color:" . $bg_color . ">";
                            echo "<tr>";
                            for($i = 0; $i < COUNT($headers); $i++){
                                echo "<th>" . $headers[$i] . "</th>";
                            }

                            echo "</tr>";

                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                foreach($row as $key => $val){
                                    echo "<td>" . $val . "</td>";
                                }
                                echo "</tr>";

                            }
                        }else {
                            echo "No compeititons won during this season";
                        }
                    }
                }
              ?>
            </center>
            </div>
        </main>
         
            <center>
                <div class="footer">
                    <form action="trophies.php" method="post">
                        Show table again <input type="submit" name="table">
                    </form> 
                </div>        

            </center>
    </body>


</html>
                   





































































                       
