<?php
// Start the session to manage login status
session_start();

// Assuming session stores user info after successful login
// Example: $_SESSION['user'] = ['username' => 'sirawit', 'role' => 'admin'];

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username']; // User's name
    $role = $_SESSION['user']['role'];         // Role (admin or user)
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>









<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>หน้าใช้งาน - เทศบาลอำเภอบ้านโป่ง</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/bg.png');
      background-size: cover;
    }
    .header {
      background: #ffffff;
      color: #000;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 5px solid #2a7cff;
      border-radius: 15px;
      width: 90%;
      margin: 20px auto;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .header img {
      height: 100px;
    }
    .user-info {
      display: flex;
      align-items: center;
    }
    .user-info span {
      margin-right: 15px;
      font-weight: bold;
      color: #2a7cff;
    }
    .user-info a {
      color: #fff;
      background-color: #2a7cff;
      padding: 5px 10px;
      text-decoration: none;
      border-radius: 5px;
    }
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px auto;
      width: 60%;
      text-align: center;
    }
    .function-buttons a {
      display: inline-block;
      width: 300px;
      padding: 15px;
      margin: 15px;
      font-size: 18px;
      color: #fff;
      background-color: #2a7cff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .function-buttons a:hover {
      background-color: #1e60c3;
    }
    .footer {
      background-color: #ffffff;
      padding: 25px;
      font-size: 14px;
      color: #666;
      text-align: center;
      position: absolute;
      bottom: 0;
      width: 100%;
    }
    .footer p {
      margin: 5px 0;
    }
  </style>
</head>

<body>

  <div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="user-info">
      <span>ยินดีต้อนรับ, <?= htmlspecialchars($username) ?></span>
      <a href="edit_account.php?username=<?= urlencode($username) ?>">แก้ไขข้อมูลบัญชี</a>
      <a href="logout.php">ออกจากระบบ</a>
    </div>
  </div>

  <div class="container">
    <h1>เมนูหลัก</h1>
    <div class="function-buttons">
      <a href="user_appeal_page.php?username=<?= urlencode($username) ?>">ร้องทุกข์ / ร้องเรียน</a>
      <a href="report-fraud.html">แจ้งเบาะแสการทุจริตประพฤติมิชอบ</a>
      <a href="track-complaint.html">ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</a>
      <?php if ($role === 'admin'): ?>
      <a href="admin_dashboard.html">แผงควบคุมผู้ดูแล</a>
    <?php endif; ?>
    </div>
  </div>

  <div class="footer">
    <p>เทศบาลเมืองบ้านโป่ง BANPONG MUNICIPALITY</p>
    <p>ถนนบ้านดอนตูม จังหวัดราชบุรี 70110</p>
    <p>โทรศัพท์ : 0-3222-1001, 0-3221-1114 | โทรสาร : 0-3222-1975</p>
    <p>Email : admin@banpong.go.th</p>
  </div>

</body>
</html>
