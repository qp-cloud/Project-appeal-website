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
<style>
    body {
        background-image: url('img/adminbg.jpg');
        background-size: cover;
        background-attachment: fixed;
    }
    .header {
        background: #333;
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: center; /* จัดวางข้อความแนวนอนตรงกลาง */
        align-items: center; /* จัดวางข้อความแนวตั้งตรงกลาง */
        border: 5px solid #2a7cff;
        border-radius: 15px;
        width: 90%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center; /* ข้อความภายในอยู่ตรงกลาง */
    }
    .header h1 {
        margin: 0; /* เอา Margin ออกเพื่อจัดตำแหน่งให้พอดี */
    }.table {
        background-color: white;
    }
    .table th,
    .table td {
        background-color: white; /* พื้นหลังของเซลล์ */
    }.table-container {
        max-width: 70%; /* กำหนดความกว้างสูงสุดของตารางเป็น 80% ของหน้าจอ */
        margin: 0 auto; /* จัดตารางให้อยู่ตรงกลาง */
    }
</style>

<body>
    <div class="container mt-5">
        <header class="header">
            <h1>แผงควบคุมผู้ดูแลระบบ - การส่งแบบฟอร์มการติดต่อ</h1>
        </header>
    </div>


        <?php
        // Display any session message
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <!-- Table to display contact form data -->
        <div class="table-responsive table-container">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>วันเวลาที่ส่งการติดต่อ</th>
                        <th>ชื่อผู้ติดต่อ</th>
                        <th>อีเมลของผู้ติดต่อ</th>
                        <th>เบอร์โทรศัพท์ของผู้ติดต่อ</th>
                        <th>ข้อความ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['submitted_at']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['message']}</td>
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
            <a href="admin_page.php" class="btn btn-primary">ย้อนกลับ</a>
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
