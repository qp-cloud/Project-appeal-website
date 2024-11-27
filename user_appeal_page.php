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
    $sql = "INSERT INTO complaints (user_id, complaint_subject, contact_phone, contact_location, contact_details, latitude, longitude, incident_date, incident_time, problem_level, department, complaint_description, complaint_file )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssssss", $user_id, $complaint_subject, $contact_phone, $contact_location, $contact_details, $latitude, $longitude, $incident_date, $incident_time, $problem_level, $department, $complaint_description, $complaint_file);

    if ($stmt->execute()) {
        header("Location: confirmation.php");  // Adjust URL to your confirmation page
        exit();
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
        /* Initial small content with scroll */
        .short-content {
            max-height: 300px; /* Adjust this value to control the initial visible height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        /* Full content when expanded */
        .full-content {
            max-height: none; /* Remove height restriction */
        }

        /* Style for the Expand button */
        .btn-expand {
            margin-top: 10px;
            padding: 5px 15px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .btn-expand:hover {
            background-color: #45a049;
        }
        
        /* Modal content styling */
        .custom-modal {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
        }

        .modal-body {
            padding: 10px;
        }
        .error-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: red;
        font-size: 20px;
        }
        /* Adjust the map size */
        #map {
            width: 100%;
            height: 400px;
        }
        #marker-info {
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

                    
            <!-- Map container -->
            <div id="map" style="width: 100%; height: 400px;"></div>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <!-- Section to display current latitude and longitude -->
            <div id="coordinates">
                <p>Latitude: <span id="current-lat">-</span></p>
                <p>Longitude: <span id="current-lon">-</span></p>
            </div>

            <button id="get-location-btn">Get Current Location</button>

            <!-- Hidden Fields to store coordinates -->
            





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
            
            <!-- Privacy consent popup -->
            <div class="custom-modal-overlay" id="modal-overlay"></div>
            <div class="custom-modal" id="modal-consent">
                <h5>ข้อกำหนดและเงื่อนไข</h5>
                <div class="modal-body">
                    <p>เราตระหนักถึงความสำคัญของการคุ้มครองข้อมูลส่วนบุคคลของท่านเพื่อรับผลิตภัณฑ์และบริการของเรา...</p>
                    
                    <div id="policy-content" class="short-content">
                        <h6>ข้อ 1. ขอบเขตการใช้บังคับ</h6>
                        <p>นโยบายคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy) ตามพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562...</p>

                        <h6>ข้อ 2. คำจำกัดความ</h6>
                        <p>“นโยบายคุ้มครองข้อมูลส่วนบุคคล” หมายความว่า นโยบายที่เราจัดทำเพื่อแจ้งให้เจ้าของข้อมูลส่วนบุคคลทราบ...</p>
                        
                        <p>“ข้อมูลส่วนบุคคล” หมายความว่า ข้อมูลเกี่ยวกับบุคคลซึ่งทำให้สามารถระบุตัวบุคคลนั้นได้...</p>

                        <h6>ข้อมูลส่วนบุคคลที่มีความอ่อนไหว (Sensitive Data)</h6>
                        <p>ข้อมูลส่วนบุคคลเกี่ยวกับเชื้อชาติ เผ่าพันธุ์ ความคิดเห็นทางการเมือง...</p>
                        
                        <h6>การประมวลผล</h6>
                        <p>การดำเนินการใดๆ กับข้อมูลส่วนบุคคล เช่น การเก็บรวบรวม บันทึก จัดระบบ...</p>

                        <h6>สิทธิของเจ้าของข้อมูลส่วนบุคคล</h6>
                        <p>ท่านมีสิทธิในการเข้าถึง แก้ไข และลบข้อมูลส่วนบุคคลของท่านได้ตลอดเวลา...</p>
                    </div>
                    
                    <button id="btn-expand" class="btn btn-expand">แสดงเพิ่มเติม</button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-close" id="btn-close">ปิด</button>
                    <button class="btn btn-agree" id="btn-agree">ยอมรับ</button>
                </div>
            </div>
    <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-full-width" id="submit-form" disabled>ยืนยันการส่งข้อมูล</button>
            </div>
        </form>

        <script>
    let map;

    // Initialize the map
    function initMap() {
        const geolocation = { lat: 13.7367, lon: 100.5231 }; // Default location (Bangkok)
        map = new longdo.Map({
            placeholder: document.getElementById('map')
        });

        map.location(geolocation);
        map.zoom(13);

        // Show initial coordinates (from the map's center)
        updateCoordinates(map.location());
    }

    // Update the coordinates displayed on the page and in the hidden input fields
    function updateCoordinates(location) {
        const lat = location.lat;
        const lon = location.lon;
        
        // Update the visible coordinates
        document.getElementById('current-lat').textContent = lat;
        document.getElementById('current-lon').textContent = lon;
        
        // Update the hidden input fields with the new coordinates
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
    }

    // Get the current location when the button is clicked
    document.getElementById('get-location-btn').addEventListener('click', function() {
        const currentLocation = map.location(); // Get current map center location
        console.log("Current Latitude: " + currentLocation.lat);
        console.log("Current Longitude: " + currentLocation.lon);

        // Update the displayed coordinates and hidden input fields
        updateCoordinates(currentLocation);
    });

    // Load the Longdo Map script and initialize the map
    function loadLongdoMap() {
        const script = document.createElement('script');
        script.src = "https://api.longdo.com/map/?key=35bbbe40a96e844b27eba45df1ddad0b";
        script.onload = initMap;
        document.body.appendChild(script);
    }

    // Load the map when the page is ready
    document.addEventListener('DOMContentLoaded', function() {
        loadLongdoMap();
    });
</script>

    <script>
        document.getElementById("btn-expand").addEventListener("click", function() {
            var content = document.getElementById("policy-content");
            var btn = document.getElementById("btn-expand");

            // Toggle between showing and hiding the policy content
            if (content.classList.contains("short-content")) {
                content.classList.remove("short-content");
                content.classList.add("full-content");
                btn.innerText = "แสดงน้อยลง";
            } else {
                content.classList.remove("full-content");
                content.classList.add("short-content");
                btn.innerText = "แสดงเพิ่มเติม";
            }
        });
    </script>
    <script>
        // Show privacy consent popup when page loads
        window.onload = function() {
            document.getElementById('modal-overlay').style.display = 'block';
            document.getElementById('modal-consent').style.display = 'block';
        };

        // Handle closing the popup
        document.getElementById('btn-close').addEventListener('click', function() {
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('modal-consent').style.display = 'none';
        });

        // Handle agreement
        document.getElementById('btn-agree').addEventListener('click', function() {
            document.getElementById('submit-form').disabled = false;  // Enable the submit button
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('modal-consent').style.display = 'none';
        });

    </script>
    <script>
           
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
