<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'db_web.php';
// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        $user_id = $_SESSION['user']['user_id'];

        $stmt = $conn->prepare("DELETE FROM complaints WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM appeals WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete user from the database (cascading delete will handle related complaints)
        $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Destroy the session and redirect to goodbye page
            session_destroy();
            header("Location: goodbye.php");
            exit();
        } else {
            $error_message = "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ยืนยันการลบบัญชี</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f8f8f8;
      padding: 50px;
    }
    h1 {
      color: #ff3333;
    }
    p {
      font-size: 18px;
      color: #333;
    }
    textarea {
      width: 80%;
      height: 100px;
      margin-top: 20px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
      resize: none;
    }
    .button-container {
      margin-top: 20px;
    }
    button {
      padding: 12px 25px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 10px;
      font-weight: bold;
    }
    .confirm-button {
      background-color: #ff3333;
      color: white;
    }
    .cancel-button {
      background-color: #2a7cff;
      color: white;
    }
    button:hover {
      opacity: 0.9;
    }
    .error {
      color: red;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <h1>ยืนยันการลบบัญชีของคุณ</h1>
  <p>ท่านมั่นใจหรือไม่ว่าต้องการลบบัญชีผู้ใช้งาน? การดำเนินการนี้ไม่สามารถย้อนกลับได้</p>
  <p>ข้อมูลเกี่ยวกับการร้องเรียนหรือการทุจริตจะถูกลบออกด้วย</p>


  <!-- Display error message if deletion fails -->
  <?php if (isset($error_message)): ?>
      <p class="error"><?= htmlspecialchars($error_message) ?></p>
  <?php endif; ?>

  <form method="POST" action="delete_account.php">
    <div class="button-container">
      <button type="submit" name="confirm_delete" class="confirm-button">ยืนยันลบบัญชี</button>
      <button type="button" class="cancel-button" onclick="window.location.href='secondpage.php'">ยกเลิก</button>
    </div>
  </form>
</body>
</html>
