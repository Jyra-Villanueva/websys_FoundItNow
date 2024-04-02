<!-- update_admin.php -->
<?php
session_start();
require_once("../login/config.php");
require('../components/superadminnavi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminID = $_POST['adminID'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';

    // Update admin password
    $updateQuery = "UPDATE admin SET pass = '$newPassword' WHERE ID = '$adminID'";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Password updated successfully
        header("Location: admin_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
