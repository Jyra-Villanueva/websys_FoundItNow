<?php
// Initialize variables
$selected_campus = "";
$search_query = "";
$all_campus_selected = false;

// Check if the form is submitted
if(isset($_POST['submit'])){
    // Get the selected campus and search query from the form
    $selected_campus = $_POST['campus'];
    $search_query = $_POST['search'];

    // Check if "All Campus" is selected
    if($selected_campus == 'All') {
        $all_campus_selected = true;
    }

    // Construct the SQL query based on the selected campus and search query
    if(!$all_campus_selected) {
        $sql = "SELECT * FROM lostitems WHERE campusID = (SELECT campusID FROM campus WHERE campusName = '$selected_campus')";
        
        // Add search query to the SQL query if not empty
        if(!empty($search_query)){
            $sql .= " AND (ItemName LIKE '%$search_query%' OR description LIKE '%$search_query%' OR locationLost LIKE '%$search_query%' OR contactInfo LIKE '%$search_query%')";
        }
    } else {
        // Select all lost items if "All Campus" is selected
        $sql = "SELECT * FROM lostitems";
        
        // Add search query to the SQL query if not empty
        if(!empty($search_query)){
            $sql .= " WHERE ItemName LIKE '%$search_query%' OR description LIKE '%$search_query%' OR locationLost LIKE '%$search_query%' OR contactInfo LIKE '%$search_query%'";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lost Items Search</title>
   <link rel="stylesheet" href="../css/cssdashboard.css">

</head>
<body>
   <h1>Search Lost Items</h1>
   <form action="" method="post">
      <label for="campus">Select Campus:</label>
      <select name="campus" id="campus">
      <option value="All" <?php if($selected_campus == 'All') echo "selected"; ?>>All Campus</option>
         <option value="Urdaneta" <?php if($selected_campus == 'Urdaneta') echo "selected"; ?>>Urdaneta</option>
         <option value="Asingan" <?php if($selected_campus == 'Asingan') echo "selected"; ?>>Asingan</option>
      </select>
      <label for="search">Search:</label>
      <input type="text" name="search" id="search" value="<?php echo $search_query; ?>" placeholder="Enter search keyword">
      <input type="submit" name="submit" value="Search">
      <br>

   </form>

   <?php
   // Check if the form is submitted
   if(isset($_POST['submit'])){
       // Include the configuration file
       require("../login/config.php");

       // Execute the query
       $result = $conn->query($sql);

       // Check if there are any results
       if ($result->num_rows > 0) {
           // Display the table header
           echo "<h2>Lost Items Found:</h2>";
           echo "<table border='1'>";
           echo "<tr><th>Item Name</th><th>Description</th><th>Location Lost</th><th>Date Found</th><th>Contact Info</th></tr>";

           // Output data of each row
           while($row = $result->fetch_assoc()) {
               echo "<tr><td>" . $row["ItemName"]. "</td><td>" . $row["description"]. "</td><td>" . $row["locationLost"]. "</td><td>" . $row["dateFound"]. "</td><td>" . $row["contactInfo"]. "</td></tr>";
           }

           // Close the table
           echo "</table>";
       } else {
           // No lost items found for the selected campus
           echo "No lost items found for the selected campus.";
       }

       // Close connection
       $conn->close();
   }
   ?>
</body>
</html>
