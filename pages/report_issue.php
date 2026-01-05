<?php
session_start();
if(!isset($_SESSION['uid'])) header("Location: login.php");

$conn = new mysqli("localhost","root","","smartcity_db");
if($conn->connect_error) die("DB Error");

$cat = $_GET['cat'] ?? '';

if(isset($_POST['submit'])){
    $desc = $conn->real_escape_string($_POST['desc']);
    $loc  = $conn->real_escape_string($_POST['loc']);
    $cat  = $conn->real_escape_string($_POST['cat']);
    $uid  = $_SESSION['uid'];

    $img = time()."_".$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/".$img);

    $conn->query("INSERT INTO issues(user_id,category,description,location,photo,status)
              VALUES('$uid','$cat','$desc','$loc','$img',0)");

    header("Location: success.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Report Issue</title>
<link rel="stylesheet" href="../css/style.css">
</head>

<body class="app-body report-page">

<div class="topbar">
  <div class="logo">
    <img src="../assets/logo.png"> Smart City
  </div>
  <div class="menu">
    <a href="dashboard.php">Dashboard</a>
  </div>
</div>

<div class="report-wrapper">

<div class="report-card">
  <h2>Report a City Problem</h2>
  <p class="category">Category: <b><?= htmlspecialchars($cat) ?></b></p>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>">

    <label>Description</label>
    <textarea name="desc" placeholder="Describe the issue in detail..." required></textarea>

    <label>Location</label>
    <input type="text" name="loc" placeholder="Example: Kadıköy Rıhtım" required>

    <label>Upload Photo</label>

<div class="file-upload">
    <span class="file-name">No file selected</span>
    <label class="file-btn">
        Browse…
        <input type="file" name="photo" required hidden onchange="this.parentElement.previousElementSibling.innerText=this.files[0]?.name || 'No file selected'">
    </label>
</div>

    <button type="submit" name="submit">Submit Report</button>
  </form>
</div>

</div>
</body>
</html>
