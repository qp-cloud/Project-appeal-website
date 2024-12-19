<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_appeal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $id_number = $_POST['id_number'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $occupation = $_POST['occupation'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $department = $_POST['department']; // รับค่า department



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

    // Add 'role' as admin
    $role = 'admin';

    // Prepare SQL query to insert data into the user table
    $stmt = $conn->prepare(
        "INSERT INTO user (first_name, last_name, id_number, gender, birth_date, occupation, phone, email, address, username, password, role, department) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt) {
        $stmt->bind_param(
            "sssssssssssss", 
            $first_name, $last_name, $id_number, $gender, $birth_date, 
            $occupation, $phone, $email, $address, $username, $hashed_password, $role, $department
        );

        if ($stmt->execute()) {
            echo "<script>
                    alert('ลงทะเบียนสำเร็จ!');
                    window.location.href = 'admin_login.html';
                  </script>";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ข้อผิดพลาดใน SQL: " . $conn->error;
    }
}

$conn->close();
?>
