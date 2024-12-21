<?php
// Start session for user authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include 'db_web.php';

// Get the complaint ID from the URL
$complaint_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Retrieve complaint details, admin details, and status change time for the given complaint_id
$sql = "SELECT 
            c.id, 
            c.user_id, 
            c.report_subject,
            c.category,
            c.report_person, 
            c.contact_phone, 
            c.contact_location, 
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
            CONCAT(u.first_name, ' ', u.last_name) AS admin_name,
            u.department AS admin_department, -- Admin's department
            CONCAT(usr.first_name, ' ', usr.last_name) AS user_name,
            logs.changed_at AS status_changed_at,
            logs.new_status,  -- New status from logs
            logs.old_status,  -- Old status from logs
            c.note,  -- Add note column here
            c.video_link
        FROM appeals AS c
        LEFT JOIN status_change_logs AS logs ON c.id = logs.complaint_id
        LEFT JOIN user AS u ON logs.changed_by = u.user_id
        LEFT JOIN user AS usr ON c.user_id = usr.user_id
        WHERE c.id = ?
        ORDER BY logs.changed_at DESC";  // Get all status changes for this complaint

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("i", $complaint_id);

    // Execute the statement
    $stmt->execute();

    // Bind the result to variables
    $stmt->bind_result($id, $user_id, $report_subject, $category, $report_person, $contact_phone, $contact_location, 
                       $latitude, $longitude, $incident_date, $incident_time, 
                       $problem_level, $department, $complaint_description, $complaint_file, $submitted_at,
                       $status, $admin_name, $admin_department, $user_name, $status_changed_at, 
                       $new_status, $old_status, $note,$video_link);

    // Fetch the complaint details
    $complaint_details = [];
   // Initialize status changes array
    $status_changes = [];

// Fetch complaint details and status change history
while ($stmt->fetch()) {
    // Store complaint details
    $complaint_details = [
        'id' => $id,
        'user_id' => $user_id,
        'user_name' => $user_name,
        'report_subject' => $report_subject,
        'category' => $category,
        'report_person' => $report_person,
        'contact_phone' => $contact_phone,
        'contact_location' => $contact_location,
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
        'admin_name' => $admin_name,
        'admin_department' => $admin_department,
        'note' => $note,
        'video_link' => $video_link,
    ];

    // Save each status change history
    $status_changes[] = [
        'status_changed_at' => $status_changed_at,
        'old_status' => $old_status,
        'new_status' => $new_status,
        'admin_name' => $admin_name,
    ];
}

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the SQL query: " . $conn->error;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดการร้องเรียน</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #AFEEEE; /* Light gray background */
            font-family: 'Arial', sans-serif;
        }

        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            border-radius: 10px; /* Rounded corners */
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
            font-size: 16px;
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

        table {
            width: 100%;
            margin-top: 20px;
            border-spacing: 0; /* Remove the collapse between cells */
        }

        th, td {
            padding: 8px 12px;
            border-right: 1px solid #ddd; /* Add right border to all cells */
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Remove the right border of the last cell */
        td:last-child, th:last-child {
            border-right: none;
        }

        .badge-info {
            background-color: #17a2b8;
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
<div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                รายละเอียดการร้องเรียน
            </div>
            <div class="card-body">
                <?php if (!empty($complaint_details)): ?>
                    <h5 class="mb-4" style="font-size: 18px; color: #000; font-weight: 600; border-bottom: 2px solid #2a7cff; padding-bottom: 5px;">
                        <strong>ชื่อเรื่อง:</strong> <?= htmlspecialchars($complaint_details['report_subject']) ?></h5>
                    
                    <!-- Complaint Details Table -->
                    <table>
                        <tr>
                            <th>หมวดหมู่การแจ้งเบาะแส</th>
                            <td><?= htmlspecialchars($complaint_details['category']) ?></td>
                        </tr>
                        <tr>
                            <th>ชื่อผู้ส่ง</th>
                            <td><?= htmlspecialchars($complaint_details['user_name']) ?></td>
                        </tr>
                        <tr>
                            <th>ช่องทางการติดต่อ</th>
                            <td><?= htmlspecialchars($complaint_details['contact_phone']) ?></td>
                        </tr>
                        <tr>
                        <th>บุคคล/องค์กรที่ร้องเรียน</th>
                        <td><?= htmlspecialchars($complaint_details['report_person']) ?></td>
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
                            <th>วันและเวลาเกิดเหตุ</th>
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
                            <th>คำอธิบายปัญหา</th>
                            <td><?= htmlspecialchars($complaint_details['complaint_description']) ?></td>
                        </tr>
                        <tr>
                        <th>วันที่ยื่นร้องเรียน</th>
                        <td><?= htmlspecialchars($complaint_details['submitted_at'])?></td>
                        </tr>
                        <tr>
                            <th>ไฟล์ประกอบการร้องเรียน</th>
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
    <th>สถานะการร้องเรียน (ประวัติการเปลี่ยนแปลง)</th>
    <td>
        <?php if (count($status_changes) > 0): ?>
            <select id="statusChangeDropdown" class="form-control">
                <option value="">เลือกสถานะที่ต้องการดู</option>
                <?php foreach ($status_changes as $index => $change): ?>
                    <option value="<?= $index ?>">
                        สถานะที่ <?= $index + 1 ?> - <?= htmlspecialchars($change['new_status']) ?> (<?= htmlspecialchars($change['status_changed_at']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Div to display the selected status change details -->
            <div id="statusChangeDetails" class="mt-3">
                <!-- Default message -->
                <p>กรุณาเลือกสถานะจาก dropdown เพื่อดูรายละเอียด.</p>
            </div>
        <?php else: ?>
            <p>สถานะของการร้องเรียนนี้ไม่เคยเปลี่ยนแปลง.</p>
        <?php endif; ?>
    </td>
</tr>




                    </table>
                <?php else: ?>
                    <p>ไม่พบข้อมูลการร้องเรียนนี้.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
        <!-- Go Back Button -->
        <div class="text-center mt-4">
            <button onclick="goBack();" class="btn btn-back" style="background-color:rgb(33, 170, 180); color: white;">ย้อนกลับ</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back(); // ย้อนกลับไปยังหน้าก่อนหน้า
        }
    </script>
    
    <script>
        // JavaScript to handle the dropdown selection and display status change details
        document.getElementById("statusChangeDropdown").addEventListener("change", function () {
            var index = this.value;
            var statusChanges = <?php echo json_encode($status_changes); ?>;

            if (index !== "") {
                var selectedChange = statusChanges[index];
                var detailsHTML = `
                    <h5>รายละเอียดการเปลี่ยนสถานะ</h5>
                    <p><strong>สถานะเก่า:</strong> ${selectedChange.old_status}</p>
                    <p><strong>สถานะใหม่:</strong> ${selectedChange.new_status}</p>
                    <p><strong>เจ้าหน้าที่:</strong> ${selectedChange.admin_name}</p>
                    <p><strong>เวลาเปลี่ยนสถานะ:</strong> ${selectedChange.status_changed_at}</p>
                `;
                document.getElementById("statusChangeDetails").innerHTML = detailsHTML;
            } else {
                document.getElementById("statusChangeDetails").innerHTML = "<p>กรุณาเลือกสถานะจาก dropdown เพื่อดูรายละเอียด.</p>";
            }
        });
    </script> 
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>