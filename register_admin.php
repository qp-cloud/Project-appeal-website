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
    // Sanitize and validate input
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $id_number = htmlspecialchars(trim($_POST['id_number']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $birth_date = htmlspecialchars(trim($_POST['birth_date']));
    $occupation = htmlspecialchars(trim($_POST['occupation']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $department = htmlspecialchars(trim($_POST['department']));

    if (empty($username) || empty($password)) {
        die("กรุณากรอกชื่อผู้ใช้งานและรหัสผ่าน.");
    }

    // Check for duplicate username or ID number
    $check_user_sql = "SELECT * FROM user WHERE username = ? OR id_number = ?";
    $stmt_check_user = $conn->prepare($check_user_sql);
    $stmt_check_user->bind_param("ss", $username, $id_number);
    $stmt_check_user->execute();
    $result = $stmt_check_user->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('ข้อมูลซ้ำ! ชื่อผู้ใช้หรือหมายเลขบัตรประชาชนมีอยู่แล้ว.');
                window.location.href = 'admin_register.html';
              </script>";
        exit();
    }

    // Check for duplicate phone number
    $check_phone_sql = "SELECT * FROM user WHERE phone = ?";
    $stmt_check_phone = $conn->prepare($check_phone_sql);
    $stmt_check_phone->bind_param("s", $phone);
    $stmt_check_phone->execute();
    $result_phone = $stmt_check_phone->get_result();

    if ($result_phone->num_rows > 0) {
        echo "<script>
                alert('หมายเลขโทรศัพท์นี้ถูกใช้งานแล้ว กรุณากรอกหมายเลขใหม่.');
                window.location.href = 'admin_register.html';
              </script>";
        exit();
    }

    // Assign role
    $role = 'admin';

    // Prepare SQL query to insert data
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
            exit();
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
