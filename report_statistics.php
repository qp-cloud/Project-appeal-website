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
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">เว็บรายงานเรื่องร้องเรียน</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">รายงานสถิติการรับแจ้งเรื่องร้องเรียน/แจ้งเบาะแส</h2>

        <!-- ฟอร์มกรองข้อมูล -->
        <form method="POST">
            <div class="row mb-3">
                <div class="col">
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
                <div class="col align-self-center">
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
                    <th>สถานะ</th>
                    <th>จำนวนเรื่องร้องเรียน</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // แสดงผลจำนวนเรื่องร้องเรียนต่อเดือนและสถานะ
                for ($month = 1; $month <= 12; $month++) {
                    if (isset($monthly_complaints[$month])) {
                        foreach ($monthly_complaints[$month] as $status => $count) {
                            echo "<tr>";
                            echo "<td>" . getMonthName($month) . "</td>";
                            echo "<td>" . $status . "</td>";
                            echo "<td>" . $count . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td>" . getMonthName($month) . "</td><td>ไม่มีข้อมูล</td><td>0</td></tr>";
                    }
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
?>
