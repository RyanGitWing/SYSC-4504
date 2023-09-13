<!DOCTYPE html>
<html lang="en">
<head >
   <meta charset="utf-8">
   <title>Register on SYSCBOOK</title>
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
         <li><a href="./index.php">Home</a></li>
         <li><a href="./profile.php">Profile</a></li>
         <li><a class="active" href="#">Register</a></li>
         <li><a href="#">Log out</a></li>
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

                    $sql = "INSERT INTO users_info (student_email, first_name, last_name, DOB) VALUES ('".$student_email."','".$first_name."','".$last_name."','".$DOB."');";
                    $connection->query($sql);

                    $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                    $result = $connection->query($getID);
                    $id = $result->fetch_assoc();

                    $sql = "INSERT INTO users_program (student_ID, Program) VALUES (".$id["student_ID"].",'".$Program."');";
                    $connection->query($sql);

                    $sql = "ALTER TABLE users_avatar
                        MODIFY avatar INT(1) NULL;";
                    $connection->query($sql);

                    $sql = "INSERT INTO users_avatar (student_ID) VALUES (".$id["student_ID"].");";
                    $connection->query($sql);

                    $sql = "ALTER TABLE users_address
                        MODIFY street_number INT(5) NULL,
                        MODIFY street_name   VARCHAR(150) NULL,
                        MODIFY city          VARCHAR(30) NULL,
                        MODIFY provence      VARCHAR(2) NULL,
                        MODIFY postal_code   VARCHAR(7) NULL;";
                    $connection->query($sql);

                    $sql = "INSERT INTO users_address (student_ID) VALUES (".$id["student_ID"].");";
                    $connection->query($sql);

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
