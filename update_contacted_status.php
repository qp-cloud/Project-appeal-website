<?php
// Start the session for potential login check or error handling
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_appeal_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Get the current 'contacted_back' status
    $sql = "SELECT contacted_back FROM contact_table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_status = $row['contacted_back'] == 1 ? 0 : 1; // Toggle the status (1 to 0 or 0 to 1)

        // Update the 'contacted_back' status
        $update_sql = "UPDATE contact_table SET contacted_back = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_status, $id);
        $update_stmt->execute();

        // Set a session message
        $_SESSION['message'] = "สถานะการตอบกลับของผู้ติดต่อได้ถูกอัพเดตแล้ว";

        // Redirect back to the view contact page
        header("Location: view_contact.php");
        exit();
    } else {
        $_SESSION['message'] = "ไม่พบข้อมูลผู้ติดต่อ";
        header("Location: view_contact.php");
        exit();
    }
} else {
    $_SESSION['message'] = "ข้อมูลไม่ถูกต้อง";
    header("Location: view_contact.php");
    exit();
}

// Close the database connection
$conn->close();
?>
