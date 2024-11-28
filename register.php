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
    // รับข้อมูลจากฟอร์มและกรองข้อมูล
    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $id_number = htmlspecialchars(trim($_POST['id_number'] ?? ''));
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
    $birth_date = htmlspecialchars(trim($_POST['birth_date'] ?? ''));
    $occupation = htmlspecialchars(trim($_POST['occupation'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));

    // ตรวจสอบว่าชื่อผู้ใช้หรือรหัสผ่านไม่ว่าง
    if (empty($username) || empty($password)) {
        die("กรุณากรอกชื่อผู้ใช้งานและรหัสผ่าน.");
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare(
        "INSERT INTO user (first_name, last_name, id_number, gender, birth_date, occupation, phone, email, address, username, password) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    
    if ($stmt) {
        // ผูกข้อมูลลงใน SQL Statement
        $stmt->bind_param(
            "sssssssssss", 
            $first_name, $last_name, $id_number, $gender, $birth_date, 
            $occupation, $phone, $email, $address, $username, $hashed_password
        );

        // ตรวจสอบการดำเนินการ
        if ($stmt->execute()) {
            // แสดงข้อความแจ้งและเปลี่ยนหน้าไปยัง login.html
            echo "<script>
                    alert('ลงทะเบียนสำเร็จ!');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
    }
    $conn->close();
}
?>
