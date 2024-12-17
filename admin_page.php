<?php
// Start the session to manage login status
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username']; // User's username
    $role = $_SESSION['user']['role'];         // Role (admin or user)
    $department = $_SESSION['user']['department']; 
    
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

// Database connection
$servername = "localhost";
$username_db = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "web_appeal_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username_db, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of complaints and appeals with the status "ยังไม่ดำเนินการ"
$sql = "
    SELECT source, status, problem_level, COUNT(*) AS count
    FROM (
        SELECT 'ร้องทุกข์' AS source, status, problem_level FROM complaints WHERE status = 'ยังไม่ดำเนินการ'
        UNION ALL
        SELECT 'การทุจริตประพฤติมิชอบ' AS source, status, problem_level FROM appeals WHERE status = 'ยังไม่ดำเนินการ'
    ) AS all_data
    GROUP BY source, status, problem_level
    ORDER BY source, problem_level";
$result = $conn->query($sql);

// Fetch the counts into an array
$counts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $counts[] = $row;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ส่วนของเจ้าหน้าที่ - เทศบาลอำเภอบ้านโป่ง</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/adminbg.jpg');
      background-size: cover;
      background-attachment: fixed;
    }
    .header {
      background: #333;
      color: #fff;
      padding: 15px 30px;
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
      height: 80px;
    }
    .header-nav a {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 5px;
      transition: color 0.3s ease, background-color 0.3s ease;
    }
    .header-nav a:hover {
      color: #fff;
      background-color: #2a7cff;
    }
    .header-nav a:last-child {
      color: #2a7cff;
      background-color: #fff;
      padding: 5px 15px;
      border: 1px solid #2a7cff;
      border-radius: 5px;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 100px 20px;
      color: #333;
      height: 80vh;
    }
    .title {
      font-size: 48px;
      font-weight: bold;
      margin-bottom: 20px;
      color:rgb(172, 27, 143);
      background-color:rgba(4, 4, 4, 0.19);
      text-align: center;
    }
    .slogan {
      font-size: 32px;
      line-height: 1.6;
      margin: 20px 0;
      color: #020202;
      text-align: center;
    }
    .slogan .highlight-blue {
      color: #0011ff;
      font-weight: bold;
      font-size: 36px;
    }
    .button-container {
      margin-top: 30px;
      text-align: center;
    }
    .button-container a {
      display: inline-block;
      width: 250px;
      padding: 15px 0;
      margin: 10px 0;
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      border-radius: 8px;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .button-container a:hover {
      transform: scale(1.05);
    }
    .button-dashboard {
      background-color: #2a7cff;
    }
    .button-dashboard:hover {
      background-color: #0056b3;
    }
    .button-manage {
      background-color: #ff5722; /* A contrasting color (Orange) */
    }
    .button-manage:hover {
      background-color: #e64a19;
    }
    .button-contact {
      background-color: #ff3122; /* A contrasting color (Orange) */
    }
    .button-contact:hover {
      background-color: #e64a19;
    }
    .footer {
      background-color: #333;
      padding: 25px;
      font-size: 16px;
      color: #fff;
      text-align: center;
      box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }
    .footer p {
      margin: 15px 0;
    }
    .footer a {
      color: #fff;
      text-decoration: none;
    }
    .footer a:hover {
      text-decoration: underline;
    }

    /* Style for the dropdown menu */
    /* Style for the dropdown menu */
.dropdown {
  position: relative;
  display: inline-block;
  margin: 10px;
}

.dropbtn {
  background-color: #2a7cff;
  color: white;
  padding: 12px 20px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s ease, transform 0.2s ease;
  text-align: center;
  width: 100%;
}

.dropbtn:hover {
  background-color: #0056b3;
  transform: scale(1.05);
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 300px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  z-index: 1;
  border-radius: 5px;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  font-size: 16px;
  background-color: #ffffff;
  border-bottom: 1px solid #ddd;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.dropdown-content a:hover {
  background-color: #f1f1f1;
  cursor: pointer;
}

/* Optional: Adjust dropdown menu arrow */
.dropdown-content:before {
  content: '';
  position: absolute;
  top: -10px;
  left: 50%;
  margin-left: -10px;
  border-width: 10px;
  border-style: solid;
  border-color: transparent transparent #f9f9f9 transparent;
}

  </style>
  
</head>
<body>
  <div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="dropdown">
  <button class="dropbtn">ดูจำนวนการร้องเรียนที่ยังไม่ดำเนินการ</button>
  <div class="dropdown-content">
        <?php foreach ($counts as $item): ?>
          <a href="#">
            <?= htmlspecialchars($item['source']) ?> - <?= htmlspecialchars($item['problem_level']) ?> : <?= htmlspecialchars($item['count']) ?> ราย
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="header-nav">
      <nav>
        <ul>
        
          <span style="color: cyan;">ยินดีต้อนรับ</span>, <?= htmlspecialchars($_SESSION['user']['first_name']) ?> <?= htmlspecialchars($_SESSION['user']['last_name']) ?>
          <span style="color: green;">แผนก</span>, <?= htmlspecialchars($_SESSION['user']['department']) ?> 
          <a href="edit_account.php?username=<?= urlencode($username) ?>">แก้ไขข้อมูลบัญชี</a>
          <a href="logout.php">ออกจากระบบ</a>
          
        </ul>
        
      </nav>
    </div>
  </div>
  
  <div class="container">
    <div class="title">ส่วนของเจ้าหน้าที่</div>
    <div class="slogan">
      "จัดการข้อมูล <span class="highlight-blue">การร้องเรียน</span><br>
      ตรวจสอบ <span class="highlight-blue">สถานะ</span><br>
      รายงาน <span class="highlight-blue">การดำเนินการ</span>"
    </div>

    <div class="button-container">
      <a href="admin_dashboard.php" class="button-dashboard">แดชบอร์ดเรื่องร้องทุกข์</a>
      <a href="admin_dashboard_appeal.php" class="button-dashboard">แดชบอร์ดแจ้งเบาะแสทุจริตประพฤติมิชอบ</a>
      <a href="admin_register.html" class="button-manage">ลงทะเบียนเจ้าหน้าที่</a>
      <a href="view_contact.php" class="button-contact">ดูการติดต่อ</a>
    </div>

    <!-- Dropdown to select status "ยังไม่ดำเนินการ" counts -->
    
    </div>
  </div>

  <div class="footer">
    <p>เทศบาลเมืองบ้านโป่ง BANPONG MUNICIPALITY</p>
    <p>ถนนบ้านดอนตูม จังหวัดราชบุรี 70110</p>
    <p>โทรศัพท์ : 0-3222-1001, 0-3221-1114 | โทรสาร : 0-3222-1975</p>
    <p>Email : <a href="mailto:admin@banpong.go.th">admin@banpong.go.th</a></p>
  </div>
</body>
</html>
