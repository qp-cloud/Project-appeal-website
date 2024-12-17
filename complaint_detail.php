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
            CONCAT(u.first_name, ' ', u.last_name) AS admin_name,
            u.department AS admin_department, -- Admin's department
            CONCAT(usr.first_name, ' ', usr.last_name) AS user_name,
            logs.changed_at AS status_changed_at,
            c.note -- Added note field
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
                   $complaint_description, $complaint_file, $submitted_at, $status, $admin_name, 
                   $admin_department, $user_name, $status_changed_at, $note); // Add $note here

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
            'admin_name' => $admin_name,
            'admin_department' => $admin_department, // Added admin's department
            'status_changed_at' => $status_changed_at,
            'note' => $note // Added note field
        ];
    } else {
        echo "Complaint not found.";
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
    </style>
</head>
<body>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                รายละเอียดการร้องเรียน
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
                            <th>รายละเอียดที่ติดต่อ</th>
                            <td><?= htmlspecialchars($complaint_details['contact_details']) ?></td>
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
                        <th>สถานะปัจจุบัน</th>
                        <td><?= htmlspecialchars($complaint_details['status'])?></td>
                        </tr>
                            </td>
                        </tr>
                        <tr>
                            <th>เจ้าหน้าที่เปลี่ยนสถานะล่าสุด</th>
                            <td><?= htmlspecialchars($complaint_details['admin_name']) ?></td>
                        </tr>
                        <tr>
                            <th>แผนกเจ้าหน้าที่</th>
                            <td><?= htmlspecialchars($complaint_details['admin_department']) ?></td>
                        </tr>
                        <tr>
                            <th>เวลาเปลี่ยนสถานะ</th>
                            <td><?= htmlspecialchars($complaint_details['status_changed_at']) ?></td>
                        </tr>
                        <tr>
                            <th>หมายเหตุจากเจ้าหน้าที่</th>
                            <td>
                                <?= !empty($complaint_details['note']) ? htmlspecialchars($complaint_details['note']) : 'ไม่มีหมายเหตุ' ?>
                            </td>
                        </tr>


                    </table>
                <?php else: ?>
                    <p>ไม่พบข้อมูลการร้องเรียนนี้.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
            
            </div>
        </div>

        <!-- Go Back Button -->
        <div class="text-center mt-4">
            <button onclick="goBackWithUserId();" class="btn btn-back">ย้อนกลับ</button>
        </div>

    </div>
    <script>
        function goBackWithUserId() {
            // Get the user_id from PHP
            const userId = <?= json_encode($_SESSION['user']['user_id']) ?>;
            // Redirect to a specific page with the user_id as a query parameter
            window.location.href = `complaint_tracking.php?user_id=${userId}`;
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
