<!DOCTYPE html>
<html>
	<body>
	<form method="POST" action="">
		<fieldset>
		<legend>Add student information</legend>
			<label>ID: </label><input type="number" name="ID"><br>
			<label>NAME: </label><input type="text" name="NAME"><br>
			<label>DOB: </label><input type="date" name="DOB"><br>	
			<label>COURSE ID: </label><input type="number" name="COURSE_ID"><br>
            <label>INCOME: </label><input type="text" name="INCOME"><br>
			<input type="submit" name="submit" value="Submit Query">
		</fieldset>
	</form>
	</body>
</html>

<?php
    include('connection.php');
    if (isset($_POST["submit"])) {
        try {
            $connection = new mysqli($server_name, $username, $password, $database_name);
            echo "Connected Successfully <br/>";
                $id = $_POST["ID"];
                $name = $_POST["NAME"];
                $dob = $_POST["DOB"];
                $income = $_POST["INCOME"];
                $course_id = $_POST["COURSE_ID"];

                $sql = "INSERT INTO STUDENT_INFO VALUES (".$id.",'".$name."','".$dob."',".$income.",".$course_id.");";
                $connection->query($sql);
                $sql = "SELECT * FROM STUDENT_INFO WHERE ID=".$_POST["ID"].";";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();

                echo "<h1>Course record created successfully!!!</h1>";
                echo "<p><strong>ID: </strong>".$row["ID"]."</p>";
                echo "<p><strong>NAME: </strong>".$row["NAME"]."</p>";
                echo "<p><strong>DOB: </strong>".$row["DOB"]."</p>";
                echo "<p><strong>COURSE ID: </strong>".$row["COURSE_ID"]."</p>";
                echo "<p><strong>INCOME: </strong>".$row["INCOME"]."</p>";

                $result->free_result();
                $connection->close();
            
        } catch (mysqli_sql_exception $e) {
            $error = $e->getMessage();
            die("Error: Couldn't connect. ". $error);
        }
    } else {

    }
?>