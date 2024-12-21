<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าใช้งาน - เทศบาลอำเภอบ้านโป่ง</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background: #ffffff; padding: 10px 20px; border-bottom: 3px solid #2a7cff; }
        .header img { height: 50px; }
        .user-info { text-align: right; }
        .user-info span { font-weight: bold; color: #2a7cff; margin-right: 10px; }
        .menu { margin: 20px; }
        .menu a { display: block; padding: 10px; margin: 10px 0; color: #fff; background: #2a7cff; text-decoration: none; border-radius: 5px; text-align: center; }
        .menu a:hover { background: #1e60c3; }
    </style>
</head>
<body>

    <div class="header">
        <img src="logo.png" alt="Ban Pong Municipality Logo">
        <div class="user-info">
            <span>ยินดีต้อนรับ, <?= htmlspecialchars($username) ?></span>
            <a href="logout.php">ออกจากระบบ</a>
        </div>
    </div>

    <div class="menu">
        <h1>เมนูหลัก</h1>
        <a href="home.html">หน้าแรก</a>
        <a href="user_appeal_page.html">ร้องทุกข์ / ร้องเรียน</a>
        <a href="report-fraud.html">แจ้งเบาะแสการทุจริตประพฤติมิชอบ</a>
        <a href="track-complaint.html">ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</a>
        
        <?php if ($role === 'admin'): ?>
            <a href="admin_dashboard.html">แผงควบคุมผู้ดูแล</a>
        <?php endif; ?>
    </div>

</body>
</html>