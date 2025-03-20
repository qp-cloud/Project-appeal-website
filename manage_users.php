<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']['user_id']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: login.php");  // Redirect to login page if not an admin
    exit();
}

include 'db_web.php';

// Handle deactivate/reactivate actions
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $user_id = $conn->real_escape_string($_GET['user_id']);
    $action = $_GET['action']; // 'deactivate' or 'reactivate'
    $admin_id = $_SESSION['user']['user_id']; // Admin who is performing the action

    // Update user status
    $new_status = ($action == 'deactivate') ? 'deactivated' : 'active';
    $sql = "UPDATE user SET status = '$new_status' WHERE user_id = '$user_id'";
    if ($conn->query($sql)) {
        // Log the action
        $log_action = ($action == 'deactivate') ? 'deactivate_user' : 'reactivate_user';
        $log_sql = "INSERT INTO activity_logs (user_id, action, performed_by, timestamp) 
                    VALUES ('$user_id', '$log_action', '$admin_id', NOW())";
        $conn->query($log_sql);

        // Redirect back with a success message
        $_SESSION['message'] = "User $action successfully!";
        header("Location: manage_users.php");
        exit();
    } else {
        // Handle database error
        $_SESSION['error'] = "Error updating user status: " . $conn->error;
        header("Location: manage_users.php");
        exit();
    }
}

// Fetch all users with role 'user'
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM user WHERE role = 'user' 
        AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR username LIKE '%$search%')";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้งาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
        .btn-action {
            margin: 2px;
        }
        .search-bar {
            max-width: 500px;
            margin: 0 auto;
        }
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-deactivated {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <h1 class="card-title">จัดการผู้ใช้งาน</h1>
                <p class="card-text">ระบบจัดการข้อมูลผู้ใช้งานทั้งหมด</p>
            </div>
            <a href="activity_logs.php">ประวัติระบบจัดการข้อมูลผู้ใช้งานทั้งหมด</a>
        </div>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="manage_users.php" class="search-bar">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ค้นหาผู้ใช้งาน..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>ค้นหา</button>
                        <a href="manage_users.php" class="btn btn-secondary"><i class="fas fa-sync me-2"></i>รีเซ็ต</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="userTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>เลขประจำตัว</th>
                                <th>เพศ</th>
                                <th>วันเกิด</th>
                                <th>อาชีพ</th>
                                <th>โทรศัพท์</th>
                                <th>อีเมล</th>
                                <th>ที่อยู่</th>
                                <th>ชื่อผู้ใช้</th>
                                <th>วันที่สร้าง</th>
                                <th>วันที่อัปเดต</th>
                                <th>แผนก</th>
                                <th>สถานะ</th>
                                <th>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['first_name']) ?></td>
                                        <td><?= htmlspecialchars($row['last_name']) ?></td>
                                        <td><?= htmlspecialchars($row['id_number']) ?></td>
                                        <td><?= htmlspecialchars($row['gender']) ?></td>
                                        <td><?= htmlspecialchars($row['birth_date']) ?></td>
                                        <td><?= htmlspecialchars($row['occupation']) ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['address']) ?></td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                                        <td><?= htmlspecialchars($row['updated_at']) ?></td>
                                        <td><?= htmlspecialchars($row['department']) ?></td>
                                        <td>
                                            <span class="<?= $row['status'] == 'active' ? 'status-active' : 'status-deactivated' ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 'active'): ?>
                                                <a href="manage_users.php?action=deactivate&user_id=<?= $row['user_id'] ?>" 
                                                   class="btn btn-danger btn-sm btn-action"><i class="fas fa-ban me-1"></i>ปิดใช้งาน</a>
                                            <?php else: ?>
                                                <a href="manage_users.php?action=reactivate&user_id=<?= $row['user_id'] ?>" 
                                                   class="btn btn-success btn-sm btn-action"><i class="fas fa-check-circle me-1"></i>เปิดใช้งาน</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="15" class="text-center">ไม่มีผู้ใช้งาน</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="text-center mt-4">
        <a href="admin_page.php" class="btn btn-primary">ย้อนกลับ</a>
    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                paging: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json' // Thai translation
                }
            });
        });
    </script>
</body>
</html>