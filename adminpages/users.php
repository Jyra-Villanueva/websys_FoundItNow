<?php
// Include the database configuration file
require("../login/config.php");

// Fetch all users from the database
$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);

// Check if there are any users
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User List</title>
       
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    </head>
    <body>
    <link rel="stylesheet" href="../css/cssusers.css">
</head>
<body>

<div class="topnav" id="myTopnav">
    <a href="#home" class="active"><i class="fa fa-fw fa-home"></i>Home</a>
    <a href="#lost_found"><i class="fas fa-fw fa-user"></i>Lost & Found</a>
    <a href="#add_post"><i class="fa-solid fa-utensils"></i>Add Post</a>
    <a href="#manage"><i class="fa-solid fa-utensils"></i>Manage</a>
    <a href="users.php"><i class="fa-solid fa-utensils"></i>Users</a>
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
        <div class="container mt-5">
            <h2 class="mb-4">User List</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Campus Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row and display user data
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['studentid']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['campusName']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
    <?php
} else {
    // No users found
    echo "No users found";
}

// Close the database connection
mysqli_close($conn);
?>
