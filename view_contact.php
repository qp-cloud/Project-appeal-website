<?php
// Start the session for potential login check or error handling
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_appeal_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all contact form submissions
$sql = "SELECT id, name, email, phone, message, submitted_at FROM contact_table ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Form Submissions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>แผงควบคุมผู้ดูแลระบบ - การส่งแบบฟอร์มการติดต่อ</h1>
        </header>

        <?php
        // Display any session message
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <!-- Table to display contact form data -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['message']}</td>
                                    <td>{$row['submitted_at']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No submissions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <a href="admin_page.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
        
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
