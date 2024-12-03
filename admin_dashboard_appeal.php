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

// Construct the SQL query with filters
$sql = "SELECT id, report_subject, incident_date, problem_level, department , status FROM appeals";
if (count($filter_conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filter_conditions);
}

$result = $conn->query($sql);
// Update status when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['complaint_id'])) {
    $new_status = $_POST['status'];
    $appeal_id = intval($_POST['complaint_id']);
    $user_id = $_SESSION['user']['user_id']; // Get the logged-in user's ID

    // Get the old status before updating
    $query_old_status = "SELECT status FROM appeals WHERE id = ?";
    $stmt_old_status = $conn->prepare($query_old_status);
    $stmt_old_status->bind_param("i", $appeal_id);
    $stmt_old_status->execute();
    $result_old_status = $stmt_old_status->get_result();
    $old_status = $result_old_status->fetch_assoc()['status'] ?? null;
    $stmt_old_status->close();

    // Update the complaint status
    $update_sql = "UPDATE appeals SET status = ? WHERE id = ?";
    if ($stmt_update = $conn->prepare($update_sql)) {
        $stmt_update->bind_param("si", $new_status, $appeal_id);
        if ($stmt_update->execute()) {
            // Insert a log entry for the status change
            $log_sql = "INSERT INTO status_change_logs (complaint_id, old_status, new_status, changed_by) VALUES (?, ?, ?, ?)";
            if ($stmt_log = $conn->prepare($log_sql)) {
                $stmt_log->bind_param("issi", $appeal_id , $old_status, $new_status, $user_id);

                $stmt_log->execute();
                $stmt_log->close();
            }
            // Redirect to the success page
            header("Location: update_success_appeal.php");
            exit(); // Always call exit after header redirection
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตสถานะ.";
        }
        $stmt_update->close();
    }
}



// Close the connection
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
            font-size: 36px;
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
    </style>
</head>
<body>

    <div class="container">
        <div class="header d-flex justify-content-between align-items-center">
            <h2>แผงควบคุมผู้ดูแลระบบ</h2>
            <!-- Go Back Button at the top right -->
            <a href="view_logs.php" class="btn btn-info">ดูบันทึกการเปลี่ยนแปลง</a>
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
                        <th>หัวข้อการร้องเรียน</th>
                        <th>วันที่เกิดเหตุ</th>
                        <th>ระดับปัญหา</th>
                        <th>หน่วยงาน</th>
                        <th>สถานะ</th>
                        <th>จัดการสถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['report_subject']) ?></td>
                                <td><?= htmlspecialchars($row['incident_date']) ?></td>
                                <td><?= htmlspecialchars($row['problem_level']) ?></td>
                                <td><?= htmlspecialchars($row['department']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td>
                                    <a href="admin_appeal_datail.php?id=<?= urlencode($row['id']) ?>" class="btn btn-info">ดูรายละเอียด</a>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                                        <select name="status" class="form-control" required>
                                            <option value="ยังไม่ดำเนินการ" <?= $row['status'] == 'ยังไม่ดำเนินการ' ? 'selected' : '' ?>>ยังไม่ดำเนินการ</option>
                                            <option value="กำลังดำเนินการ" <?= $row['status'] == 'กำลังดำเนินการ' ? 'selected' : '' ?>>กำลังดำเนินการ</option>
                                            <option value="ดำเนินการเสร็จสิ้น" <?= $row['status'] == 'ดำเนินการเสร็จสิ้น' ? 'selected' : '' ?>>ดำเนินการเสร็จสิ้น</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-2">อัปเดตสถานะ</button>
                                    </form>
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
