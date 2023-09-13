<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head >
   <meta charset="utf-8">
   <title>Register on SYSCBOOK</title>
   <link rel="stylesheet" href="assets/css/reset.css" />
   <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <?php
        echo '<script>
                if (window.confirm("Already have an account? Go to login?")) { 
                    window.location.href="http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/login.php";
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
         <li><a class="active" href="#">Register</a></li>
         <?php
            echo "<li><a href='./user_list.php'>User List</a></li>";

            if (!isset($_SESSION['student_ID'])) {
               echo "<li><a href='./login.php'>Login</a></li>";
            } else {
               echo "<li><a href='./login.php'>Log out</a></li>";
            }
         ?>
     </ul>
   </nav>

   <main>
      <section>
         <h2>Register a new profile</h2>
         <form id="reg" method="post" action="">
            <fieldset>
                <legend><span>Personal information</span></legend>
                <table>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>First Name:</label>
                                <input type="text" name="first_name">
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Last Name:</label>
                                <input type="text" name="last_name">
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>DOB:</label>
                                <input type="date" name="DOB">
                            </p>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><span>Profile Information</span></legend>
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
                                <label>Program</label>
                                <select name="Program">
                                    <option>Choose Program</option>
                                    <option>Computer Systems Engineering</option>
                                    <option>Software Engineering</option>
                                    <option>Communications Engineering</option>
                                    <option>Biomedical and Electrical</option>
                                    <option>Electrical Engineering</option>
                                    <option>Special</option>
                                </select>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label id='pw'>Password:</label>
                                <input type="text" name="password">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>Confirm Password:</label>
                                <input type="text" name="confirm_password" onchange="checkPW()">
                            </p>
                        </td>
                    </tr>
                    <script type='text/javascript'>
                        function checkPW() {
                            pass = document.getElementsByName('password')[0].value;
                            conf = document.getElementsByName('confirm_password')[0].value;
                            if (conf != pass) {
                                document.getElementById('pw').innerHTML = "Password: Passwords do not match";
                            } else {
                                document.getElementById('pw').innerHTML = "Password:";
                            }
                        }
                    </script>
                    <tr>
                        <td>
                            <input type="submit" value="Register" name="register">
                            <input type="reset">
                        </td>
                    </tr>
                </table>
            </fieldset>
         </form>
         <?php
            include('./connection.php');

            if (isset($_POST["register"])) {

                try {
                    $connection = new mysqli($server_name, $username, $password, $database_name);
                    
                    $first_name = $_POST["first_name"];
                    $last_name = $_POST["last_name"];
                    $DOB = $_POST["DOB"];                    
                    $student_email = $_POST["student_email"];
                    $Program = $_POST["Program"];
                    $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);
                    $flag = TRUE;

                    $getEmails = "SELECT * FROM users_info";
                    $result = $connection->query($getEmails);

                    while ($email = $result->fetch_assoc()) {
                        if ($student_email == $email['student_email']) {
                            $flag = FALSE;
                            break;
                        }
                    }

                    if ($flag) {
                        $sql = "INSERT INTO users_info (student_email, first_name, last_name, DOB) VALUES (?,?,?,?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('ssss', $student_email, $first_name, $last_name, $DOB);
                        $result->execute();

                        $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                        $result = $connection->query($getID);
                        $id = $result->fetch_assoc();

                        $sql = "INSERT INTO users_program (student_ID, Program) VALUES (?,?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('is', $id["student_ID"], $Program);
                        $result->execute();

                        // $sql = "ALTER TABLE users_avatar
                        //     MODIFY avatar INT(1) NULL;";
                        // $connection->query($sql);

                        $sql = "INSERT INTO users_avatar (student_ID) VALUES (?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('i', $id["student_ID"]);
                        $result->execute();

                        // $sql = "ALTER TABLE users_address
                        //     MODIFY street_number INT(5) NULL,
                        //     MODIFY street_name   VARCHAR(150) NULL,
                        //     MODIFY city          VARCHAR(30) NULL,
                        //     MODIFY provence      VARCHAR(2) NULL,
                        //     MODIFY postal_code   VARCHAR(7) NULL;";
                        // $connection->query($sql);

                        $sql = "INSERT INTO users_address (student_ID) VALUES (?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('i', $id["student_ID"]);
                        $result->execute();

                        $sql = "INSERT INTO users_passwords (student_ID, password) VALUES (?,?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('is', $id["student_ID"], $pass);
                        $result->execute();

                        $sql = "INSERT INTO users_permissions (student_ID) VALUES (?);";
                        $result = $connection->prepare($sql);
                        $result->bind_param('i', $id["student_ID"]);
                        $result->execute();
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