<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Welcome to Our Website</title>

   <!-- Link to Bootstrap CSS file -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

   <!-- Link to your custom CSS file -->
   <link rel="stylesheet" href="../css/csslanding.css">
   
   <!-- Custom CSS to override Bootstrap button color -->
   <style>
      .btn {
         background-color: blue !important;
         border-color: blue !important;
         border-radius: 60px;
         color: white;
         padding: 20px 50px;
         border: none;
         cursor: pointer;
         margin-top: 520px;
         text-decoration: none;
      }
      body {
         font-family: Arial, sans-serif;
         background-color: #f0f0f0;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         background: url('../images/land1.png') no-repeat;
         background-size: cover;
         background-position: center;
      }
      .container {
         max-width: 800px;
         margin: 100px auto;
         text-align: center;
      }
      h1 {
         color: #333;
      }
      p {
         color: #666;
         font-size: 18px;
         line-height: 1.6;
      }
   </style>
</head>

<body>
   
<div class="container">
   <a href="../login/login.php" class="btn">Login Now!</a>
</div>

<!-- Optional: Include Bootstrap JavaScript file if needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
