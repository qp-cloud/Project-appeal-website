<?php
// login.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform simple validation
    if (empty($username) || empty($password)) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน.";
    } else {
        // Here you would connect to your database and check the username and password.
        // Example (replace with real database checks):
        $stored_username = "admin";  // Example username
        $stored_password = "password123";  // Example password

        if ($username === $stored_username && $password === $stored_password) {
            // Redirect to home page if login is successful
            header("Location: home.html");
            exit();
        } else {
            // Display error message if login fails
            echo "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง.";
        }
    }
}
?>
pph