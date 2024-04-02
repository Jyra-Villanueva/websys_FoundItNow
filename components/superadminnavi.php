<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .topnav {
            background-color: #007bff;
            overflow: hidden;
            display: flex; 
            align-items: center; /* Center vertically */
            padding: 0 20px; /* Add padding */
        }

        .topnav .logo img {
            height: 40px; /* Adjust the height as needed */
        }

        .topnav a {
            color: #f2f2f2;
            text-decoration: none;
            font-size: 20px;
            padding: 14px 16px;
            text-align: center;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div class="topnav" id="myTopnav">
    <div class="logo">
        <img src="../images/Found.png" alt="Logo">
    </div>
    <a href="../superadminpage/superadminBoard.php" <?php if(basename($_SERVER['PHP_SELF']) == 'adminBoard.php') echo 'class="active"'; ?>><i class="fa fa-fw fa-home"></i>Home</a>
    <a href="../superadminpage/add_lost_item.php" <?php if(basename($_SERVER['PHP_SELF']) == 'add_lost_item.php') echo 'class="active"'; ?>><i class="fa-solid fa-utensils"></i>Add Post</a>
    <a href="../superadminpage/manageitems.php" <?php if(basename($_SERVER['PHP_SELF']) == 'manageitems.php') echo 'class="active"'; ?>><i class="fa-solid fa-utensils"></i>Manage</a>
    <a href="../superadminpage/usersAdmin.php" <?php if(basename($_SERVER['PHP_SELF']) == 'usersAdmin.php') echo 'class="active"'; ?>><i class="fa-solid fa-utensils"></i>Users</a>
    <a href="../superadminpage/admin_list.php"><i class="fa-solid fa-utensils"></i>Admin</a>
    <a href="../login/logout.php"><i class="fas fa-fw fa-sign-out"></i>Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>



<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>

</body>
</html>
