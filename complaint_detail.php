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

// Retrieve complaint details for the given complaint_id
$sql = "SELECT id, user_id, complaint_subject, contact_phone, contact_location, contact_details, 
        latitude, longitude, incident_date, incident_time, problem_level, department, 
        complaint_description, complaint_file, submitted_at
        FROM complaints 
        WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("i", $complaint_id);

    // Execute the statement
    $stmt->execute();

    // Bind the result to variables
    $stmt->bind_result($id, $user_id, $complaint_subject, $contact_phone, $contact_location, $contact_details,
                       $latitude, $longitude, $incident_date, $incident_time, $problem_level, $department, 
                       $complaint_description, $complaint_file, $submitted_at);

    // Fetch the complaint details
    if ($stmt->fetch()) {
        $complaint_details = [
            'id' => $id,
            'user_id' => $user_id,
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
            'status' => $status
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
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">รายละเอียดการร้องเรียน</h2>

        <?php if (!empty($complaint_details)): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($complaint_details['complaint_subject']) ?></h5>
                    <p><strong>เบอร์โทรติดต่อ:</strong> <?= htmlspecialchars($complaint_details['contact_phone']) ?></p>
                    <p><strong>สถานที่เกิดเหตุ:</strong> <?= htmlspecialchars($complaint_details['contact_location']) ?></p>
                    <p><strong>รายละเอียดที่ติดต่อ:</strong> <?= htmlspecialchars($complaint_details['contact_details']) ?></p>
                    <p><strong>วันและเวลาเกิดเหตุ:</strong> <?= htmlspecialchars($complaint_details['incident_date']) ?> <?= htmlspecialchars($complaint_details['incident_time']) ?></p>
                    <p><strong>ระดับปัญหา:</strong> <?= htmlspecialchars($complaint_details['problem_level']) ?></p>
                    <p><strong>หน่วยงานที่เกี่ยวข้อง:</strong> <?= htmlspecialchars($complaint_details['department']) ?></p>
                    <p><strong>คำอธิบายปัญหา:</strong> <?= htmlspecialchars($complaint_details['complaint_description']) ?></p>
                    <p><strong>ไฟล์ประกอบการร้องเรียน:</strong> 
                        <?php if (!empty($complaint_details['complaint_file'])): ?>
                            <a href="uploads/<?= htmlspecialchars($complaint_details['complaint_file']) ?>" download class="btn btn-success">ดาวน์โหลดไฟล์</a>

                        <?php else: ?>
                            <span>ไม่มีไฟล์</span>
                        <?php endif; ?>
                    </p>


                    <p><strong>วันที่ยื่นร้องเรียน:</strong> <?= htmlspecialchars($complaint_details['submitted_at']) ?></p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">ไม่พบข้อมูลการร้องเรียน</p>
        <?php endif; ?>

        <!-- Go Back Button -->
        <div class="text-center mt-4">
            <button onclick="window.history.back();" class="btn btn-primary">ย้อนกลับ</button>
        </div>
    </div>
</body>
</html>
