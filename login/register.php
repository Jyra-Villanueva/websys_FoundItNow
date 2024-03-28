<?php
session_start();
require("config.php");

if(isset($_POST['submit'])){

   $studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $campusName = mysqli_real_escape_string($conn, $_POST['campusName']); 


   $select = "SELECT * FROM user WHERE studentid = '$studentid'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   } else {

      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {

         $insert = "INSERT INTO user(studentid, name, email, password, campusName) VALUES('$studentid','$name','$email','$pass','$campusName')";
         mysqli_query($conn, $insert);
         header('location:login.php');
         exit(); 
      }
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="studentid" required placeholder="enter your Student ID">
      <input type="text" name="name" required placeholder="enter your Fullname">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="campusName">
         <option value="">SELECT PSU CAMPUS</option>
         <option value="Urdaneta">Urdaneta</option>
         <option value="Asingan">Asingan</option>
         <option value="Lingayen">Lingayen</option>
         <option value="Binmaley">Binmaley</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>