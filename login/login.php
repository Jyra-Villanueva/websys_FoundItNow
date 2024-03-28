<?php
session_start();

require("config.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $select = "SELECT * FROM user WHERE studentid = '$studentid' AND password = MD5('$password')";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($studentid === "admin" && $password === "admin123") {
            $_SESSION["is_admin"] = true;
            header("Location: ../adminpages/adminBoard.php");
            exit();
        } else {
            $_SESSION["studentid"] = $studentid;
            header("Location: ../pages/dashboard.php");
            exit();
        }
    } else {
        $error = "Invalid student ID or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
      <?php if($error != ''): ?>
         <span class="error-msg"><?= $error ?></span>
      <?php endif; ?>
      <input type="text" name="studentid" required placeholder="Enter your Student ID">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register.php">Register Now</a></p>
   </form>
</div>

</body>
</html>
