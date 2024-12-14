
<?php
session_start();

// Ensure the session contains user information
if (!isset($_SESSION['user'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Create a database connection
$servername = "localhost";  // Change this to your server's address if needed
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "web_appeal_db";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If username is provided in the query string, search for the user
if (isset($_GET['username'])) {
    $search_username = $_GET['username'];

    // Query to fetch the user details by username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $search_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit();
    }

    $stmt->close();
} else {
    echo "No username specified!";
    exit();
}

// Get current user details
$first_name = isset($user['first_name']) ? $user['first_name'] : '';
$last_name = isset($user['last_name']) ? $user['last_name'] : '';
$occupation = isset($user['occupation']) ? $user['occupation'] : '';
$phone = isset($user['phone']) ? $user['phone'] : '';
$email = isset($user['email']) ? $user['email'] : '';
$address = isset($user['address']) ? $user['address'] : '';

// Check if the form is submitted to update details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated details from the form
    $updated_first_name = $_POST['first_name'];
    $updated_last_name = $_POST['last_name'];
    $updated_occupation = $_POST['occupation'];
    $updated_phone = $_POST['phone'];
    $updated_email = $_POST['email'];
    $updated_address = $_POST['address'];

    // Get the user's ID from the session (make sure this is set when the user logs in)
    $user_id = $user['user_id'];

    // Prepare the UPDATE SQL query
    $stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ?, occupation = ?, phone = ?, email = ?, address = ? WHERE user_id = ?");
    $stmt->bind_param("ssssssi", $updated_first_name, $updated_last_name, $updated_occupation, $updated_phone, $updated_email, $updated_address, $user_id);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Update session data with the new values
        $_SESSION['user']['first_name'] = $updated_first_name;
        $_SESSION['user']['last_name'] = $updated_last_name;
        $_SESSION['user']['occupation'] = $updated_occupation;
        $_SESSION['user']['phone'] = $updated_phone;
        $_SESSION['user']['email'] = $updated_email;
        $_SESSION['user']['address'] = $updated_address;

        // Redirect with a success message
        header("Location: edit_account.php?username=" . $search_username . "&status=success");
        exit();
    } else {
        // Handle SQL errors
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>แก้ไขข้อมูลบัญชี - เทศบาลอำเภอบ้านโป่ง</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f8ff;
    }
    .header {
      background: #ffffff;
      color: #000;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 5px solid #2a7cff;
      border-radius: 15px;
      width: 90%;
      margin: 20px auto;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .header img {
      height: 100px;
    }
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 50px auto;
      width: 50%;
      text-align: center;
    }
    h1 {
      color: #2a7cff;
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      width: 100%;
    }
    label {
      font-size: 16px;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 2px solid #ddd;
      border-radius: 5px;
    }
    textarea {
      resize: vertical;
      height: 80px;
    }
    .invalid-feedback {
      color: red;
      font-size: 14px;
      display: none;
    }
    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .button-container button {
      padding: 12px 25px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin: 0 10px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .save-button {
      background-color: #2a7cff;
      color: #fff;
    }
    .cancel-button {
      background-color: #ff6666;
      color: #fff;
    }
    .footer {
      background-color: #ffffff;
      padding: 25px;
      font-size: 14px;
      color: #666;
      text-align: center;
      margin-top: 50px;
    }
    .footer p {
      margin: 5px 0;
    }
  </style>
</head>
<body>

  <div class="header">
    <img src="logo.png" alt="Ban Pong Municipality Logo">
    <div class="user-info">
      <a href="secondpage.php" style="color: #2a7cff; text-decoration: none;">กลับสู่หน้าหลัก</a>
    </div>
  </div>

  <div class="container">
    <h1>แก้ไขข้อมูลบัญชีผู้ใช้</h1>

    <!-- Display success message if update is successful -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
      <p style="color: green;">ข้อมูลของคุณได้รับการอัปเดตสำเร็จ!</p>
    <?php endif; ?>

    <form method="POST" action="edit_account.php?username=<?= htmlspecialchars($search_username) ?>" class="needs-validation" novalidate>
      <label for="first-name">ชื่อจริง:</label>
      <input type="text" id="first-name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>
      <div class="invalid-feedback">กรุณากรอกชื่อจริง</div>

      <label for="last-name">นามสกุล:</label>
      <input type="text" id="last-name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>
      <div class="invalid-feedback">กรุณากรอกนามสกุล</div>

      <label for="occupation">อาชีพ:</label>
      <input type="text" id="occupation" name="occupation" value="<?= htmlspecialchars($occupation) ?>" required>
      <div class="invalid-feedback">กรุณากรอกอาชีพ</div>

      <label for="phone">เบอร์โทรศัพท์:</label>
      <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" pattern="[0-9]{10}" maxlength="10" required 
             oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="กรอก 10 หลัก">
      <div class="invalid-feedback">กรุณากรอกเบอร์โทรศัพท์ 10 หลัก</div>

      <label for="email">อีเมล:</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
      <div class="invalid-feedback">กรุณากรอกอีเมล</div>

      <label for="address">ที่อยู่:</label>
      <textarea id="address" name="address" required><?= htmlspecialchars($address) ?></textarea>
      <div class="invalid-feedback">กรุณากรอกที่อยู่</div>

      <div class="button-container">
        <button type="submit" class="save-button">บันทึก</button>
        <button type="button" class="cancel-button" onclick="window.location.href='secondpage.php'">ยกเลิก</button>
        <button type="button" class="delete-button" onclick="window.location.href='delete_account.php'">ลบบัญชี</button>
      </div>
    </form>
  </div>

  <div class="footer">
    <p>เทศบาลเมืองบ้านโป่ง BANPONG MUNICIPALITY</p>
    <p>ถนนบ้านดอนตูม จังหวัดราชบุรี 70110</p>
    <p>โทรศัพท์ : 0-3222-1001, 0-3221-1114 | โทรสาร : 0-3222-1975</p>
    <p>Email : admin@banpong.go.th</p>
  </div>

  <script>
    // Your JS validation code here
  </script>

</body>
</html>