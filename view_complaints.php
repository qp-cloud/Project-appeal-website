<?php
// Connect to the MySQL database
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'web_appeal_db'; // Updated Database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch complaints data by year and status
$query_complaints = "
    SELECT YEAR(incident_date) AS year, 
           status, 
           COUNT(*) AS count 
    FROM complaints 
    WHERE status IN ('ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 'ดำเนินการเสร็จสิ้น')
    GROUP BY YEAR(incident_date), status
    ORDER BY year ASC
";
$result_complaints = $conn->query($query_complaints);

// Organize complaints data by year and status
$complaints_data = [];
while ($row = $result_complaints->fetch_assoc()) {
    $complaints_data[$row['year']][$row['status']] = $row['count'];
}

// Query to fetch appeals data by year and status
$query_appeals = "
    SELECT YEAR(incident_date) AS year, 
           status, 
           COUNT(*) AS count 
    FROM appeals 
    WHERE status IN ('ยังไม่ดำเนินการ', 'กำลังดำเนินการ', 'ดำเนินการเสร็จสิ้น')
    GROUP BY YEAR(incident_date), status
    ORDER BY year ASC
";
$result_appeals = $conn->query($query_appeals);

// Organize appeals data by year and status
$appeals_data = [];
while ($row = $result_appeals->fetch_assoc()) {
    $appeals_data[$row['year']][$row['status']] = $row['count'];
}

$conn->close();

// Prepare data for the chart based on selected year
$years = array_keys($complaints_data + $appeals_data);
sort($years);

// Get the selected year from the GET request (if any)
$selected_year = isset($_GET['year']) ? $_GET['year'] : $years[0]; // Default to the first year if no year is selected

// Prepare data for the selected year
$complaints_not_started = isset($complaints_data[$selected_year]['ยังไม่ดำเนินการ']) ? $complaints_data[$selected_year]['ยังไม่ดำเนินการ'] : 0;
$complaints_in_progress = isset($complaints_data[$selected_year]['กำลังดำเนินการ']) ? $complaints_data[$selected_year]['กำลังดำเนินการ'] : 0;
$complaints_completed = isset($complaints_data[$selected_year]['ดำเนินการเสร็จสิ้น']) ? $complaints_data[$selected_year]['ดำเนินการเสร็จสิ้น'] : 0;

$appeals_not_started = isset($appeals_data[$selected_year]['ยังไม่ดำเนินการ']) ? $appeals_data[$selected_year]['ยังไม่ดำเนินการ'] : 0;
$appeals_in_progress = isset($appeals_data[$selected_year]['กำลังดำเนินการ']) ? $appeals_data[$selected_year]['กำลังดำเนินการ'] : 0;
$appeals_completed = isset($appeals_data[$selected_year]['ดำเนินการเสร็จสิ้น']) ? $appeals_data[$selected_year]['ดำเนินการเสร็จสิ้น'] : 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard: Complaints and Appeals by Year</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f8f8f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      padding: 40px 30px;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }
    h1 {
      font-size: 36px;
      color: #2a7cff;
      margin-bottom: 40px;
    }
    .chart-container {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-bottom: 30px;
    }
    select {
      padding: 12px 20px;
      margin: 20px 0;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ddd;
      background-color: #fff;
      cursor: pointer;
    }
    .go-back-btn {
      padding: 12px 24px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .go-back-btn:hover {
      background-color: #45a049;
    }
    .footer {
      margin-top: 50px;
      font-size: 14px;
      color: #888;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>ข้อมูลการร้องเรียนและการทุจริตตามปี</h1>

    <!-- Year Select Dropdown -->
    <form method="GET" action="">
      <label for="year" style="font-size: 18px;">เลือกปี: </label>
      <select id="year" name="year" onchange="this.form.submit()">
        <?php foreach ($years as $year): ?>
          <option value="<?php echo $year; ?>" <?php echo ($year == $selected_year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
        <?php endforeach; ?>
      </select>
    </form>

    <div class="chart-container">
      <canvas id="myBarChart"></canvas>
    </div>

    <button class="go-back-btn" onclick="window.location.href='admin_page.php';">ย้อนกลับ</button>

    <div class="footer">
      <p>แสดงข้อมูลการร้องเรียนและการทุจริตตามสถานะในแต่ละปี</p>
    </div>
  </div>

  <script>
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var selectedYear = <?php echo json_encode($selected_year); ?>;
    var complaintsNotStarted = <?php echo json_encode($complaints_not_started); ?>;
    var complaintsInProgress = <?php echo json_encode($complaints_in_progress); ?>;
    var complaintsCompleted = <?php echo json_encode($complaints_completed); ?>;
    var appealsNotStarted = <?php echo json_encode($appeals_not_started); ?>;
    var appealsInProgress = <?php echo json_encode($appeals_in_progress); ?>;
    var appealsCompleted = <?php echo json_encode($appeals_completed); ?>;

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [selectedYear],
            datasets: [
                {
                    label: 'การร้องเรียนยังไม่ดำเนินการ',
                    data: [complaintsNotStarted],
                    backgroundColor: '#ff5722',
                    borderColor: '#ff5722',
                    borderWidth: 1
                },
                {
                    label: 'การร้องเรียนกำลังดำเนินการ',
                    data: [complaintsInProgress],
                    backgroundColor: '#ff9800',
                    borderColor: '#ff9800',
                    borderWidth: 1
                },
                {
                    label: 'การร้องเรียนดำเนินการเสร็จสิ้น',
                    data: [complaintsCompleted],
                    backgroundColor: '#4caf50',
                    borderColor: '#4caf50',
                    borderWidth: 1
                },
                {
                    label: 'การทุจริตยังไม่ดำเนินการ',
                    data: [appealsNotStarted],
                    backgroundColor: '#ff5722',
                    borderColor: '#ff5722',
                    borderWidth: 1
                },
                {
                    label: 'การทุจริตกำลังดำเนินการ',
                    data: [appealsInProgress],
                    backgroundColor: '#ff9800',
                    borderColor: '#ff9800',
                    borderWidth: 1
                },
                {
                    label: 'การทุจริตดำเนินการเสร็จสิ้น',
                    data: [appealsCompleted],
                    backgroundColor: '#2a7cff',
                    borderColor: '#2a7cff',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
  </script>
</body>
</html>
