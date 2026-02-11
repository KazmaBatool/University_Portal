<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f1f5f9;color:#0f172a;}

/* Sidebar */
.sidebar{position:fixed;left:0;top:0;width:260px;height:100vh;background:#0f172a;color:#cbd5e1;display:flex;flex-direction:column;z-index:1000;transition:0.3s;}
.sidebar-header{padding:20px;background:#1e40af;font-size:18px;color:white;display:flex;justify-content:space-between;align-items:center;}
.sidebar-nav{display:flex;flex-direction:column;margin-top:20px;}
.sidebar-nav a{text-decoration:none;color:#94a3b8;padding:12px 20px;transition:0.3s;}
.sidebar-nav a:hover,.sidebar-nav a.active{background:rgba(59,130,246,0.15);color:#3b82f6;border-left:3px solid #3b82f6;}
.close-sidebar{background:none;border:none;color:white;font-size:18px;cursor:pointer;}

/* Sidebar overlay */
.sidebar-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);display:none;z-index:900;}
.sidebar-overlay.active{display:block;}

/* Top Navbar */
.top-navbar{position:fixed;top:0;left:260px;right:0;height:70px;background:white;display:flex;align-items:center;justify-content:space-between;padding:0 20px;border-bottom:1px solid #e2e8f0;z-index:500;}
.hamburger{display:none;flex-direction:column;gap:4px;background:#1e40af;padding:8px;border:none;border-radius:5px;cursor:pointer;}
.hamburger span{width:20px;height:2px;background:white;}
.navbar-right{display:flex;align-items:center;gap:15px;}
#searchInput{padding:6px 12px;border:1px solid #cbd5e1;border-radius:6px;outline:none;}

/* Notification dropdown */
.notification-bell{position:relative;cursor:pointer;}
.notification-dropdown{position:absolute;top:28px;right:0;background:white;box-shadow:0 4px 10px rgba(0,0,0,0.1);width:220px;border-radius:8px;display:none;flex-direction:column;}
.notification-dropdown p{padding:8px 10px;border-bottom:1px solid #e2e8f0;font-size:14px;}
.notification-dropdown p:last-child{border-bottom:none;}

/* Main content */
.main{margin-left:260px;padding:100px 30px;}

/* Quick Stats */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px;margin-bottom:30px;}
.stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.05);text-align:center;transition:0.3s;}
.stat-card:hover{transform:translateY(-5px);}
.stat-card h3{font-size:14px;color:#64748b;margin-bottom:8px;}
.stat-card p{font-size:22px;font-weight:700;color:#0f172a;}

/* Charts */
.chart-card{background:white;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.05);margin-bottom:30px;}

/* Courses grid */
.courses-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:30px;}
.course-card{background:white;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.05);}
.progress-bar{background:#e2e8f0;height:8px;border-radius:6px;margin:8px 0;}
.progress-fill{height:8px;border-radius:6px;}

/* Deadline & Messages */
.deadline-card,.messages-card{background:white;padding:20px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.05);margin-bottom:30px;}
.deadline-card table{width:100%;border-collapse:collapse;}
.deadline-card th, .deadline-card td{padding:8px 10px;border-bottom:1px solid #e2e8f0;text-align:left;}
.message{padding:8px 10px;border-bottom:1px solid #e2e8f0;}
.message:last-child{border-bottom:none;}

/* Logout modal */
.logout-modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);display:none;justify-content:center;align-items:center;z-index:2000;}
.logout-modal.active{display:flex;}
.logout-content{background:white;padding:30px;border-radius:10px;text-align:center;}
.logout-content button{padding:8px 15px;margin:10px;border:none;border-radius:6px;cursor:pointer;}
.logout-content button[name="yes"]{background:#dc2626;color:white;}
.logout-content button#cancelLogout{background:#64748b;color:white;}

/* Responsive */
@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.active{transform:translateX(0);}
    .top-navbar{left:0;}
    .main{margin-left:0;padding:100px 15px;}
    .hamburger{display:flex;position:fixed;top:15px;left:15px;z-index:1000;}
}
</style>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - FAST EduPortal</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>FAST EduPortal</h2>
        <button class="close-sidebar" id="closeSidebar">✕</button>
    </div>
    <nav class="sidebar-nav">
        <a href="#" class="active">📊 Dashboard</a>
        <a href="#">📚 My Courses</a>
        <a href="#">📝 Assignments</a>
        <a href="#">📖 Resources</a>
        <a href="#">💬 Messages</a>
        <a href="#">📅 Calendar</a>
        <a href="#">⚙️ Settings</a>
        <a href="#" id="logoutBtn">🚪 Logout</a>
    </nav>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Top Navbar -->
<nav class="top-navbar">
    <button class="hamburger" id="sidebarToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="navbar-title">Student Dashboard</div>
    <div class="navbar-right">
        <input type="text" placeholder="🔍 Search courses..." id="searchInput">
        <div class="notification-bell" id="notificationBell">🔔
            <div class="notification-dropdown" id="notificationDropdown">
                <p><strong>New Grades Released</strong> - CS301</p>
                <p><strong>Assignment Submitted</strong> - SE402</p>
                <p><strong>New Message</strong> - Prof. Ali</p>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="main">

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Current Courses</h3>
            <p>4</p>
        </div>
        <div class="stat-card">
            <h3>Completed Credits</h3>
            <p>48/120</p>
        </div>
        <div class="stat-card">
            <h3>Pending Assignments</h3>
            <p>3</p>
        </div>
        <div class="stat-card">
            <h3>Notifications</h3>
            <p>5</p>
        </div>
    </div>

    <!-- GPA Chart -->
    <div class="chart-card">
        <h3>GPA Trend</h3>
        <canvas id="gpaChart"></canvas>
    </div>

    <!-- Courses Progress -->
    <div class="courses-grid">
        <div class="course-card">
            <h4>CS301 - Data Structures</h4>
            <div class="progress-bar">
                <div class="progress-fill" style="width:75%; background:#3b82f6;"></div>
            </div>
            <p>Progress: 75%</p>
        </div>
        <div class="course-card">
            <h4>SE402 - Software Engineering</h4>
            <div class="progress-bar">
                <div class="progress-fill" style="width:60%; background:#dc2626;"></div>
            </div>
            <p>Progress: 60%</p>
        </div>
        <div class="course-card">
            <h4>BBA201 - Business Management</h4>
            <div class="progress-bar">
                <div class="progress-fill" style="width:85%; background:#8b5cf6;"></div>
            </div>
            <p>Progress: 85%</p>
        </div>
        <div class="course-card">
            <h4>MTH301 - Advanced Mathematics</h4>
            <div class="progress-bar">
                <div class="progress-fill" style="width:45%; background:#f59e0b;"></div>
            </div>
            <p>Progress: 45%</p>
        </div>
    </div>

    <!-- Upcoming Deadlines -->
    <div class="deadline-card">
        <h3>Upcoming Deadlines</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Assignment / Exam</th>
            </tr>
            <tr><td>Feb 15</td><td>CS301 Assignment 3</td></tr>
            <tr><td>Feb 18</td><td>SE402 Project Phase 2</td></tr>
            <tr><td>Feb 21</td><td>BBA201 Mid Term</td></tr>
        </table>
    </div>

    <!-- Recent Messages -->
    <div class="messages-card">
        <h3>Recent Messages</h3>
        <div class="message">
            <strong>Prof. Ali:</strong> Please submit assignment 3 by Feb 15.
        </div>
        <div class="message">
            <strong>Dr. Sarah:</strong> New material uploaded for BBA201.
        </div>
        <div class="message">
            <strong>Prof. Fatima:</strong> Quiz results are out.
        </div>
    </div>

</main>

<!-- Logout Modal -->
<div class="logout-modal" id="logoutModal">
    <div class="logout-content">
        <h3>Confirm Logout</h3>
        <p>Are you sure you want to logout?</p>
        <form method="post" action="logout.php">
            <button name="yes">Yes</button>
            <button type="button" id="cancelLogout">No</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
// Sidebar Toggle
<script>
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const closeSidebar = document.getElementById('closeSidebar');

sidebarToggle.addEventListener('click', ()=>{
    sidebar.classList.add('active');
    sidebarOverlay.classList.add('active');
});
closeSidebar.addEventListener('click', ()=>{
    sidebar.classList.remove('active');
    sidebarOverlay.classList.remove('active');
});
sidebarOverlay.addEventListener('click', ()=>{
    sidebar.classList.remove('active');
    sidebarOverlay.classList.remove('active');
});

// Notification Dropdown
const notificationBell = document.getElementById('notificationBell');
const notificationDropdown = document.getElementById('notificationDropdown');
notificationBell.addEventListener('click', ()=>{
    notificationDropdown.classList.toggle('active');
});
document.addEventListener('click', (e)=>{
    if(!notificationBell.contains(e.target)){
        notificationDropdown.classList.remove('active');
    }
});

// Logout Modal
const logoutBtn = document.getElementById('logoutBtn');
const logoutModal = document.getElementById('logoutModal');
const cancelLogout = document.getElementById('cancelLogout');

logoutBtn.addEventListener('click', ()=>{
    logoutModal.classList.add('active');
});
cancelLogout.addEventListener('click', ()=>{
    logoutModal.classList.remove('active');
});

// GPA Chart
const ctx = document.getElementById('gpaChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sem 1','Sem 2','Sem 3','Sem 4'],
        datasets:[{
            label:'GPA',
            data:[3.2,3.5,3.52,3.45],
            borderColor:'#3b82f6',
            backgroundColor:'rgba(59,130,246,0.2)',
            fill:true,
            tension:0.4
        }]
    },
    options:{
        responsive:true,
        plugins:{legend:{display:false}},
        scales:{
            y:{beginAtZero:true,max:4}
        }
    }
});
</script>