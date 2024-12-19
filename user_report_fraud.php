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
    $report_subject = $_POST['report_subject'];
    $report_person = $_POST['report_person'];
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
    if (isset($_FILES['reportfraud_file']) && $_FILES['reportfraud_file']['error'] == 0) {
        $file_name = $_FILES['reportfraud_file']['name'];
        $file_tmp_name = $_FILES['reportfraud_file']['tmp_name'];
        $file_upload_dir = 'uploads/';  // Directory where the file will be saved
        $file_upload_path = $file_upload_dir . basename($file_name);

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_types) && $_FILES['reportfraud_file']['size'] < 5000000) {  // 5MB limit
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
    $sql = "INSERT INTO appeals (user_id, report_subject, report_person, contact_phone, contact_location, contact_details, latitude, longitude, incident_date, incident_time, problem_level, department, complaint_description, complaint_file )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssssss", $user_id, $report_subject, $report_person, $contact_phone, $contact_location, $contact_details, $latitude, $longitude, $incident_date, $incident_time, $problem_level, $department, $complaint_description, $complaint_file);

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
    
    /* Style for error message in top-right corner */
    .error-message {
        position: fixed; /* Fixed position to the top-right */
        top: 20px;
        right: 20px;
        background-color: rgba(255, 0, 0, 0.8); /* Red background */
        color: white;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        z-index: 9999; /* Ensure it's on top of other elements */
        display: none; /* Initially hidden */
        max-width: 300px;
        word-wrap: break-word;
    }
    /* Optional: Styling for error message when visible */
    .error-message.show {
        display: block; /* Show the error message */
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
        <h2 class="text-center mb-4">การแจ้งเบาะแสทุจริตประพฤติมิชอบ</h2>

        <form id="report-form" action="user_report_fraud.php?username=<?= $username ?>" method="POST" enctype="multipart/form-data" novalidate>
            <!-- Report Subject -->
            <div class="form-group">
                <label for="report-subject">เรื่องที่ต้องการแจ้งเบาะแส <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="report-subject" name="report_subject" required>
                <div class="invalid-feedback">กรุณากรอกเรื่องที่ต้องการแจ้งเบาะแส</div>
            </div>

            <!-- Report Person -->
            <div class="form-group">
                <label for="report-person">องค์กรหรือบุคคลที่ต้องการแจ้งเบาะแส <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="report-person" name="report_person" required>
                <div class="invalid-feedback">กรุณากรอกชื่อองค์กรหรือบุคคลที่ต้องการแจ้งเบาะแส</div>
            </div>

            <div class="form-group">
                <label for="contact">ช่องทางการติดต่อ </label>
                <select class="form-control" id="contact" name="contact" required>
                    <option value="" disabled selected>เลือกช่องทางการติดต่อ</option>
                    <option value="อีเมล">อีเมล</option>
                    <option value="เบอร์โทรศัพท์">เบอร์โทรศัพท์</option>
                </select>
                <div class="invalid-feedback">กรุณาเลือกช่องทางการติดต่อ</div>
            </div>
            <!-- Contact Phone -->
            <div class="form-group">
                <label for="contact">ข้อมูลช่องทางการติดต่อ <span class="text-danger">*</span></label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control" required>
                <div class="invalid-feedback">กรุณาเลือกและกรอกช่องทางการติดต่อ</div>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="contact-location">สถานที่</label>
                <input type="text" class="form-control" id="contact-location" name="contact_location" required>
                <div class="invalid-feedback">กรุณากรอกสถานที่</div>
            </div>

            <!-- Details -->
            <div class="form-group">
                <label for="contact-details">รายละเอียดสถานที่</label>
                <textarea class="form-control" id="contact-details" name="contact_details" rows="4" required></textarea>
            </div>

                    
            <!-- Map container -->
            <div id="map" style="width: 100%; height: 400px;"></div>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <!-- Section to display current latitude and longitude -->
            <div id="coordinates">
                <p>Latitude: <span id="current-lat">-</span></p>
                <p>Longitude: <span id="current-lon">-</span></p>
                <button id="get-location-btn" type="button">Get Current Location</button>
            </div>

    
             <!-- Incident Date and Time -->
            <div class="form-group">
                <label for="incident-time">เวลาที่เกิดเหตุหรือพบเหตุ</label>
                <div class="form-row">
                    <div class="col">
                        <input type="date" class="form-control" id="incident-date" name="incident_date" required>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control" id="incident-time" name="incident_time" required>
                    </div>
                </div>
            </div>
            <!-- Problem Level -->
            <div class="form-group">
                <label for="problem-level">ระดับปัญหา</label>
                <select class="form-control" id="problem-level" name="problem_level" required>
                    <option value="" disabled selected>เลือกระดับปัญหา</option>
                    <option value="เร่งด่วน">เร่งด่วน (ร้ายแรง มีผลกระทบต่อชีวิตและทรัพย์สินของประชาชน)</option>
                    <option value="ปานกลาง">ปานกลาง (เรื่องร้องเรียนปัญหาเกี่ยวกับระบบหรือการช่วยเหลือที่เกี่ยวข้องกับเทศบาล)</option>
                    <option value="ต่ำ">ต่ำ (เรื่องร้องเรียนทั่วไปของปัญหาในพื้นที่)</option>
                </select>
                <div class="invalid-feedback">กรุณาเลือกระดับปัญหา</div>
            </div>


            <!-- Department -->
            <div class="form-group">
                <label for="department">หน่วยงานที่รับผิดชอบ</label>
                <select class="form-control" id="department" name="department" required>
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
                    <option value="ไม่ทราบหน่วยงาน">ไม่ทราบหน่วยงาน</option>
                </select>
                <div class="invalid-feedback">กรุณาเลือกหน่วยงานที่รับผิดชอบ</div>
            </div>

            <!-- Complaint Description -->
            <div class="form-group">
                <label for="complaint-description">รายละเอียดการแจ้งเบาะแส</label>
                <textarea class="form-control" id="complaint-description" name="complaint_description" rows="5" required></textarea>
                <small class="error-message" id="complaint-description-error"></small>
                <div class="invalid-feedback">กรุณากรอกรายละเอียดการแจ้งเบาะแส</div>
            </div>

            <!-- File Upload -->
            <div class="form-group">
                <label for="complaint-file">ไฟล์ที่แนบ (ถ้ามี)</label>
                <input type="file" class="form-control-file" id="complaint-file" name="complaint_file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" onchange="validateFile()">
                <small class="form-text text-muted">รองรับไฟล์: .jpg, .jpeg, .png, .pdf, .doc, .docx (ขนาดไม่เกิน 5MB)</small>
                <div class="invalid-feedback" id="file-error"></div>
            </div>
            <!-- Modal Confirmation for Submit -->
            <div class="modal" tabindex="-1" role="dialog" id="confirmation-modal">
            <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ยืนยันการส่งข้อมูล</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>คุณต้องการยืนยันการส่งข้อมูลนี้หรือไม่?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cancel-submit" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" class="btn btn-primary" id="confirm-submit">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Privacy consent popup -->
            <div class="custom-modal-overlay" id="modal-overlay"></div>
            <div class="custom-modal" id="modal-consent">
                <h5>ข้อกำหนดและเงื่อนไข</h5>
                <div class="modal-body">
                <p>เราตระหนักถึงความสำคัญของการคุ้มครองข้อมูลส่วนบุคคลของผู้ใช้งานเว็บไซต์ และเราให้ความสำคัญกับการรักษาความเป็นส่วนตัวของคุณ. ข้อกำหนดและเงื่อนไขนี้มีวัตถุประสงค์เพื่ออธิบายถึงวิธีที่เราเก็บรวบรวม ใช้ และปกป้องข้อมูลส่วนบุคคลที่คุณให้ไว้ผ่านเว็บไซต์ของเรา.</p>
                    <p><strong>1. การเก็บข้อมูลส่วนบุคคล</strong></p>
                    <p>เมื่อคุณใช้บริการของเรา เราอาจขอข้อมูลส่วนบุคคล เช่น ชื่อ ที่อยู่ อีเมล์ และหมายเลขโทรศัพท์ เพื่อให้บริการต่างๆ แก่คุณ. ข้อมูลเหล่านี้จะถูกเก็บไว้อย่างปลอดภัยและจะไม่ถูกนำไปใช้เพื่อวัตถุประสงค์อื่นใดโดยไม่ได้รับความยินยอมจากคุณ.</p>
                    <p><strong>2. การใช้ข้อมูล</strong></p>
                    <p>ข้อมูลที่เรารวบรวมจะถูกใช้เพื่อปรับปรุงการบริการ และเพื่อการติดต่อกับคุณเกี่ยวกับบริการที่คุณได้รับจากเว็บไซต์. เราอาจใช้ข้อมูลนี้ในการส่งข้อมูลเกี่ยวกับผลิตภัณฑ์หรือบริการที่คุณอาจสนใจ.</p>
                    <p><strong>3. ความปลอดภัยของข้อมูล</strong></p>
                    <p>เราดำเนินการตามมาตรการที่เหมาะสมเพื่อปกป้องข้อมูลส่วนบุคคลของคุณจากการเข้าถึง การใช้ หรือการเปิดเผยที่ไม่ได้รับอนุญาต. อย่างไรก็ตาม, โปรดทราบว่าไม่มีวิธีการถ่ายโอนข้อมูลผ่านอินเทอร์เน็ตที่สามารถรับประกันความปลอดภัย 100% ได้.</p>
                    <p><strong>4. การยอมรับและการปฏิเสธ</strong></p>
                    <p>เมื่อคุณใช้เว็บไซต์ของเรา, คุณยอมรับข้อกำหนดและเงื่อนไขนี้. หากคุณไม่ยินยอม, คุณสามารถเลือกไม่ให้เราเก็บข้อมูลส่วนบุคคลของคุณได้โดยไม่ต้องใช้บริการบางประการของเว็บไซต์.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-close" id="btn-close">ปิด</button>
                    <button class="btn btn-agree" id="btn-agree">ยอมรับ</button>
                </div>
            </div>
        <div class="form-group text-center">
                <button type="submit" class="btn btn-primary w-50" id="submit-form" disabled>ยืนยันการส่งข้อมูล</button>
            </div>
        </form>
    </div>

    <script>
        // Enable validation feedback on form submit
        const form = document.getElementById('report-form');
        const submitButton = document.getElementById('submit-form');

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Enable the submit button only when the form is valid
        form.addEventListener('input', function () {
            submitButton.disabled = !form.checkValidity();
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
        // Enable validation feedback on form submit
        const form = document.getElementById('report-form');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
        </script>
        <script>
    let map;

    // Coordinates for Ban Pong District (approximate bounding box)
    const BANPONG_LAT_MIN = 13.5;
    const BANPONG_LAT_MAX = 13.9;
    const BANPONG_LON_MIN = 99.7;
    const BANPONG_LON_MAX = 100.1;

    // Initialize the map
    function initMap() {
        const geolocation = { lat: 13.811046841299785, lon: 99.87560507925443 }; // Default location (Banpong)
        map = new longdo.Map({
            placeholder: document.getElementById('map')
        });

        map.location(geolocation);
        map.zoom(13);

        // Bind the Get Location button event only after the map is initialized
        document.getElementById('get-location-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission
            const currentLocation = map.location(); // Get current map center location

            // Check if the location is within Ban Pong District
            if (isInBanPong(currentLocation.lat, currentLocation.lon)) {
                console.log("Current Latitude: " + currentLocation.lat);
                console.log("Current Longitude: " + currentLocation.lon);

                // Update the displayed coordinates and hidden input fields
                updateCoordinates(currentLocation);

                alert("The location is within Ban Pong District.");
            } else {
                alert("The location is outside Ban Pong District. Action not allowed.");
            }
        });
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

    // Check if the location is within Ban Pong District's coordinates
    function isInBanPong(lat, lon) {
        return lat >= BANPONG_LAT_MIN && lat <= BANPONG_LAT_MAX && lon >= BANPONG_LON_MIN && lon <= BANPONG_LON_MAX;
    }

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
        document.getElementById("registerForm").addEventListener("submit", function(event) {
        var form = this;
        var isValid = true;

        // ตรวจสอบข้อมูลในแต่ละช่อง
        form.querySelectorAll('.form-control').forEach(function(input) {
            var feedback = input.nextElementSibling; // ข้อความ invalid-feedback
            if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.style.display = 'block';
            }
            isValid = false;
            } else {
            input.classList.remove('is-invalid');
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.style.display = 'none';
            }
            }
        });
        // หยุดการส่งฟอร์มถ้าข้อมูลไม่ถูกต้อง
        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
        });
        </script>
    <script>
        function validateFile() {
            const fileInput = document.getElementById('complaint-file');
            const fileError = document.getElementById('file-error');
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            const maxFileSize = 5 * 1024 * 1024; // 5MB

            fileError.textContent = ''; // Clear previous error messages
            fileInput.classList.remove('is-invalid');

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                // Check file extension
                if (!allowedExtensions.includes(fileExtension)) {
                    fileError.textContent = 'รูปแบบไฟล์ไม่ถูกต้อง กรุณาอัปโหลดไฟล์ในรูปแบบที่รองรับ';
                    fileInput.classList.add('is-invalid');
                    return false;
                }
                 // Check file size
                 if (file.size > maxFileSize) {
                    fileError.textContent = 'ขนาดไฟล์เกิน 5MB กรุณาอัปโหลดไฟล์ที่มีขนาดเล็กกว่า';
                    fileInput.classList.add('is-invalid');
                    return false;
                }
            }
            return true; // File is valid
        }

        // Validate file before submitting form
        document.getElementById('report-form').addEventListener('submit', function (event) {
            if (!validateFile()) {
                event.preventDefault(); // Prevent form submission if file is invalid
            }
        });
        </script>
</html>