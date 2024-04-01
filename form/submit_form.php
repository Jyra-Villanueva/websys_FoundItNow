<?php
require("../components/navigator.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include_once '../login/config.php';

    // Prepare and bind parameters
    $itemName = $_POST['itemName'];
    $description = $_POST['description'];
    $locationLost = $_POST['locationLost'];
    $dateFound = $_POST['dateFound'];
    $contactInfo = $_POST['contactInfo'];

    // Check if image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File upload configuration
        $uploadDir = 'uploads/';
        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);

        // Move uploaded file to designated directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            // Insert into images table
            $stmt = $conn->prepare("INSERT INTO images (image_path) VALUES (?)");
            $stmt->bind_param("s", $uploadedFile);
            $stmt->execute();

            // Get the image ID
            $imageID = $stmt->insert_id;
            $stmt->close();
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // If no image uploaded, set image ID to 0
        $imageID = 0;
    }

    // Insert into lostitems table
    $campusID = $_POST['campusID'];

    $stmt = $conn->prepare("INSERT INTO lostitems (image, ItemName, description, campusID, locationLost, dateFound, contactInfo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $imageID, $itemName, $description, $campusID, $locationLost, $dateFound, $contactInfo);
    
    if ($stmt->execute()) {
        // Redirect to dashboard
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        echo "Error submitting form: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
