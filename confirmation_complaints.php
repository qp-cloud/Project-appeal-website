<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_appeal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['user_id'])) {
    echo "User not found!";
    exit();
}

$user_id = $_GET['user_id'];

// Fetch the user's complaint data
$sql = "SELECT * FROM complaints WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $complaint = $result->fetch_assoc();
} else {
    echo "No complaint data found!";
    exit();
}

// Fetch the user's first name and last name from the users table
$sql_user = "SELECT first_name, last_name FROM user WHERE user_id = '$user_id'";
$result_user = $conn->query($sql_user);
$first_name = '';
$last_name = '';

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $first_name = $user['first_name'];  // Store first name
    $last_name = $user['last_name'];    // Store last name
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการส่งข้อมูล</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .confirmation-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            padding: 30px;
            max-width: 800px;
            font-size: 1.1rem;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
            font-size: 2rem;
        }
        .btn-container {
    display: flex;
    flex-direction: column; /* Stack buttons vertically */
    gap: 10px;
    margin-top: 30px;
}

.btn-container button {
    width: 100%; /* Make buttons take up the full width */
}
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-secondary {
            background-color: #f1f1f1;
            border-color: #ccc;
            color: #333;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .complaint-info {
            margin-bottom: 20px;
        }
        .complaint-info p {
            margin: 10px 0;
            line-height: 1.6;
        }
        .complaint-info strong {
            color: #333;
        }
        .file-link a {
            color: #007bff;
            text-decoration: none;
        }
        .file-link a:hover {
            text-decoration: underline;
        }
        .section-header {
            font-size: 1.2rem;
            margin-top: 20px;
            color: #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 5px;
        }
        .confirmation-container p {
            font-size: 1.1rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container confirmation-container">
        <h2>ยืนยันการส่งข้อมูล</h2>
        <div class="complaint-info">
            <p><strong>ชื่อผู้ใช้:</strong> <?= htmlspecialchars($first_name) ?> <?= htmlspecialchars($last_name) ?></p>
            <p><strong>เรื่องที่ต้องการร้องทุกข์:</strong> <?= htmlspecialchars($complaint['complaint_subject']) ?></p>
            <p><strong>รายละเอียดการร้องเรียน:</strong> <?= nl2br(htmlspecialchars($complaint['complaint_description'])) ?></p>
            <p><strong>ข้อมูลช่องทางการติดต่อ:</strong> <?= htmlspecialchars($complaint['contact_phone']) ?></p>
            <p><strong>สถานที่:</strong> <?= htmlspecialchars($complaint['contact_location']) ?></p>
            <p><strong>รายละเอียดสถานที่:</strong> <?= nl2br(htmlspecialchars($complaint['contact_details'])) ?></p>
            <p><strong>พิกัด (ละติจูด):</strong> <?= htmlspecialchars($complaint['latitude']) ?></p>
            <p><strong>พิกัด (ลองจิจูด):</strong> <?= htmlspecialchars($complaint['longitude']) ?></p>
            <p><strong>เวลาที่เกิดเหตุหรือพบเหตุ:</strong> <?= htmlspecialchars($complaint['incident_date']) ?> <?= htmlspecialchars($complaint['incident_time']) ?></p>
            <p><strong>ระดับปัญหา:</strong> <?= htmlspecialchars($complaint['problem_level']) ?></p>
            <p><strong>หน่วยงานที่รับผิดชอบ:</strong> <?= htmlspecialchars($complaint['department']) ?></p>
            <p><strong>วันที่และเวลาที่รายงาน:</strong> <?= htmlspecialchars($complaint['submitted_at']) ?></p>
            <div class="section-header">ไฟล์ที่แนบ</div>
            <p><?= $complaint['complaint_file'] ? "<a href='" . htmlspecialchars($complaint['complaint_file']) . "'>ดาวน์โหลดไฟล์</a>" : "ไม่มีไฟล์" ?></p>

            <div class="section-header">ลิงก์คลิปวิดีโอแนบ</div>
            <p><?= $complaint['video_link'] ? "<a href='" . htmlspecialchars($complaint['video_link']) . "'>ดูคลิปวิดีโอ</a>" : "ไม่มีลิงก์" ?></p>
        </div>

        <div class="btn-container">
            <form action="confirmation_success_complaints.php?user_id=<?= $user_id ?>" method="POST">
                <button type="submit" name="submit" class="btn btn-primary">ยืนยัน</button>
            </form>
            <button type="button" id="cancelButton" class="btn btn-secondary" onclick="handleCancel()">ยกเลิก</button>
        </div>
    </div>

    <script>
        function handleCancel() {
            if (confirm("คุณต้องการยกเลิกการกระทำนี้และกลับไป?")) {
                window.history.go(-1); // Navigate back
            }
        }
    </script>
</body>
</html>
