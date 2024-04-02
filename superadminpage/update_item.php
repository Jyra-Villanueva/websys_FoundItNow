<?php
// Include the database configuration file
require("../login/config.php");
require('../components/superadminnavi.php');

// Check if itemID is provided in the URL
if (isset($_GET['itemID'])) {
    // Sanitize input
    $itemID = mysqli_real_escape_string($conn, $_GET['itemID']);
    
    // Fetch the details of the item from the database
    $query = "SELECT * FROM lostitems WHERE itemID = '$itemID'";
    $result = mysqli_query($conn, $query);
    
    // Check if the item exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Store the item details in variables
        $itemName = $row['ItemName'];
        $campusID = $row['campusID'];
        $description = $row['description'];
        $locationLost = $row['locationLost'];
        $dateFound = $row['dateFound'];
        $contactInfo = $row['contactInfo'];
    } else {
        echo "Item not found.";
        exit(); // Stop further execution
    }
} else {
    echo "Item ID not provided.";
    exit(); // Stop further execution
}

// Check if form is submitted for updating the item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $itemName = mysqli_real_escape_string($conn, $_POST['itemName']);
    $campusID = mysqli_real_escape_string($conn, $_POST['campusID']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $locationLost = mysqli_real_escape_string($conn, $_POST['locationLost']);
    $dateFound = mysqli_real_escape_string($conn, $_POST['dateFound']);
    $contactInfo = mysqli_real_escape_string($conn, $_POST['contactInfo']);
    
    // Update the item details in the database
    $query = "UPDATE lostitems SET ItemName = '$itemName', campusID = '$campusID', description = '$description', locationLost = '$locationLost', dateFound = '$dateFound', contactInfo = '$contactInfo' WHERE itemID = '$itemID'";
    if (mysqli_query($conn, $query)) {
        echo "Item details updated successfully.";
    } else {
        echo "Error updating item details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Lost Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2 class="mt-4">Update Lost Item</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" class="form-control" value="<?php echo $itemName; ?>">
        </div>
        <div class="form-group">
            <label for="campusID">Campus ID:</label>
            <input type="text" name="campusID" class="form-control" value="<?php echo $campusID; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="locationLost">Location Lost:</label>
            <input type="text" name="locationLost" class="form-control" value="<?php echo $locationLost; ?>">
        </div>
        <div class="form-group">
            <label for="dateFound">Date Found:</label>
            <input type="datetime-local" name="dateFound" class="form-control" value="<?php echo $dateFound; ?>">
        </div>
        <div class="form-group">
            <label for="contactInfo">Contact Info:</label>
            <input type="text" name="contactInfo" class="form-control" value="<?php echo $contactInfo; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
