<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "hr";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger' role='alert'>
        <strong>Connection Error!</strong> Failed to connect to the database: " . $conn->connect_error . "
        </div>");
}
?>
