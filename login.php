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

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    // Prepare SQL query
    $sql = "SELECT username, password FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Output any errors in preparing the query
        die("Error preparing the SQL query: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'username' => $user['username'],
                'role' => 'user' // or other roles as per your setup
            ];
            header("Location: secondpage.php"); // Redirect to the main page after login
            exit();
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('ไม่พบชื่อผู้ใช้งาน'); window.location.href='login.html';</script>";
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
