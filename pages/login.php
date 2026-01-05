<?php
session_start();
$conn = new mysqli("localhost","root","","smartcity_db");
if($conn->connect_error) die("DB Error");

if(isset($_POST['type'])){

$email = trim($conn->real_escape_string($_POST['email']));
$pass  = trim($conn->real_escape_string($_POST['password']));
$type  = $_POST['type'];

/* ================= ADMIN ================= */
if($type=="admin"){

    if(!str_ends_with($email,"@sehir.gov")){
        echo "<script>alert('Only government emails can login as ADMIN');</script>";
        exit;
    }

    $r = $conn->query("SELECT * FROM users WHERE email='$email' AND role='admin' LIMIT 1");

    if($r->num_rows==0){
        $conn->query("INSERT INTO users(name,email,password,role)
                      VALUES('$email','$email','$pass','admin')");
        $uid = $conn->insert_id;
    } else {
        $u = $r->fetch_assoc();
        if($u['password']!=$pass){
            echo "<script>alert('Wrong password');</script>";
            exit;
        }
        $uid = $u['id'];
    }

    $_SESSION['uid']=$uid;
    $_SESSION['role']="admin";
    header("Location: admin_panel.php");
    exit;
}

/* ================= CITIZEN ================= */
if($type=="citizen"){

    if(str_ends_with($email,"@sehir.gov")){
        echo "<script>alert('Government emails can only login as ADMIN');</script>";
        exit;
    }

    $r = $conn->query("SELECT * FROM users WHERE email='$email' AND role='citizen' LIMIT 1");

    if($r->num_rows==0){
        $conn->query("INSERT INTO users(name,email,password,role)
                      VALUES('$email','$email','$pass','citizen')");
        $uid = $conn->insert_id;
    } else {
        $u = $r->fetch_assoc();
        if($u['password']!=$pass){
            echo "<script>alert('Wrong password');</script>";
            exit;
        }
        $uid = $u['id'];
    }

    $_SESSION['uid']=$uid;
    $_SESSION['role']="citizen";
    header("Location: dashboard.php");
    exit;
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Smart City - Login</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="login-box">
<img src="../assets/logo.png">
<h2>Smart City</h2>
<p>Issue Reporting System</p>

<form method="post">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="type" value="citizen">Citizen Login</button><br><br>
<button name="type" value="admin">Admin Login</button>

<div class="hint">
Citizen: any email & password<br>
Admin: only *@sehir.gov emails
</div>
</form>
</div>
</body>
</html>
