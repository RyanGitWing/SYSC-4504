<!DOCTYPE html>
<html lang="en">
<head >
   <meta charset="utf-8">
   <title>SYSCBOOK - Main</title>
   <link rel="stylesheet" href="assets/css/reset.css" />
   <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
   <header>
      <h1>SYSCBOOK</h1>
      <p>Social media for SYSC students in Carleton University</p>
   </header>

   <nav>
      <ul>
         <li><a class="active" href="#">Home</a></li>
         <li><a href="./profile.php">Profile</a></li>
         <li><a href="./register.php">Register</a></li>
         <li><a href="#">Log out</a></li>
     </ul>
   </nav>

   <main>
      <div>
         <form method="post" action="">
            <fieldset>
               <legend><span>New Post</span></legend>
               <table>
                  <tr>
                     <td>
                        <p>
                           <textarea name="new_post" placeholder="What's on your mind? (max 500 char)"></textarea>
                        </p>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <input type="submit" value="Post" name="submit">
                        <input type="reset">
                     </td>
                  </tr>
               </table>
            </fieldset>
         </form>
         <?php
            include('./connection.php');

            if (isset($_POST["submit"])) {

                try {
                    $connection = new mysqli($server_name, $username, $password, $database_name);
                    
                    $new_post = $_POST["new_post"];

                    $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                    $result = $connection->query($getID);
                    $id = $result->fetch_assoc();

                    $sql = "INSERT INTO users_posts (student_ID, new_post) VALUES (".$id["student_ID"].",'".$new_post."');";
                    $connection->query($sql);

                } catch (mysqli_sql_exception $e) {
                    $error = $e->getMessage();
                    die("Error: Couldn't connect. " . $error);
                }

            }
        ?>
      </div>
      <?php
               include('./connection.php');
               try {
                  $connection = new mysqli($server_name, $username, $password, $database_name);

                  $getPOSTS = "SELECT * FROM users_posts WHERE student_ID=(SELECT max(student_ID) FROM users_posts) ORDER BY post_date DESC LIMIT 5 ";
                  $result = $connection->query($getPOSTS);
                  
                  $i = 1;
                  while ($posts = $result->fetch_assoc()) {
                     echo "<details>";
                        echo"<summary>Post ".$i."</summary>";
                        echo"<p>".$posts["new_post"]."<br> </p>";
                     echo "</details>";
                     ++$i;
                  }

               } catch (mysqli_sql_exception $e) {
                  $error = $e->getMessage();
                  die("Error: Couldn't connect. " . $error);
               }
         ?>
      <!-- <details>
         <summary>Post 1</summary>
         <p>
            This is the first post! <br>
            This is the first post! <br>
            This is the first post! <br>
            This is the first post! <br>
            This is the first post! <br>
            This is the first post! <br>
            This is the first post! <br>
         </p>
      </details>

      <details>
         <summary>Post 2</summary>
         <p>
            This is the second post! <br>
            This is the second post! <br>
            This is the second post! <br>
            This is the second post! <br>
            This is the second post! <br>
            This is the second post! <br>
            This is the second post! <br>
         </p>
      </details>

      <details>
         <summary>Post 3</summary>
         <p>
            This is the third post! <br>
            This is the third post! <br>
            This is the third post! <br>
            This is the third post! <br>
            This is the third post! <br>
            This is the third post! <br>
            This is the third post! <br>
         </p>
      </details> -->
   </main>
</body>
</html>