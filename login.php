<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.location.href='login.html';</script>";
        exit();
    }

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "web_appeal_db";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    $sql = "SELECT username, password FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: secondpage.html");
            exit();
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('ไม่พบชื่อผู้ใช้งาน'); window.location.href='login.html';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
