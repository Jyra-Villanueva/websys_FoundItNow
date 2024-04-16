<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");
// Check if student ID is provided via POST
if(isset($_POST['ID'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['ID']);

    // Delete user from the database
    $query = "DELETE FROM user WHERE ID = '$id'";
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
