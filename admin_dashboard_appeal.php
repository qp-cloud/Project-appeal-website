<?php
// Start session for user authentication
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']['user_id']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");  // Redirect to login page if not an admin
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "web_appeal_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define records per page (set this value)
$records_per_page = 20;  // Adjust as needed

// Prepare filter conditions based on user input
$filter_conditions = [];

// Get the current date for date filters
$current_date = date("Y-m-d");
$start_of_week = date("Y-m-d", strtotime('monday this week'));
$end_of_week = date("Y-m-d", strtotime('sunday this week'));
$start_of_month = date("Y-m-01");
$end_of_month = date("Y-m-t");
$start_of_year = date("Y-01-01");
$end_of_year = date("Y-12-31");

// Handle date filters
if (isset($_POST['date_filter']) && $_POST['date_filter'] != '') {
    $date_filter = $_POST['date_filter'];
    switch ($date_filter) {
        case 'today':
            $filter_conditions[] = "incident_date = '$current_date'";
            break;
        case 'this_week':
            $filter_conditions[] = "incident_date BETWEEN '$start_of_week' AND '$end_of_week'";
            break;
        case 'this_month':
            $filter_conditions[] = "incident_date BETWEEN '$start_of_month' AND '$end_of_month'";
            break;
        case 'this_year':
            $filter_conditions[] = "incident_date BETWEEN '$start_of_year' AND '$end_of_year'";
            break;
        case 'custom':
            // Custom filter will be handled below
            if (isset($_POST['start_date']) && $_POST['start_date'] != '' && isset($_POST['end_date']) && $_POST['end_date'] != '') {
                $start_date = $conn->real_escape_string($_POST['start_date']);
                $end_date = $conn->real_escape_string($_POST['end_date']);
                $filter_conditions[] = "incident_date BETWEEN '$start_date' AND '$end_date'";
            }
            break;
    }
}

// Handle department filter
if (isset($_POST['department']) && $_POST['department'] != '') {
    $department = $conn->real_escape_string($_POST['department']);
    $filter_conditions[] = "department = '$department'";
}

// Handle status filter
if (isset($_POST['status']) && $_POST['status'] != '') {
    $status = $conn->real_escape_string($_POST['status']);
    $filter_conditions[] = "status = '$status'";
}

// Handle category filter
if (isset($_POST['category']) && $_POST['category'] != '') {
    $category = $conn->real_escape_string($_POST['category']);
    $filter_conditions[] = "category = '$category'";
}

// Handle sorting order (default to descending)
$sort_order = isset($_POST['sort_order']) && $_POST['sort_order'] == 'asc' ? 'ASC' : 'DESC';

// Pagination setup
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $records_per_page;

// Count the total number of complaints
$count_sql = "SELECT COUNT(*) as total FROM appeals";
if (count($filter_conditions) > 0) {
    $count_sql .= " WHERE " . implode(" AND ", $filter_conditions);
}
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Construct the SQL query with filters, sorting, and pagination
$sql = "SELECT id, report_subject, category, incident_date, problem_level, department, submitted_at, status FROM appeals";
if (count($filter_conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filter_conditions);
}
$sql .= " ORDER BY submitted_at $sort_order LIMIT $records_per_page OFFSET $offset";

// Execute the query
$result = $conn->query($sql);

// Function to map problem level
function map_problem_level($level) {
    switch ($level) {
        case 'ต่ำ': // Low
            return 'low';
        case 'ปานกลาง': // Medium
            return 'medium';
        case 'เร่งด่วน': // Urgent (mapped to high)
            return 'high';
        default:
            return 'unknown'; // Fallback for unknown levels
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แผงควบคุมผู้ดูแลระบบ</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .header {
            background-color: #2a7cff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            font-weight: bold;
            font-size: 30px;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        .filter-form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-form select,
        .filter-form input {
            border-radius: 5px;
        }

        .table {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
         /* Add color for problem levels */
         .problem-level.low {
            background-color: #28a745; /* Green for low level */
            color: white;
        }

        .problem-level.medium {
            background-color: #ffc107; /* Yellow for medium level */
            color: white;
        }

        .problem-level.high {
            background-color: #dc3545; /* Red for high level */
            color: white;
        }

        .problem-level.unknown {
            background-color: #6c757d; /* Default gray for unknown levels */
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header d-flex justify-content-between align-items-center">
            <h2>เรื่องราวแจ้งเบาะแสการทุจริตประพฤติมิชอบในระบบ</h2>
            <!-- Go Back Button at the top right -->
            <a href="view_logs_appeal.php" class="btn btn-info">ดูบันทึกการเปลี่ยนแปลง</a>
            <a href="admin_page.php" class="btn btn-back">ย้อนกลับ</a>
        </div>

        <!-- Filter Form -->
        <form method="POST" class="filter-form mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="date_filter">กรองตามวันที่</label>
                    <select name="date_filter" id="date_filter" class="form-control">
                        <option value="">เลือกช่วงเวลา</option>
                        <option value="today">วันนี้</option>
                        <option value="this_week">สัปดาห์นี้</option>
                        <option value="this_month">เดือนนี้</option>
                        <option value="this_year">ปีนี้</option>
                        <option value="custom">กำหนดเอง</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="category">กรองตามหมวดหมู่การแจ้งเบาะแส</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="" disabled selected>เลือกหมวดหมู่การแจ้งเบาะแส</option>
                        <option value="ทุจริตทางการเงิน">ทุจริตทางการเงิน</option>
                        <option value="ทุจริตในโครงการ">ทุจริตในโครงการ</option>
                        <option value="ใช้อำนาจหน้าที่โดยมิชอบ">ใช้อำนาจหน้าที่โดยมิชอบ</option>
                        <option value="การเลือกปฏิบัติ">การเลือกปฏิบัติ</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                        <option value="ไม่ทราบหมวดหมู่">ไม่ทราบหมวดหมู่</option>
                    </select>
                    <div class="invalid-feedback">กรุณาเลือกช่องทางการติดต่อ</div>
                </div>

                <div class="col-md-3" id="custom_date_range" style="display: none;">
                    <label for="start_date">วันที่เริ่มต้น</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
                <div class="col-md-3" id="custom_date_range" style="display: none;">
                    <label for="end_date">วันที่สิ้นสุด</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="department">หน่วยงาน</label>
                    <select name="department" id="department" class="form-control">
                        <option value="">เลือกหน่วยงาน</option>
                        <option value="เทศบาลเมือง">เทศบาลเมือง</option>
                        <option value="สำนักปลัดเทศบาลเมือง">สำนักปลัดเทศบาลเมือง</option>
                        <option value="กองคลัง">กองคลัง</option>
                        <option value="กองช่าง">กองช่าง</option>
                        <option value="กองการศึกษา">กองการศึกษา</option>
                        <option value="กองสาธารณสุข">กองสาธารณสุข</option>
                        <option value="กองสวัสดิการสังคม">กองสวัสดิการสังคม</option>
                        <option value="กองยุทธศาสตร์">กองยุทธศาสตร์</option>
                        <option value="กองการเจ้าหน้าที่">กองการเจ้าหน้าที่</option>
                        <option value="หน่วยตรวจสอบภายใน">หน่วยตรวจสอบภายใน</option>
                        <option value="หน่วยงานอื่นๆ">หน่วยงานอื่นๆ</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort_order">จัดเรียงตามวันที่</label>
                    <select name="sort_order" id="sort_order" class="form-control">
                        <option value="desc" <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'desc') ? 'selected' : '' ?>>ใหม่ล่าสุด</option>
                        <option value="asc" <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'asc') ? 'selected' : '' ?>>เก่าสุด</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status">สถานะ</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">เลือกสถานะ</option>
                        <option value="ยังไม่ดำเนินการ">ยังไม่ดำเนินการ</option>
                        <option value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                        <option value="ดำเนินการเสร็จสิ้น">ดำเนินการเสร็จสิ้น</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">กรองข้อมูล</button>
        </form>

        <!-- Complaint Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>วันที่ยื่นเรื่องทุจริตประพฤติมิชอบ</th>
                        <th>หมวดหมู่การแจ้งเบาะแส</th>
                        <th>หัวข้อการแจ้งเบาะแส</th>
                        <th>วันที่เกิดเหตุ</th>
                        <th>ระดับปัญหา</th>
                        <th>หน่วยงาน</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td><?= htmlspecialchars($row['report_subject']) ?></td>
                                <td><?= htmlspecialchars($row['incident_date']) ?></td>
                                <td class="problem-level <?= strtolower(map_problem_level($row['problem_level'])) ?>">
                                <?= htmlspecialchars($row['problem_level']) ?>
                                <td><?= htmlspecialchars($row['department']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td>
                                    <a href="admin_appeal_datail.php?id=<?= urlencode($row['id']) ?>" class="btn btn-info">จัดการเรื่อง</a>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลการร้องเรียน</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
  <!-- Pagination -->
  <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- JavaScript to show/hide custom date range fields -->
    <script>
        document.getElementById('date_filter').addEventListener('change', function() {
            var customDateRange = document.getElementById('custom_date_range');
            if (this.value === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    </script>
</body>
</html>
