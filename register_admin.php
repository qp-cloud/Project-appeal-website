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
            echo "ลงทะเบียนสำเร็จ!";
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
