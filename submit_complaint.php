<?php
include 'db_web.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_POST['user_id'];
    $complaint_subject = $_POST['complaint_subject'];
    $contact_phone = $_POST['contact_phone'];
    $contact_location = $_POST['contact_location'];
    $contact_details = $_POST['contact_details'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $incident_date = $_POST['incident_date'];
    $incident_time = $_POST['incident_time'];
    $problem_level = $_POST['problem_level'];
    $department = $_POST['department'];
    $complaint_description = $_POST['complaint_description'];
    $privacy_consent = isset($_POST['privacy_consent']) ? 1 : 0;  // 1 if consent is given, 0 otherwise
    
    // Handle file upload
    $complaint_file = '';
    if (isset($_FILES['complaint_file']) && $_FILES['complaint_file']['error'] == 0) {
        $file_name = $_FILES['complaint_file']['name'];
        $file_tmp_name = $_FILES['complaint_file']['tmp_name'];
        $file_upload_dir = 'uploads/';  // Directory where the file will be saved
        $file_upload_path = $file_upload_dir . basename($file_name);

        // Move the uploaded file to the server
        if (move_uploaded_file($file_tmp_name, $file_upload_path)) {
            $complaint_file = $file_upload_path;
        }
    }

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO complaints (user_id, complaint_subject, contact_phone, contact_location, contact_details, latitude, longitude, incident_date, incident_time, problem_level, department, complaint_description, complaint_file, privacy_consent)
            VALUES ('$user_id', '$complaint_subject', '$contact_phone', '$contact_location', '$contact_details', '$latitude', '$longitude', '$incident_date', '$incident_time', '$problem_level', '$department', '$complaint_description', '$complaint_file', '$privacy_consent')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to the confirmation page
        header("Location: confirmation_page.php");
        exit();  // Ensure no further code is executed after the redirect
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
