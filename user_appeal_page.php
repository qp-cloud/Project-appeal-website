<?php
// Start session for user authentication
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "web_appeal_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the URL
$logged_in_username = isset($_GET['username']) ? $_GET['username'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';  // Fallback to guest if no session is available

if ($logged_in_username) {
    // Retrieve the user ID from the user table based on the username
    $sql = "SELECT user_id, username FROM user WHERE username = '$logged_in_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user ID and username
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $username = $row['username'];  // Set the username from the database
    } else {
        echo "User not found!";
        exit();
    }
} else {
    echo "Username parameter is missing!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
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

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_types) && $_FILES['complaint_file']['size'] < 5000000) {  // 5MB limit
            if (move_uploaded_file($file_tmp_name, $file_upload_path)) {
                $complaint_file = $file_upload_path;
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type or file size exceeded.";
            exit();
        }
    }

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO complaints (user_id, complaint_subject, contact_phone, contact_location, contact_details, latitude, longitude, incident_date, incident_time, problem_level, department, complaint_description, complaint_file, privacy_consent)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssssssi", $user_id, $complaint_subject, $contact_phone, $contact_location, $contact_details, $latitude, $longitude, $incident_date, $incident_time, $problem_level, $department, $complaint_description, $complaint_file, $privacy_consent);

    if ($stmt->execute()) {
        echo "ข้อมูลถูกส่งเรียบร้อยแล้ว!";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้า ร้องเรียน / ร้องทุกข์</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://api.longdo.com/map?key=35bbbe40a96e844b27eba45df1ddad0b"></script>
    <style>
        body {
            background-color: #a2e1ec;
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
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info span {
            margin-right: 15px;
            font-weight: bold;
            color: #2a7cff;
        }
        .user-info a {
            color: #fff;
            background-color: #2a7cff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .form-container {
            margin-top: 50px;
        }
        .error-message {
            color: red;
            font-size: 0.875rem;
        }
        .function-buttons a {
            display: inline-block;
            width: 300px;
            padding: 15px;
            margin: 15px;
            font-size: 18px;
            color: #fff;
            background-color: #2a7cff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .function-buttons a:hover {
            background-color: #1e60c3;
        }
        .custom-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .custom-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            width: 80%;
            max-width: 500px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            z-index: 1001;
        }
        .custom-modal h5 {
            margin-bottom: 15px;
            font-size: 1.2rem;
            text-align: center;
        }
        .custom-modal .modal-footer {
            text-align: center;
        }
        .custom-modal .modal-footer button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn-close {
            background: #ccc;
            color: #333;
        }
        .btn-agree {
            background: #007bff;
            color: white;
        }
        .btn-full-width {
            width: 100%;
            padding: 15px;
            font-size: 1.2rem;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="logo.png" alt="Ban Pong Municipality Logo">
        <div class="user-info">
        <span>ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user']['first_name']) ?> <?= htmlspecialchars($_SESSION['user']['last_name']) ?></span>
            <a href="secondpage.php">กลับสู่หน้าหลัก</a>
        </div>
    </div>
    <div class="container form-container">
        <h2 class="text-center mb-4">ร้องทุกข์ / ร้องเรียน</h2>

        <form id="complaint-form" action="user_appeal_page.php?username=<?= $username ?>" method="POST" enctype="multipart/form-data">
            <!-- Complaint Subject -->
            <div class="form-group">
                <label for="complaint-subject">เรื่องที่ต้องการร้องทุกข์ <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="complaint-subject" name="complaint_subject" required>
            </div>

            <!-- Contact Phone -->
            <div class="form-group">
                <label for="contact-phone">เบอร์โทรศัพท์ที่สามารถติดต่อได้ <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="contact-phone" name="contact_phone" required>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="contact-location">สถานที่</label>
                <input type="text" class="form-control" id="contact-location" name="contact_location">
            </div>

            <!-- Details -->
            <div class="form-group">
                <label for="contact-details">รายละเอียด</label>
                <textarea class="form-control" id="contact-details" name="contact_details" rows="4"></textarea>
            </div>

            <!-- Longdo Map (This is just a placeholder for the map) -->
            <div class="form-group">
                <label>ปักหมุดบนแผนที่</label>
                <div id="map" style="height: 200px; background-color: #ddd;">แผนที่</div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <!-- Incident Date and Time -->
            <div class="form-group">
                <label for="incident-time">เวลาที่เกิดเหตุหรือพบเหตุ</label>
                <div class="form-row">
                    <div class="col">
                        <input type="date" class="form-control" id="incident-date" name="incident_date">
                    </div>
                    <div class="col">
                        <input type="time" class="form-control" id="incident-time" name="incident_time">
                    </div>
                </div>
            </div>

            <!-- Problem Level -->
            <div class="form-group">
                <label for="problem-level">ระดับปัญหา</label>
                <select class="form-control" id="problem-level" name="problem_level">
                    <option value="ต่ำ">ต่ำ</option>
                    <option value="ปานกลาง">ปานกลาง</option>
                    <option value="สูง">สูง</option>
                </select>
            </div>

            <!-- Department -->
            <div class="form-group">
                <label for="department">หน่วยงานที่รับผิดชอบ</label>
                <select class="form-control" id="department" name="department">
                    <option value="เทศบาลเมือง">เทศบาลเมือง</option>
                    <option value="สำนักปลัดเทศบาลเมือง">สำนักปลัดเทศบาลเมือง</option>
                    <option value="กองคลัง">กองคลัง</option>
                    <option value="กองช่าง">กองช่าง</option>
                    <option value="กองการศึกษา">กองการศึกษา</option>
                    <option value="กองสาธารณสุข">กองสาธารณสุข</option>
                    <option value="กองสวัสดิการสังคม">กองสวัสดิการสังคม</option>
                    <option value="กองยุทธศาสตร์">กองยุทธศาสตร์</option>
                    <option value="กองการเจ้าหน้าที่">กองการเจ้าหน้าที่</option>
                    <option value="หน่วยตรวจสอบภายใน">หน่วยตรวจสอบภายใน</option>
                    <option value="หน่วยงานอื่นๆ">หน่วยงานอื่นๆ</option>
                </select>
            </div>

            <!-- Complaint Description -->
            <div class="form-group">
                <label for="complaint-description">รายละเอียดการร้องเรียน</label>
                <textarea class="form-control" id="complaint-description" name="complaint_description" rows="5"></textarea>
                <small class="error-message" id="complaint-description-error"></small>
            </div>

            <!-- File Upload -->
            <div class="form-group">
                <label for="complaint-file">ไฟล์ที่แนบ</label>
                <input type="file" class="form-control" id="complaint-file" name="complaint_file">
            </div>
            <form id="report-person-form">
            <!-- Form fields go here -->
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="privacy-consent" disabled>
                <label class="form-check-label" for="privacy-consent">
                    ยินยอมให้ข้อมูลส่วนบุคคล
                    <a href="#" id="show-agreement">[อ่านข้อตกลง]</a>
                </label>
            </div>
            <div id="confirmation-buttons" class="mt-3">
                <button type="button" class="btn btn-success btn-full-width" id="confirm-submit" disabled>ยืนยันการส่งข้อมูล</button>
                <button type="button" class="btn btn-danger btn-full-width" id="cancel-submit">ยกเลิก</button>
            </div>
        </form>
    </div>
    <!-- Custom Modal -->
    <div class="custom-modal-overlay" id="custom-modal-overlay"></div>
    <div class="custom-modal" id="custom-modal">
        <h5>ข้อตกลงการยินยอมให้ข้อมูลส่วนบุคคล</h5>
        <p>ข้อมูลส่วนบุคคลของท่านจะถูกใช้เพื่อประมวลผลคำร้องทุกข์/ร้องเรียนของท่านตามวัตถุประสงค์
            และจะถูกเก็บรักษาอย่างปลอดภัยภายใต้พระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ.2562</p>
        <div class="modal-footer">
            <button class="btn-close" id="btn-close">ยกเลิก</button>
            <button class="btn-agree" id="btn-agree">ตกลง</button>
        </div>
    </div>
    <script>
            // Show Agreement Modal
            document.getElementById('show-agreement').addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('custom-modal-overlay').style.display = 'block';
                document.getElementById('custom-modal').style.display = 'block';
            });
    
            // Close Modal
            document.getElementById('btn-close').addEventListener('click', function () {
                document.getElementById('custom-modal-overlay').style.display = 'none';
                document.getElementById('custom-modal').style.display = 'none';
            });
    
            // Agree to Consent
            document.getElementById('btn-agree').addEventListener('click', function () {
                document.getElementById('privacy-consent').checked = true;
                document.getElementById('privacy-consent').disabled = false;
                toggleConfirmButton();
                document.getElementById('custom-modal-overlay').style.display = 'none';
                document.getElementById('custom-modal').style.display = 'none';
            });
    
            // Enable/Disable Confirm Button
            document.getElementById('privacy-consent').addEventListener('change', function () {
                toggleConfirmButton();
            });
    
            function toggleConfirmButton() {
                const confirmButton = document.getElementById('confirm-submit');
                confirmButton.disabled = !document.getElementById('privacy-consent').checked;
            }
    
            // Cancel Button Action
            document.getElementById('cancel-submit').addEventListener('click', function () {
                alert('การส่งข้อมูลถูกยกเลิก');
                document.getElementById('report-form').reset();
                toggleConfirmButton();
            });
    
            // Confirm Button Action
            document.getElementById('confirm-submit').addEventListener('click', function (e) {
                e.preventDefault(); // Prevent page refresh
                alert('ส่งข้อมูลสำเร็จ');
                document.getElementById('report-form').reset();
                toggleConfirmButton();
            });
        </script>
    <script>
        let geolocation = { lat: 13.7367, lng: 100.5231 }; // Default location (Bangkok)
        map = new longdo.Map({
            placeholder: document.getElementById('map'),
            defaultCenter: geolocation,
            defaultZoom: 13
        });
        var script = document.createElement('script');
        script.src = "https://mapapi.longdo.com/mapapi?key=35bbbe40a96e844b27eba45df1ddad0b";
        script.onload = initMap;
        document.body.appendChild(script);

        $(document).ready(function() {

            // เปิด Modal เมื่อคลิกที่ลิงก์ "อ่านข้อตกลง"
            $('#show-agreement').click(function(e) {
                e.preventDefault();
            $('#agreement-modal').modal('show'); // เปิด Modal
            });

            // เมื่อผู้ใช้กดปุ่ม "ตกลง" ใน Modal
            $('#agree-consent').click(function() {
            $('#privacy-consent').prop('checked', true); // ติ๊ก checkbox
            $('#privacy-consent').prop('disabled', false); // ปลดล็อก checkbox
            $('#submit-form').prop('disabled', false); // เปิดปุ่มส่งข้อมูล
            $('#agreement-modal').modal('hide'); // ปิด Modal
            });

            // Enable/Disable the submit button based on privacy consent
            // Enable/Disable the submit button based on privacy consent
            $('#privacy-consent').change(function() {
                if ($(this).prop('checked')) {
                    $('#submit-form').prop('disabled', false); // Enable submit button
                } else {
                    $('#submit-form').prop('disabled', true); // Disable submit button
                }
            });


            // Function to reset error messages
            function resetErrorMessages() {
                $('.error-message').text('');
                $('.form-control').removeClass('is-invalid');
            }

            // Function to show error messages
            function showError(inputId, message) {
                $(inputId).addClass('is-invalid');
                $(inputId + '-error').text(message);
            }
        // Validate form on submit
        $('#complaint-form').submit(function(e) {
            e.preventDefault();
            resetErrorMessages();

            let isValid = true;

            // Validate Complaint Subject
            if ($('#complaint-subject').val().trim() === '') {
                showError('#complaint-subject', 'กรุณากรอกเรื่องที่ต้องการร้องทุกข์');
                isValid = false;
            }

            // Validate Contact Phone
            if ($('#contact-phone').val().trim() === '') {
                showError('#contact-phone', 'กรุณากรอกเบอร์โทรศัพท์ที่สามารถติดต่อได้');
                isValid = false;
            }

            // Validate Incident Date
            if ($('#incident-date').val().trim() === '') {
                showError('#incident-date', 'กรุณากรอกวันที่เกิดเหตุ');
                isValid = false;
            }

            // Validate Incident Time
            if ($('#incident-time').val().trim() === '') {
                showError('#incident-time', 'กรุณากรอกเวลาที่เกิดเหตุ');
                isValid = false;
            }

            // Validate Complaint Description
            if ($('#complaint-description').val().trim() === '') {
                showError('#complaint-description', 'กรุณากรอกรายละเอียดการร้องเรียน');
                isValid = false;
            }

            // If all validations pass, submit the form
            if (isValid) {
                this.submit();
            }
        });


            // Handle confirmation modal submission
            $('#confirm-submit').click(function() {
                $('#confirmation-modal').modal('hide');
                alert('ข้อมูลถูกส่งเรียบร้อยแล้ว!');
                $('#complaint-form')[0].reset(); // Reset the form
                $('#submit-form').prop('disabled', true); // Disable submit button
            });

            // Handle the cancel button to reset the form
            $('#cancel-form').click(function() {
                if (confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิก?')) {
                    $('#complaint-form')[0].reset(); // Reset the form
                    $('#submit-form').prop('disabled', true); // Disable submit button
                }
            });
        });
    </script>
    
</html>
