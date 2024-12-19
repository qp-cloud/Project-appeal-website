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

// Get user_id from session
$user_id = $_SESSION['user']['user_id'];

// Retrieve the complaints for the logged-in user
$sql = "SELECT id, complaint_subject, contact_phone, contact_location, contact_details, 
        latitude, longitude, incident_date, incident_time, problem_level, department, 
        complaint_description, complaint_file, submitted_at, status
        FROM complaints 
        WHERE user_id = ? 
        ORDER BY submitted_at DESC";  // Fetch complaints in descending order of submission

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("i", $user_id);  // "i" stands for integer

    // Execute the statement
    $stmt->execute();
    
    // Bind the result to variables
    $stmt->bind_result($id, $complaint_subject, $contact_phone, $contact_location, 
                       $contact_details, $latitude, $longitude, $incident_date, $incident_time, 
                       $problem_level, $department, $complaint_description, $complaint_file, 
                        $submitted_at,$status);

    // Fetch the complaints
    $complaints = [];
    while ($stmt->fetch()) {
        $complaints[] = [
            'id' => $id,
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
    <title>ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/bg.png');
            background-size: cover; /* Light gray background */
        }
        .table {
            background-color: #fff; /* White table background */
        }
        .table th {
            background-color: #17a2b8; 
            color: #F8F8FF; 
        }
        .card {
            margin-top: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .btn-info {
            background-color: #99FF99; /* Custom color for "Details" button */
            border-color: #000;
            color:#000;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        h2 {
            font-weight: bold;
            color:rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">ติดตามรายงานผลการร้องทุกข์ / ร้องเรียน</h2>

                <!-- Display complaints if available -->
                <?php if (!empty($complaints)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>เรื่องร้องเรียน</th>
                                <th>วันที่เกิดเหตุ</th>
                                <th>ระดับปัญหา</th>
                                <th>สถานะ</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($complaints as $complaint): ?>
                                <tr>
                                    <td><?= htmlspecialchars($complaint['complaint_subject']) ?></td>
                                    <td><?= htmlspecialchars($complaint['incident_date']) ?></td>
                                    <td><?= htmlspecialchars($complaint['problem_level']) ?></td>
                                    <td><?= htmlspecialchars($complaint['status']) ?></td>
                                    <td>
                                        <a href="complaint_detail.php?id=<?= urlencode($complaint['id']) ?>" class="btn btn-info btn-sm">ดูรายละเอียด</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center text-muted">ยังไม่มีข้อมูลร้องทุกข์ / ร้องเรียน</p>
                <?php endif; ?>

                <!-- Go Back Button -->
                <!-- Go Back Button -->
                <div class="text-center mt-4">
                    <button onclick="goBackWithUserId();" class="btn btn-back" style="background-color:rgb(221, 177, 32); color: black;">ย้อนกลับ</button>
                </div>

            

            </div>
        </div>
    </div>
    <script>
                    function goBackWithUserId() {
                        // Get the user_id from PHP
                        const userId = <?= json_encode($_SESSION['user']['user_id']) ?>;
                        // Redirect to a specific page with the user_id as a query parameter
                        window.location.href = `secondpage.php`;
                    }
    </script>                
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
