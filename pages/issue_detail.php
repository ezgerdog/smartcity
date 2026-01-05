<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!="admin") header("Location: login.php");

require_once "../mail/config.php";

$conn = new mysqli("localhost","root","","smartcity_db");

$id = intval($_GET['id']);

$q = $conn->query("SELECT issues.*, users.email FROM issues 
                    LEFT JOIN users ON issues.user_id=users.id
                    WHERE issues.id=$id");
$row = $q->fetch_assoc();

if(!$row) die("Issue not found");

// Pending → In Review
if($row['status']==0){
    $conn->query("UPDATE issues SET status=1 WHERE id=$id");
    $row['status']=1;
}

// Decision
if(isset($_POST['decision']) && $row['status']==1){
    $new = intval($_POST['decision']);
    $conn->query("UPDATE issues SET status=$new WHERE id=$id");

    $statusText = $new==2 ? "APPROVED" : "REJECTED";

    sendMail(
        $row['email'],
        "Smart City Report Result",
        "Your report <b>#{$row['id']}</b> has been <b>$statusText</b>."
    );

    header("Location: admin_panel.php");
    exit;
}

$labels = ["Pending","In Review","Approved","Rejected"];
$colors = ["#f1c40f","#e67e22","#2ecc71","#e74c3c"];
?>
<!DOCTYPE html>
<html>
<head>
<title>Issue Review</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.detail-card{
  width:900px;
  max-width:95%;
  margin:90px auto;
  background:white;
  border-radius:32px;
  padding:55px 65px;
  box-shadow:0 35px 90px rgba(0,0,0,.6);
  color:#134d34;
}

.status-badge{
  display:inline-block;
  padding:8px 22px;
  border-radius:999px;
  font-weight:600;
  margin-bottom:18px;
  color:white;
}

.detail-card img{
  width:100%;
  max-height:380px;
  object-fit:cover;
  border-radius:20px;
  margin:30px 0;
  box-shadow:0 14px 40px rgba(0,0,0,.35);
}

.issue-meta{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:18px;
  margin-bottom:20px;
}

.issue-description{
  margin:25px 0;
  background:#f4fff8;
  padding:22px 25px;
  border-radius:16px;
  line-height:1.65;
  font-size:16px;
  max-height:260px;
  overflow:auto;
}

.actions{
  display:flex;
  gap:35px;
  margin-top:35px;
}

.actions button{
  flex:1;
  padding:18px;
  font-size:16px;
  border:none;
  border-radius:999px;
  font-weight:600;
  cursor:pointer;
}

.approve{background:#2ecc71;color:#0b1a12}
.reject{background:#e74c3c;color:white}
</style>
</head>

<body class="dash-bg">

<div class="detail-card">

<div class="status-badge" style="background:<?= $colors[$row['status']] ?>">
<?= $labels[$row['status']] ?>
</div>

<h2><?= htmlspecialchars($row['category']) ?></h2>

<div class="issue-meta">
  <div><b>User:</b> <?= htmlspecialchars($row['email']) ?></div>
  <div><b>Location:</b> <?= htmlspecialchars($row['location']) ?></div>
</div>

<div class="issue-description">
  <?= nl2br(htmlspecialchars($row['description'])) ?>
</div>

<img src="../uploads/<?= htmlspecialchars($row['photo']) ?>">

<?php if($row['status']==1): ?>
<form method="post" class="actions">
  <button class="reject" name="decision" value="3">Reject</button>
  <button class="approve" name="decision" value="2">Approve</button>
</form>
<?php else: ?>
<div style="margin-top:35px;font-weight:600;color:#888;">
Decision already finalized.
</div>
<?php endif; ?>

</div>

</body>
</html>
