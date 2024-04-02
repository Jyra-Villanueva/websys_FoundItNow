<!-- delete_admin.php -->
<?php
session_start();
require_once("../login/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminID = $_POST['adminID'] ?? '';

    // Delete admin from the database
    $deleteQuery = "DELETE FROM admin WHERE ID = '$adminID'";
    
    if (mysqli_query($conn, $deleteQuery)) {
        // Admin deleted successfully
        header("Location: admin_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
