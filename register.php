<?php
// Database connection
$servername = "localhost";  // Your database host
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "registration_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required form fields are set before accessing them
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['id_number'], $_POST['gender'], $_POST['birth_date'], $_POST['occupation'], $_POST['phone'], $_POST['email'], $_POST['address'])) {
        // Collect form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $id_number = $_POST['id_number'];
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $occupation = $_POST['occupation'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        // SQL query to insert data into the database
        $sql = "INSERT INTO users (first_name, last_name, id_number, gender, birth_date, occupation, phone, email, address)
                VALUES ('$first_name', '$last_name', '$id_number', '$gender', '$birth_date', '$occupation', '$phone', '$email', '$address')";

        // Check if the data was inserted successfully
        if ($conn->query($sql) === TRUE) {
            $message = "ลงทะเบียนสำเร็จ!"; // Success message
        } else {
            $message = "เกิดข้อผิดพลาด: " . $conn->error; // Error message
        }
    } else {
        $message = "กรุณากรอกข้อมูลให้ครบถ้วน!"; // Error message if required fields are missing
    }
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    
  <div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="header-nav">
      <nav>
        <ul>
          <a href="login.html">เข้าสู่ระบบ</a>
          <a href="contact.html">ติดต่อเรา</a>
          <a href="home.html">หน้าแรก</a>
        </ul>
      </nav>
    </div>
  </div>
</body>
</html>
