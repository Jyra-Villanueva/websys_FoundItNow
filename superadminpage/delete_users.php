<?php
require("../login/config.php");

if (isset($_POST['ID'])) {
    $userID = $_POST['ID'];
    echo "Received ID: " . $userID; // Debug statement
    // Delete the user from the database
    $deleteQuery = "DELETE FROM user WHERE ID = $userID";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "No user ID provided";
}
?>
