<?php
session_start();

require("config.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'id' and 'pass' keys are set in $_POST array
    if (isset($_POST['id']) && isset($_POST['pass'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        if ($id === "superadmin" && $pass === "superadmin123") {
            $_SESSION["id"] = $id;
            header("Location: ../superadminpage/superadminBoard.php");
            exit();
        }

        $select_admin = "SELECT * FROM admin WHERE ID = '$id' AND pass = '$pass'";
        $result_admin = mysqli_query($conn, $select_admin);

        if (mysqli_num_rows($result_admin) == 1) {
            $_SESSION["id"] = $id;
            header("Location: ../adminpages/adminBoard.php");
            exit();
        }

        $error = "Invalid ID or password. Please try again.";
    } else {
        $error = "ID or password fields are missing.";
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
      <h1>Admin Login</h1>
      <?php if($error != ''): ?>
         <span class="error-msg"><?= $error ?></span>
      <?php endif; ?>
      <div class="input-box">
      <input type="text" name="id" required placeholder="Enter your ID">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
      <input type="password" name="pass" required placeholder="Enter your password">
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="remember-forgot">
      </div>
      <button type="submit" name="submit" value="Login Now" class="btn">Login</button>
      <div class="register-link">
        <p>Login as User: <a href="login.php">User Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>
