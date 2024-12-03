<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_appeal_db";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
        exit;
    }

    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo "<script>alert('เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $conn->connect_error . "');</script>";
        exit;
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO contact_table (name, email, phone, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Statement preparation failed: " . $conn->error . "');</script>";
        exit;
    }

    // Bind parameters
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Execute query
    if ($stmt->execute()) {
        echo "<script>alert('ข้อมูลถูกบันทึกเรียบร้อยแล้ว'); window.location.href = 'home.html';</script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error . "');</script>";
        exit;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
