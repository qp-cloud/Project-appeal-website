<?php
// Start the session to manage login status
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username']; // User's username
    $role = $_SESSION['user']['role'];         // Role (admin or user)
    
    // Check the user's role
    if ($role === 'admin') {
        echo "Welcome, $username! You are logged in as an administrator.";
        // Add admin-specific functionality here
    } elseif ($role === 'user') {
        echo "Welcome, $username! You are logged in as a regular user.";
        // Add user-specific functionality here
    } else {
        echo "Access denied. Unknown role.";
        exit();
    }
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
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/bg.png');
      background-size: cover;
      background-attachment: fixed;
      color: #333;
    }
    /* Header Style */
    .header {
      background: #ffffff;
      color: #000;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 5px solid #2a7cff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .header img {
      height: 80px;
    }
    .header-nav a {
      color: #000;
      font-weight: bold;
      text-decoration: none;
      margin: 0 10px;
      padding: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .header-nav a:hover {
      color: #fff;
      background-color: #2a7cff;
    }

    /* User Info */
    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .user-info span {
      font-weight: bold;
      color: #2a7cff;
    }
    .user-info a {
      color: #fff;
      background-color: #2a7cff;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }
    .user-info a:hover {
      background-color: #1e60c3;
    }

    /* Main Content */
    .container {
      max-width: 960px;
      margin: 50px auto;
      text-align: center;
      padding: 30px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .container h1 {
      font-size: 36px;
      color: #2a7cff;
      margin-bottom: 30px;
    }
    .function-buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    .function-buttons a {
      display: inline-block;
      width: 280px;
      padding: 20px;
      margin: 15px;
      font-size: 20px;
      font-weight: bold;
      color: #fff;
      background-color: #2a7cff;
      text-decoration: none;
      border-radius: 12px;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .function-buttons a:hover {
      background-color: #1e60c3;
      transform: scale(1.05);
    }
    .footer {
      background-color: #f9f9f9;
      padding: 25px;
      font-size: 14px;
      color: #666;
      text-align: center;
      border-top: 1px solid #ddd;
    }
    .footer p {
      margin: 5px 0;
    }
    .footer a {
      color: #2a7cff;
      text-decoration: none;
      font-weight: bold;
    }
    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Header Section -->
  <div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="user-info">
      <span>ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user']['first_name']) ?> <?= htmlspecialchars($_SESSION['user']['last_name']) ?></span>
      <a href="edit_account.php?username=<?= urlencode($username) ?>">แก้ไขข้อมูลบัญชี</a>
      <a href="logout.php">ออกจากระบบ</a>
    </div>
  </div>

  <!-- Main Menu Section -->
  <div class="container">
    <h1>เมนูหลัก</h1>
    <div class="function-buttons">
      <a href="user_appeal_page.php?username=<?= urlencode($username) ?>">ร้องทุกข์ / ร้องเรียน</a>
      <a href="report-fraud.html">แจ้งเบาะแสการทุจริตประพฤติมิชอบ</a>
      <?php if (isset($_SESSION['user']['user_id'])): ?>
        <a href="complaint_tracking.php?user_id=<?= urlencode($_SESSION['user']['user_id']) ?>">ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</a>
      <?php else: ?>
        <p style="color: red;">กรุณาเข้าสู่ระบบเพื่อใช้งานเมนูนี้</p>
      <?php endif; ?>
      <?php if ($role === 'admin'): ?>
        <a href="admin_dashboard.php?user_id=<?= urlencode($_SESSION['user']['user_id']) ?>">ส่วนงานของเจ้าหน้าที่</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer Section -->
  <div class="footer">
    <p>เทศบาลเมืองบ้านโป่ง BANPONG MUNICIPALITY</p>
    <p>ถนนบ้านดอนตูม จังหวัดราชบุรี 70110</p>
    <p>โทรศัพท์ : 0-3222-1001, 0-3221-1114 | โทรสาร : 0-3222-1975</p>
    <p>Email : <a href="mailto:admin@banpong.go.th">admin@banpong.go.th</a></p>
  </div>

</body>
</html>
