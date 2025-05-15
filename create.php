<?php
include_once('database_connection.php');
// Handle Create Operation
        if (isset($_POST['create'])) {
            $title = $_POST['title'];
            $department = $_POST['department'];
            $location = $_POST['location'];

            $sql = "INSERT INTO job (title, department, location) VALUES ('$title', '$department', '$location')";
            if ($conn->query($sql) === TRUE) {
                showMessage("Job created successfully!", "success");
            } else {
                showMessage("Error creating job: " . $conn->error, "danger");
            }
        }
?>