<?php
session_start();

require("config.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the password meets the minimum length requirement
    if(strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        $hashed_password = md5($password);

        $select = "SELECT * FROM user WHERE studentid = '$studentid' AND password = '$hashed_password'";
        $result = mysqli_query($conn, $select);

        if ($studentid === "admin" && $password === "admin123") {
          $_SESSION["studentid"] = $studentid;
          header("Location: ../adminpages/adminBoard.php");
          exit();
      }
  
        if (mysqli_num_rows($result) == 1) {
            $_SESSION["studentid"] = $studentid; 
            header("Location: ../pages/dashboard.php");
            exit();
        } else {
            $error = "Invalid student ID or password. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/csslogin.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
h1{
    color:#fff;
}
p{
  color:#fff;
}
</style>
<body>
  <div class="wrapper">
    <form action="" method="post">
      <h1>User Login</h1>
      <?php if($error != ''): ?>
         <span class="error-msg"><?= $error ?></span>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" name="studentid" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="remember-forgot">
      </div>
      <button type="submit" name="submit" class="btn">Login</button>
      <div class="register-link">
        <p>Don't have an account? <a href="register.php">Register</a></p>
        <p>Login as Admin: <a href="adminlogin.php">Admin Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>
