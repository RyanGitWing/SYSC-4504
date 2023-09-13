<?php
    session_start();

    if (!isset($_SESSION['student_ID'])) {
        header("Location: http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>SYSCBOOK - Main</title>
   <link rel="stylesheet" href="assets/css/reset.css" />
   <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <?php
        include('./connection.php');
        try {
    
            $connection = new mysqli($server_name, $username, $password, $database_name);
    
            $sql = "SELECT account_type FROM users_permissions WHERE student_ID=?";
            $result = $connection->prepare($sql);
            $result->bind_param('i', $_SESSION['student_ID']);
            $result->execute();
            $type = $result->get_result()->fetch_assoc();
    
            if ($type['account_type'] != 0) {
                echo '<script>window.confirm("Permission denied"); window.location.href="http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/index.php";</script>;';
            }
            
        } catch (mysqli_sql_exception $e) {
            $error = $e->getMessage();
            die("Error: Couldn't connect. " . $error);
        }
    ?>
   <header>
      <h1>SYSCBOOK</h1>
      <p>Social media for SYSC students in Carleton University</p>
   </header>

   <nav>
      <ul>
         <li><a href="#">Home</a></li>
         <li><a href="./profile.php">Profile</a></li>
         <li><a href="./register.php">Register</a></li>
         <?php
            echo "<li><a class='active' href='#'>User List</a></li>";

            if (!isset($_SESSION['student_ID'])) {
               echo "<li><a href='./login.php'>Login</a></li>";
            } else {
               echo "<li><a href='./login.php'>Log out</a></li>";
            }
         ?>
     </ul>
   </nav>

   <main>
      <div>
         <form method="post" action="">
            <fieldset>
               <legend><span>User List</span></legend>
               <table class=users_list>
                  <tr>
                     <td >student_ID</td>
                     <td>First_name</td>
                     <td>Last_name</td>
                     <td>student_email</td>
                     <td>program</td>
                  </tr>
                    <?php
                    include('./connection.php');
                    try {
                        $connection = new mysqli($server_name, $username, $password, $database_name);
        
                        $getPrg = "SELECT * FROM users_program";
                        $resultprg = $connection->query($getPrg);

                        $getID = "SELECT * FROM users_info";
                        $result = $connection->query($getID);

                        while ($id = $result->fetch_assoc()) {
                            $prg = $resultprg->fetch_assoc();
                            echo "<tr>";
                            echo "<td>".$id['student_ID']."</td>";
                            echo "<td>".$id['first_name']."</td>";
                            echo "<td>".$id['last_name']."</td>";
                            echo "<td>".$id['student_email']."</td>";
                            echo "<td>".$prg['Program']."</td>";
                            echo "</tr>";    
                        }
        
                    } catch (mysqli_sql_exception $e) {
                        $error = $e->getMessage();
                        die("Error: Couldn't connect. " . $error);
                    }
                    ?>
               </table>
            </fieldset>
         </form>
      </div>
   </main>
</body>
</html>