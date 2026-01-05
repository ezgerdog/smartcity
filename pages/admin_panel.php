<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!="admin") header("Location: login.php");

$conn = new mysqli("localhost","root","","smartcity_db");

$r = $conn->query("SELECT issues.*, users.email FROM issues 
                   LEFT JOIN users ON issues.user_id = users.id
                   ORDER BY issues.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.admin-table{
width:100%;
border-collapse:collapse;
margin-top:30px;
}

.admin-table th, .admin-table td{
border-bottom:1px solid rgba(255,255,255,.12);
padding:14px;
font-size:14px;
}

.admin-table img{
width:90px;
border-radius:14px;
object-fit:cover;
}

tr.click-row{cursor:pointer}
tr.click-row:hover{background:rgba(255,255,255,.05)}

.badge{
display:inline-block;
padding:5px 14px;
border-radius:999px;
font-size:12px;
font-weight:600;
}
.Pending{background:#f1c40f;color:#2c2c2c}
.Review{background:#e67e22;color:#2c2c2c}
.Approved{background:#2ecc71;color:#0b1a12}
.Rejected{background:#e74c3c;color:#0b1a12}
</style>
</head>

<body class="dash-bg">

<div class="topbar">
  <div class="logo-area">
    <img src="../assets/logo.png"> Smart City Admin
  </div>
  <div class="menu">
    <a href="admin_panel.php">Panel</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div style="padding:40px">

<table class="admin-table">
<tr>
<th>ID</th>
<th>User</th>
<th>Category</th>
<th>Description</th>
<th>Location</th>
<th>Photo</th>
<th>Status</th>
</tr>

<?php
$label=["Pending","In Review","Approved","Rejected"];
$class=["Pending","Review","Approved","Rejected"];
?>

<?php while($row=$r->fetch_assoc()): ?>
<tr class="click-row" onclick="location.href='issue_detail.php?id=<?= $row['id'] ?>'">
<td>#<?= $row['id'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['category'] ?></td>
<td><?= substr($row['description'],0,80) ?>...</td>
<td><?= $row['location'] ?></td>
<td><img src="../uploads/<?= $row['photo'] ?>"></td>
<td><span class="badge <?= $class[$row['status']] ?>"><?= $label[$row['status']] ?></span></td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
