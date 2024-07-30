<?php

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    // Lấy tên file hiện tại
    $currentFile = basename($_SERVER['PHP_SELF']);

    // Kiểm tra nếu file hiện tại không phải là UsersLog.php hoặc login_process.php
    if ($currentFile !== 'login.php' && $currentFile !== 'login_process.php') {
        // Chuyển hướng đến UsersLog.php
        header('Location: login.php');
        exit();
    }
}
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/header.css">
</head>
<header>
<div class="header">
    <div class="logo">
        <a href="index.php">FPT Attendance System</a>
    </div>
    
</div>

<div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>    
	<div class="login-logout">
        <?php if (isset($_SESSION['username'])): ?>
            <a href="login_process.php?action=logout" class="btn-logout">Logout</a>
        <?php else: ?>
            <a href="UsersLog.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="navFunction()">
      <i class="fa fa-bars"></i></a>
</div>
</header>
<script>
    function navFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }
</script>
