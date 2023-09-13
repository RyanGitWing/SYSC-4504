<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head >
   <meta charset="utf-8">
   <title>Login on SYSCBOOK</title>
   <link rel="stylesheet" href="assets/css/reset.css" />
   <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <?php
        echo '<script>
                if (window.confirm("Dont have an account? Register?")) { 
                    window.location.href="http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/register.php";
                } 
            </script>';
    ?>

   <header>
      <h1>SYSCBOOK</h1>
      <p>Social media for SYSC students in Carleton University</p>
   </header>

   <nav>
      <ul>
         <li><a href="./index.php">Home</a></li>
         <li><a href="./profile.php">Profile</a></li>
         <li><a href="./register.php">Register</a></li>
         <?php
            echo "<li><a href='./user_list.php'>User List</a></li>";

            if (!isset($id["student_ID"])) {
               echo "<li><a class='active' href='#'>Login</a></li>";
            } else {
               echo "<li><a class='active' href='#'>Log out</a></li>";
            }
         ?>
     </ul>
   </nav>

   <main>
      <section>
         <h2>Login to profile</h2>
         <form id="reg" method="post" action="">
            <fieldset>
                <legend><span>Personal information</span></legend>
                <table>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>Email address:</label>
                                <input type="email" name="student_email">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>Password:</label>
                                <input type="text" name="password">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Login" name="login">
                        </td>
                    </tr>
                </table>
            </fieldset>
         </form>
         <?php
            include('./connection.php');

            if (isset($_POST["login"])) {

                try {
                    $connection = new mysqli($server_name, $username, $password, $database_name);
                    
                    $student_email = $_POST['student_email'];
                    $pass = $_POST['password'];

                    $getEmails = "SELECT users_info.student_email, users_passwords.password
                                    FROM users_info
                                    INNER JOIN users_passwords
                                    ON users_info.student_ID = users_passwords.student_ID";
                    $result = $connection->query($getEmails);
                    
                    while ($email = $result->fetch_assoc()) {
                        if ($student_email == $email['student_email']) {
                            
                            $getPW = "SELECT users_info.student_email, users_passwords.password
                                    FROM users_info
                                    INNER JOIN users_passwords
                                    ON users_info.student_ID = users_passwords.student_ID
                                    WHERE users_info.student_email = ?;";

                            $resultPW = $connection->prepare($getPW);
                            $resultPW->bind_param('s', $student_email);
                            $resultPW->execute();
                            $pw = $resultPW->get_result()->fetch_assoc();

                            if (password_verify($pass, $pw['password'])) {

                                $getID = "SELECT student_ID FROM users_info
                                            WHERE users_info.student_email = ?;";
                                
                                $resultID = $connection->prepare($getID);
                                $resultID->bind_param('s', $student_email);
                                $resultID->execute();
                                $id = $resultID->get_result()->fetch_assoc();      
                                   
                                $_SESSION['student_ID'] = $id['student_ID'];

                                header("Location: http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/index.php");
                            }
                        }
                    }

                } catch (mysqli_sql_exception $e) {
                    $error = $e->getMessage();
                    die("Error: Couldn't connect. " . $error);
                }

            }
        ?>
      </section>
   </main>
</body>
</html>
