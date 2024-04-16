<?php
// Include the database configuration file
require("../login/config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the form data
    $itemId = $_POST['itemId']; // Corrected variable name
    $question1 = $_POST['question1'];
   
    // Perform a query to fetch the description of the item
    $query = "SELECT description FROM lostitems WHERE itemID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->store_result();

    // Check if the item exists
    if ($stmt->num_rows > 0) {
        // Bind the result to a variable
        $stmt->bind_result($description);
        $stmt->fetch();

        // Compare the user's answers with the description
        if ($description == $question1) {
            // Answers match the description
            // You can perform further actions here, such as marking the item as claimed in the database
            echo '<div class="alert alert-success" role="alert">Congratulations! Your answers match the description. The item is successfully claimed.</div>';
        } else {
            // Answers don't match
            echo '<div class="alert alert-danger" role="alert">Sorry, your answers do not match the description of the item. Please try again.</div>';
        }
    } else {
        // Item not found
        echo '<div class="alert alert-danger" role="alert">Error: Item not found.</div>';
    }

    // Close the prepared statement and database connection
    $stmt->close();
    mysqli_close($conn);
} else {
    // If the form is not submitted, redirect to the homepage or display an error message
    echo '<div class="alert alert-danger" role="alert">Error: Form not submitted.</div>';
}
?>
