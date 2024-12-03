<?php
// ตรวจสอบสถานะที่ส่งมาทาง query string
$status = isset($_GET['status']) ? $_GET['status'] : '';

// ตรวจสอบว่ามีการลบสำเร็จหรือไม่
if ($status !== 'deleted') {
    header("Location: login.php"); // ถ้าไม่มี status ที่ถูกต้อง ให้เปลี่ยนเส้นทางไปหน้า login
    exit();
}

session_start();
session_destroy(); // ทำลาย session เพื่อออกจากระบบ
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ลบบัญชีสำเร็จ</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      text-align: center;
      padding: 50px;
    }
    .message-container {
      background-color: #ffffff;
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #ff6666;
    }
    p {
      color: #555;
      font-size: 18px;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #2a7cff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="message-container">
    <h1>บัญชีของคุณถูกลบเรียบร้อยแล้ว</h1>
    <p>ขอขอบคุณที่ใช้บริการของเรา หากต้องการสมัครสมาชิกใหม่ คุณสามารถกลับไปยังหน้าหลักได้</p>
    <a href="index.php">กลับสู่หน้าหลัก</a>
  </div>
</body>
</html>
