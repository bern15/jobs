<?php
include_once('database_connection.php');
// Handle Delete Operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM job WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        showMessage("Job deleted successfully!", "success");
    } else {
        showMessage("Error deleting job: " . $conn->error, "danger");
    }
}
?>