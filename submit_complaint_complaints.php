<?php
session_start();

include 'db_web.php';

// Ensure the complaint_id is passed
if (!isset($_POST['complaint_id'])) {
    echo "Complaint ID is missing!";
    exit();
}

$complaint_id = $_POST['complaint_id'];

// Update the complaint status or process the complaint here
$sql = "UPDATE complaints SET status = 'Submitted' WHERE complaint_id = '$complaint_id'";

if ($conn->query($sql) === TRUE) {
    echo "Complaint submitted successfully!";
    // You can redirect to a confirmation page or home page
    header("Location: confirmation_success.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
