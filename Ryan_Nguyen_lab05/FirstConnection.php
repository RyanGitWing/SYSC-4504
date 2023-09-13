<?php
    include('connection.php');
    try {
        $connection = new mysqli($server_name, $username, $password, $database_name);
        echo "Connected Successfully";
    } catch (mysqli_sql_exception $e) {
        $error = $e->getMessage();
        die("Error: Couldn't connect.". $error);
    }

    // $connection = new mysqli($server_name, $username, $password, $database_name);
    // if ($connection->connect_error) {
    //     die("Error: Couldn't connect." . $connection->connection_error);
    // }
    // echo "Connected Successfully";

?>