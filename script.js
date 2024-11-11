// Sample data from the image
const complaints = [
  { id: "FIG-123", title: "ท่อนแตก", department: "กองช่าง", level: "ปกติ", date: "Dec 5", status: "✔" },
  { id: "FIG-122", title: "ไฟไหม้ เศษขยะ", department: "กองช่าง", level: "ร้ายแรง", date: "Dec 5", status: "✔" },
  { id: "FIG-121", title: "เก็บขยะ", department: "กองสาธารณะสุข", level: "ปกติ", date: "Dec 5", status: "✔" },
  { id: "FIG-120", title: "ฟันยางกันสูง", department: "กองสาธารณะสุข", level: "ปกติ", date: "Dec 5", status: "✔" },
  { id: "FIG-119", title: "ถนนเป็นหลุม", department: "เทศบาล", level: "เร่งด่วน", date: "Dec 5", status: "✔" },
  { id: "FIG-118", title: "เสาไฟฟ้าหัก", department: "เทศบาล", level: "เร่งด่วน", date: "Dec 5", status: "✔" },
  { id: "FIG-117", title: "อยากให้มีห้องที่มีอุปสรรค", department: "กองช่าง", level: "ปกติ", date: "Dec 5", status: "✔" },
  { id: "FIG-116", title: "ไฟราวส่องถนน", department: "เทศบาล", level: "ปกติ", date: "Dec 5", status: "✔" },
  { id: "FIG-115", title: "หายทรากทางเข้า", department: "เทศบาล", level: "เร่งด่วน", date: "Dec 5", status: "✔" }
];
function showDetails(title, details) {
  document.getElementById("complaintTitle").textContent = title;
  document.getElementById("complaintDetails").textContent = details;
}

// Function to load data into the table
function loadTableData() {
  const tableBody = document.querySelector("#complaintTable tbody");
  tableBody.innerHTML = '';  // Clear table first
  complaints.forEach(complaint => {
    const row = `<tr>
                  <td>${complaint.id}</td>
                  <td>${complaint.title}</td>
                  <td>${complaint.department}</td>
                  <td>${complaint.level}</td>
                  <td>${complaint.date}</td>
                  <td>${complaint.status}</td>
                  <td><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#infoModal" onclick="showDetails('${complaint.title}', 'Details for ${complaint.title}')">More Info</button></td>
                </tr>`;
    tableBody.innerHTML += row;
  });
}


// Function to search and filter the table
function filterTable() {
  const departmentFilter = document.getElementById('departmentFilter').value.toLowerCase();
  const levelFilter = document.getElementById('levelFilter').value.toLowerCase();
  const table = document.getElementById('complaintTable');
  const rows = table.getElementsByTagName('tr');

  for (let i = 1; i < rows.length; i++) {
    const departmentCell = rows[i].getElementsByTagName('td')[2].innerText.toLowerCase();
    const levelCell = rows[i].getElementsByTagName('td')[3].innerText.toLowerCase();
    
    let departmentMatch = departmentFilter === "" || departmentCell === departmentFilter;
    let levelMatch = levelFilter === "" || levelCell === levelFilter;
    
    if (departmentMatch && levelMatch) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}

// Function to search table data
function searchTable() {
  const input = document.getElementById('search').value.toLowerCase();
  const table = document.getElementById('complaintTable');
  const rows = table.getElementsByTagName('tr');

  for (let i = 1; i < rows.length; i++) {
    let cells = rows[i].getElementsByTagName('td');
    let match = false;
    for (let j = 0; j < cells.length; j++) {
      if (cells[j].innerText.toLowerCase().includes(input)) {
        match = true;
        break;
      }
    }
    rows[i].style.display = match ? '' : 'none';
  }
}


// Load table data when the page is loaded
window.onload = loadTableData;
