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

// Get the complaint_id from the URL
$complaint_id = isset($_GET['complaint_id']) ? $_GET['complaint_id'] : null;

// Ensure the complaint ID is valid
if (!$complaint_id) {
    echo "Invalid complaint ID!";
    exit();
}

// Retrieve the complaint details from the database
$sql = "SELECT complaint_subject, contact_phone, contact_location, contact_details, 
        latitude, longitude, incident_date, incident_time, problem_level, department, 
        complaint_description, complaint_file, privacy_consent, submitted_at 
        FROM complaints 
        WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("i", $complaint_id);

    // Execute the statement
    $stmt->execute();
    
    // Bind the result to variables
    $stmt->bind_result($complaint_subject, $contact_phone, $contact_location, $contact_details, 
                       $latitude, $longitude, $incident_date, $incident_time, $problem_level, 
                       $department, $complaint_description, $complaint_file, $privacy_consent, 
                       $submitted_at);

    // Fetch the complaint details
    if ($stmt->fetch()) {
        // Complaint details fetched successfully
    } else {
        echo "Complaint not found!";
        exit();
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
    <title>รายละเอียดการร้องทุกข์ / ร้องเรียน</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">รายละเอียดการร้องทุกข์ / ร้องเรียน</h2>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= htmlspecialchars($complaint_subject) ?></h4>
                <p><strong>หมายเลขโทรศัพท์:</strong> <?= htmlspecialchars($contact_phone) ?></p>
                <p><strong>สถานที่เกิดเหตุ:</strong> <?= htmlspecialchars($contact_location) ?></p>
                <p><strong>รายละเอียดการติดต่อ:</strong> <?= nl2br(htmlspecialchars($contact_details)) ?></p>
                <p><strong>วันที่เกิดเหตุ:</strong> <?= htmlspecialchars($incident_date) ?> <?= htmlspecialchars($incident_time) ?></p>
                <p><strong>ระดับปัญหา:</strong> <?= htmlspecialchars($problem_level) ?></p>
                <p><strong>หน่วยงานที่รับผิดชอบ:</strong> <?= htmlspecialchars($department) ?></p>
                <p><strong>รายละเอียดการร้องเรียน:</strong></p>
                <p><?= nl2br(htmlspecialchars($complaint_description)) ?></p>

                <?php if ($complaint_file): ?>
                    <p><strong>ไฟล์แนบ:</strong> <a href="data:application/pdf;base64,<?= base64_encode($complaint_file) ?>" target="_blank">ดูไฟล์</a></p>
                <?php endif; ?>

                <p><strong>ความยินยอมในการเก็บข้อมูล:</strong> <?= $privacy_consent ? "ยินยอม" : "ไม่ยินยอม" ?></p>
                <p><strong>วันที่ส่งเรื่อง:</strong> <?= htmlspecialchars($submitted_at) ?></p>

                <a href="track_complaint.php" class="btn btn-primary">กลับ</a>
            </div>
        </div>
    </div>
</body>
</html>
