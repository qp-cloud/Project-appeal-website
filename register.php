<?php
// Database connection
$servername = "localhost";
$username = "root"; // ชื่อผู้ใช้งาน MySQL
$password = "";     // รหัสผ่าน MySQL
$dbname = "web_appeal_db"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบ method ว่าเป็น POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $id_number = $_POST['id_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, id_number, gender, birth_date, occupation, phone, email, address,username,password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
    if ($stmt) {
        $stmt->bind_param("sssssssssss", $first_name, $last_name, $id_number, $gender, $birth_date, $occupation, $phone, $email, $address,$username,$password);
        if ($stmt->execute()) {
            $message = "ลงทะเบียนสำเร็จ!";
        } else {
            $message = "เกิดข้อผิดพลาด: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
    }
    $conn->close();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form processing code goes here
    // Example: save the form data to the database
    
    // After processing, redirect to login.html
    header('Location: login.html');
    exit();
}
?>
