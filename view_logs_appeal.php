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

// Query the appeals table to retrieve the required data
$sql = "SELECT 
            logs.id, 
            logs.complaint_id,
            appeals.report_subject, 
            appeals.category, -- Fetch the title from the appeals table
            logs.old_status, 
            logs.new_status, 
            logs.changed_at, 
            CONCAT(user.first_name, ' ', user.last_name) AS changed_by,
            user.department AS admin_department -- Fetch admin's department
        FROM status_change_logs AS logs
        JOIN user ON logs.changed_by = user.user_id
        JOIN appeals ON logs.complaint_id = appeals.id -- Join with appeals table
        ORDER BY logs.changed_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการยื่นคำร้อง</title>
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
        .old_status {
            background-color:rgba(214, 153, 118, 0.74);
        }
        .new_status {
            background-color:rgba(133, 230, 157, 0.77);
        }
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header d-flex justify-content-between align-items-center">
            <h2>ประวัติการเปลี่ยนสถานะเรื่องการแจ้งเบาะแสการทุจริต</h2>
            <!-- Go Back Button -->
            <a href="#" class="btn btn-back" onclick="goBack()">ย้อนกลับ</a>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>วันที่เปลี่ยน</th>
                        <th>ชื่อเรื่องการแจ้งเบาะแส</th>
                        <th>หมวดหมู่การแจ้งเบาะแส</th>
                        <th class="old_status">สถานะเดิม</th>
                        <th class="new_status">สถานะใหม่</th>
                        <th>เปลี่ยนโดย</th>
                        <th>หน่วยงาน</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['changed_at']) ?></td>
                                <td><?= htmlspecialchars($row['report_subject']) ?></td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td class="old_status"><?= htmlspecialchars($row['old_status']) ?></td>
                                <td class="new_status"><?= htmlspecialchars($row['new_status']) ?></td>
                                <td><?= htmlspecialchars($row['changed_by']) ?></td>
                                <td><?= htmlspecialchars($row['admin_department']) ?></td>
                                <td>
                                    <a href="detailappeal_logs.php?id=<?= urlencode($row['complaint_id']) ?>" class="btn btn-info">รายละเอียดเรื่อง</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลคำร้อง</td>
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
