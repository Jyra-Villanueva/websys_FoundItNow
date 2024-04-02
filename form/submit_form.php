<?php
// Include the database configuration file
require("../login/config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign form data to variables
    $itemName = $_POST['itemName'];
    $campusID = $_POST['campusID'];
    $description = $_POST['description'];
    $locationLost = $_POST['locationLost'];
    $dateFound = $_POST['dateFound'];
    $contactInfo = $_POST['contactInfo'];
    
    // Check if an image is uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File upload path
        $targetDir = "../form/uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if(in_array($fileType, $allowedTypes)){
            // Move the uploaded file to the specified location
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                // Insert data into database
                $sql = "INSERT INTO lostitems (ItemName, campusID, description, locationLost, dateFound, contactInfo, image) 
                        VALUES ('$itemName', '$campusID', '$description', '$locationLost', '$dateFound', '$contactInfo', '$fileName')";
                if(mysqli_query($conn, $sql)){
                    echo "Form submitted successfully.";
                } else{
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else{
                echo "Sorry, there was an error uploading your file.";
            }
        } else{
            echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
        }
    } else {
        // Insert data into database without an image
        $sql = "INSERT INTO lostitems (ItemName, campusID, description, locationLost, dateFound, contactInfo) 
                VALUES ('$itemName', '$campusID', '$description', '$locationLost', '$dateFound', '$contactInfo')";
if(mysqli_query($conn, $sql)){
    echo "Form submitted successfully.";
    // Redirect to dashboard page
    header("Location: ../pages/dashboard.php");
    exit(); // Ensure that no other output is sent to the browser
} else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

    }
} else {
    // If the form is not submitted
    echo "Form not submitted.";
}

// Close the database connection
mysqli_close($conn);
?>
