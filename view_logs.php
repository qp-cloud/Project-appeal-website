<?php
// Start session for user authentication
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']['user_id']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");  // Redirect to login page if not an admin
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "web_appeal_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the logs
$sql = "SELECT 
            logs.id, 
            logs.complaint_id, 
            logs.old_status, 
            logs.new_status, 
            logs.changed_at, 
            CONCAT(user.first_name, ' ', user.last_name) AS changed_by,
            user.department AS admin_department -- Fetch admin's department
        FROM status_change_logs AS logs
        JOIN user ON logs.changed_by = user.user_id
        ORDER BY logs.changed_at DESC";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการเปลี่ยนสถานะ</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .header {
            background-color: #2a7cff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header h2 {
            font-weight: bold;
            font-size: 36px;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .table {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header d-flex justify-content-between align-items-center">
            <h2>ประวัติการเปลี่ยนสถานะ</h2>
            <!-- Go Back Button -->
            <a href="#" class="btn btn-back" onclick="goBack()">ย้อนกลับ</a>


        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>รหัสร้องเรียน</th>
                        <th>สถานะเดิม</th>
                        <th>สถานะใหม่</th>
                        <th>เปลี่ยนโดย</th>
                        <th>หน่วยงาน</th>
                        <th>วันที่เปลี่ยน</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['complaint_id']) ?></td>
                                <td><?= htmlspecialchars($row['old_status']) ?></td>
                                <td><?= htmlspecialchars($row['new_status']) ?></td>
                                <td><?= htmlspecialchars($row['changed_by']) ?></td>
                                <td><?= htmlspecialchars($row['admin_department']) ?></td>
                                <td><?= htmlspecialchars($row['changed_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลการเปลี่ยนสถานะ</td>
                            <td colspan="7" class="text-center">ไม่มีข้อมูลการเปลี่ยนสถานะ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function goBack() {
        window.history.back(); // Goes to the previous page in the history
    }
</script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
