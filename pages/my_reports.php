<?php
session_start();
if(!isset($_SESSION['uid'])) header("Location: login.php");

$conn = new mysqli("localhost","root","","smartcity_db");
$uid = $_SESSION['uid'];

$r = $conn->query("SELECT * FROM issues WHERE user_id=$uid ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>My Reports</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.feed{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
gap:35px;
padding:60px;
}

.feed-card{
background:#02160e;
border-radius:25px;
overflow:hidden;
box-shadow:0 20px 50px rgba(0,0,0,.6);
color:white;
}

.feed-card img{
width:100%;
height:220px;
object-fit:cover;
}

.feed-body{
padding:20px;
}

.feed-body p{font-size:14px;opacity:.9;margin:8px 0}

.status{
display:inline-block;
padding:6px 18px;
border-radius:30px;
font-size:12px;
margin-bottom:10px;
}

.Pending{background:#f1c40f;color:black}
.Review{background:#e67e22}
.Approved{background:#2ecc71}
.Rejected{background:#e74c3c}
</style>
</head>

<body class="dash-bg">

<div class="topbar">
  <div class="logo-area">
    <img src="../assets/logo.png"> Smart City
  </div>
  <div class="menu">
    <a href="dashboard.php">Dashboard</a>
    <a href="my_reports.php">My Reports</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="feed">
<?php while($row=$r->fetch_assoc()): 
$st = $row['status'];
$labels = ["Pending","In Review","Approved","Rejected"];
$classes = ["Pending","Review","Approved","Rejected"];
?>
  <div class="feed-card">
    <img src="../uploads/<?= $row['photo'] ?>">
    <div class="feed-body">
      <span class="status <?= $classes[$st] ?>">#<?= $row['id'] ?> — <?= $labels[$st] ?></span>
      <p><b>Category:</b> <?= $row['category'] ?></p>
      <p><?= $row['description'] ?></p>
      <p><b>Location:</b> <?= $row['location'] ?></p>
      <p style="opacity:.6"><?= $row['created_at'] ?? '' ?></p>
    </div>
  </div>
<?php endwhile; ?>
</div>

</body>
</html>
