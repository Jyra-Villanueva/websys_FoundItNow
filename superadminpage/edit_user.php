<?php
// Include the database configuration file
require("../login/config.php");
require('../components/superadminnavi.php');
// Check if the user ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from the database based on the provided ID
    $query = "SELECT * FROM user WHERE ID = $userId";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);
        $studentId = $user['studentid'];
        $name = $user['name'];
        $email = $user['email'];
        $campusName = $user['campusID']; // Adjusted to match the database column name
    } else {
        // User not found
        echo "User not found.";
        exit;
    }
} else {
    // Redirect back to the user list page if no user ID is provided
    header("Location: usersAdmin.php");
    exit;
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $newName = mysqli_real_escape_string($conn, $_POST['name']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newCampusName = mysqli_real_escape_string($conn, $_POST['campusName']);

    // Update user details in the database
    $updateQuery = "UPDATE user SET name = '$newName', email = '$newEmail', campusID = '$newCampusName' WHERE ID = $userId";
    if (mysqli_query($conn, $updateQuery)) {
        // Redirect back to the user list page after successful update
        header("Location: usersAdmin.php");
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
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
</head>
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
    <h2>Edit User</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="mb-3">
            <label for="campusName" class="form-label">Campus ID:</label>
            <input type="text" class="form-control" id="campusName" name="campusName" value="<?php echo $campusName; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
