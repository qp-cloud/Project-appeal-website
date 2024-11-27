<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";  // ชื่อผู้ใช้งาน MySQL
$password = "";      // รหัสผ่าน MySQL
$dbname = "web_appeal_db"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตัวแปรสำหรับกรองข้อมูล
$selected_department = isset($_POST['department']) ? $_POST['department'] : null;

// กำหนดคำสั่ง SQL เพื่อดึงข้อมูล
$sql = "SELECT MONTH(incident_date) AS month, status, COUNT(*) AS complaint_count
        FROM complaints
        WHERE 1=1";

// กรองตามหน่วยงาน
if ($selected_department) {
    $sql .= " AND department = ?";
}

$sql .= " GROUP BY MONTH(incident_date), status ORDER BY MONTH(incident_date), status";  // Group by month and status

$stmt = $conn->prepare($sql);

// Binding parameter for department filter
if ($selected_department) {
    $stmt->bind_param("s", $selected_department);
}

$stmt->execute();
$result = $stmt->get_result();

// ตัวแปรสำหรับนับจำนวน complaint ต่อเดือนและสถานะ
$monthly_complaints = [];

while ($row = $result->fetch_assoc()) {
    $monthly_complaints[$row['month']][$row['status']] = $row['complaint_count'];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสถิติการรับแจ้งเรื่องร้องเรียน</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 30px;
        }
        h2, h4 {
            color: #2a7cff;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .btn-primary {
            border-radius: 8px;
            background-color: #2a7cff;
            border-color: #2a7cff;
            padding: 10px 20px;
            width: 100%;  /* Make the button stretch across the available space */
        }
        .btn-primary:hover {
            background-color: #1e60c3;
            border-color: #1e60c3;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-row {
            display: flex;
            align-items: center;
        }
        .form-group select {
            margin-right: 15px; /* Space between the dropdown and the button */
        }
        .btn-container {
            text-align: right;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #2a7cff;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table td {
            font-size: 16px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }
        .table-bordered {
            margin-top: 20px;
        }
        .header {
            background: #98FB98;
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
        .header-nav a {
            color: #000;
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
    </style>
</head>
<body>
<div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="header-nav">
      <nav>
        <ul>
          <a href="login.html">เข้าสู่ระบบ</a>
          <a href="contact.html">ติดต่อเรา</a>
          <a href="home.html">หน้าแรก</a>
        </ul>
      </nav>
    </div>
  </div>


    <div class="container mt-5">
        <h2 class="text-center mb-4">รายงานสถิติการรับแจ้งเรื่องร้องเรียน/แจ้งเบาะแส</h2>

        <!-- ฟอร์มกรองข้อมูล -->
        <form method="POST">
            <div class="form-row mb-3">
                <div class="form-group col-md-8">
                    <label for="department">หน่วยงาน</label>
                    <select class="form-control" name="department" id="department">
                        <option value="">เลือกหน่วยงาน</option>
                        <option value="เทศบาลเมือง" <?= ($selected_department == 'เทศบาลเมือง') ? 'selected' : ''; ?>>เทศบาลเมือง</option>
                        <option value="สำนักปลัดเทศบาลเมือง" <?= ($selected_department == 'สำนักปลัดเทศบาลเมือง') ? 'selected' : ''; ?>>สำนักปลัดเทศบาลเมือง</option>
                        <option value="กองคลัง" <?= ($selected_department == 'กองคลัง') ? 'selected' : ''; ?>>กองคลัง</option>
                        <option value="กองช่าง" <?= ($selected_department == 'กองช่าง') ? 'selected' : ''; ?>>กองช่าง</option>
                        <option value="กองการศึกษา" <?= ($selected_department == 'กองการศึกษา') ? 'selected' : ''; ?>>กองการศึกษา</option>
                        <option value="กองสาธารณสุข" <?= ($selected_department == 'กองสาธารณสุข') ? 'selected' : ''; ?>>กองสาธารณสุข</option>
                        <option value="กองสวัสดิการสังคม" <?= ($selected_department == 'กองสวัสดิการสังคม') ? 'selected' : ''; ?>>กองสวัสดิการสังคม</option>
                        <option value="กองยุทธศาสตร์" <?= ($selected_department == 'กองยุทธศาสตร์') ? 'selected' : ''; ?>>กองยุทธศาสตร์</option>
                        <option value="กองการเจ้าหน้าที่" <?= ($selected_department == 'กองการเจ้าหน้าที่') ? 'selected' : ''; ?>>กองการเจ้าหน้าที่</option>
                        <option value="หน่วยตรวจสอบภายใน" <?= ($selected_department == 'หน่วยตรวจสอบภายใน') ? 'selected' : ''; ?>>หน่วยตรวจสอบภายใน</option>
                        <option value="หน่วยงานอื่นๆ" <?= ($selected_department == 'หน่วยงานอื่นๆ') ? 'selected' : ''; ?>>หน่วยงานอื่นๆ</option>
                    </select>
                </div>
                <div class="form-group col-md-4 btn-container">
                    <button type="submit" class="btn btn-primary">กรองข้อมูล</button>
                </div>
            </div>
        </form>

        <!-- แสดงผลรวมตามเดือนและสถานะ -->
        <h4>ผลรวมตามเดือนและสถานะ</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>เดือน</th>
                    <th>ยังไม่ดำเนินการ</th>
                    <th>กำลังดำเนินการ</th>
                    <th>ดำเนินการเสร็จสิ้น</th>
                    <th>รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // แสดงผลจำนวนเรื่องร้องเรียนต่อเดือนและสถานะ
                for ($month = 1; $month <= 12; $month++) {
                    // Get the complaint counts for each status
                    $not_processed = isset($monthly_complaints[$month]['ยังไม่ดำเนินการ']) ? $monthly_complaints[$month]['ยังไม่ดำเนินการ'] : 0;
                    $in_progress = isset($monthly_complaints[$month]['กำลังดำเนินการ']) ? $monthly_complaints[$month]['กำลังดำเนินการ'] : 0;
                    $completed = isset($monthly_complaints[$month]['ดำเนินการเสร็จสิ้น']) ? $monthly_complaints[$month]['ดำเนินการเสร็จสิ้น'] : 0;

                    // Calculate the total for the month
                    $total = $not_processed + $in_progress + $completed;

                    echo "<tr>";
                    echo "<td>" . getMonthName($month) . "</td>";
                    echo "<td>" . $not_processed . "</td>";
                    echo "<td>" . $in_progress . "</td>";
                    echo "<td>" . $completed . "</td>";
                    echo "<td>" . $total . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// ฟังก์ชันสำหรับแปลงหมายเลขเดือนเป็นชื่อเดือน
function getMonthName($month) {
    $months = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];
    return $months[$month];
}
