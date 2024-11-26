<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banpong_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับ ID เรื่องร้องเรียนจาก URL
$complaint_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลรายละเอียดเรื่องร้องเรียน
$sql = "SELECT * FROM complaints WHERE id = $complaint_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $complaint = $result->fetch_assoc();
} else {
    die("ไม่พบข้อมูลเรื่องร้องเรียน");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>รายละเอียดเรื่องร้องเรียน</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }
    .header {
      background-color: #2a7cff;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    .container {
      margin: 20px auto;
      width: 80%;
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .details {
      margin: 20px 0;
    }
    .details h2 {
      color: #2a7cff;
    }
    .footer {
      text-align: center;
      padding: 20px;
      background-color: #2a7cff;
      color: #fff;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>รายละเอียดเรื่องร้องเรียน</h1>
  </div>

  <div class="container">
    <h2>เรื่อง: <?= htmlspecialchars($complaint['title']) ?></h2>
    <div class="details">
      <p><strong>สถานะ:</strong> <?= htmlspecialchars($complaint['status']) ?></p>
      <p><strong>วันที่ร้องเรียน:</strong> <?= htmlspecialchars($complaint['created_at']) ?></p>
      <p><strong>รายละเอียด:</strong></p>
      <p><?= nl2br(htmlspecialchars($complaint['description'])) ?></p>
    </div>
    <a href="track_complaint.php?username=<?= urlencode($complaint['username']) ?>" style="color: #fff; background-color: #2a7cff; padding: 10px 15px; text-decoration: none; border-radius: 5px;">ย้อนกลับ</a>
  </div>

  <div class="footer">
    <p>เทศบาลเมืองบ้านโป่ง BANPONG MUNICIPALITY</p>
  </div>

  <?php $conn->close(); ?>
</body>
</html>
