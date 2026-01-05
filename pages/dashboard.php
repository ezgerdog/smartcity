<?php session_start(); if(!isset($_SESSION['uid'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body class="dash-bg">

<div class="topbar">
    <div class="logo-area">
        <img src="../assets/logo.png">
        <span>Smart City</span>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="my_reports.php">My Reports</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="title-area">
    <h1>City Problem</h1>
    <p>Select a category to report a new issue</p>
</div>

<div class="cards">

<a href="report_issue.php?cat=Transportation" class="card">
<img src="../assets/urban.png">
<h3>Transportation</h3>
<p>Road damages, traffic and transportation issues</p>
</a>

<a href="report_issue.php?cat=Environment" class="card">
<img src="../assets/env.png">
<h3>Environment</h3>
<p>Garbage, pollution and environmental issues</p>
</a>

<a href="report_issue.php?cat=Infrastructure" class="card">
<img src="../assets/ins.png">
<h3>Infrastructure</h3>
<p>Water, electricity and infrastructure problems</p>
</a>

<a href="report_issue.php?cat=Public Safety" class="card">
<img src="../assets/public.png">
<h3>Public Safety</h3>
<p>Lighting, unsafe areas and security issues</p>
</a>

</div>

</body>
</html>
