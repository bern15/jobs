<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for the message box */
        #message-box {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f0fdf4;
            color: #15803d;
            padding: 16px;
            border-radius: 6px;
            border: 1px solid #16a34a;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }
        #message-box.show {
            display: block;
        }
    </style>
</head>
<body class="bg-light font-inter">
    <div class="container mt-5">
        <h1 class="text-3xl font-semibold text-primary text-center mb-5">Admin Panel Job Listings</h1>

        <div id="message-box" class="alert alert-success" role="alert" style="display: none;">
            <p id="message-text"></p>
        </div>

        <?php
        include_once('database_connection.php');
        include_once('create.php');
        include_once('update.php');
        include_once('delete.php');

        // Function to display messages
        function showMessage($message, $type = 'success') {
            echo "<script>
                const messageBox = document.getElementById('message-box');
                const messageText = document.getElementById('message-text');
                messageText.textContent = '$message';
                messageBox.className = `alert alert-${type}`;
                messageBox.style.display = 'block';
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 3000);
            </script>";
        }

        // Select all jobs from the jobs table
        $sql = "SELECT id, title, department, location FROM job";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row in a table format
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover shadow-sm rounded-lg'>";
            echo "<thead class='thead-light'>";
            echo "<tr>";
            echo "<th scope='col'>Title</th>";
            echo "<th scope='col'>Department</th>";
            echo "<th scope='col'>Location</th>";
            echo "<th scope='col'>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='font-semibold text-primary'>" . $row["title"] . "</td>";
                echo "<td>" . $row["department"] . "</td>";
                echo "<td class='font-medium text-success'>" . $row["location"] . "</td>";
                echo "<td>
                        <button class='btn btn-primary btn-sm me-2' onclick='openModal(\"updateModal\", ".$row["id"].", \"".$row["title"]."\", \"".$row["department"]."\", \"".$row["location"]."\")'>Edit</button>
                        <a href='index.php?delete=".$row["id"]."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this job listing?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>
                <p class='font-bold'>No jobs found!</p>
                <p>There are currently no job listings available.</p>
                </div>";
        }

        // Close connection
        $conn->close();
        ?>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create New Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="index.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="create">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Edit Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="index.php">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="update_id" name="id">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="update_title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="update_department" name="department" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="update_location" name="location" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                Create New Job
            </button>
        </div>
    </div>

    <script>
        function showMessage(message, type = 'success') {
            const messageBox = document.getElementById('message-box');
            const messageText = document.getElementById('message-text');
            messageText.textContent = message;
            messageBox.className = `alert alert-${type}`;
            messageBox.style.display = 'block';
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 3000);
        }

        function openModal(modalId, id, title, department, location) {
            if (modalId === "updateModal") {
                document.getElementById("update_id").value = id;
                document.getElementById("update_title").value = title;
                document.getElementById("update_department").value = department;
                document.getElementById("update_location").value = location;
            }
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
