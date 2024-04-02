<!-- add_admin.php -->
<?php
session_start();
require_once("../login/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminID = $_POST['adminID'] ?? '';
    $password = $_POST['password'] ?? '';
    $campusID = $_POST['campusID'] ?? '';

    // Insert new admin into the database
    $insertQuery = "INSERT INTO admin (ID, pass, campusID) VALUES ('$adminID', '$password', '$campusID')";
    
    if (mysqli_query($conn, $insertQuery)) {
        // Admin added successfully
        header("Location: admin_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
