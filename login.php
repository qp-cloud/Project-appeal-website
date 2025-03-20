<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.location.href='login.html';</script>";
        exit();
    }

    include 'db_web.php';

    // Prepare SQL query to fetch user details
    $sql = "SELECT user_id, username, password, first_name, last_name, role, status, department FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
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

        // Check if the account is deactivated
        if ($user['status'] === 'deactivated') {
            echo "<script>alert('บัญชีของคุณถูกปิดใช้งาน กรุณาติดต่อผู้ดูแลระบบ'); window.location.href='login.html';</script>";
            exit();
        }

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user info and role in session
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'first_name' => $user['first_name'], // Store first name
                'last_name' => $user['last_name'],   // Store last name
                'role' => $user['role'],             // Store role
                'department' => $user['department']  // Store department
            ];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: secondpage.php"); // Redirect for admin
            } else {
                header("Location: secondpage.php"); // Redirect for regular user
            }
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