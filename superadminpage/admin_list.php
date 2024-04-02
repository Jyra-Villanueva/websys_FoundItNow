<!-- admin_list.php -->
<?php
session_start();
require_once("../login/config.php");

// Fetch admins from the database
$query = "SELECT * FROM admin";
$result = mysqli_query($conn, $query);
$admins = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
</head>
<style>
.card {
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 10px;
                background-color: #f9f9f9;
            }
            .card img {
                max-width: 100%;
                height: auto;
            }

            body {
            margin: 0;
            padding: 0;
        }

        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
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
<body>
<div class="topnav" id="myTopnav">
    <a href="../adminpages/adminBoard.php" class="active"><i class="fa fa-fw fa-home"></i>Home</a>
    <a href="../adminpages/adminpost.php"><i class="fas fa-fw fa-user"></i>Lost & Found</a>
    <a href="../adminpages/add_lost_item.php"><i class="fa-solid fa-utensils"></i>Add Post</a>
    <a href="../adminpages/manageitems.php"><i class="fa-solid fa-utensils"></i>Manage</a>
    <a href="../adminpages/usersAdmin.php"><i class="fa-solid fa-utensils"></i>Users</a>
    <a href="admin_list.php"><i class="fa-solid fa-utensils"></i>Admin</a>
    <a href="../login/logout.php"><i class="fas fa-fw fa-sign-out"></i>Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>
    <h2>Admin List</h2>

    <!-- Display list of admins -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Campus ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo $admin['ID']; ?></td>
                    <td><?php echo $admin['campusID']; ?></td>
                    <td>
                        <form action="update_admin.php" method="post">
                            <input type="hidden" name="adminID" value="<?php echo $admin['ID']; ?>">
                            <input type="password" name="newPassword" placeholder="New Password">
                            <button type="submit">Update Password</button>
                        </form>
                        <form action="delete_admin.php" method="post">
                            <input type="hidden" name="adminID" value="<?php echo $admin['ID']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Form to add a new admin -->
    <h2>Add New Admin</h2>
    <form action="add_admin.php" method="post">
        <input type="text" name="adminID" placeholder="Admin ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="campusID" required>
            <option value="">Select Campus ID</option>
            <?php
            // Fetch campuses from the database
            $query = "SELECT * FROM campus";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['campusID'] . "'>" . $row['campusName'] . "</option>";
            }
            ?>
        </select>
        <button type="submit">Add Admin</button>
    </form>
</body>
</html>

