<?php
// Start the session for potential login check or error handling
session_start();

include 'db_web.php';

// Define items per page
$items_per_page = 20;

// Calculate the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Handle filter for 'Contacted Back' status
$filter_contacted_back = isset($_GET['contacted_back']) ? $_GET['contacted_back'] : '';

// Query to get total number of records
$sql_count = "SELECT COUNT(id) AS total FROM contact_table";
if ($filter_contacted_back !== '') {
    $sql_count .= " WHERE contacted_back = " . ($filter_contacted_back == '1' ? "1" : "0");
}
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_items = $row_count['total'];

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);

// Query to get all contact form submissions, with optional filter for contacted_back status and pagination
$sql = "SELECT id, name, contact, message, submitted_at, contacted_back FROM contact_table";
if ($filter_contacted_back !== '') {
    $sql .= " WHERE contacted_back = " . ($filter_contacted_back == '1' ? "1" : "0");
}
$sql .= " ORDER BY submitted_at DESC LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Form Submissions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-image: url('img/adminbg.jpg');
        background-size: cover;
        background-attachment: fixed;
    }
    .header {
        background: #333;
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: center; /* จัดวางข้อความแนวนอนตรงกลาง */
        align-items: center; /* จัดวางข้อความแนวตั้งตรงกลาง */
        border: 5px solid #2a7cff;
        border-radius: 15px;
        width: 90%;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center; /* ข้อความภายในอยู่ตรงกลาง */
    }
    .header h1 {
        margin: 0; /* เอา Margin ออกเพื่อจัดตำแหน่งให้พอดี */
    }
    .table {
        background-color: white;
    }
    .table th,
    .table td {
        background-color: white; /* พื้นหลังของเซลล์ */
    }
    .table-container {
        padding: 20px;
        max-width: 70%; /* กำหนดความกว้างสูงสุดของตารางเป็น 80% ของหน้าจอ */
        margin: 0 auto; /* จัดตารางให้อยู่ตรงกลาง */
    }.alert-container {
        display: flex;
        justify-content: center; /* จัดข้อความให้อยู่ตรงกลาง */
        margin-top: 20px; /* เพิ่มระยะห่างจากด้านบน */
    }
    .alert {
        max-width: 600px; /* กำหนดความกว้างสูงสุด */
        width: 90%; /* กำหนดให้ปรับตามขนาดหน้าจอ */
        text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงา */
    }
</style>

<body>
    <div class="container mt-5">
        <header class="header">
            <h1>แผงควบคุมผู้ดูแลระบบ - การส่งแบบฟอร์มการติดต่อ</h1>
        </header>
    </div>

    <!-- Filter options for 'Contacted Back' status -->
    <div class="text-center mt-4">
        <a href="?contacted_back=1" class="btn btn-success">แสดงที่ตอบกลับแล้ว</a>
        <a href="?contacted_back=0" class="btn btn-danger">แสดงที่ยังไม่ตอบกลับ</a>
        <a href="view_contact.php" class="btn btn-primary">แสดงทั้งหมด</a>
    </div>


    <!-- Table to display contact form data -->
    <div class="table-responsive table-container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>วันเวลาที่ส่งการติดต่อ</th>
                    <th>ชื่อผู้ติดต่อ</th>
                    <th>ข้อมูลการติดต่อกลับ</th>
                    <th>ข้อความ</th>
                    <th>สถานะการตอบกลับ</th>
                    <th>เปลี่ยนสถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any rows returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $contacted_back = $row['contacted_back'] ? 'ตอบกลับแล้ว' : 'ยังไม่ตอบกลับ';
                        $button_text = $row['contacted_back'] ? 'ยกเลิกการตอบกลับ' : 'ทำเครื่องหมายว่าตอบกลับแล้ว';
                        $button_class = $row['contacted_back'] ? 'btn-warning' : 'btn-success';
                        echo "<tr>
                                <td>{$row['submitted_at']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['message']}</td>
                                <td>{$contacted_back}</td>
                                <td>
                                    <form method='POST' action='update_contacted_status.php'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' class='btn $button_class'>$button_text</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>ไม่พบข้อมูลการส่งการติดต่อ</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    // Display any session message
    if (isset($_SESSION['message'])) {
        echo "
        <div class='alert-container'>
            <div class='alert alert-success'>{$_SESSION['message']}</div>
        </div>";
        unset($_SESSION['message']);
    }
    ?>

   <!-- Pagination Controls -->
    <div class="d-flex justify-content-center">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=1<?= $filter_contacted_back ? '&contacted_back=' . $filter_contacted_back : '' ?>">แรก</a></li>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?><?= $filter_contacted_back ? '&contacted_back=' . $filter_contacted_back : '' ?>">ก่อนหน้า</a></li>
            <?php endif; ?>

            <li class="page-item disabled"><span class="page-link"><?= $page ?> จาก <?= $total_pages ?></span></li>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?><?= $filter_contacted_back ? '&contacted_back=' . $filter_contacted_back : '' ?>">ถัดไป</a></li>
                <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?><?= $filter_contacted_back ? '&contacted_back=' . $filter_contacted_back : '' ?>">สุดท้าย</a></li>
            <?php endif; ?>
        </ul>
    </div>


    <div class="text-center mt-4">
        <a href="admin_page.php" class="btn btn-primary">ย้อนกลับ</a>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
