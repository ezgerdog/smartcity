<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Success</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.success-page{
    min-height:100vh;
    background:radial-gradient(circle at top,#0d4026,#03160e);
    display:flex;
    align-items:center;
    justify-content:center;
}

.success-box{
    text-align:center;
    color:white;
}

.success-box h1{
    font-size:68px;
    color:#3cff88;
    margin-bottom:15px;
}

.success-box p{
    font-size:18px;
    opacity:.85;
    margin-bottom:40px;
}

.success-btns{
    display:flex;
    justify-content:center;
    gap:25px;
}

.success-btns a{
    background:#3cff88;
    color:#06351f;
    padding:14px 36px;
    border-radius:40px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}

.success-btns a:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 30px rgba(0,0,0,.4);
}
</style>
</head>

<body>
<div class="success-page">
    <div class="success-box">
        <h1>Request Received ✓</h1>
        <p>Your city issue has been successfully submitted.</p>

        <div class="success-btns">
            <a href="dashboard.php">Dashboard</a>
            <a href="my_reports.php">My Reports</a>
        </div>
    </div>
</div>
</body>
</html>
