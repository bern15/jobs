<?php
include_once('database_connection.php');
// Handle Update Operation
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $department = $_POST['department'];
            $location = $_POST['location'];

            $sql = "UPDATE job SET title='$title', department='$department', location='$location' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                showMessage("Job updated successfully!", "success");
            } else {
                showMessage("Error updating job: " . $conn->error, "danger");
            }
        }
?>