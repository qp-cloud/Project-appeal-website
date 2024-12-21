<?php
// Start session for user authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

include 'db_web.php';
// Get user_id from session
$user_id = $_SESSION['user']['user_id'];

// Number of records per page
$limit = 10;

// Get the current page from the URL (default is 1 if not set)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get the total number of complaints to calculate the number of pages
$total_sql = "SELECT COUNT(*) FROM appeals WHERE user_id = ?";
if ($stmt = $conn->prepare($total_sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_appeals);
    $stmt->fetch();
    $stmt->close();
}

// Calculate total pages
$total_pages = ceil($total_appeals / $limit);

// Retrieve the complaints for the current page
$sql = "SELECT id, report_subject, category, report_person, contact_phone, contact_location,
        latitude, longitude, incident_date, incident_time, problem_level, department, 
        complaint_description, complaint_file, submitted_at, status
        FROM appeals 
        WHERE user_id = ? 
        ORDER BY submitted_at DESC
        LIMIT ?, ?";
if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("iii", $user_id, $offset, $limit);  // "iii" for three integers

    // Execute the statement
    $stmt->execute();
    
    // Bind the result to variables
    $stmt->bind_result($id, $report_subject, $category, $report_person, $contact_phone, $contact_location, 
                       $latitude, $longitude, $incident_date, $incident_time, 
                       $problem_level, $department, $complaint_description, $complaint_file, 
                       $submitted_at, $status);

    // Fetch the complaints
    $appeals = [];
    while ($stmt->fetch()) {
        $appeals[] = [
            'id' => $id,
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
            background-size: cover;
        }
        .table {
            background-color: #fff;
        }
        .table th {
            background-color: #17a2b8;
            color: #F8F8FF;
        }
        .card {
            margin-top: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-info {
            background-color: #99FF99;
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
        .pagination .page-item.active .page-link {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">ติดตามรายงานผลการแจ้งเบาะแสการทุจริตประพฤติมิชอบ</h2>

                <!-- Display complaints if available -->
                <?php if (!empty($appeals)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>เรื่องร้องเรียน</th>
                                <th>หมวดหมู่การแจ้งเบาะแส</th>
                                <th>วันที่เกิดเหตุ</th>
                                <th>ระดับปัญหา</th>
                                <th>สถานะ</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appeals as $appeal): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appeal['report_subject']) ?></td>
                                    <td><?= htmlspecialchars($appeal['category']) ?></td>
                                    <td><?= htmlspecialchars($appeal['incident_date']) ?></td>
                                    <td><?= htmlspecialchars($appeal['problem_level']) ?></td>
                                    <td><?= htmlspecialchars($appeal['status']) ?></td>
                                    <td>
                                        <a href="appeal_detail.php?id=<?= urlencode($appeal['id']) ?>" class="btn btn-info btn-sm">ดูรายละเอียด</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center text-muted">ยังไม่มีข้อมูลการแจ้งเบาะแสกรทุจริตประพฤติมิชอบ</p>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=1" aria-label="First">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <!-- Page Number Links -->
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $total_pages ?>" aria-label="Last">
                                    <span aria-hidden="true">&raquo;&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

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
