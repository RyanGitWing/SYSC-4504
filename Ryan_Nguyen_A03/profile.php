<?php
    session_start();

    if (!isset($_SESSION["student_ID"])) {
        header("Location: http://localhost/SYSC4504_Labs/Ryan_Nguyen_A03/login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head >
   <meta charset="utf-8">
   <title>Update SYSCBOOK profile</title>
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
         <li><a class="active" href="#">Profile</a></li>
         <li><a href="./register.php">Register</a></li>
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
         <h2>Update Profile information</h2>
         <?php
            include('./connection.php');
            try {
                $connection = new mysqli($server_name, $username, $password, $database_name);

                $getID = "SELECT * FROM users_info WHERE student_ID=?;";
                $result = $connection->prepare($getID);
                $result->bind_param('i', $_SESSION['student_ID']);
                $result->execute();
                $id = $result->get_result()->fetch_assoc();

                $getPrg = "SELECT * FROM users_program WHERE student_ID=?";
                $result = $connection->prepare($getPrg);
                $result->bind_param('i', $_SESSION['student_ID']);
                $result->execute();
                $prg = $result->get_result()->fetch_assoc();

                $getAVTR = "SELECT * FROM users_avatar WHERE student_ID=?";
                $result = $connection->prepare($getAVTR);
                $result->bind_param('i', $_SESSION['student_ID']);
                $result->execute();
                $avtr = $result->get_result()->fetch_assoc();

                $getADDR = "SELECT * FROM users_address WHERE student_ID=?";
                $result = $connection->prepare($getADDR);
                $result->bind_param('i', $_SESSION['student_ID']);
                $result->execute();
                $addr = $result->get_result()->fetch_assoc();

            } catch (mysqli_sql_exception $e) {
                $error = $e->getMessage();
                die("Error: Couldn't connect. " . $error);
            }
        ?>
         <form id="profile" method="post" action="">
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
                <legend><span>Address</span></legend>
                <table>
                    <tr>
                        <td colspan="2">
                            <p class="tdInputs">
                                <label>Street Number:</label>
                                <input type="number" min="1" name="street_number">
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Street Name:</label>
                                <input type="text" name="street_name">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>City:</label>
                                <input type="text" name="city">
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Provence:</label>
                                <input type="text" name="provence">
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Postal Code:</label>
                                <input type="text" name="postal_code">
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
                                <label >Program</label>
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
                                <label>Choose your Avatar</label><br>
                                <input type="radio" name="avatar" value="1">
                                <img src="images/img_avatar1.png" alt="img_avatar1">                               
                                <input type="radio" name="avatar" value="2">
                                <img src="images/img_avatar2.png" alt="img_avatar2">                                
                                <input type="radio" name="avatar" value="3">
                                <img src="images/img_avatar3.png" alt="img_avatar3">                                
                                <input type="radio" name="avatar" value="4">
                                <img src="images/img_avatar4.png" alt="img_avata4">                                
                                <input type="radio" name="avatar" value="5">
                                <img src="images/img_avatar5.png" alt="img_avatar5">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit">
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
                    
                    $first_name = $_POST["first_name"];
                    $last_name = $_POST["last_name"];
                    $DOB = $_POST["DOB"];
                    $street_number = $_POST["street_number"];
                    $street_name = $_POST["street_name"];
                    $city = $_POST["city"];           
                    $provence = $_POST["provence"];
                    $postal_code = $_POST["postal_code"];       
                    $student_email = $_POST["student_email"];
                    $Program = $_POST["Program"];
                    $avatar = $_POST["avatar"];

                    // $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                    // $result = $connection->query($getID);
                    // $id = $result->fetch_assoc();

                    $sql = "UPDATE users_info 
                            SET student_email=?, first_name=?, last_name=?, DOB=?
                            WHERE student_ID=?;";
                            $result = $connection->prepare($sql);
                            $result->bind_param('ssssi', $student_email, $first_name, $last_name, $DOB, $_SESSION['student_ID']);
                            $result->execute();

                    $sql = "UPDATE users_avatar 
                            SET avatar=? 
                            WHERE student_ID=?;";
                    $result = $connection->prepare($sql);
                    $result->bind_param('si', $avatar, $_SESSION['student_ID']);
                    $result->execute();

                    $sql = "UPDATE users_program 
                            SET Program=? 
                            WHERE student_ID=?;";
                    $result = $connection->prepare($sql);
                    $result->bind_param('si', $Program, $_SESSION['student_ID']);
                    $result->execute();
                    
                    $sql = "UPDATE users_address 
                            SET street_number=?, street_name=?, city=?, provence=?, postal_code=? 
                            WHERE student_ID=?;";
                    $result = $connection->prepare($sql);
                    $result->bind_param('issssi', $street_number, $street_name, $city, $provence, $postal_code, $_SESSION['student_ID']);
                    $result->execute();

                    $getID = "SELECT * FROM users_info WHERE student_ID=?";
                    $result = $connection->prepare($getID);
                    $result->bind_param('i', $_SESSION['student_ID']);
                    $result->execute();
                    $id = $result->get_result()->fetch_assoc();

                    $getPrg = "SELECT * FROM users_program WHERE student_ID=?";
                    $result = $connection->prepare($getPrg);
                    $result->bind_param('i', $_SESSION['student_ID']);
                    $result->execute();
                    $prg = $result->get_result()->fetch_assoc();

                    $getAVTR = "SELECT * FROM users_avatar WHERE student_ID=?";
                    $result = $connection->prepare($getAVTR);
                    $result->bind_param('i', $_SESSION['student_ID']);
                    $result->execute();
                    $avtr = $result->get_result()->fetch_assoc();

                    $getADDR = "SELECT * FROM users_address WHERE student_ID=?";
                    $result = $connection->prepare($getADDR);
                    $result->bind_param('i', $_SESSION['student_ID']);
                    $result->execute();
                    $addr = $result->get_result()->fetch_assoc();

                } catch (mysqli_sql_exception $e) {
                    $error = $e->getMessage();
                    die("Error: Couldn't connect. " . $error);
                }

            }
        ?>
        <script>
            document.getElementsByName('first_name')[0].value = '<?php echo $id["first_name"]; ?>';
            document.getElementsByName('last_name')[0].value = '<?php echo $id["last_name"]; ?>';
            document.getElementsByName('DOB')[0].value = '<?php echo $id["DOB"]; ?>';
            document.getElementsByName('street_number')[0].value = '<?php echo $addr["street_number"]; ?>';
            document.getElementsByName('street_name')[0].value = '<?php echo $addr["street_name"]; ?>';
            document.getElementsByName('city')[0].value = '<?php echo $addr["city"]; ?>';
            document.getElementsByName('provence')[0].value = '<?php echo $addr["provence"]; ?>';
            document.getElementsByName('postal_code')[0].value = '<?php echo $addr["postal_code"]; ?>';
            document.getElementsByName('student_email')[0].value = '<?php echo $id["student_email"]; ?>';

            document.getElementsByTagName('option')[1].selected = '<?php if($prg['Program'] == 'Computer Systems Engineering'){echo True;}?>';
            document.getElementsByTagName('option')[2].selected = '<?php if($prg['Program'] == 'Software Engineering'){echo True;}?>';
            document.getElementsByTagName('option')[3].selected = '<?php if($prg['Program'] == 'Communications Engineering'){echo True;}?>';
            document.getElementsByTagName('option')[4].selected = '<?php if($prg['Program'] == 'Biomedical and Electrical'){echo True;}?>';
            document.getElementsByTagName('option')[5].selected = '<?php if($prg['Program'] == 'Electrical Engineering'){echo True;}?>';
            document.getElementsByTagName('option')[6].selected = '<?php if($prg['Program'] == 'Special'){echo True;}?>';

            document.getElementsByName('avatar')[0].checked = '<?php if($avtr['avatar'] == '1'){echo("checked");}?>';
            document.getElementsByName('avatar')[1].checked = '<?php if($avtr['avatar'] == '2'){echo("checked");}?>';
            document.getElementsByName('avatar')[2].checked = '<?php if($avtr['avatar'] == '3'){echo("checked");}?>';
            document.getElementsByName('avatar')[3].checked = '<?php if($avtr['avatar'] == '4'){echo("checked");}?>';
            document.getElementsByName('avatar')[4].checked = '<?php if($avtr['avatar'] == '5'){echo("checked");}?>';
        </script>
      </section>
   </main>
</body>
</html>

