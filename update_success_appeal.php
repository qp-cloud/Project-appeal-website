<?php
// Start session to check authentication if needed
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัปเดตสำเร็จ</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            text-align: center;
        }
        .message {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h2>สถานะการร้องเรียนได้รับการอัปเดตสำเร็จ!</h2>
            <a href="admin_dashboard_appeal.php" class="btn btn-primary">กลับไปยังแผงควบคุม</a>
        </div>
    </div>
</body>
</html>
