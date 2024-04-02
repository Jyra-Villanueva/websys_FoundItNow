<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link rel="stylesheet" href="../css/cssnavigator.css">
   <style>
      body {
          margin: 0;
          padding: 0;
          font-family: Arial, sans-serif; /* Adding a font family */
      }

      nav {
          background-color: #007bff;
          padding: 10px 20px; 
          display: flex;
          justify-content: space-between; 
          align-items: center; 
      }

      .logo img {
          height: 40px;
          width: auto; 
      }

      nav ul {
          list-style-type: none;
          margin: 0;
          padding: 0;
          display: flex;
          align-items: center; 
      }

      nav ul li {
          margin-right: 20px; 
      }

      nav ul li:last-child {
          margin-right: 0; 
      }

      nav ul li a {
          color: #fff;
          text-decoration: none;
          font-size: 20px;
      }

      nav ul li a:hover {
          color: #ddd;
      }
   </style>
</head>
<body>

   <nav>
       <div class="logo">
           <img src="../images/Found.png" alt="Logo">
       </div>
       <ul>
           <li><a href="../pages/dashboard.php">Home</a></li>
           <li><a href="../pages/questionaire.php">Lost Something?</a></li>
           <li><a href="../login/logout.php">Logout</a></li>
       </ul>
   </nav>

</body>
</html>
