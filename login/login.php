<?php
session_start();

require("config.php");

$error = [];

if(isset($_POST['submit'])){
   
   $studentid = isset($_POST['studentid']) ? mysqli_real_escape_string($conn, $_POST['studentid']) : '';
   $pass = isset($_POST['password']) ? md5($_POST['password']) : '';

   if(!empty($studentid) && !empty($pass)) {
      $select = "SELECT * FROM user WHERE studentid = '$studentid' && password = '$pass' ";
      
      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);
         
         if($row['school'] == 'Urdaneta' || 'Asingan' || 'Lingayen' || 'Binmaley'){
            $_SESSION['user_name'] = $row['name'];
            header('location: pages/dashboard.php');
         }
      } else {
         $error[] = 'Incorrect student ID or password!';
      }
   } else {
      $error[] = 'Please enter both student ID and password!';
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
      <?php
      if(isset($error)){
         foreach($error as $errorMsg){
            echo '<span class="error-msg">'.$errorMsg.'</span>';
         }
      }
      ?>
      <input type="text" name="studentid" required placeholder="Enter your Student ID">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register.php">Register Now</a></p>
   </form>

</div>

</body>
</html>