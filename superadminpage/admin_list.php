<!-- admin_list.php -->
<?php
session_start();
require_once("../login/config.php");
require('../components/superadminnavi.php');

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Admin List</h2>

    <!-- Display list of admins -->
    <div class="table-responsive">
        <table class="table table-bordered">
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
                            <form action="update_admin.php" method="post" class="d-inline">
                                <input type="hidden" name="adminID" value="<?php echo $admin['ID']; ?>">
                                <div class="form-group">
                                    <input type="password" name="newPassword" class="form-control" placeholder="New Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                            <form action="delete_admin.php" method="post" class="d-inline">
                                <input type="hidden" name="adminID" value="<?php echo $admin['ID']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Form to add a new admin -->
    <h2>Add New Admin</h2>
    <form action="add_admin.php" method="post" class="mb-4">
        <div class="form-row">
            <div class="col-md-4">
                <input type="text" name="adminID" class="form-control" placeholder="Admin ID" required>
            </div>
            <div class="col-md-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-4">
                <select name="campusID" class="form-control" required>
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
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-2">Add Admin</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


