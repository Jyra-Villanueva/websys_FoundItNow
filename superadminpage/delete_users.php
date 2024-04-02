<?php
// Include the database configuration file
require("../login/config.php");
require('../components/superadminnavi.php');;
// Check if student ID is provided via POST
if(isset($_POST['id'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Delete user from the database
    $query = "DELETE FROM user WHERE studentid = '$id'";
    $result = mysqli_query($conn, $query);

    // Check if deletion was successful
    if($result) {
        // Return success message if deletion was successful
        echo "User deleted successfully";
    } else {
        // Return error message if deletion failed
        echo "Error: Unable to delete user";
    }
} else {
    // Return error message if student ID is not provided
    echo "Error: Student ID not provided";
}

// Close the database connection
mysqli_close($conn);
?>
