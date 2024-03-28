<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../css/cssadmin.css">
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

</body>
</html>
