<?php
session_start();
include 'db_web.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $responded_by = $_POST['responded_by'];

    // Check if the 'contacted_back' is already set to 1 (i.e., already responded)
    $sql_check = "SELECT contacted_back FROM contact_table WHERE id = $id";
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();

    if ($row_check['contacted_back'] == 1) {
        // If already contacted back, prevent updating again
        $_SESSION['message'] = "ไม่สามารถตอบกลับได้อีกครั้ง";
    } else {
        // If not yet responded, mark as contacted back
        $sql_update = "UPDATE contact_table SET contacted_back = 1, responded_by = ?, responded_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param('si', $responded_by, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "ตอบกลับสำเร็จ";
        } else {
            $_SESSION['message'] = "เกิดข้อผิดพลาดในการอัพเดต";
        }
    }
}

// Redirect back to the contact form submissions page
header('Location: view_contact.php');
exit;
?>
