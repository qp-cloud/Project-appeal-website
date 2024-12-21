<?php
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
?>