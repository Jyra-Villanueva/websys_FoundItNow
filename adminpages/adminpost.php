<?php
session_start();
require("../login/config.php");
require("../components/adminnavi.php");
// Check if admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Retrieve admin's campus ID
$adminID = $_SESSION['id'];
$query = "SELECT campusID FROM admin WHERE ID = '$adminID'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Error: Unable to retrieve admin data.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$loggedInCampusID = $row['campusID'];

// Retrieve campus name
$query = "SELECT campusName FROM campus WHERE campusID = '$loggedInCampusID'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Error: Unable to retrieve campus name.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$loggedInCampusName = $row['campusName'];

// Retrieve specific admin posts
$query = "SELECT * FROM lostitems WHERE campusID = '$loggedInCampusID'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: Unable to retrieve admin posts.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Posts in <?php echo $loggedInCampusName; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h2>Admin Posts in <?php echo $loggedInCampusName; ?></h2>
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Location Lost</th>
                    <th>Date Found</th>
                    <th>Contact Info</th>
                    <th>Image</th>
                    <th>Claimed</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ItemName']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['locationLost']); ?></td>
                        <td><?php echo htmlspecialchars($row['dateFound']); ?></td>
                        <td><?php echo htmlspecialchars($row['contactInfo']); ?></td>
                        <td><img src="<?php echo $row['image']; ?>" alt="Item Image" style="max-width: 100px;"></td>
                        <td><?php echo $row['claimed'] == 1 ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../login/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
