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
         <li><a href="#">Log out</a></li>
     </ul>
   </nav>
   <main>
      <section>
         <h2>Update Profile information</h2>
         <?php
            include('./connection.php');
            try {
                $connection = new mysqli($server_name, $username, $password, $database_name);

                $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                $result = $connection->query($getID);
                $id = $result->fetch_assoc();

                $getPrg = "SELECT * FROM users_program WHERE student_ID=(SELECT max(student_ID) FROM users_program)";
                $result = $connection->query($getPrg);
                $prg = $result->fetch_assoc();

                $getAVTR = "SELECT * FROM users_avatar WHERE student_ID=(SELECT max(student_ID) FROM users_avatar)";
                $result = $connection->query($getAVTR);
                $avtr = $result->fetch_assoc();

                $getADDR = "SELECT * FROM users_address WHERE student_ID=(SELECT max(student_ID) FROM users_address)";
                $result = $connection->query($getADDR);
                $addr = $result->fetch_assoc();

            } catch (mysqli_sql_exception $e) {
                $error = $e->getMessage();
                die("Error: Couldn't connect. " . $error);
            }
        ?>
         <form id="profile" method="post" action="./profile.php">
            <fieldset>
                <legend><span>Personal information</span></legend>
                <table>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>First Name:</label>
                                <?php
                                    echo "<input type=text name=first_name value='".$id["first_name"]."'>";
                                ?>
                                <!-- <input type="text" name="first_name"> -->
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Last Name:</label>
                                <?php
                                    echo "<input type=text name=last_name value='".$id["last_name"]."'>";
                                ?>
                                <!-- <input type="text" name="last_name"> -->
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>DOB:</label>
                                <?php
                                    echo "<input type=date name=DOB value='".$id["DOB"]."'>";
                                ?>
                                <!-- <input type="date" name="DOB"> -->
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
                                <?php
                                    echo "<input type=number min=1 name=street_number value='".$addr["street_number"]."'>";
                                ?>
                                <!-- <input type="number" min="1" name="street_number"> -->
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Street Name:</label>
                                <?php
                                    echo "<input type=text name=street_name value='".$addr["street_name"]."'>";
                                ?>
                                <!-- <input type="text" name="street_name"> -->
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>City:</label>
                                <?php
                                    echo "<input type=text name=city value='".$addr["city"]."'>";
                                ?>
                                <!-- <input type="text" name="city"> -->
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Provence:</label>
                                <?php
                                    echo "<input type=text name=provence value='".$addr["provence"]."'>";
                                ?>
                                <!-- <input type="text" name="provence"> -->
                            </p>
                        </td>
                        <td>
                            <p class="tdInputs">
                                <label>Postal Code:</label>
                                <?php
                                    echo "<input type=text name=postal_code value='".$addr["postal_code"]."'>";
                                ?>
                                <!-- <input type="text" name="postal_code"> -->
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
                                <?php
                                    echo "<input type=email name=student_email value='".$id["student_email"]."'>";
                                ?>
                                <!-- <input type="email" name="student_email"> -->
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label >Program</label>
                                <select name="Program">
                                    <option>Choose Program</option>
                                    <option <?php if($prg['Program'] == 'Computer Systems Engineering'){echo("selected");}?> >Computer Systems Engineering</option>
                                    <option <?php if($prg['Program'] == 'Software Engineering'){echo("selected");}?> >Software Engineering</option>
                                    <option <?php if($prg['Program'] == 'Communications Engineering'){echo("selected");}?> >Communications Engineering</option>
                                    <option <?php if($prg['Program'] == 'Biomedical and Electrical'){echo("selected");}?> >Biomedical and Electrical</option>
                                    <option <?php if($prg['Program'] == 'Electrical Engineering'){echo("selected");}?> >Electrical Engineering</option>
                                    <option <?php if($prg['Program'] == 'Special'){echo("selected");}?> >Special</option>
                                </select>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="tdInputs">
                                <label>Choose your Avatar</label><br>
                                <input type="radio" name="avatar" value="1" <?php if($avtr['avatar'] == '1'){echo("checked");}?> >
                                <img src="images/img_avatar1.png" alt="img_avatar1">                               
                                <input type="radio" name="avatar" value="2" <?php if($avtr['avatar'] == '2'){echo("checked");}?> >
                                <img src="images/img_avatar2.png" alt="img_avatar2">                                
                                <input type="radio" name="avatar" value="3" <?php if($avtr['avatar'] == '3'){echo("checked");}?> >
                                <img src="images/img_avatar3.png" alt="img_avatar3">                                
                                <input type="radio" name="avatar" value="4" <?php if($avtr['avatar'] == '4'){echo("checked");}?> >
                                <img src="images/img_avatar4.png" alt="img_avata4">                                
                                <input type="radio" name="avatar" value="5" <?php if($avtr['avatar'] == '5'){echo("checked");}?> >
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

                    $getID = "SELECT * FROM users_info WHERE student_ID=(SELECT max(student_ID) FROM users_info)";
                    $result = $connection->query($getID);
                    $id = $result->fetch_assoc();

                    $sql = "UPDATE users_info 
                            SET student_email='".$student_email."', first_name='".$first_name."', last_name='".$last_name."', DOB='".$DOB."' 
                            WHERE student_ID=".$id["student_ID"].";";
                    $connection->query($sql);

                    $sql = "UPDATE users_avatar 
                            SET avatar='".$avatar."' 
                            WHERE student_ID=".$id["student_ID"].";";
                    $connection->query($sql);

                    $sql = "UPDATE users_program 
                            SET Program='".$Program."' 
                            WHERE student_ID=".$id["student_ID"].";";
                    $connection->query($sql);

                    $sql = "UPDATE users_address 
                            SET street_number=".$street_number.", street_name='".$street_name."', city='".$city."', provence='".$provence."', postal_code='".$postal_code."' 
                            WHERE student_ID=".$id["student_ID"].";";
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

