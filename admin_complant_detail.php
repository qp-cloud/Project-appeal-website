<?php
// Start session for user authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
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

// Get the complaint ID from the URL
$complaint_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Retrieve complaint details, admin details, and status change time for the given complaint_id
$sql = "SELECT 
            c.id, 
            c.user_id, 
            c.complaint_subject, 
            c.contact_phone, 
            c.contact_location, 
            c.contact_details, 
            c.latitude, 
            c.longitude, 
            c.incident_date, 
            c.incident_time, 
            c.problem_level, 
            c.department, 
            c.complaint_description, 
            c.complaint_file, 
            c.submitted_at, 
            c.status, 
            c.note,
            c.video_link, -- Added the 'note' field
            CONCAT(u.first_name, ' ', u.last_name) AS admin_name,
            u.department AS admin_department, -- Admin's department
            CONCAT(usr.first_name, ' ', usr.last_name) AS user_name,
            logs.changed_at AS status_changed_at
        FROM complaints AS c
        LEFT JOIN status_change_logs AS logs ON c.id = logs.complaint_id
        LEFT JOIN user AS u ON logs.changed_by = u.user_id
        LEFT JOIN user AS usr ON c.user_id = usr.user_id
        WHERE c.id = ?
        ORDER BY logs.changed_at DESC
        LIMIT 1";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("i", $complaint_id);

    // Execute the statement
    $stmt->execute();

    // Bind the result to variables
    $stmt->bind_result($id, $user_id, $complaint_subject, $contact_phone, $contact_location, $contact_details,
                   $latitude, $longitude, $incident_date, $incident_time, $problem_level, $department, 
                   $complaint_description, $complaint_file, $submitted_at, $status, $note, $video_link, // Added note
                   $admin_name, $admin_department, $user_name, $status_changed_at);

    // Fetch the complaint details
    if ($stmt->fetch()) {
        $complaint_details = [
            'id' => $id,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'complaint_subject' => $complaint_subject,
            'contact_phone' => $contact_phone,
            'contact_location' => $contact_location,
            'contact_details' => $contact_details,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'incident_date' => $incident_date,
            'incident_time' => $incident_time,
            'problem_level' => $problem_level,
            'department' => $department,
            'complaint_description' => $complaint_description,
            'complaint_file' => $complaint_file,
            'submitted_at' => $submitted_at,
            'status' => $status,
            'note' => $note,
            'video_link' => $video_link, // Added note
            'admin_name' => $admin_name,
            'admin_department' => $admin_department, 
            'status_changed_at' => $status_changed_at,
            
        ];
    } else {
        echo "Complaint not found.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the SQL query: " . $conn->error;
}

// Update complaint status and note
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['complaint_id'], $_POST['note'])) {
    $new_status = $_POST['status'];
    $note = $_POST['note'];  // Get the new note
    $complaint_id = intval($_POST['complaint_id']);
    $user_id = $_SESSION['user']['user_id']; // Get the logged-in user's ID

    // Get the old status before updating
    $query_old_status = "SELECT status FROM complaints WHERE id = ?";
    $stmt_old_status = $conn->prepare($query_old_status);
    $stmt_old_status->bind_param("i", $complaint_id);
    $stmt_old_status->execute();
    $result_old_status = $stmt_old_status->get_result();
    $old_status = $result_old_status->fetch_assoc()['status'] ?? null;
    $stmt_old_status->close();

    // Update the complaint status and note
    $update_sql = "UPDATE complaints SET status = ?, note = ? WHERE id = ?";
    if ($stmt_update = $conn->prepare($update_sql)) {
        $stmt_update->bind_param("ssi", $new_status, $note, $complaint_id);
        if ($stmt_update->execute()) {
            // Insert a log entry for the status change
            $log_sql = "INSERT INTO status_change_logs (complaint_id, old_status, new_status, changed_by) VALUES (?, ?, ?, ?)";
            if ($stmt_log = $conn->prepare($log_sql)) {
                $stmt_log->bind_param("issi", $complaint_id, $old_status, $new_status, $user_id);
                $stmt_log->execute();
                $stmt_log->close();
            }
            // Redirect to the success page
            header("Location: update_success.php");
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
    <title>รายละเอียดการร้องทุกข์</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-body p {
            margin-bottom: 10px;
        }
        .btn-download {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-download:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }
        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .card-body table {
            width: 100%;
            border-collapse: collapse;
        }
        .card-body table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                รายละเอียดการร้องทุกข์
            </div>
            <div class="card-body">
                <?php if (!empty($complaint_details)): ?>
                    <h5 class="mb-4" style="font-size: 18px; color: #000; font-weight: 600; border-bottom: 2px solid #2a7cff; padding-bottom: 5px;">
                        <strong>ชื่อเรื่อง:</strong> <?= htmlspecialchars($complaint_details['complaint_subject']) ?></h5>
                    
                    <!-- Complaint Details Table -->
                    <table>
                        <tr>
                            <th>ชื่อผู้ส่ง</th>
                            <td><?= htmlspecialchars($complaint_details['user_name']) ?></td>
                        </tr>
                        <tr>
                            <th>ช่องทางการติดต่อ</th>
                            <td><?= htmlspecialchars($complaint_details['contact_phone']) ?></td>
                        </tr>
                        <tr>
                            <th>สถานที่เกิดเหตุ</th>
                            <td><?= htmlspecialchars($complaint_details['contact_location']) ?></td>
                        </tr>
                        <tr>
                            <th>ค่า Latitude และ Longitude</th>
                            <td>Latitude: <?= htmlspecialchars($complaint_details['latitude']) ?>, Longitude: <?= htmlspecialchars($complaint_details['longitude']) ?></td>
                        </tr>
                        <tr>
                            <th>รายละเอียดสถานที่</th>
                            <td><?= htmlspecialchars($complaint_details['contact_details']) ?></td>
                        </tr>
                        <tr>
                            <th>วันและเวลาที่เกิดเหตุ</th>
                            <td><?= htmlspecialchars($complaint_details['incident_date']) ?> <?= htmlspecialchars($complaint_details['incident_time']) ?></td>
                        </tr>
                        <tr>
                            <th>ระดับปัญหา</th>
                            <td><?= htmlspecialchars($complaint_details['problem_level']) ?></td>
                        </tr>
                        <tr>
                            <th>หน่วยงานที่เกี่ยวข้อง</th>
                            <td><?= htmlspecialchars($complaint_details['department']) ?></td>
                        </tr>
                        <tr>
                            <th>รายละเอียดเรื่องที่ร้องทุกข์</th>
                            <td><?= htmlspecialchars($complaint_details['complaint_description']) ?></td>
                        </tr>
                        <tr>
                        <th>วันที่ยื่นร้องทุกข์</th>
                        <td><?= htmlspecialchars($complaint_details['submitted_at'])?></td>
                        </tr>
                        <tr>
                            <th>ไฟล์ประกอบการร้องทุกข์</th>
                            <td>
                                <?php if (!empty($complaint_details['complaint_file'])): ?>
                                    <a href="<?= htmlspecialchars($complaint_details['complaint_file']) ?>" class="btn btn-download" download>ดาวน์โหลดไฟล์</a>
                                <?php else: ?>
                                    ไม่มีไฟล์ที่แนบมาด้วย
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>ลิงก์คลิปวิดีโอประกอบ</th>
                            <td>
                                <?php if (!empty($complaint_details['video_link'])): ?>
                                    <a href="<?= htmlspecialchars($complaint_details['video_link']) ?>" target="_blank">
                                        <?= htmlspecialchars($complaint_details['video_link']) ?>
                                    </a>
                                <?php else: ?>
                                    ไม่มีลิงก์วิดีโอ
                                <?php endif; ?>
                            </td>
                        </tr>                    

                        <tr>
                            <th>สถานะ</th>
                            <td>
                                <form method="POST" class="mt-4">
                                    <input type="hidden" name="complaint_id" value="<?= $complaint_details['id'] ?>">
                                    <div class="form-group">
                                        <label for="status">เปลี่ยนสถานะการร้องทุกข์:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="ยังไม่ดำเนินการ" <?= $complaint_details['status'] == 'ยังไม่ดำเนินการ' ? 'selected' : '' ?>>ยังไม่ดำเนินการ</option>
                                            <option value="กำลังดำเนินการ" <?= $complaint_details['status'] == 'กำลังดำเนินการ' ? 'selected' : '' ?>>กำลังดำเนินการ</option>
                                            <option value="ดำเนินการเสร็จสิ้น" <?= $complaint_details['status'] == 'ดำเนินการเสร็จสิ้น' ? 'selected' : '' ?>>ดำเนินการเสร็จสิ้น</option>
                                        </select>
                                    </div>

                                    <!-- Note Textarea -->
                                    <div class="form-group">
                                        <label for="note">หมายเหตุ:</label>
                                        <textarea name="note" id="note" class="form-control" rows="3"><?= !empty($complaint_details['note']) ? htmlspecialchars($complaint_details['note']) : 'ไม่มีหมายเหตุ' ?></textarea>
                                    </div>


                                    <button type="submit" name="update_status" class="btn btn-primary">อัปเดตสถานะ</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                <?php else: ?>
                    <p>ไม่พบข้อมูลการร้องทุกข์นี้.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
            <button onclick="goBackWithUserId();" class="btn btn-back">ย้อนกลับ</button>
        </div>

    </div>
    <script>
            function goBackWithUserId() {
                // Get the user_id from PHP
                const userId = <?= json_encode($_SESSION['user']['user_id']) ?>;
                // Redirect to a specific page with the user_id as a query parameter
                window.location.href = `admin_dashboard.php?user_id=${userId}`;
            }
        </script>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>