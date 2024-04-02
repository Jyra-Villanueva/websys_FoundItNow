<?php
session_start();

require("config.php");

$error = [];

if(isset($_POST['submit'])){

   $studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $school = $_POST['campusID'];

   $select = "SELECT * FROM user WHERE studentid = '$studentid'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   } else {
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {
         $insert = "INSERT INTO user (studentid, name, email, password, campusID) VALUES ('$studentid', '$name', '$email', '$pass', '$school')";
         mysqli_query($conn, $insert);
         $_SESSION['user_name'] = $name;
         $_SESSION['campusID'] = $school; // Store selected school in session
         header('location: login.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../css/cssregister.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
  <div class="wrapper">
    <form action="" method="post">
      <h1>Register</h1>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <div class="input-box">
        <input type="text" name="studentid" placeholder="Student ID" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" name="name" placeholder="Full Name" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
        <i class='bx bxs-envelope'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="input-box">
        <input type="password" name="cpassword" placeholder="Confirm Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <select name="campusID" required>
         <option value="">SELECT PSU CAMPUS</option>
                <option value="CAMP1001">Urdaneta Campus</option>
                <option value="CAMP1002">Asingan Campus</option>
                <option value="CAMP1003">Binmaley Campus</option>
                <option value="CAMP1004">Alaminos Campus</option>
                <option value="CAMP1005">Bayambang Campus</option>
                <option value="CAMP1006">Infanta Campus</option>
                <option value="CAMP1007">San Carlos Campus</option>
                <option value="CAMP1008">Sta. Maria Campus</option>
                <option value="CAMP1009">Lingayen Campus</option>
      </select>
      <br>
      <button type="submit" name="submit" class="btn">Register</button>
      <div class="register-link">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>
