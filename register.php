<?php
// Database connection
include 'db_web.php';

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

    // ตรวจสอบว่า username หรือ id_number มีอยู่ในฐานข้อมูลแล้วหรือไม่
    $check_user_sql = "SELECT * FROM user WHERE username = ? OR id_number = ?";
    $stmt_check_user = $conn->prepare($check_user_sql);
    $stmt_check_user->bind_param("ss", $username, $id_number);
    $stmt_check_user->execute();
    $result = $stmt_check_user->get_result();

    if ($result->num_rows > 0) {
        // ถ้าข้อมูลซ้ำ ให้แสดงข้อความแจ้งเตือน
        echo "<script>
                alert('ข้อมูลซ้ำ! ชื่อผู้ใช้หรือหมายเลขบัตรประชาชนมีอยู่แล้ว.');
                window.location.href = 'register.html';
              </script>";
        exit();
    }

    // ตรวจสอบว่า email มีอยู่ในฐานข้อมูลแล้วหรือไม่
    $check_email_sql = "SELECT * FROM user WHERE email = ?";
    $stmt_check_email = $conn->prepare($check_email_sql);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_email = $stmt_check_email->get_result();

    if ($result_email->num_rows > 0) {
        // ถ้า email ซ้ำ ให้แสดงข้อความแจ้งเตือน
        echo "<script>
                alert('อีเมลนี้ถูกใช้งานแล้ว กรุณากรอกอีเมลใหม่.');
                window.location.href = 'register.html';
              </script>";
        exit();
    }

    // ตรวจสอบว่า phone มีอยู่ในฐานข้อมูลแล้วหรือไม่
    $check_phone_sql = "SELECT * FROM user WHERE phone = ?";
    $stmt_check_phone = $conn->prepare($check_phone_sql);
    $stmt_check_phone->bind_param("s", $phone);
    $stmt_check_phone->execute();
    $result_phone = $stmt_check_phone->get_result();

    if ($result_phone->num_rows > 0) {
        echo "<script>
                alert('หมายเลขโทรศัพท์นี้ถูกใช้งานแล้ว กรุณากรอกหมายเลขใหม่.');
                window.location.href = 'register.html';
            </script>";
        exit();
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
