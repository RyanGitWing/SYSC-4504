<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Xbox Fan page</title>
        <link rel="icon" href="images/Microsoft_logo.png" type="image/x-icon">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <header>
            <h1>Microsoft Xbox</h1>
            <h2>by: Ryan Nguyen</h2>
            <h3>10-02-2023</h3>
        </header>

        <nav>
            <ul>
                <li><a href="./index.html">Home page</a></li>
                <li><a href="./catalog.html">Catalog</a></li>
                <li><a href="https://www.xbox.com/en-CA/consoles" target="_blank">Company website</a></li>
                <li><a href="./contact.html">Contact us</a></li>
                <li><a href="./escape_js.html">Escape Room</a></li>
                <li><a class="active" href="#">Add Game</a></li>
            </ul>
        </nav>

        <main>
            <div class="info">
                <form method="POST" action="">
                    <fieldset>
                    <legend>Add student information</legend>
                        <label>Game Name: </label><input type="text" name="game_name"><br>
                        <label>Release date: </label><input type="date" name="release_date"><br>
                        <label>Price: </label><input type="text" name="game_price"><br>
                        <label>Game Description: </label><br><textarea name="game_description" rows="4" cols="50" placeholder="max 500 characters"></textarea><br>
                        <input type="submit" name="submit" value="Submit Query">
                    </fieldset>
                </form>
            </div>
       </main>
       <table class="game">
            <?php
                include('../connection.php');
                if (isset($_POST["submit"])) {
                    echo"<tr>";
                    echo"<td>#</td>";
                    echo"<td>Game ID</td>";
                    echo"<td>Game Name</td>";
                    echo"<td>Game Price</td>";
                    echo"<td>Release Date</td>";
                    echo"<td>Game Description</td>";
                    echo"</tr>";
                    try {
                        $connection = new mysqli($server_name, $username, $password, $database_name);
                        echo "Connected Successfully <br/>";
                            $game_name = $_POST["game_name"];
                            $release_date = $_POST["release_date"];
                            $game_price = $_POST["game_price"];
                            $game_description = $_POST["game_description"];

                            $sql = "INSERT INTO game_details (game_name, release_date, game_price, game_description) VALUES ('".$game_name."','".$release_date."',".$game_price.",'".$game_description."');";
                            $connection->query($sql);
                            $sql = "SELECT * FROM game_details ORDER BY release_date DESC;";
                            $result = $connection->query($sql);

                            echo "<h1>Course record created successfully!!!</h1>";
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$row["game_ID"]."</td>";
                                echo "<td>".$row["game_name"]."</td>";
                                echo "<td>".$row["game_price"]."</td>";
                                echo "<td>".$row["release_date"]."</td>";
                                echo "<td>".$row["game_description"]."</td>";
                                echo "</tr>";
                                ++$i;
                            }
                            
                            $result->free_result();
                            $connection->close();
                        
                    } catch (mysqli_sql_exception $e) {
                        $error = $e->getMessage();
                        die("Error: Couldn't connect. ". $error);
                    }
                } else {

                }
            ?>
        </table>
        <hr>
        <footer>
            <div id="copy">
                <p>
                    Copyright &copy; Ryan Nguyen - Carleton University <a href="#">ryannguyen3@cmail.Carleton.ca</a>
                </p>
            </div>
        </footer>
    </body>
</html>