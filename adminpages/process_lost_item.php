<?php
// Include the database configuration file
require_once "../login/config.php";
require("../components/adminnavi.php");
// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Define upload directory and target file
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Prepare an insert statement
    $sql = "INSERT INTO lostitems (ItemName, campusID, description, locationLost, dateFound, contactInfo, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssss", $param_itemName, $param_campusID, $param_description, $param_locationLost, $param_dateFound, $param_contactInfo, $param_image);
        
        // Set parameters
        $param_itemName = $_POST["itemName"];
        $param_campusID = $_POST["campusID"];
        $param_description = $_POST["description"];
        $param_locationLost = $_POST["locationLost"];
        $param_dateFound = $_POST["dateFound"];
        $param_contactInfo = $_POST["contactInfo"];
        $param_image = $target_file; // Store the file path
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to success page
            header("location: add_lost_item.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
